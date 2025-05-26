<?php
session_start();
ob_start();
require_once 'nedmin/netting/baglan.php';
require_once 'nedmin/netting/fonksiyonlar.php';
require_once 'nedmin/production/fonksiyon.php';
if (isset($_GET['kod'])) {
    $kod = $_GET['kod'];
    $sorgu = $db->prepare("SELECT * FROM kullanici WHERE dogrulama_kodu=:kod AND dogrulama_durumu= '0' ");
    $sorgu->execute(array(
        'kod' => $kod
    ));

    $say = $sorgu->rowCount();

    if ($say > 0) {
        $kullanicicek = $sorgu->fetch(PDO::FETCH_ASSOC);
        $kullanici_id = $kullanicicek['kullanici_id'];
        $guncelle = $db->prepare("UPDATE kullanici SET dogrulama_durumu= '1', dogrulama_kodu=NULL  WHERE dogrulama_kodu=:kod");
        $guncelle->execute([
            'kod' => $kod,
        ]);

        $kullanici_id = $kullanicicek["kullanici_id"];
        $_SESSION["user_kullanici_mail"] = $kullanici_id;   // id gönderiliyor
        echo $_SESSION["user_kullanici_mail"];
        header("location:../../teklif-al-ver-basvuru");
        exit;
    } else {
        echo "Geçersiz veya zaten doğrulanmış bağlantı.";
    }
} else {
    echo "Kod bulunamadı.";
}
?>