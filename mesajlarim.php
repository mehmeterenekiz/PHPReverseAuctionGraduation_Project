<?php

use Opencart\Catalog\Model\Localisation\Location;
$title = "Kullanıcı Bilgilerim";
ob_start();
session_start();
require_once "header_user.php";

?>

<?php require_once "arama-cubuk.php"; ?>

<style>
    .map {
        position: relative;
        overflow: hidden;
        width: 20%;
        height: 110px;
        border: 1px solid #ccc;
        display: flex;
    }

    .map-container {
        position: absolute;
        display: inline;
        margin-right: 200rem;
        width: 177.8px;
        height: 130px;
        background: rgba(0, 0, 0, 0.5);
        z-index: 10000;
        margin-left: 0.1rem;
        margin-top: -13rem;
    }

    .gm-control-active {
        transform: scale(0.7);
    }

    .gm-fullscreen-control {
        /* büyütme emojisinin yeri kaydırıldı. */
        top: -10px !important;
        right: -10px !important;
    }

    .gm-bundled-control {
        transform: scale(0.65);
    }

    /* Zoom butonlarının konumunu değiştir */
    .gm-bundled-control-on-bottom {
        bottom: 65px !important;
        right: 24px !important;
    }

    /* "Map Data" yazısını gizle */
    .gm-style-cc {
        display: none !important;
    }

    .gm-style a {
        /* Google maps haritası üzerinde google yazısı vardı onun görünürlüğünü kaldırdım. */
        pointer-events: none;
        cursor: default;
        opacity: 0;
    }

    a .map {
        pointer-events: auto;
        /* Sadece .map tıklanabilir */
        cursor: pointer;
    }

    .info-box {
        background-color: #f6f9fc;
        border: 1px solid #c7d7eb;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 20px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        font-family: Arial, sans-serif;
    }

    .ilan-bilgi {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .ilan-ust {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 6px;
    }

    .ilan-baslik {
        font-weight: bold;
        color: #003366;
        font-size: 15px;
        max-width: 500px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: none;
    }

    .ilan-fiyat {
        position: absolute;
        font-size: 14px;
        color: rgb(175, 54, 24);
        white-space: nowrap;
        margin-left: 50rem;
        margin-top: 3rem;
    }

    .ilan-mesaj {
        position: absolute;
        font-size: 15px;
        margin-left: 56rem;
    }

    .ilan-model {
        font-size: 14px;
        color: #666;
    }

    .ilan-konum {
        font-size: 13px;
        color: #999;
    }

    .sohbet-ad {
        font-size: 13px;
        color: #999;
    }
</style>

<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper">
            <ul>
                <li><a href="index.php">Home</a><span> -</span></li>
                <li>Hesabım</li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->
<!-- Settings Page Start Here -->
<div class="settings-page-area bg-secondary section-space-bottom">
    <div class="container">
        <div class="row settings-wrapper">

            <?php
            $kimden = $_SESSION['user_kullanici_mail'];
            $talepsor = $db->prepare("
                SELECT m.*, t.*, k.*, vm.*, u.kullanici_ad, u.kullanici_soyad
                FROM mesaj m
                INNER JOIN (
                    SELECT talep_id, kimden, MAX(mesaj_id) as max_id
                    FROM mesaj
                    WHERE kimden != :kimden AND (kimden = :kimden OR kime = :kimden)
                    GROUP BY talep_id, kimden
                ) son ON m.talep_id = son.talep_id AND m.mesaj_id = son.max_id AND m.kimden = son.kimden
                INNER JOIN talep t ON t.talep_id = m.talep_id
                INNER JOIN kategori k ON t.kategori_id = k.kategori_id
                INNER JOIN vasitamarka vm ON vm.marka_id = t.talep_marka
                INNER JOIN kullanici u ON u.kullanici_id = m.kimden
                WHERE t.talep_durum = :talep_durum
                ORDER BY m.mesaj_okunma, m.mesaj_zaman DESC
            ");


            $talepsor->execute(array(
                'talep_durum' => 1,
                ':kimden' => $kimden
            ));

            $say = $talepsor->rowCount();

            ?>

            <?php require_once "sidebar-user.php" ?>

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">

                <div class="settings-details tab-content">
                    <div class="tab-pane fade active in" id="Personal">
                        <h2 class="title-section"> Mesajlarım </h2>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>

                        <div class="personal-info inner-page-padding">

                            <?php if ($say == 0) { ?>
                                <div class="info-box"
                                    style="display:block !important; margin: -6px 25px 25px 10px !important;">

                                    <span class="icon" style="font-size: 18px; color: blue; padding-right: 1rem;"><i
                                            class="bi bi-info-square"></i></span>

                                    <span style="text-transform:none; font-size: 13px !important;" class="font-opacity">
                                        Herhangi bir mesajınız bulunmamaktadır.
                                    </span>
                                </div>
                            <?php } else { ?>

                                <?php while ($talepcek = $talepsor->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <?php
                                    $kimdenn = $_SESSION['user_kullanici_mail'];
                                    $kimee = $talepcek['kimden'];
                                    $talep_id = $talepcek['talep_id'];

                                    $sonmesajtarihsor = $db->prepare("
                                        SELECT mesaj_zaman
                                        FROM mesaj
                                        WHERE talep_id = :talep_id
                                        AND (
                                                (kimden = :kimden AND kime = :kime)
                                            OR (kimden = :kime AND kime = :kimden)
                                        )
                                        ORDER BY mesaj_id DESC
                                        LIMIT 1
                                    ");

                                    $sonmesajtarihsor->execute(array(
                                        'talep_id' => $talep_id,
                                        'kimden' => $kimdenn,
                                        'kime' => $kimee
                                    ));

                                    $sonmesajtarihcek = $sonmesajtarihsor->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <a
                                        href="mesaj-detay?talep_id=<?php echo $talepcek['talep_id'] ?>&kime=<?php echo $talepcek['kimden'] ?>">
                                        <div class="info-box">
                                            <div class="map" enlem="<?php echo $talepcek['talep_konum_enlem'] ?>"
                                                boylam="<?php echo $talepcek['talep_konum_boylam'] ?>"
                                                yaricap="<?= $talepcek['talep_cember_yaricap'] ?>" zoom="<?php
                                                  if ($talepcek['talep_cember_yaricap'] < 92000) { // 6 numara
                                                      echo '7';
                                                  } else if ($talepcek['talep_cember_yaricap'] < 185000) {  // 1 numara
                                                      echo '6';
                                                  } elseif ($talepcek['talep_cember_yaricap'] < 395000) {
                                                      echo '5';
                                                  } else {
                                                      echo '4';
                                                  }
                                                  ?>">
                                            </div>

                                            <div class="ilan-bilgi">
                                                <div class="ilan-ust">
                                                    <div class="ilan-baslik"> <?php echo $talepcek['talep_ad'] ?> </div>
                                                    <div class="ilan-fiyat"> 

                                                        <?php echo $talepcek['talep_fiyat'] ?> 
                                                    
                                                    </div>
                                                    <div class="ilan-mesaj"> 

                                                        <?php if($talepcek['mesaj_okunma'] == 1) { ?> 
                                                    
                                                            <i class="bi bi-envelope-open"></i>
                                                    
                                                        <?php } else {?>

                                                            <i class="bi bi-envelope"></i>

                                                        <?php }?>
                                                    </div>
                                                </div>


                                                <div class="ilan-model"> <?php echo $talepcek['marka_ad'] ?> </div>
                                                <div class="ilan-konum"> <?php echo $talepcek['talep_sehir'] ?> </div>
                                                <div class="sohbet-ad">
                                                    <?php echo $talepcek['kullanici_ad'] ?>
                                                    <?php echo $talepcek['kullanici_soyad'] . "   " ?>

                                                    <?php
                                                    $tarih = $sonmesajtarihcek["mesaj_zaman"];
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

                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Settings Page End Here -->
<?php require_once 'footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let maps = [];
        let markers = [];
        let circles = [];
        let searchTimeout;

        function initMap() {
            // Varsayılan başlangıç konumu
            const mapElements = document.querySelectorAll(".map");

            mapElements.forEach((mapElement, index) => {
                const lat = parseFloat(mapElement.getAttribute("enlem"));
                const lng = parseFloat(mapElement.getAttribute("boylam"));
                const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
                const zoom = parseInt(mapElement.getAttribute("zoom"));
                const location = { lat: lat, lng: lng };

                console.log("Harita Verileri:");
                console.log("Enlem (lat):", lat);
                console.log("Boylam (lng):", lng);
                console.log("Yarıçap:", yaricap);
                console.log("Zoom:", zoom);
                console.log("Konum Nesnesi:", location);

                let map = new google.maps.Map(mapElement, {
                    center: location,
                    zoom: zoom,
                    zoomControl: false,
                    fullscreenControl: false,
                    streetViewControl: false, // Sokak görünümü kontrolünü kaldırır
                    mapTypeControl: false,  // Map tipinin değiştirilmesini engeller
                    draggable: window.innerWidth > 2000, // Ekran boyutuna göre draggable ayarı
                });

                window.addEventListener('resize', () => {
                    if (window.innerWidth <= 1500) {
                        map.setOptions({ draggable: false });
                    } else {
                        map.setOptions({ draggable: true });
                    }
                });

                let marker = new google.maps.Marker({
                    position: location,
                    map: map,
                });

                let circle = new google.maps.Circle({
                    map: map,
                    radius: yaricap,
                    fillColor: "#0000FF",
                    fillOpacity: 0.2,
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                });

                circle.bindTo("center", marker, "position");

                maps.push(map);
                markers.push(marker);
                circles.push(circle);
            });
        }

        initMap();
    });
</script>