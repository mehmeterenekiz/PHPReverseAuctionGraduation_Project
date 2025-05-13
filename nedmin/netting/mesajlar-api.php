<?php
ob_start();
session_start();
require_once 'baglan.php';
require_once "../production/fonksiyon.php";

$kime = isset($_POST['kime']) ? htmlspecialchars($_POST['kime']) : null;
$kimden = isset($_POST['kimden']) ? htmlspecialchars($_POST['kimden']) : null;
$talep_id = isset($_POST['talep_id']) ? htmlspecialchars($_POST['talep_id']) : null;
$mesaj = isset($_POST['mesaj']) ? htmlspecialchars($_POST['mesaj']) : null;



switch ($_GET['mode']) {

    case 'insert':

        if ($_POST['kime']) {
            if ($kime != "" and $kimden != "" and $talep_id != "" and $mesaj != "") {
                $mesaj_ekle = $db->prepare("insert into mesaj (talep_id, kimden, kime, mesaj_detay) values(?,?,?,?) ");

                $insert = $mesaj_ekle->execute(array($talep_id, $kimden, $kime, $mesaj));

                if ($insert) {
                    echo "mesaj veritabanına kaydedildi.";
                }

            } else {
                echo "lütfen tüm alanları doldurunuz";
            }
        }
        break;

    case 'get':

        $talep_id_mesaj =  isset($_POST['talep_id']) ? htmlspecialchars($_POST['talep_id']) : null;
        $kimden_mesaj = isset($_POST['kime']) ? htmlspecialchars($_POST['kime']) : null;
        $kullanici_id_mesaj = $kimden = isset($_POST['kimden']) ? htmlspecialchars($_POST['kimden']) : null;

        $mesajguncelle = $db->prepare("
        UPDATE mesaj 
        SET mesaj_okunma = :mesaj_okunma
        WHERE talep_id = :talep_id 
        AND kimden = :kimden 
        AND kime = :kime 
        AND mesaj_okunma = '0'
        ");

        $mesajguncelle->execute(array(
            'mesaj_okunma' => 1,
            'talep_id' => $talep_id_mesaj,
            'kimden' => $kimden_mesaj,
            'kime' => $kullanici_id_mesaj
        ));

        $veri = $db->prepare("SELECT * FROM mesaj WHERE ((kimden=:kimden AND kime=:kime) 
        OR (kimden=:kime AND kime=:kimden)) AND talep_id=:talep_id 
        ORDER BY mesaj_zaman");
        $veri->execute(array(':kimden' => $kimden, ':kime' => $kime, ':talep_id' => $talep_id));
        $mesajlar = $veri->fetchAll(PDO::FETCH_ASSOC);

        foreach ($mesajlar as $key => $value) {
            if ($value["kimden"] == $kimden) { ?>
                <li class="clearfix" id="other-messagee">
                    <div class="message-data text-right">
                        <span class="message-data-time">

                            <?php
                            $tarih = $value["mesaj_zaman"];
                            $tarihDateTime = new DateTime($tarih);
                            $bugun = new DateTime();

                            // Sadece tarih kısmını al (saat olmadan)
                            $tarihDate = DateTime::createFromFormat('Y-m-d', $tarihDateTime->format('Y-m-d'));
                            $bugunDate = DateTime::createFromFormat('Y-m-d', $bugun->format('Y-m-d'));

                            // Gün farkını al
                            $gunFarki = $bugunDate->diff($tarihDate)->days;
                            $artiEksi = $bugunDate > $tarihDate ? -1 : 1;
                            $gunFarki *= $artiEksi;

                            if ($gunFarki === 0) {
                                echo "Bugün " . $tarihDateTime->format("H:i");
                            } elseif ($gunFarki === -1) {
                                echo "Dün " . $tarihDateTime->format("H:i");
                            } elseif ($gunFarki === -2) {
                                echo "Evvelsi gün " . $tarihDateTime->format("H:i");
                            } else {
                                echo $tarihDateTime->format("d.m.Y H:i");
                            }
                            ?>

                        </span>
                    </div>
                    <div class="message other-message float-right">
                        <?php echo $value["mesaj_detay"] ?>

                        <?php if ($value["mesaj_okunma"] == 1) { ?>

                            <span style="position: absolute; bottom: 2rem; right: 0.5rem;">
                                <i class="fa-solid fa-check mesaj-goruldu" style="position: absolute; right: 0.7rem;"></i>
                                <i class="fa-solid fa-check mesaj-goruldu"
                                    style="position: absolute; right: 0.2rem; clip-path: inset(0 0 0 0.2rem);"></i>
                            </span>

                        <?php } else { ?>

                            <span style="position: absolute; bottom: 2rem; right: 0.5rem;">
                                <i class="fa-solid fa-check mesaj-gorulmedi" style="position: absolute; right: 0.7rem;"></i>
                                <i class="fa-solid fa-check mesaj-gorulmedi"
                                    style="position: absolute; right: 0.2rem; clip-path: inset(0 0 0 0.2rem);"></i>
                            </span>

                        <?php } ?>
                    </div>
                </li>
            <?php } else { ?>
                <li class="clearfix" id="my-messagee">
                    <div class="message-data">
                        <span class="message-data-time">

                            <?php
                            $tarih = $value["mesaj_zaman"];
                            $tarihDateTime = new DateTime($tarih);
                            $bugun = new DateTime();

                            // Sadece tarih kısmını al (saat olmadan)
                            $tarihDate = DateTime::createFromFormat('Y-m-d', $tarihDateTime->format('Y-m-d'));
                            $bugunDate = DateTime::createFromFormat('Y-m-d', $bugun->format('Y-m-d'));

                            // Gün farkını al
                            $gunFarki = $bugunDate->diff($tarihDate)->days;
                            $artiEksi = $bugunDate > $tarihDate ? -1 : 1;
                            $gunFarki *= $artiEksi;

                            if ($gunFarki === 0) {
                                echo "Bugün " . $tarihDateTime->format("H:i");
                            } elseif ($gunFarki === -1) {
                                echo "Dün " . $tarihDateTime->format("H:i");
                            } elseif ($gunFarki === -2) {
                                echo "Evvelsi gün " . $tarihDateTime->format("H:i");
                            } else {
                                echo $tarihDateTime->format("d.m.Y H:i");
                            }
                            ?>

                        </span>
                    </div>
                    <div class="message my-message">
                        <?php echo $value["mesaj_detay"] ?>
                    </div>
                </li>
            <?php }
        }
        break;
}
?>