<?php
ob_start();
session_start();

require_once "baglan.php";
require_once "../production/fonksiyon.php";

if (isset($_POST["admin_giris"])) {

    $kullanici_mail = $_POST["kullanici_mail"];
    $kullanici_password = md5($_POST["kullanici_password"]);

    $kullanicisor = $db->prepare("select * from kullanici 
    where kullanici_mail=:kullanici_mail and kullanici_password=:kullanici_password and kullanici_yetki=:kullanici_yetki");
    $kullanicisor->execute(array(
        "kullanici_mail" => $kullanici_mail,
        "kullanici_password" => $kullanici_password,
        "kullanici_yetki" => 5
    ));

    $say = $kullanicisor->rowCount();

    if ($say == 1) {
        $kullanicidene = $db->prepare("select * from kullanici where kullanici_mail=:mail");
        $kullanicidene->execute(array(
            'mail' => $kullanici_mail,
        ));
        $kullanicicek = $kullanicidene->fetch(PDO::FETCH_ASSOC);
        $kullanici_id = $kullanicicek["kullanici_id"];
        $_SESSION["kullanici_mail"] = $kullanici_id;
        header("location:../production/index.php");
        exit;

    } else {
        header("location:../../admin_login_page/admin_login.php?durum=no");
        exit;
    }
}

if (isset($_POST['logo_duzenle'])) {

    if ($_FILES['ayar_logo']['size'] > 1048576) {

        echo "Bu dosya boyutu çok büyük";

        Header("Location:../production/genel_ayarlar.php?durum=dosyabuyuk");

    }


    $izinli_uzantilar = array('jpg', 'png');

    //echo $_FILES['ayar_logo']["name"];

    $ext = strtolower(substr($_FILES['ayar_logo']["name"], strpos($_FILES['ayar_logo']["name"], '.') + 1));

    if (in_array($ext, $izinli_uzantilar) === false) {
        echo "Bu uzantı kabul edilmiyor";
        Header("Location:../production/genel_ayarlar.php?durum=formathata");

        exit;
    }

    $uploads_dir = '../../images';

    @$tmp_name = $_FILES['ayar_logo']["tmp_name"];
    @$name = $_FILES['ayar_logo']["name"];

    $benzersizsayi4 = rand(20000, 32000);
    $refimgyol = "";

    // Dosya yüklenmişse işlemi yap
    if (!empty($name)) {
        $refimgyol = substr($uploads_dir, 6) . "/" . $benzersizsayi4 . " " . $name;
        @move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4 $name");
    }

    $duzenle = $db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
    $update = $duzenle->execute(array(
        'logo' => $refimgyol
    ));

    if ($update) {

        $resimsilunlink = $_POST['eski_yol'];
        unlink("../../$resimsilunlink");
        Header("Location:../production/genel_ayarlar.php?durum=ok");

    } else {

        Header("Location:../production/genel_ayarlar.php?durum=no");
    }
}

if (isset($_POST["genel_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update ayar set 
    
        ayar_title=:ayar_title,
        ayar_description=:ayar_description,
        ayar_keywords=:ayar_keywords,
        ayar_author=:ayar_author
        
        where ayar_id=0");

    $update = $ayar_kaydet->execute(array(
        "ayar_title" => $_POST["ayar_title"],
        "ayar_description" => $_POST["ayar_description"],
        "ayar_keywords" => $_POST["ayar_keywords"],
        "ayar_author" => $_POST["ayar_author"],
    ));

    if ($update) {
        header("location: ../production/genel_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/genel_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["iletisim_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update ayar set 
    
        ayar_tel=:ayar_tel,
        ayar_gsm=:ayar_gsm,
        ayar_faks=:ayar_faks,
        ayar_mail=:ayar_mail,
        ayar_ilce=:ayar_ilce,
        ayar_il=:ayar_il,
        ayar_adres=:ayar_adres,
        ayar_mesai=:ayar_mesai
        
        where ayar_id=0");

    $update = $ayar_kaydet->execute(array(
        "ayar_tel" => $_POST["ayar_tel"],
        "ayar_gsm" => $_POST["ayar_gsm"],
        "ayar_faks" => $_POST["ayar_faks"],
        "ayar_mail" => $_POST["ayar_mail"],
        "ayar_ilce" => $_POST["ayar_ilce"],
        "ayar_il" => $_POST["ayar_il"],
        "ayar_adres" => $_POST["ayar_adres"],
        "ayar_mesai" => $_POST["ayar_mesai"],
    ));

    if ($update) {
        header("location: ../production/iletisim_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/iletisim_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["api_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update ayar set 
    
        ayar_analystic=:ayar_analystic,
        ayar_maps=:ayar_maps,
        ayar_zopim=:ayar_zopim
        
        where ayar_id=0");


    $update = $ayar_kaydet->execute(array(
        "ayar_analystic" => $_POST["ayar_analystic"],
        "ayar_maps" => $_POST["ayar_maps"],
        "ayar_zopim" => $_POST["ayar_zopim"],
    ));

    if ($update) {
        header("location: ../production/api_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/api_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["sosyal_aglar_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update ayar set 
    
        ayar_facebook=:ayar_facebook,
        ayar_twitter=:ayar_twitter,
        ayar_instagram=:ayar_instagram,
        ayar_youtube=:ayar_youtube,
        ayar_linkedin=:ayar_linkedin

        where ayar_id=0");


    $update = $ayar_kaydet->execute(array(
        "ayar_facebook" => $_POST["ayar_facebook"],
        "ayar_twitter" => $_POST["ayar_twitter"],
        "ayar_instagram" => $_POST["ayar_instagram"],
        "ayar_youtube" => $_POST["ayar_youtube"],
        "ayar_linkedin" => $_POST["ayar_linkedin"],

    ));

    if ($update) {
        header("location: ../production/sosyal_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/sosyal_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["mail_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update ayar set 
    
        ayar_smtphost=:ayar_smtphost,
        ayar_smtpuser=:ayar_smtpuser,
        ayar_smtppassword=:ayar_smtppassword,
        ayar_smtpport=:ayar_smtpport,
        ayar_bakim=:ayar_bakim

        where ayar_id=0");


    $update = $ayar_kaydet->execute(array(
        "ayar_smtphost" => $_POST["ayar_smtphost"],
        "ayar_smtpuser" => $_POST["ayar_smtpuser"],
        "ayar_smtppassword" => $_POST["ayar_smtppassword"],
        "ayar_smtpport" => $_POST["ayar_smtpport"],
        "ayar_bakim" => $_POST["ayar_bakim"],

    ));

    if ($update) {
        header("location: ../production/mail_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/mail_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["hakkimizda_ayar_kaydet"])) {

    $ayar_kaydet = $db->prepare("update hakkimizda set 
    
        hakkimizda_baslik=:hakkimizda_baslik,
        hakkimizda_icerik_baslik=:hakkimizda_icerik_baslik,
        hakkimizda_icerik=:hakkimizda_icerik,
        hakkimizda_video_baslik=:hakkimizda_video_baslik,
        hakkimizda_video=:hakkimizda_video,
        hakkimizda_vizyon_baslik=:hakkimizda_vizyon_baslik,
        hakkimizda_vizyon=:hakkimizda_vizyon,
        hakkimizda_misyon_baslik=:hakkimizda_misyon_baslik,
        hakkimizda_misyon=:hakkimizda_misyon
        
        where hakkimizda_id=0");


    $update = $ayar_kaydet->execute(array(
        "hakkimizda_baslik" => $_POST["hakkimizda_baslik"],
        "hakkimizda_icerik_baslik" => $_POST["hakkimizda_icerik_baslik"],
        "hakkimizda_icerik" => $_POST["hakkimizda_icerik"],
        "hakkimizda_video_baslik" => $_POST["hakkimizda_video_baslik"],
        "hakkimizda_video" => $_POST["hakkimizda_video"],
        "hakkimizda_vizyon_baslik" => $_POST["hakkimizda_vizyon_baslik"],
        "hakkimizda_vizyon" => $_POST["hakkimizda_vizyon"],
        "hakkimizda_misyon_baslik" => $_POST["hakkimizda_misyon_baslik"],
        "hakkimizda_misyon" => $_POST["hakkimizda_misyon"],
    ));

    if ($update) {
        header("location: ../production/hakkimizda_ayarlar.php?durum=ok");
        exit;
    } else {
        header("location: ../production/hakkimizda_ayarlar.php?durum=no");
        exit;
    }
}

if (isset($_POST["menu_duzenle"])) {

    $menu_id = $_POST["menu_id"];

    $menu_seourl = seo($_POST['menu_ad']);

    $ayar_kaydet = $db->prepare("update menu set 

        menu_ad=:menu_ad,
        menu_detay=:menu_detay,
        menu_url=:menu_url,
        menu_sira=:menu_sira,
        menu_seourl=:menu_seourl,
        menu_durum=:menu_durum
        
        where menu_id = $menu_id");


    $update = $ayar_kaydet->execute(array(
        "menu_ad" => $_POST["menu_ad"],
        "menu_detay" => $_POST["menu_detay"],
        "menu_url" => strtolower($_POST["menu_url"]),
        "menu_sira" => $_POST["menu_sira"],
        "menu_seourl" => $menu_seourl,
        "menu_durum" => $_POST["menu_durum"],
    ));

    if ($update) {
        header("location: ../production/menu-duzenle.php?menu_id=$menu_id&durum=ok");
        exit;
    } else {
        header("location: ../production/menu-duzenle.php?menu_id=$menu_id&durum=no");
        exit;
    }
}

if (isset($_GET["menu_sil"]) && $_GET["menu_sil"] === "ok") {

    $menu_id = $_GET["menu_id"];

    $ayar_kaydet = $db->prepare("delete from menu where menu_id=:id");

    $delete = $ayar_kaydet->execute(array(
        "id" => $_GET["menu_id"],
    ));

    if ($delete) {
        header("location: ../production/menu.php?menu_sil=ok");
        exit;
    } else {
        header("location: ../production/menu.php?menu_sil=no");
        exit;
    }
}

if (isset($_POST["menu_kaydet"])) {

    $menu_seourl = seo($_POST["menu_ad"]);

    $ayar_kaydet = $db->prepare("insert into menu set 

        menu_ad=:menu_ad,
        menu_detay=:menu_detay,
        menu_url=:menu_url,
        menu_sira=:menu_sira,
        menu_seourl=:menu_seourl,
        menu_durum=:menu_durum
        ");

    $insert = $ayar_kaydet->execute(array(
        "menu_ad" => $_POST["menu_ad"],
        "menu_detay" => $_POST["menu_detay"],
        "menu_url" => strtolower($_POST["menu_url"]),
        "menu_sira" => $_POST["menu_sira"],
        "menu_seourl" => $menu_seourl,
        "menu_durum" => $_POST["menu_durum"],
    ));

    if ($insert) {
        header("location: ../production/menu.php?&durum=ok");
        exit;
    } else {
        header("location: ../production/menu.php?&durum=no");
        exit;
    }
}

if (isset($_POST["kategori_duzenle"])) {

    $kategori_id = $_POST["kategori_id"];
    $kategori_seourl = seo($_POST['kategori_ad']);

    $ayar_kaydet = $db->prepare("update kategori set 

        kategori_ad=:kategori_ad,
        kategori_sira=:kategori_sira,
        kategori_seourl=:kategori_seourl,
        kategori_durum=:kategori_durum
        
        where kategori_id = $kategori_id");


    $update = $ayar_kaydet->execute(array(
        "kategori_ad" => $_POST["kategori_ad"],
        "kategori_sira" => $_POST["kategori_sira"],
        "kategori_seourl" => $kategori_seourl,
        "kategori_durum" => $_POST["kategori_durum"],
    ));

    if ($update) {
        header("location: ../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=ok");
        exit;
    } else {
        header("location: ../production/kategori-duzenle.php?kategori_id=$kategori_id&durum=no");
        exit;
    }
}

if (isset($_GET["kategori_sil"]) && $_GET["kategori_sil"] === "ok") {

    $kategori_id = $_GET["kategori_id"];

    $ayar_kaydet = $db->prepare("delete from kategori where kategori_id=:id");

    $delete = $ayar_kaydet->execute(array(
        "id" => $_GET["kategori_id"],
    ));

    if ($delete) {
        header("location: ../production/kategori.php?kategori_sil=ok");
        exit;
    } else {
        header("location: ../production/kategori.php?kategori_sil=no");
        exit;
    }
}

if (isset($_POST["kategori_kaydet"])) {

    $kategori_seourl = seo($_POST["kategori_ad"]);

    $ayar_kaydet = $db->prepare("insert into kategori set 

        kategori_ad=:kategori_ad,
        kategori_sira=:kategori_sira,
        kategori_seourl=:kategori_seourl,
        kategori_durum=:kategori_durum
        ");

    $insert = $ayar_kaydet->execute(array(
        "kategori_ad" => $_POST["kategori_ad"],
        "kategori_sira" => $_POST["kategori_sira"],
        "kategori_seourl" => $kategori_seourl,
        "kategori_durum" => $_POST["kategori_durum"],
    ));

    if ($insert) {
        header("location: ../production/kategori.php?&kategori_kaydet=ok");
        exit;
    } else {
        header("location: ../production/kategori.php?&kategori_kaydet=no");
        exit;
    }
}

if (isset($_GET['talep_one_cikar']) and $_GET['talep_one_cikar'] == "ok") {

    $talep_id = $_GET['talep_id'];

    $duzenle = $db->prepare("UPDATE talep SET

		talep_one_cikar=:talep_one_cikar		
		WHERE talep_id=$talep_id");

    $update = $duzenle->execute(array(
        'talep_one_cikar' => $_GET['talep_one']
    ));

    if ($update) {
        Header("Location:../production/talepler.php?durum=ok");
    } else {
        Header("Location:../production/talepler.php?durum=no");
    }
}

if (isset($_GET['talep_onay']) and $_GET['talep_onay'] == "ok") {

    $talep_id = $_GET['talep_id'];

    $duzenle = $db->prepare("UPDATE talep SET

		talep_durum=:talep_durum		
		WHERE talep_id=$talep_id");

    $update = $duzenle->execute(array(
        'talep_durum' => $_GET['talep_one']
    ));

    if ($update) {
        Header("Location:../production/talepler.php?durum=ok");
    } else {
        Header("Location:../production/talepler.php?durum=no");
    }
}


if (isset($_POST['talep_duzenle'])) {

    $talep_id = $_POST['talep_id'];
    $talep_seourl = seo($_POST['talep_ad']);

    $kaydet = $db->prepare("UPDATE talep SET
		kategori_id=:kategori_id,
		talep_ad=:talep_ad,
		talep_detay=:talep_detay,
		talep_fiyat=:talep_fiyat,
		talep_one_cikar=:talep_one_cikar,
		talep_keyword=:talep_keyword,
		talep_durum=:talep_durum,
		talep_seourl=:seourl		
		WHERE talep_id={$_POST['talep_id']}");
    $update = $kaydet->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'talep_ad' => $_POST['talep_ad'],
        'talep_detay' => $_POST['talep_detay'],
        'talep_fiyat' => $_POST['talep_fiyat'],
        'talep_one_cikar' => $_POST['talep_one_cikar'],
        'talep_keyword' => $_POST['talep_keyword'],
        'talep_durum' => $_POST['talep_durum'],
        'seourl' => $talep_seourl));

    if ($update) {

        Header("Location:../production/talep-duzenle.php?durum=ok&talep_id=$talep_id");

    } else {

        Header("Location:../production/talep-duzenle.php?durum=no&talep_id=$talep_id");
    }
}

if (isset($_GET['talep_sil']) and $_GET['talep_sil'] == "ok") {
    
    $sil = $db->prepare("DELETE from talep where talep_id=:talep_id");
    $kontrol = $sil->execute(array(
        'talep_id' => $_GET['talep_id']
    ));

    if ($kontrol) {

        Header("Location:../production/talepler.php?durum=ok");
        exit;
    } else {

        Header("Location:../production/talepler.php?durum=no");
        exit;
    }

}

if (isset($_POST['talep_ekle'])) {

    $talep_seourl = seo($_POST['talep_ad']);

    $kaydet = $db->prepare("INSERT INTO talep SET
		kategori_id=:kategori_id,
		talep_ad=:talep_ad,
		talep_detay=:talep_detay,
		talep_fiyat=:talep_fiyat,
		talep_keyword=:talep_keyword,
		talep_durum=:talep_durum,
		talep_seourl=:seourl		
		");
    $insert = $kaydet->execute(array(
        'kategori_id' => $_POST['kategori_id'],
        'talep_ad' => $_POST['talep_ad'],
        'talep_detay' => $_POST['talep_detay'],
        'talep_fiyat' => $_POST['talep_fiyat'],
        'talep_keyword' => $_POST['talep_keyword'],
        'talep_durum' => $_POST['talep_durum'],
        'seourl' => $talep_seourl
    ));

    if ($insert) {

        Header("Location:../production/talepler.php?durum=ok");

    } else {

        Header("Location:../production/talepler.php?durum=no");
    }

}

if (isset($_POST["kullanici_duzenle"])) {

    $kullanici_id = $_POST["kullanici_id"];

    $ayar_kaydet = $db->prepare("update kullanici set 

        kullanici_ad=:kullanici_ad,
        kullanici_soyad=:kullanici_soyad,
        kullanici_il=:kullanici_il,
        kullanici_yetki=:kullanici_yetki,
        kullanici_durum=:kullanici_durum
        
        where kullanici_id = $kullanici_id ");


    $update = $ayar_kaydet->execute(array(
        "kullanici_ad" => $_POST["kullanici_ad"],
        "kullanici_soyad" => $_POST["kullanici_soyad"],
        "kullanici_il" => $_POST["kullanici_il"],
        "kullanici_yetki" => $_POST["kullanici_yetki"],
        "kullanici_durum" => $_POST["kullanici_durum"],
    ));

    if ($update) {
        header("location: ../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");
        exit;
    } else {
        header("location: ../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
        exit;
    }
}

if (isset($_GET["kullanici_sil"]) && $_GET["kullanici_sil"] === "ok") {

    $kullanici_id = $_GET["kullanici_id"];

    $ayar_kaydet = $db->prepare("delete from kullanici where kullanici_id=:id");

    $delete = $ayar_kaydet->execute(array(
        "id" => $_GET["kullanici_id"],
    ));

    if ($delete) {
        header("location: ../production/kullanici-listesi.php?kullanici_sil=ok");
        exit;
    } else {
        header("location: ../production/kullanici-listesi.php?kullanici_sil=no");
        exit;
    }
}

if (isset($_GET["kullanici_onay"]) && $_GET["kullanici_onay"] === "red") {

    $kullanici_id = $_GET["kullanici_id"];

    $kullanici_guncelle = $db->prepare("update kullanici set kullanici_teklif_alma_verme=:kullanici_teklif_alma_verme 
    
    where kullanici_id=$kullanici_id");

    $update = $kullanici_guncelle->execute(array(
        "kullanici_teklif_alma_verme" => 0
    ));

    if ($update) {
        header("location: ../production/kullanici-onay.php?durum=ok");
        exit;
    } else {
        header("location: ../production/kullanici-onay.php?durum=no");
        exit;
    }
}

if (isset($_POST["kullanici_basvuru_onay"])) {

    $kullanici_id = $_POST["kullanici_id"];

    $kullanici_guncelle = $db->prepare("update kullanici set 
    
    kullanici_ad=:kullanici_ad,
    kullanici_soyad=:kullanici_soyad,
    kullanici_il=:kullanici_il,
    kullanici_yetki=:kullanici_yetki,
    kullanici_durum=:kullanici_durum,
    kullanici_teklif_alma_verme=:kullanici_teklif_alma_verme 
    
    where kullanici_id=$kullanici_id");


    $update = $kullanici_guncelle->execute(array(
        "kullanici_ad" => mb_convert_case(htmlspecialchars(trim($_POST["kullanici_ad"])), MB_CASE_TITLE, "UTF-8"),
        "kullanici_soyad" => mb_convert_case(htmlspecialchars(trim($_POST["kullanici_soyad"])), MB_CASE_TITLE, "UTF-8"),
        "kullanici_il" => htmlspecialchars(trim($_POST["kullanici_il"])),
        "kullanici_yetki" => $_POST["kullanici_yetki"],
        "kullanici_durum" => $_POST["kullanici_durum"],
        "kullanici_teklif_alma_verme" => 2
    ));

    if ($update) {
        header("location: ../production/kullanici-onay.php?onaydurum=ok");
        exit;
    } else {
        header("location: ../production/kullanici-onay.php?onaydurum=no");
        exit;
    }
}

?>