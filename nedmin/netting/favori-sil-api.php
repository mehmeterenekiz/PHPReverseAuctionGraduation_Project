<?php
ob_start();
session_start();
require_once 'baglan.php';
require_once "../production/fonksiyon.php";

$talep_id = isset($_POST['talep_id']) ? htmlspecialchars($_POST['talep_id']) : null;
$kullanici_id = $_SESSION['user_kullanici_mail'];

switch ($_GET['mode']) {
    case 'delete':
        if ($talep_id) {
            $sil = $db->prepare("DELETE FROM favori WHERE talep_id=:talep_id AND kullanici_id=:kullanici_id");
            $sil->execute([
                'talep_id' => $talep_id,
                'kullanici_id' => $kullanici_id
            ]);
            echo $sil->rowCount() > 0 ? "ok" : "no";
        }
        break;

    case 'insert':
        if ($talep_id) {
            $ekle = $db->prepare("INSERT INTO favori SET talep_id=:talep_id, kullanici_id=:kullanici_id");
            $ekle->execute([
                'talep_id' => $talep_id,
                'kullanici_id' => $kullanici_id
            ]);
            echo $ekle->rowCount() > 0 ? "ok" : "no";
        }
        break;
}
?>
