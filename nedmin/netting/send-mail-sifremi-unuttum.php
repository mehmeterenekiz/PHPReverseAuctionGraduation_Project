<?php
ob_start();
session_start();
require_once "baglan.php";
require_once "../production/fonksiyon.php";

$ayarsor = $db->prepare("select * from ayar where ayar_id=:id");
$ayarsor->execute(array(
    "id" => 0,
));
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../../vendor/autoload.php';

if (isset($_POST['sifremi_unuttum'])) {

    $kullanici_mail = $_POST["kullanici_email"];

    $kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_mail=:kullanici_mail");
    $kullanicisor->execute(array(
        'kullanici_mail' => $kullanici_mail
    ));
    $say = $kullanicisor->rowCount();

    if ($say == 0) {
        Header("location:../../sign-in.php");
        exit;
    } else {
        $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

        global $ayarcek;
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $ayarcek['ayar_smtphost'];                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = $ayarcek['ayar_smtpuser'];                     //SMTP username
            $mail->Password = $ayarcek['ayar_smtppassword'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = $ayarcek['ayar_smtpport'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";

            //Recipients
            $mail->setFrom($ayarcek['ayar_smtpuser'], 'Reverse Auction');
            // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress($kullanici_mail);               //Name is optional

            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name


            $mail->isHTML(true);

            $mail->Subject = 'Şifre Değişikliği';

            $isim = $kullanicicek['kullanici_ad'];
            $soyisim = $kullanicicek['kullanici_soyad'];
            $yeniSifre = bin2hex(openssl_random_pseudo_bytes(8));


            $update_sifre = $db->prepare("UPDATE kullanici SET 
                kullanici_password = :kullanici_password
                WHERE kullanici_mail = :kullanici_mail");

            $updatesifre = $update_sifre->execute(array(
                "kullanici_password" => md5($yeniSifre),
                "kullanici_mail" => $kullanici_mail
            ));

            $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; padding: 20px;">
                <div style="background-color: #2553a1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;">
                    <h2>Reverse Auction - İletişim</h2>
                </div>
                <div style="margin: 20px 0; padding: 20px; background-color: #ffffff; border-radius: 5px; border: 1px solid #dddddd;">
                    <p>Merhaba sayın <strong>' . htmlspecialchars($isim) . " " . htmlspecialchars($soyisim) . '</strong>,</p>
                    <p>Yeni şifre talebinizi aldık.</p>
                    <p><strong>Yeni Şifreniz:</strong> ' . nl2br(htmlspecialchars($yeniSifre)) . ' </p>
                </div>
                <div style="margin-top: 20px; text-align: center; font-size: 0.9em; color: #777777;">
                    <p>Teşekkürler</p>
                    <p>Reverse Auction Proje Ekibi</p>
                </div>
            </div>
        ';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 

            if($mail->send()){
                Header("location:../../sign-in.php?durum=mailgonderildi");
            }else{
                Header("location:../../sign-in.php?durum=mailgonderilemedi");
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>