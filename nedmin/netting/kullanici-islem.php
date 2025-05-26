<?php
ob_start();
session_start();

require_once "baglan.php";
require_once "../production/fonksiyon.php";
require_once 'send-mail-kullanici-onay.php';

if (isset($_POST["kullanici_kaydet"])) {
    $kullanici_ad_soyad = htmlspecialchars(trim($_POST["kullanici_ad_soyad"])); // input içerisinde yazılır bir script varsa script içini temizler.
    $kullanici_mail = htmlspecialchars(string: trim($_POST["kullanici_mail"]));
    $kullanici_password_one = htmlspecialchars(trim($_POST["kullanici_password_one"]));
    $kullanici_password_two = htmlspecialchars(trim($_POST["kullanici_password_two"]));

    if ($kullanici_password_one == $kullanici_password_two) {

        $eksikler = [];

        if (strlen($kullanici_password_one) < 10) {
            $eksikler[] = "karakter";
        }

        if (!preg_match('/[A-Z]/', $kullanici_password_one)) {
            $eksikler[] = "buyukharf";
        }

        if (!preg_match('/[a-z]/', $kullanici_password_one)) {
            $eksikler[] = "kucukharf";
        }

        if (!preg_match('/[0-9]/', $kullanici_password_one)) {
            $eksikler[] = "rakam";
        }

        if (!empty($eksikler)) {
            $durum = implode("-", $eksikler);
            header("location:../../sign-up.php?durum=$durum");
        } else {

            $kullanicisor = $db->prepare("select * from kullanici where kullanici_mail=:mail");
            $kullanicisor->execute(array(
                'mail' => $kullanici_mail,
            ));

            $say = $kullanicisor->rowCount();

            if ($say == 0) {

                $password = md5($kullanici_password_one);
                $kullanici_yetki = 1;
                $kullanici_ad_soyad = trim($kullanici_ad_soyad);
                $kullanici_ad_soyad = explode(" ", $kullanici_ad_soyad);
                $dogrulama_kodu = bin2hex(random_bytes(32));

                if (count($kullanici_ad_soyad) > 1) {
                    // Ad kısmı tüm kelimeleri al
                    $kullanici_ad = implode(" ", array_slice($kullanici_ad_soyad, 0, -1)); // Son kelime hariç tümünü ad olarak al
                    $kullanici_soyad = end($kullanici_ad_soyad); // Son kelimeyi soyad olarak al
                } else {
                    // Tek kelime girildiyse
                    $kullanici_ad = $kullanici_ad_soyad[0];
                    $kullanici_soyad = '';
                }

                $kullanicikaydet = $db->prepare("insert into kullanici set 
                    kullanici_ad=:kullanici_ad,
                    kullanici_soyad=:kullanici_soyad,
                    kullanici_mail=:kullanici_mail,
                    kullanici_password=:kullanici_password,
                    kullanici_yetki=:kullanici_yetki,
                    dogrulama_kodu=:dogrulama_kodu,
                    dogrulama_durumu=:dogrulama_durumu");

                $insert = $kullanicikaydet->execute(array(
                    'kullanici_ad' => mb_convert_case($kullanici_ad, MB_CASE_TITLE, "UTF-8"),
                    'kullanici_soyad' => mb_convert_case($kullanici_soyad, MB_CASE_TITLE, "UTF-8"),
                    'kullanici_mail' => $kullanici_mail,
                    'kullanici_password' => $password,
                    'kullanici_yetki' => $kullanici_yetki,
                    'dogrulama_kodu' => $dogrulama_kodu,
                    'dogrulama_durumu' => 0

                ));

                if ($insert) {
                    mailGonder($kullanici_mail, $dogrulama_kodu, $_POST["kullanici_ad_soyad"]);
                    header("location:../../sign-up.php?durum=kullanici_dogrulama");
                    exit;

                } else {

                    header("location:../../sign-up.php?durum=basarisiz");
                }

            } else {
                $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
                if ($kullanicicek['dogrulama_durumu'] == '0') {
                    mailGonder($kullanici_mail, $dogrulama_kodu, $_POST["kullanici_ad_soyad"]);
                    header("location:../../sign-up.php?durum=kullanici_dogrulama");
                    exit;
                } else {
                    header("location:../../sign-up.php?durum=mukerrerkayit");
                    exit;
                }
            }
        }
    } else {
        // Şifreler eşleşmiyorsa
        header("location:../../sign-up.php?durum=farklisifre");
    }
}

if (isset($_POST["kullanici_giris"])) {

    $talep_url = isset($_POST["talep_url"]) ? $_POST["talep_url"] : '';
    $kullanici_mail = htmlspecialchars(trim($_POST["kullanici_mail"]));
    $kullanici_password = md5(htmlspecialchars(trim($_POST["kullanici_password"])));

    $kullanicisor = $db->prepare("select * from kullanici where 
    kullanici_mail=:kullanici_mail and 
    kullanici_password=:kullanici_password and
    kullanici_yetki=:kullanici_yetki and 
    kullanici_durum=:kullanici_durum");

    $kullanicisor->execute(array(
        "kullanici_mail" => $kullanici_mail,
        "kullanici_password" => $kullanici_password,
        "kullanici_yetki" => 1,
        "kullanici_durum" => 1,
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {

        $kullanici_son_ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

        // Kullanıcı IP'sini "kullanici" tablosuna güncelle
        $kullanici_son_ip_guncelle = $db->prepare("UPDATE kullanici SET kullanici_son_ip=:kullanici_son_ip WHERE kullanici_mail=:kullanici_mail");
        $kullanici_son_ip_guncelle->execute(array(
            'kullanici_son_ip' => $kullanici_son_ip,
            'kullanici_mail' => $kullanici_mail,
        ));

        // Kullanıcı verilerini al
        $kullanicidene = $db->prepare("SELECT * FROM kullanici WHERE kullanici_mail=:mail");
        $kullanicidene->execute(array(
            'mail' => $kullanici_mail,
        ));
        $kullanicicek = $kullanicidene->fetch(PDO::FETCH_ASSOC);
        if ($kullanicicek['dogrulama_durumu'] == '0') {
            $dogrulama_kodu = bin2hex(random_bytes(32));

            $kullanicikaydet = $db->prepare("UPDATE kullanici SET 
            dogrulama_kodu = :dogrulama_kodu 
            WHERE kullanici_mail = :kullanici_mail");

            $insert = $kullanicikaydet->execute(array(
                'dogrulama_kodu' => $dogrulama_kodu,
                'kullanici_mail' => $kullanici_mail
            ));

            mailGonder($kullanici_mail, $dogrulama_kodu, $kullanicicek['kullanici_ad']);
            header("location:../../sign-in.php?durum=kullanici_dogrulama");
            exit;

        }
        $kullanici_id = $kullanicicek["kullanici_id"];
        $_SESSION["user_kullanici_mail"] = $kullanici_id;

        // 📥 IP log tablosuna yeni kayıt ekle (INSERT)
        $ip_log_ekle = $db->prepare("INSERT INTO kullaniciiplog (kullanici_mail, ip_address, user_agent) VALUES (:kullanici_mail, :ip_address, :user_agent)");
        $ip_log_ekle->execute(array(
            'kullanici_mail' => $kullanici_mail,
            'ip_address' => $kullanici_son_ip,
            'user_agent' => $user_agent
        ));

        // Yönlendirme
        if (!empty($talep_url)) {
            header("Location: ../../$talep_url");
            exit;
        } else {
            if ($kullanicicek["kullanici_teklif_alma_verme"] == 0) {
                header("Location: ../../teklif-al-ver-basvuru");
                exit;
            } else {
               header("Location: ../../");
               exit;
            }
        }
    } else {
        header("location:../../sign-in.php?durum=no");
        exit;
    }
}

if (isset($_GET["email"])) {

    echo $kullanici_name = htmlspecialchars(trim($_GET["name"]));
    echo $kullanici_mail = htmlspecialchars(trim($_GET["email"]));

    $kullanicisor = $db->prepare("select * from kullanici where 
    kullanici_mail=:kullanici_mail and 
    kullanici_yetki=:kullanici_yetki and 
    kullanici_durum=:kullanici_durum");

    $kullanicisor->execute(array(
        "kullanici_mail" => $kullanici_mail,
        "kullanici_yetki" => 1,
        "kullanici_durum" => 1,
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {
        $kullanicigiris = $db->prepare("select * from kullanici where kullanici_mail=:mail");
        $kullanicigiris->execute(array(
            'mail' => $kullanici_mail,
        ));
        $kullanicicek = $kullanicigiris->fetch(PDO::FETCH_ASSOC);
        $kullanici_id = $kullanicicek["kullanici_id"];
        $_SESSION["user_kullanici_mail"] = $kullanici_id;    // id gönderiliyor

        header("location:../../");
        exit;

    } else {

        $kullanici_yetki = 1;
        $kullanici_ad_soyad = trim($kullanici_name);
        $kullanici_ad_soyad = explode(" ", $kullanici_ad_soyad);

        if (count($kullanici_ad_soyad) > 1) {
            // Ad kısmı tüm kelimeleri al
            $kullanici_ad = implode(" ", array_slice($kullanici_ad_soyad, 0, -1)); // Son kelime hariç tümünü ad olarak al
            $kullanici_soyad = end($kullanici_ad_soyad); // Son kelimeyi soyad olarak al
        } else {
            // Tek kelime girildiyse
            $kullanici_ad = $kullanici_ad_soyad[0];
            $kullanici_soyad = '';
        }

        $kullanicikaydet = $db->prepare("insert into kullanici set 
            kullanici_ad=:kullanici_ad,
            kullanici_soyad=:kullanici_soyad,
            kullanici_mail=:kullanici_mail,
            kullanici_yetki=:kullanici_yetki");

        $insert = $kullanicikaydet->execute(array(
            'kullanici_ad' => mb_convert_case($kullanici_ad, MB_CASE_TITLE, "UTF-8"),
            'kullanici_soyad' => mb_convert_case($kullanici_soyad, MB_CASE_TITLE, "UTF-8"),
            'kullanici_mail' => $kullanici_mail,
            'kullanici_yetki' => $kullanici_yetki
        ));

        if ($insert) {
            $kullanicidene = $db->prepare("select * from kullanici where kullanici_mail=:mail");
            $kullanicidene->execute(array(
                'mail' => $kullanici_mail,
            ));
            $kullanicicek = $kullanicidene->fetch(PDO::FETCH_ASSOC);
            $kullanici_id = $kullanicicek["kullanici_id"];
            $_SESSION["user_kullanici_mail"] = $kullanici_id;   // id gönderiliyor
            header("location:../../teklif-al-ver-basvuru");
            exit;

        } else {

            header("location:../../sign-up.php?durum=basarisiz");
        }

    }
}

if (isset($_POST["kullanici_bilgiler_duzenle"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $kullanici_id = $_SESSION['user_kullanici_mail']; //bu aslında bizim idmiz idmizi çekiyoruz user_kullanici_mail sessiona

    $kullanici_dogum_tarihi = trim($_POST["year"]) . "-" . trim($_POST["month"]) . "-" . trim($_POST["day"]);

    $ayar_kaydet = $db->prepare("update kullanici set 

        kullanici_ad=:kullanici_ad,
        kullanici_soyad=:kullanici_soyad,
        kullanici_gsm=:kullanici_gsm,
        kullanici_dogum_tarihi=:kullanici_dogum_tarihi
        
        where kullanici_id = $kullanici_id ");


    $update = $ayar_kaydet->execute(array(
        "kullanici_ad" => mb_convert_case(htmlspecialchars(trim($_POST["kullanici_ad"])), MB_CASE_TITLE, "UTF-8"),
        "kullanici_soyad" => mb_convert_case(htmlspecialchars(trim($_POST["kullanici_soyad"])), MB_CASE_TITLE, "UTF-8"),
        "kullanici_gsm" => htmlspecialchars(trim($_POST["kullanici_gsm"])),
        "kullanici_dogum_tarihi" => $kullanici_dogum_tarihi
    ));

    if ($update) {
        header("location: ../../kullanici?bilgiler=ok");
        exit;
    } else {
        header("location: ../../kullanici?bilgiler=no");
        exit;
    }
}

if (isset($_POST["kullanici_adres_duzenle"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $kullanici_id = $_SESSION['user_kullanici_mail'];   // burada aslında mail değil id gelmekte...

    $kontrol_adres = $db->prepare("SELECT * FROM adres WHERE kullanici_id=:kullanici_id");
    $kontrol_adres->execute(array(
        'kullanici_id' => $kullanici_id
    ));
    $adres = $kontrol_adres->rowCount();

    /*
    $kontrol_firma = $db->prepare("SELECT * FROM firma WHERE kullanici_id=:kullanici_id");
    $kontrol_firma->execute(array(
        'kullanici_id' => $kullanici_id
    ));
    $firma = $kontrol_firma->rowCount();
  
    $update_kullanici_tip = $db->prepare("update kullanici set 
            kullanici_tip=:kullanici_tip
            where kullanici_id = $kullanici_id"
    );

    $updatekullanicitip = $update_kullanici_tip->execute(array(
        'kullanici_tip' => htmlspecialchars(trim($_POST["kullanici_tip"])),
    ));
    */

    if ($adres == 0) {
        // Eğer adres kaydı yoksa yeni bir satır ekle
        $insert_adres = $db->prepare("insert into adres set 
            kullanici_id=:kullanici_id,
            adres_ad=:adres_ad,
            adres_soyad=:adres_soyad,
            adres_gsm=:adres_gsm,
            adres_il=:adres_il,
            adres_ilce=:adres_ilce,
            adres_mahalle=:adres_mahalle,
            adres_adres=:adres_adres");

        $insertadres = $insert_adres->execute(array(
            'kullanici_id' => $kullanici_id,
            "adres_ad" => mb_convert_case(htmlspecialchars(trim($_POST["adres_ad"])), MB_CASE_TITLE, "UTF-8"),
            "adres_soyad" => mb_convert_case(htmlspecialchars(trim($_POST["adres_soyad"])), MB_CASE_TITLE, "UTF-8"),
            "adres_gsm" => htmlspecialchars(trim($_POST["adres_gsm"])),
            "adres_il" => htmlspecialchars(trim($_POST["adres_il"])),
            "adres_ilce" => htmlspecialchars(trim($_POST["adres_ilce"])),
            "adres_mahalle" => htmlspecialchars(trim($_POST["adres_mahalle"])),
            "adres_adres" => htmlspecialchars(trim($_POST["adres_adres"])),
        ));
    }
    if ($adres != 0) {
        $ayar_kaydet = $db->prepare("update adres set 
            adres_ad=:adres_ad,
            adres_soyad=:adres_soyad,
            adres_gsm=:adres_gsm,
            adres_il=:adres_il,
            adres_ilce=:adres_ilce,
            adres_mahalle=:adres_mahalle,
            adres_adres=:adres_adres
            
            where kullanici_id = $kullanici_id");

        $updateadres = $ayar_kaydet->execute(array(
            "adres_ad" => mb_convert_case(htmlspecialchars(trim($_POST["adres_ad"])), MB_CASE_TITLE, "UTF-8"),
            "adres_soyad" => mb_convert_case(htmlspecialchars(trim($_POST["adres_soyad"])), MB_CASE_TITLE, "UTF-8"),
            "adres_gsm" => htmlspecialchars(trim($_POST["adres_gsm"])),
            "adres_il" => htmlspecialchars(trim($_POST["adres_il"])),
            "adres_ilce" => htmlspecialchars(trim($_POST["adres_ilce"])),
            "adres_mahalle" => htmlspecialchars(trim($_POST["adres_mahalle"])),
            "adres_adres" => htmlspecialchars(trim($_POST["adres_adres"])),
        ));
    }
    /* if ($firma == 0) {
        // Eğer adres kaydı yoksa yeni bir satır ekle
        $insert_firma = $db->prepare("insert into firma set 
            kullanici_id=:kullanici_id,
            firma_ad=:firma_ad,
            firma_vdaire=:firma_vdaire,
            firma_vno=:firma_vno");

        $insertfirma = $insert_firma->execute(array(
            'kullanici_id' => $kullanici_id,
            "firma_ad" => htmlspecialchars(trim($_POST["firma_ad"])),
            "firma_vdaire" => htmlspecialchars(trim($_POST["firma_vdaire"])),
            "firma_vno" => htmlspecialchars(trim($_POST["firma_vno"]))
        ));
    }
    if ($firma != 0) {
        $update_firma = $db->prepare("update firma set 
            firma_ad=:firma_ad,
            firma_vdaire=:firma_vdaire,
            firma_vno=:firma_vno

            where kullanici_id = $kullanici_id");

        $updatefirma = $update_firma->execute(array(
            "firma_ad" => htmlspecialchars(trim($_POST["firma_ad"])),
            "firma_vdaire" => htmlspecialchars(trim($_POST["firma_vdaire"])),
            "firma_vno" => htmlspecialchars(trim($_POST["firma_vno"]))
        ));
    } */

    if ($updateadres || $insertadres || $insertfirma || $updatefirma) {
        header("location: ../../adres?adres=ok");
        exit;
    } else {
        header("location: ../../adres?adres=no");
        exit;
    }
}

if (isset($_POST['kullanici_sifre_duzenle'])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $kullanici_password_old = htmlspecialchars(trim($_POST['kullanici_password_old']));
    $kullanici_password_new1 = htmlspecialchars(trim($_POST['kullanici_password_new1']));
    $kullanici_password_new2 = htmlspecialchars(trim($_POST['kullanici_password_new2']));

    $kullanici_password = md5($kullanici_password_old);
    $kullanici_id = $_SESSION['user_kullanici_mail'];

    $kullanicisor = $db->prepare("select * from kullanici 
    where kullanici_id=:id and kullanici_password=:password");
    $kullanicisor->execute(array(
        'id' => $kullanici_id,
        'password' => $kullanici_password
    ));

    //dönen satır sayısını belirtir
    $say = $kullanicisor->rowCount();


    if ($say == 0) {

        header("Location:../../sifrem?sifrem=eskisifrehata");
        exit;

    } else {

        //eski şifre doğruysa başla
        if ($kullanici_password_new1 == $kullanici_password_new2) {

            $eksikler = [];

            if (strlen($kullanici_password_new1) < 10) {
                $eksikler[] = "karakter";
            }

            if (!preg_match('/[A-Z]/', $kullanici_password_new1)) {
                $eksikler[] = "buyukharf";
            }

            if (!preg_match('/[a-z]/', $kullanici_password_new1)) {
                $eksikler[] = "kucukharf";
            }

            if (!preg_match('/[0-9]/', $kullanici_password_new1)) {
                $eksikler[] = "rakam";
            }

            if (!empty($eksikler)) {
                $durum = implode("-", $eksikler);
                header("location:../../sifrem.php?durum=$durum");
            } else {

                $password = md5($kullanici_password_new1);

                $kullanici_yetki = 1;

                $kullanicikaydet = $db->prepare("UPDATE kullanici SET
                kullanici_password=:kullanici_password
                WHERE kullanici_id=$kullanici_id");

                $update = $kullanicikaydet->execute(array(
                    'kullanici_password' => $password
                ));

                if ($update) {
                    header("Location:../../sifrem?sifrem=ok");
                    exit;
                } else {
                    header("Location:../../sifrem?sifrem=no");
                    exit;
                }
            }

        } else {

            header("Location:../../sifrem?sifrem=sifreleruyusmuyor");
            exit;

        }
    }
}

if (isset($_POST["kullanici_teklif_basvuru"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $kullanici_id = $_SESSION['user_kullanici_mail'];   // burada mail değil id geliyor aslında

    $kontrol_banka = $db->prepare("SELECT * FROM banka WHERE kullanici_id=:kullanici_id");
    $kontrol_banka->execute(array(
        'kullanici_id' => $kullanici_id
    ));
    $banka = $kontrol_banka->rowCount();

    $kontrol_firma = $db->prepare("SELECT * FROM firma WHERE kullanici_id=:kullanici_id");
    $kontrol_firma->execute(array(
        'kullanici_id' => $kullanici_id
    ));
    $firma = $kontrol_firma->rowCount();

    $update_kullanici_tip = $db->prepare(
        "update kullanici set 
            kullanici_ad=:kullanici_ad,
            kullanici_soyad=:kullanici_soyad,
            kullanici_tip=:kullanici_tip,
            kullanici_gsm=:kullanici_gsm,
            kullanici_il=:kullanici_il,
            kullanici_teklif_alma_verme=:kullanici_teklif_alma_verme
            
            where kullanici_id = $kullanici_id"
    );

    $updatekullanicitip = $update_kullanici_tip->execute(array(
        'kullanici_ad' => htmlspecialchars(trim($_POST["kullanici_ad"])),
        'kullanici_soyad' => htmlspecialchars(trim($_POST["kullanici_soyad"])),
        'kullanici_tip' => htmlspecialchars(trim($_POST["kullanici_tip"])),
        'kullanici_il' => htmlspecialchars(trim($_POST["kullanici_il"])),
        'kullanici_gsm' => htmlspecialchars(trim($_POST["kullanici_gsm"])),
        'kullanici_teklif_alma_verme' => 1
    ));

    if ($banka == 0) {
        // Eğer adres kaydı yoksa yeni bir satır ekle
        $insert_banka = $db->prepare("insert into banka set 
            kullanici_id=:kullanici_id,
            banka_ad=:banka_ad,
            banka_iban=:banka_iban,
            banka_hesapadsoyad=:banka_hesapadsoyad");

        $insertbanka = $insert_banka->execute(array(
            'kullanici_id' => $kullanici_id,
            "banka_ad" => htmlspecialchars(trim($_POST["banka_ad"])),
            "banka_iban" => htmlspecialchars(trim($_POST["banka_iban"])),
            "banka_hesapadsoyad" => htmlspecialchars(trim($_POST["banka_hesapadsoyad"]))
        ));
    }
    if ($banka != 0) {
        $update_banka = $db->prepare("update banka set 
            banka_ad=:banka_ad,
            banka_iban=:banka_iban,
            banka_hesapadsoyad=:banka_hesapadsoyad

            where kullanici_id = $kullanici_id");

        $updatebanka = $update_banka->execute(array(
            "banka_ad" => htmlspecialchars(trim($_POST["banka_ad"])),
            "banka_iban" => htmlspecialchars(trim($_POST["banka_iban"])),
            "banka_hesapadsoyad" => htmlspecialchars(trim($_POST["banka_hesapadsoyad"]))
        ));
    }
    if (htmlspecialchars(trim($_POST["kullanici_tip"])) == "PRIVATE_COMPANY") {

        if ($firma == 0) {
            // Eğer adres kaydı yoksa yeni bir satır ekle
            $insert_firma = $db->prepare("insert into firma set 
                kullanici_id=:kullanici_id,
                firma_ad=:firma_ad,
                firma_vdaire=:firma_vdaire,
                firma_vno=:firma_vno");

            $insertfirma = $insert_firma->execute(array(
                'kullanici_id' => $kullanici_id,
                "firma_ad" => htmlspecialchars(trim($_POST["firma_ad"])),
                "firma_vdaire" => htmlspecialchars(trim($_POST["firma_vdaire"])),
                "firma_vno" => htmlspecialchars(trim($_POST["firma_vno"]))
            ));
        }
        if ($firma != 0) {
            $update_firma = $db->prepare("update firma set 
                firma_ad=:firma_ad,
                firma_vdaire=:firma_vdaire,
                firma_vno=:firma_vno
    
                where kullanici_id = $kullanici_id");

            $updatefirma = $update_firma->execute(array(
                "firma_ad" => htmlspecialchars(trim($_POST["firma_ad"])),
                "firma_vdaire" => htmlspecialchars(trim($_POST["firma_vdaire"])),
                "firma_vno" => htmlspecialchars(trim($_POST["firma_vno"]))
            ));
        }

    }

    if ($updatebanka || $insertbanka || $insertadres || $updateadres || $insertfirma || $updatefirma) {
        header("location: ../../teklif-al-ver-basvuru");
        exit;
    } else {
        header("location: ../../teklif-al-ver-basvuru");
        exit;
    }
}

if (isset($_POST["talep_olustur"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $talep_seourl = seo(htmlspecialchars(trim($_POST["talep_ad"])));

    $kullanici_id = $_SESSION['user_kullanici_mail'];   // burada aslında mail değil id gelmekte...

    $yakit = isset($_POST['yakit']) ? $_POST['yakit'] : [];
    $yakit_string = htmlspecialchars(trim(implode(", ", $yakit)));

    $kasa = isset($_POST['kasa']) ? $_POST['kasa'] : [];
    $kasa_string = htmlspecialchars(trim(implode(", ", $kasa)));

    $kapi = isset($_POST['kapi']) ? $_POST['kapi'] : [];
    $kapi_string = htmlspecialchars(trim(implode(", ", $kapi)));

    $vites = isset($_POST['vites']) ? $_POST['vites'] : [];
    $vites_string = htmlspecialchars(trim(implode(", ", $vites)));

    $talep_min_yil = !empty($_POST['talep_min_yil']) ? htmlspecialchars(trim($_POST['talep_min_yil'])) : 0;
    $yil = date("Y"); // 2025
    $talep_max_yil = !empty($_POST['talep_max_yil']) ? htmlspecialchars(trim($_POST['talep_max_yil'])) : $yil;
    if (isset($_POST['talep_max_yil']) && $_POST['talep_max_yil'] > $yil) {
        $talep_max_yil = $yil;
    }

    $talep_min_km = !empty($_POST['talep_min_km']) ? htmlspecialchars(trim($_POST['talep_min_km'])) : 0;
    $talep_max_km = !empty($_POST['talep_max_km']) ? htmlspecialchars(trim($_POST['talep_max_km'])) : 10000000;

    $talep_uzeri_teklif = !empty($_POST['talep_uzeri_teklif']) ? htmlspecialchars(trim($_POST['talep_uzeri_teklif'])) : 0;

    $insert_talep = $db->prepare("insert into talep set 
        kullanici_id=:kullanici_id,
        kategori_id=:kategori_id,
        talep_ad=:talep_ad,
        talep_marka=:talep_marka,
        talep_min_yil=:talep_min_yil,
        talep_max_yil=:talep_max_yil,
        talep_yakit_tipi=:talep_yakit_tipi,
        talep_kasa_tipi=:talep_kasa_tipi,
        talep_kapi_sayisi=:talep_kapi_sayisi,
        talep_vites_tipi=:talep_vites_tipi,
        talep_min_km=:talep_min_km,
        talep_max_km=:talep_max_km,
        talep_fiyat=:talep_fiyat,
        talep_uzeri_teklif=:talep_uzeri_teklif,
        talep_sehir=:talep_sehir,
        talep_cember_yaricap=:talep_cember_yaricap,
        talep_konum_enlem=:talep_konum_enlem, 
        talep_konum_boylam=:talep_konum_boylam,
        talep_detay=:talep_detay,
        talep_seourl=:talep_seourl,
        talep_durum=:talep_durum");

    $inserttalep = $insert_talep->execute(array(
        'kullanici_id' => $kullanici_id,
        "kategori_id" => htmlspecialchars(trim($_POST["kategori_id"])),
        "talep_ad" => htmlspecialchars(trim($_POST["talep_ad"])),
        "talep_marka" => htmlspecialchars(trim($_POST["talep_marka"])),
        "talep_min_yil" => $talep_min_yil,
        "talep_max_yil" => $talep_max_yil,
        "talep_yakit_tipi" => $yakit_string,
        "talep_kasa_tipi" => $kasa_string,
        "talep_kapi_sayisi" => $kapi_string,
        "talep_vites_tipi" => $vites_string,
        "talep_min_km" => $talep_min_km,
        "talep_max_km" => $talep_max_km,
        "talep_fiyat" => htmlspecialchars(trim($_POST["talep_fiyat"])),
        "talep_uzeri_teklif" => $talep_uzeri_teklif,
        "talep_sehir" => htmlspecialchars(trim($_POST["talep_sehir"])),
        "talep_cember_yaricap" => htmlspecialchars(trim($_POST["talep_cember_yaricap"])),
        "talep_konum_enlem" => htmlspecialchars(trim($_POST["talep_konum_enlem"])),
        "talep_konum_boylam" => htmlspecialchars(trim($_POST["talep_konum_boylam"])),
        "talep_detay" => $_POST["talep_detay"],
        "talep_seourl" => $talep_seourl,
        "talep_durum" => 0
    ));

    if ($inserttalep) {
        header("location: ../../taleplerim?durum=ok");
        exit;
    } else {
        header("location: ../../taleplerim?durum=no");
        exit;
    }
}


if (isset($_POST["talep_duzenle"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $talep_seourl = seo(htmlspecialchars(trim($_POST["talep_ad"])));

    $kullanici_id = $_SESSION['user_kullanici_mail'];   // burada aslında mail değil id gelmekte...
    $talep_id = $_POST['talep_id'];

    $yakit = isset($_POST['yakit']) ? $_POST['yakit'] : [];
    $yakit_string = htmlspecialchars(trim(implode(", ", $yakit)));

    $kasa = isset($_POST['kasa']) ? $_POST['kasa'] : [];
    $kasa_string = htmlspecialchars(trim(implode(", ", $kasa)));

    $kapi = isset($_POST['kapi']) ? $_POST['kapi'] : [];
    $kapi_string = htmlspecialchars(trim(implode(", ", $kapi)));

    $vites = isset($_POST['vites']) ? $_POST['vites'] : [];
    $vites_string = htmlspecialchars(trim(implode(", ", $vites)));

    $talep_min_yil = !empty($_POST['talep_min_yil']) ? htmlspecialchars(trim($_POST['talep_min_yil'])) : 0;
    $yil = date("Y"); // 2025
    $talep_max_yil = !empty($_POST['talep_max_yil']) ? htmlspecialchars(trim($_POST['talep_max_yil'])) : $yil;

    $talep_min_km = !empty($_POST['talep_min_km']) ? htmlspecialchars(trim($_POST['talep_min_km'])) : 0;
    $talep_max_km = !empty($_POST['talep_max_km']) ? htmlspecialchars(trim($_POST['talep_max_km'])) : 10000000;

    $talep_uzeri_teklif = !empty($_POST['talep_uzeri_teklif']) ? htmlspecialchars(trim($_POST['talep_uzeri_teklif'])) : 0;

    $update_talep = $db->prepare("update talep set 
        kategori_id=:kategori_id,
        talep_ad=:talep_ad,
        talep_marka=:talep_marka,
        talep_min_yil=:talep_min_yil,
        talep_max_yil=:talep_max_yil,
        talep_yakit_tipi=:talep_yakit_tipi,
        talep_kasa_tipi=:talep_kasa_tipi,
        talep_kapi_sayisi=:talep_kapi_sayisi,
        talep_vites_tipi=:talep_vites_tipi,
        talep_min_km=:talep_min_km,
        talep_max_km=:talep_max_km,
        talep_fiyat=:talep_fiyat,
        talep_uzeri_teklif=:talep_uzeri_teklif,
        talep_sehir=:talep_sehir,
        talep_cember_yaricap=:talep_cember_yaricap,
        talep_konum_enlem=:talep_konum_enlem, 
        talep_konum_boylam=:talep_konum_boylam,
        talep_detay=:talep_detay,
        talep_seourl=:talep_seourl
        where talep_id = $talep_id");

    $updatetalep = $update_talep->execute(array(
        "kategori_id" => htmlspecialchars(trim($_POST["kategori_id"])),
        "talep_ad" => htmlspecialchars(trim($_POST["talep_ad"])),
        "talep_marka" => htmlspecialchars(trim($_POST["talep_marka"])),
        "talep_min_yil" => $talep_min_yil,
        "talep_max_yil" => $talep_max_yil,
        "talep_yakit_tipi" => $yakit_string,
        "talep_kasa_tipi" => $kasa_string,
        "talep_kapi_sayisi" => $kapi_string,
        "talep_vites_tipi" => $vites_string,
        "talep_min_km" => $talep_min_km,
        "talep_max_km" => $talep_max_km,
        "talep_fiyat" => htmlspecialchars(trim($_POST["talep_fiyat"])),
        "talep_uzeri_teklif" => $talep_uzeri_teklif,
        "talep_sehir" => htmlspecialchars(trim($_POST["talep_sehir"])),
        "talep_cember_yaricap" => htmlspecialchars(trim($_POST["talep_cember_yaricap"])),
        "talep_konum_enlem" => htmlspecialchars(trim($_POST["talep_konum_enlem"])),
        "talep_konum_boylam" => htmlspecialchars(trim($_POST["talep_konum_boylam"])),
        "talep_detay" => $_POST["talep_detay"],
        "talep_seourl" => $talep_seourl
    ));

    if ($updatetalep) {
        header("location: ../../taleplerim?talep_duzenle=ok");
        exit;
    } else {
        header("location: ../../taleplerim?talep_duzenle=no");
        exit;
    }
}

if (isset($_GET["talep_kaldır"]) && $_GET["talep_kaldır"] === "ok") {

    $talep_id = $_GET["talep_id"];

    $update_talep = $db->prepare("update talep set 
        talep_durum=:talep_durum
        where talep_id = $talep_id");

    $updatetalep = $update_talep->execute(array(
        "talep_durum" => 2,
    ));

    if ($updatetalep) {
        header("location: ../../taleplerim.php?talep_kaldir=ok");
        exit;
    } else {
        header("location: ../../taleplerim.php?talep_kaldir=no");
        exit;
    }
}

if (isset($_POST["teklif_ver"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    $insert_teklif = $db->prepare("insert into teklif set 

            talep_id=:talep_id,
            teklif_veren_kullanici_id=:teklif_veren_kullanici_id,
            teklif_fiyat=:teklif_fiyat,
            teklif_aciklama=:teklif_aciklama,
            teklif_sehir_ilce=:teklif_sehir_ilce,
            teklif_cember_yaricap=:teklif_cember_yaricap,
            teklif_konum_enlem=:teklif_konum_enlem, 
            teklif_konum_boylam=:teklif_konum_boylam,
            teklif_onay_durum=:teklif_onay_durum"
    );

    $insertteklif = $insert_teklif->execute(array(
        "talep_id" => htmlspecialchars(trim($_POST["talep_id"])),       // teklif verilecek talepin idsi geliyor.
        "teklif_veren_kullanici_id" => $_SESSION['user_kullanici_mail'],     // teklif veren kullanıcının idsi geliyor.
        "teklif_fiyat" => htmlspecialchars(trim($_POST["teklif_fiyat"])),
        "teklif_aciklama" => htmlspecialchars(trim($_POST["teklif_aciklama"])),
        "teklif_sehir_ilce" => htmlspecialchars(trim($_POST["teklif_sehir_ilce"])),
        "teklif_cember_yaricap" => htmlspecialchars(trim($_POST["teklif_cember_yaricap"])),
        "teklif_konum_enlem" => htmlspecialchars(trim($_POST["teklif_konum_enlem"])),
        "teklif_konum_boylam" => htmlspecialchars(trim($_POST["teklif_konum_boylam"])),
        "teklif_onay_durum" => 0
    ));

    if ($insertteklif) {
        header("location: ../../verilen-teklifler.php");
        exit;
    } else {
        header("location: ../../alinan-teklifler.php");
        exit;
    }
}

if (isset($_GET["talep_url_teklif"])) {
    $talep_url = $_GET["talep_url_teklif"];
    header("location: ../../$talep_url");
}

if (isset($_GET["talep_url_taleplerim"])) {
    $talep_url = $_GET["talep_url_taleplerim"];
    header("location: ../../$talep_url");
}

if (isset($_POST["teklif_duzenle"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    echo $teklif_id = htmlspecialchars(trim($_POST["teklif_id"]));

    $update_teklif = $db->prepare("update teklif set 

            teklif_fiyat=:teklif_fiyat,
            teklif_aciklama=:teklif_aciklama,
            teklif_sehir_ilce=:teklif_sehir_ilce,
            teklif_cember_yaricap=:teklif_cember_yaricap,
            teklif_konum_enlem=:teklif_konum_enlem, 
            teklif_konum_boylam=:teklif_konum_boylam

            where teklif_id = $teklif_id ");

    $updateteklif = $update_teklif->execute(array(
        "teklif_fiyat" => htmlspecialchars(trim($_POST["teklif_fiyat"])),
        "teklif_aciklama" => htmlspecialchars(trim($_POST["teklif_aciklama"])),
        "teklif_sehir_ilce" => htmlspecialchars(trim($_POST["teklif_sehir_ilce"])),
        "teklif_cember_yaricap" => htmlspecialchars(trim($_POST["teklif_cember_yaricapp"])),
        "teklif_konum_enlem" => htmlspecialchars(trim($_POST["teklif_konum_enlem"])),
        "teklif_konum_boylam" => htmlspecialchars(trim($_POST["teklif_konum_boylam"])),
    ));

    if ($_POST["teklif_onay_durum"] == 1) {
        $update_teklif = $db->prepare("update teklif set 

            teklif_onay_durum=:teklif_onay_durum
            where teklif_id = $teklif_id ");

        $updateteklif = $update_teklif->execute(array(
            "teklif_onay_durum" => 2,
        ));
    }

    if ($updateteklif) {
        header("location: ../../verilen-teklifler.php?durum=guncellendi");
        exit;
    } else {
        header("location: ../../alinan-teklifler.php?durum=guncellenemedi");
        exit;
    }
}

if (isset($_GET["teklif_kaldir"]) && $_GET["teklif_kaldir"] === "ok") {

    $teklif_id = $_GET["teklif_id"];

    $delete_teklif = $db->prepare("delete from teklif 
        where teklif_id = $teklif_id");

    $deleteteklif = $delete_teklif->execute();

    if ($deleteteklif) {
        header("location: ../../verilen-teklifler.php?teklif_kaldir=ok");
        exit;
    } else {
        header("location: ../../verilen-teklifler.php?teklif_kaldir=no");
        exit;
    }
}

if (isset($_POST["revize_iste"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    echo $teklif_id = htmlspecialchars(trim($_POST["teklif_id"]));


    $update_teklif = $db->prepare("update teklif set 

            teklif_onay_durum=:teklif_onay_durum
            where teklif_id = $teklif_id ");

    $updateteklif = $update_teklif->execute(array(
        "teklif_onay_durum" => 1,
    ));


    if ($updateteklif) {
        header("location: ../../alinan-teklifler.php?durum=guncellendi");
        exit;
    } else {
        header("location: ../../alinan-teklifler.php?durum=guncellenemedi");
        exit;
    }
}

if (isset($_POST["teklif_onayla"])) {

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz istek (CSRF)!");
    }

    echo $teklif_id = htmlspecialchars(trim($_POST["teklif_id"]));

    $update_teklif = $db->prepare("update teklif set 

            teklif_onay_durum=:teklif_onay_durum
            where teklif_id = $teklif_id ");

    $updateteklif = $update_teklif->execute(array(
        "teklif_onay_durum" => 3,
    ));


    if ($updateteklif) {
        header("location: ../../alinan-teklifler.php?durum=guncellendi");
        exit;
    } else {
        header("location: ../../alinan-teklifler.php?durum=guncellenemedi");
        exit;
    }
}

if (isset($_GET["teklif_reddet"]) && $_GET["teklif_reddet"] === "ok") {

    $teklif_id = $_GET["teklif_id"];

    $update_teklif = $db->prepare("update teklif set 
        teklif_onay_durum=:teklif_onay_durum
        where teklif_id = $teklif_id");

    $updateteklif = $update_teklif->execute(array(
        "teklif_onay_durum" => 4,
    ));

    if ($updateteklif) {
        header("location: ../../alinan-teklifler.php?teklif_reddet=ok");
        exit;
    } else {
        header("location: ../../alinan-teklifler.php?teklif_reddet=no");
        exit;
    }
}

if (isset($_GET["kullanici_aktif_degil"])) {
    header("location: ../../teklif-al-ver-basvuru");
    exit;
}
?>