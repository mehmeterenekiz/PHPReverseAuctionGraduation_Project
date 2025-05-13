<?php
ob_start();
session_start();
require_once 'baglan.php';
require_once "../production/fonksiyon.php";

if (isset($_POST['teklif_id'])) {
    if (!empty($_POST['teklif_id'])) {
        $teklifsor = $db->prepare("SELECT * FROM teklif WHERE teklif_id = :teklif_id");
        $teklifsor->execute(array(
            'teklif_id' => $_POST['teklif_id']
        ));
        $teklifcek = $teklifsor->fetch(PDO::FETCH_ASSOC);
        
        if ($teklifcek) {
            $data = [
                'status' => true,
                'message' => 'Veri başarıyla alındı',
                'data' => $teklifcek,  // Veriyi 'data' anahtarında gönderiyoruz
            ];
            echo json_encode($data);
        } else {
            // Veri bulunamadığında
            $data = [
                'status' => false,
                'message' => 'Veri bulunamadı',
                'code' => 404,
            ];
            echo json_encode($data);
        }
    } else {
        // Teklif ID boşsa
        http_response_code(403);
        $data = [
            'status' => false,
            'message' => 'Teklif ID boş',
            'code' => 403,
        ];
        die(json_encode($data));
    }
} else {
    // Teklif ID gelmemişse
    http_response_code(403);
    $data = [
        'status' => false,
        'message' => 'Teklif ID gelmedi',
        'code' => 403,
    ];
    die(json_encode($data));
}


?>
