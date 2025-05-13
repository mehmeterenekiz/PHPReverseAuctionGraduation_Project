<?php
ob_start();
session_start();
$title = "Taleplerim";
require_once "header_user.php";
?>
<style>
    .map {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 130px;
        border: 1px solid #ccc;
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

    .text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 540;
        font-size: 1.4rem;
        color: rgba(0, 0, 0, 0.8);
        background: rgba(237, 237, 237, 0.7);
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

    th {
        border: 1px solid #ddd;
    }

    td {
        display: table-cell;
        border: 1px solid #ddd;
        padding: 5px !important;
        font-size: 1.3rem;
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
</style>


<?php require_once "arama-cubuk.php"; ?>

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

            <?php require_once "sidebar-user.php" ?>

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">

                <div class="settings-details tab-content">
                    <div class="tab-pane fade active in" id="Adres">
                        <h2 class="title-section">Taleplerim</h2>
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
                        <?php
                        if (isset($_GET['durum']) and $_GET['durum'] == "ok") { ?>
                            <div class="alert-box-ok"
                                style="max-width:22.5%; position:absolute; margin-top: -5.25rem !important; margin-left:18.6rem !important;">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                    width="15" height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span style="text-transform:none;" class="font-opacity">Talep Oluşturuldu.</span>
                            </div>
                        <?php }
                        if (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>
                            <div class="alert-box"
                                style="max-width:26%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left: 18.6rem !important;">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span style="text-transform:none;" class="font-opacity">Talep Oluşturulamadı.</span>
                            </div>
                        <?php } ?>

                        <?php
                        if (isset($_GET['talep_duzenle']) and $_GET['talep_duzenle'] == "ok") { ?>
                            <div class="alert-box-ok"
                                style="max-width:23.5%; position:absolute; margin-top: -5.25rem !important; margin-left:18.6rem !important;">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                    width="15" height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span style="text-transform:none;" class="font-opacity">Talepiniz Güncellendi</span>
                            </div>
                        <?php }
                        if (isset($_GET['talep_duzenle']) and $_GET['talep_duzenle'] == "no") { ?>
                            <div class="alert-box"
                                style="max-width:26%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left:18.6rem !important;">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span style="text-transform:none;" class="font-opacity">Talepiniz Güncellenemedi</span>
                            </div>
                        <?php } ?>

                        <?php
                        if (isset($_GET['talep_kaldir']) and $_GET['talep_kaldir'] == "ok") { ?>
                            <div class="alert-box-ok"
                                style="max-width:23.5%; position:absolute; margin-top: -5.25rem !important; margin-left:18.6rem !important;">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                    width="15" height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span style="text-transform:none;" class="font-opacity">Talepiniz Yayından Kaldırıldı</span>
                            </div>
                        <?php }
                        if (isset($_GET['talep_kaldır']) and $_GET['talep_kaldır'] == "no") { ?>
                            <div class="alert-box"
                                style="max-width:26%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left:18.6rem !important;">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span style="text-transform:none;" class="font-opacity">Talepiniz Yayından
                                    Kaldırılamadı</span>
                            </div>
                        <?php } ?>

                        <div class="personal-info inner-page-padding" style="padding: 25px 25px 5px 25px !important;">

                            <?php
                            $talepsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id where talep.kullanici_id=:kullanici_id order by talep_durum asc, talep_zaman desc");
                            $talepsor->execute(array(
                                'kullanici_id' => $_SESSION['user_kullanici_mail']   // kulllanici id geliyor aslında
                            ));

                            $say = $talepsor->rowCount();
                            ?>

                            <?php if ($say == 0) { ?>
                                <div class="info-box"
                                    style="display:block !important; margin: -6px 25px 25px 10px !important;">

                                    <span class="icon" style="font-size: 18px; color: blue; padding-right: 1rem;"><i
                                            class="bi bi-info-square"></i></span>

                                    <span style="text-transform:none; font-size: 13px !important;" class="font-opacity">
                                        Herhangi bir talabiniz bulunmamaktadır.
                                    </span>
                                </div>
                            <?php } else { ?>

                                <table class="table table-striped yeni">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="width: 190px;">Konum</th>
                                            <th scope="col">Yayın T.</th>
                                            <th scope="col">Adı</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php
                                        $talepsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id where talep.kullanici_id=:kullanici_id order by talep_durum asc, talep_zaman desc");
                                        $talepsor->execute(array(
                                            'kullanici_id' => $_SESSION['user_kullanici_mail']   // kulllanici id geliyor aslında
                                        ));

                                        $say = 1;

                                        while ($talepcek = $talepsor->fetch(PDO::FETCH_ASSOC)) { ?>

                                            <tr>
                                                <th scope="row"> <?php echo $say ?> </th>
                                                <td hidden class="yaricap"
                                                    cap="<?php echo $talepcek['talep_cember_yaricap'] ?>"> </td>
                                                <td>
                                                    <a
                                                        href="nedmin/netting/kullanici-islem?talep_url_taleplerim=talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>">
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
                                                              ?>"></div>
                                                        <?php
                                                        if ($talepcek['talep_durum'] == 2 || $talepcek['talep_durum'] == 3) { ?>
                                                            <div class="map-container">
                                                                <div class="text">
                                                                    kaldırıldı
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </a>

                                                </td>
                                                <td>
                                                    <?php
                                                    $tarih = substr($talepcek['talep_zaman'], 8, 2) . '/' . substr($talepcek['talep_zaman'], 5, 2) . '/' . substr($talepcek['talep_zaman'], 0, 4);
                                                    echo $tarih;
                                                    ?>
                                                </td>
                                                <td style="max-width:190px;"><?php echo $talepcek['talep_ad'] ?></td>
                                                <td style="text-align: center;"><?php echo $talepcek['kategori_ad'] ?></td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    if ($talepcek['talep_durum'] == 0 || $talepcek['talep_durum'] == 1) { ?>
                                                        <a href="talep-duzenle?talep_id=<?php echo $talepcek['talep_id'] ?>"><button
                                                                class="btn btn-primary btn-xs">Düzenle</button></a>
                                                    <?php } else { ?>
                                                        <a href="talep-duzenle?talep_id=<?php echo $talepcek['talep_id'] ?>"><button
                                                                disabled style="cursor: default;"
                                                                class="btn btn-primary btn-xs">Düzenle</button></a>
                                                    <?php } ?>

                                                </td>

                                                <td style="max-width:135px; text-align: center;">
                                                    <?php
                                                    if ($talepcek['talep_durum'] == 0) { ?>

                                                        <button class="btn btn-warning btn-xs"
                                                            style="pointer-events:none; cursor:default;">Onay Bekleniyor</button>

                                                    <?php } else if ($talepcek['talep_durum'] == 1) { ?>

                                                            <a
                                                                href="nedmin/netting/kullanici-islem?talep_kaldır=ok&talep_id=<?php echo $talepcek['talep_id'] ?>"><button
                                                                    class="btn btn-danger btn-xs">Yayından Kaldır</button></a>

                                                    <?php } else if ($talepcek['talep_durum'] == 2) { ?>

                                                                <button
                                                                    style="background-color: black; border: none; pointer-events:none; cursor:default;"
                                                                    class="btn btn-danger btn-xs">Yayından Kaldırıldı</button>
                                                                <p style="font-size: 12px;">Kullanıcı tarafından</p>


                                                    <?php } else if ($talepcek['talep_durum'] == 3) { ?>

                                                                    <button
                                                                        style="background-color: black; border: none; pointer-events:none; cursor:default;"
                                                                        class="btn btn-danger btn-xs">Yayından Kaldırıldı</button>
                                                                    <p style="font-size: 12px;">Admin tarafından</p>

                                                    <?php } ?>

                                                </td>
                                            </tr>

                                            <?php $say++;
                                        } ?>

                                    </tbody>
                                </table>
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

    let maps = [];
    let markers = [];
    let circles = [];
    let searchTimeout;

    function initMap() {
        // Varsayılan başlangıç konumu
        // Tüm .map sınıfına sahip elementleri seç
        const mapElements = document.querySelectorAll(".map");
        const yaricapElement = document.querySelector(".yaricap");
        const yaricap = parseFloat(yaricapElement.getAttribute("cap"));

        mapElements.forEach((mapElement, index) => {

            const lat = parseFloat(mapElement.getAttribute("enlem"));
            const lng = parseFloat(mapElement.getAttribute("boylam"));
            const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
            const zoom = parseInt(mapElement.getAttribute("zoom"));
            const location = { lat: lat, lng: lng };

            
            // Yeni bir harita oluştur
            let map = new google.maps.Map(mapElement, {
                center: location,
                zoom: zoom,
                zoomControl: false,
                fullscreenControl: false,
                streetViewControl: false, // Sokak görünümü kontrolünü kaldırır
                mapTypeControl: false,  // map tipinin değiştirilmesini engeller
                draggable: window.innerWidth > 2000, // Ekran boyutuna göre draggable ayarı
            });

            // Harita boyutu değiştiğinde draggable özelliğini güncelle
            window.addEventListener('resize', () => {
                if (window.innerWidth <= 1500) {
                    map.setOptions({ draggable: false });
                } else {
                    map.setOptions({ draggable: true });
                }
            });

            // Marker oluştur
            let marker = new google.maps.Marker({
                position: location,
                map: map,
            });

            // Daire oluştur
            let circle = new google.maps.Circle({
                map: map,
                radius: yaricap, // Varsayılan yarıçap (70km)
                fillColor: "#0000FF", // Mavi doldurma rengi
                fillOpacity: 0.2,     // Daha açık bir görünüm için opaklık
                strokeColor: "#0000FF", // Mavi kenar çizgisi
                strokeOpacity: 0.8,     // Çizginin opaklığı
                strokeWeight: 2,        // Çizgi kalınlığı
            });

            // Marker ile daireyi bağla
            circle.bindTo("center", marker, "position");

            // Diziye ekle
            maps.push(map);
            markers.push(marker);
            circles.push(circle);
        });
    }

    // Haritayı başlat
    window.onload = initMap;


</script>