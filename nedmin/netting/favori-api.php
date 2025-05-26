<?php
ob_start();
session_start();
require_once 'baglan.php';
require_once "../production/fonksiyon.php";

$talep_id = isset($_POST['talep_id']) ? htmlspecialchars($_POST['talep_id']) : null;
$kullanici_id = $_SESSION['user_kullanici_mail'];

switch ($_GET['mode']) {

    case 'delete':

        if ($_POST['talep_id']) {

            $sil = $db->prepare("DELETE FROM favori WHERE talep_id=:talep_id AND kullanici_id=:kullanici_id");
            $sil->execute([
                'talep_id' => $talep_id,
                'kullanici_id' => $kullanici_id
            ]);

            if ($sil->rowCount() > 0) {
                echo "ok";
            } else {
                echo "no";
            }
        }
        break;

    case 'insert':

        break;
    
}
?>