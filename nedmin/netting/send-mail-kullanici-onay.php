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

function mailGonder($kime, $kod, $adsoyad)
{
    global $ayarcek;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $ayarcek['ayar_smtphost']; // Örnek Gmail SMTP
        $mail->SMTPAuth = true;
        $mail->Username = $ayarcek['ayar_smtpuser'];                     //SMTP username
        $mail->Password = $ayarcek['ayar_smtppassword'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = $ayarcek['ayar_smtpport'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";

        $mail->setFrom($ayarcek['ayar_smtpuser'], 'Reverse Auction');
        $mail->addAddress($kime);

        $mail->isHTML(true);
        $mail->Subject = 'E-posta Doğrulama';
        $link = "http://localhost/e-posta-dogrulama.php?kod=$kod";
        $mail->Body = "Lütfen hesabınızı doğrulamak için <a href='$link'>buraya tıklayın</a>.";
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; padding: 20px;">
                <div style="background-color: #2553a1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;">
                    <h2>Reverse Auction - Hesap Doğrulama</h2>
                </div>
                <div style="margin: 20px 0; padding: 20px; background-color: #ffffff; border-radius: 5px; border: 1px solid #dddddd;">
                    <p>Aramıza hoş geldiniz sayın <strong>' . $adsoyad . '</strong>,</p>
                    <p>Sizi Reverse Auction platformunda görmekten mutluluk duyuyoruz.</p>
                    <p><strong>Hesabınızı aktif hale getirmek için</strong> lütfen aşağıdaki bağlantıya tıklayın:</p>
                    <p><a href="' . $link . '">Hesabımı Doğrula</a></p>
                    <p>Bu bağlantı yalnızca belirli bir süre için geçerlidir. Hesabınızı hemen doğrulamanızı öneririz.</p>
                </div>
                <div style="margin-top: 20px; text-align: center; font-size: 0.9em; color: #777777;">
                    <p>Teşekkürler</p>
                    <p>Reverse Auction Proje Ekibi</p>
                </div>
            </div>
        ';



        $mail->send();
    } catch (Exception $e) {
        echo "Mail gönderilemedi. Hata: {$mail->ErrorInfo}";
    }
}

?>