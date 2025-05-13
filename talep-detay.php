<?php
$title = "Talep Sayfası";
ob_start();
session_start();
if (isset($_SESSION['user_kullanici_mail'])) {
    require_once "header_user.php";
} else {
    require_once 'header.php';
}
$talep_id = $_GET['talep_id'];
$talepsor = $db->prepare("SELECT * FROM talep inner join kategori on talep.kategori_id=kategori.kategori_id inner join kullanici on talep.kullanici_id=kullanici.kullanici_id inner join vasitamarka on talep.talep_marka = vasitamarka.marka_id where talep_id=:talep_id and talep_durum=:talep_durum");
$talepsor->execute(array(
    'talep_id' => $talep_id,
    'talep_durum' => 1
));

$talepcek = $talepsor->fetch(PDO::FETCH_ASSOC);
?>
<style>
    .pagination-area .pagination-wrapper .sidebar-item-title {
        position: relative;
        margin-bottom: -35px;
        font-size: 16px;
        font-weight: 900;
        margin-top: -1rem;
    }

    .pagination-area .pagination-wrapper .sidebar-item-title:before {
        content: "";
        height: 0.5px;
        width: 100%;
        background: #dde3e8;
        position: absolute;
        z-index: 1;
        bottom: 14px;
        width: 1138px;
    }

    .user-card {
        border: 1px solid #ddd;
        padding: 16px;
        width: 100%;
        font-family: Arial, sans-serif;
        background-color: #fff;
        margin-top: 2rem;
    }

    .user-card strong {
        font-size: 13px;
        display: block;
        margin-bottom: 4px;
    }

    .account-date {
        color: #777;
        font-size: 12px;
        margin-bottom: 12px;
        border-bottom: 1px dotted #ccc;
        text-transform: none;
    }

    .message-link {
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #0056b3;
    }

    .message-link:hover a {
        text-decoration: underline;
    }

    .tab-content p {
        text-transform: lowercase;
    }
</style>

<?php require_once "arama-cubuk.php"; ?>

<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper" style="margin-left: -33px;">
            <ul>
                <li><a href="index.php">anasayfa</a><span> -</span></li>
                <li><a
                        href="kategori-<?= seo($talepcek['kategori_ad']) . "-" . $talepcek['kategori_id'] ?>"><?php echo $talepcek['kategori_ad'] ?></a><span>
                        -</span></li>
                <li> <?php echo $talepcek['marka_ad'] ?> </li>
            </ul>
            <br>
            <ul class="sidebar-item-title">
                <li>
                    <h3 style="text-transform: none; "><?php echo $talepcek['talep_ad'] ?></h3>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Inner Page Banner Area End Here -->
<!-- Product Details Page Start Here -->
<div class="product-details-page bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="inner-page-main-body product-width">

                    <div id="map-detay" enlem="<?php echo $talepcek['talep_konum_enlem'] ?>"
                        boylam="<?php echo $talepcek['talep_konum_boylam'] ?>"
                        yaricap="<?= $talepcek['talep_cember_yaricap'] ?>" zoom="<?php
                          if ($talepcek['talep_cember_yaricap'] < 92000) { // 6 numara
                              echo '8';
                          } else if ($talepcek['talep_cember_yaricap'] < 185000) {  // 1 numara
                              echo '7';
                          } elseif ($talepcek['talep_cember_yaricap'] < 395000) {
                              echo '6';
                          } else {
                              echo '5';
                          }
                          ?>"></div>


                    <div class="product-tag-line">

                        <ul class="product-tag-item">

                            <?php if (isset($_SESSION['user_kullanici_mail'])) { ?>

                                <?php if (isset($_SESSION['user_kullanici_mail']) && $_SESSION['user_kullanici_mail'] == $talepcek['kullanici_id']) { ?>
                                    <!-- kullanici id çekiliyor user kullanici maile -->

                                    <li> <a href="#"
                                            style="pointer-events: none; cursor: not-allowed; background-color: gray; border-color: gray;"
                                            class="add-to-cart-btn" id="cart-button"><i class="fa fa-shopping-cart"
                                                aria-hidden="true"></i> Teklif Ver </a></li>

                                    <li><a href="#"
                                            style="pointer-events: none; cursor: not-allowed; background-color: gray; border-color: gray;"
                                            class="add-to-favourites-btn" id="favourites-button"><i class="fa fa-heart-o"
                                                aria-hidden="true"></i> Favorilerime Ekle</a></li>

                                <?php } else { ?>

                                    <li> <a href="#" class="add-to-cart-btn" id="cart-button"><i class="fa fa-shopping-cart"
                                                aria-hidden="true"></i> Teklif Ver </a></li>

                                    <li><a href="#" class="add-to-favourites-btn" id="favourites-button"><i
                                                class="fa fa-heart-o" aria-hidden="true"></i> Favorilerime Ekle</a></li>

                                <?php } ?>

                            <?php } else { ?>

                                <li> <a href="sign-in.php?sign-in=talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>"
                                        class="add-to-cart-btn"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        Teklif Ver </a> </li>

                                <li> <a href="sign-in.php?sign-in=talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>"
                                        class="add-to-favourites-btn" id="favourites-button"><i class="fa fa-heart-o"
                                            aria-hidden="true"></i> Favorilerime Ekle</a> </li>

                            <?php } ?>


                        </ul>

                        <ul class="social-default" hidden>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                        </ul>

                    </div>
                    <div class="product-details-tab-area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <ul class="product-details-title">
                                    <li style="font-weight: 600;"><a href="" data-toggle="tab"
                                            aria-expanded="false">Talep Detayları</a></li>
                                    <!-- <li class="active"><a href="#review" data-toggle="tab" aria-expanded="false">Yorumlar</a></li> -->
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="description">
                                        <p> <?php echo turkce_title_case($talepcek['talep_detay']); ?>
                                    </div>
                                    <!-- <div class="tab-pane fade" id="review">
                                        <p> Yorumlar burada olacak.</p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <h3 class="title-inner-section">More Product by PsdBosS</h3>
                    <div class="row more-product-item-wrapper">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more1.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$12</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more2.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$20</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more3.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$49</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more4.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$18</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more5.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$59</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="more-product-item">
                                <div class="more-product-item-img">
                                    <img src="img\product\more6.jpg" alt="product" class="img-responsive">
                                </div>
                                <div class="more-product-item-details">
                                    <h4><a href="#">Grand Ballet - Dance</a></h4>
                                    <div class="p-title">PSD Template</div>
                                    <div class="p-price">$48</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
            


            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-right: -4rem;">
                <div class="fox-sidebar">
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <h3 class="sidebar-item-title" style="">
                                <?php echo $talepcek['talep_fiyat'] . " TL" ?>
                                <span style="display: block; font-size: 1.3rem; margin-top: 1rem;">
                                    <?php echo turkce_title_case($talepcek['talep_sehir']); ?>
                                </span>

                            </h3>

                            <ul class="sidebar-product-price">
                                <li>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <ul class="sidebar-product-info">

                                <li>Talep Tarihi <span>
                                        <?php
                                        $aylar = [
                                            "January" => "Ocak",
                                            "February" => "Şubat",
                                            "March" => "Mart",
                                            "April" => "Nisan",
                                            "May" => "Mayıs",
                                            "June" => "Haziran",
                                            "July" => "Temmuz",
                                            "August" => "Ağustos",
                                            "September" => "Eylül",
                                            "October" => "Ekim",
                                            "November" => "Kasım",
                                            "December" => "Aralık"
                                        ];

                                        $tarih = date('d F Y', strtotime($talepcek['talep_zaman']));
                                        foreach ($aylar as $en => $tr) {
                                            $tarih = str_replace($en, $tr, $tarih);
                                        }
                                        echo $tarih;
                                        ?>
                                    </span></li>

                                <li>marka <span> <?php echo $talepcek['marka_ad'] ?> </span></li>
                                <li>yıl <span>
                                        <?php echo $talepcek['talep_min_yil'] . "-" . $talepcek['talep_max_yil'] ?>
                                    </span></li>
                                <li>yakıt <span> <?php echo $talepcek['talep_yakit_tipi'] ?> </span></li>
                                <li>vites <span> <?php echo $talepcek['talep_vites_tipi'] ?> </span></li>
                                <li>KM <span> <?php echo $talepcek['talep_min_km'] . "-" . $talepcek['talep_max_km'] ?>
                                    </span></li>
                                <li>kasa tipi <span> <?php echo $talepcek['talep_kasa_tipi'] ?> </span></li>
                                <li>kapı sayısı <span> <?php echo $talepcek['talep_kapi_sayisi'] ?> </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <div class="user-card">
                                <strong>
                                    <?php echo $talepcek['kullanici_ad'] . " " . strtoupper(substr($talepcek['kullanici_soyad'], 0, 1)) . "."; ?>
                                </strong>

                                <p class="account-date">Hesap açma tarihi:
                                    <?php
                                    $aylar = [
                                        "January" => "Ocak",
                                        "February" => "Şubat",
                                        "March" => "Mart",
                                        "April" => "Nisan",
                                        "May" => "Mayıs",
                                        "June" => "Haziran",
                                        "July" => "Temmuz",
                                        "August" => "Ağustos",
                                        "September" => "Eylül",
                                        "October" => "Ekim",
                                        "November" => "Kasım",
                                        "December" => "Aralık"
                                    ];

                                    $tarih = date('d F Y', strtotime($talepcek['kullanici_zaman']));
                                    foreach ($aylar as $en => $tr) {
                                        $tarih = str_replace($en, $tr, $tarih);
                                    }
                                    echo $tarih;
                                    ?>

                                </p>

                                <?php if (isset($_SESSION['user_kullanici_mail'])) { ?>

                                    <?php if (isset($_SESSION['user_kullanici_mail']) && $_SESSION['user_kullanici_mail'] == $talepcek['kullanici_id']) { ?>
                                        <!-- kullanici id çekiliyor user kullanici maile -->

                                        <div class="#" style="pointer-events: none; cursor: not-allowed;">
                                            <a style="color: gray;"
                                                href="mesaj-detay?talep_id=<?php echo $talepcek['talep_id'] ?>"> <i
                                                    class="bi bi-chat"></i> Mesaj gönder</a>
                                        </div>

                                    <?php } else { ?>

                                        <div class="message-link">
                                            <a href="mesaj-detay?talep_id=<?php echo $talepcek['talep_id'] ?>"> <i
                                                    class="bi bi-chat"></i> Mesaj gönder</a>
                                        </div>
                                    <?php } ?>

                                <?php } else { ?>

                                    <div class="message-link">
                                        <a
                                            href="sign-in.php?sign-in=talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>">
                                            <i class="bi bi-chat"></i> Mesaj gönder</a>
                                    </div>

                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal">
                <form action="nedmin/netting/kullanici-islem.php" method="POST">
                    <label>Fiyat <span id="uyari_mesaji" style="color:red; font-size: 1rem; display:none;">
                            <?php echo "(vereceğiniz teklif, talep fiyatından yüksek olamaz!)" ?> </span> </label>
                    <div class="form-group">
                        <input type="text" class="form-control rakam" required name="teklif_fiyat" id="teklif_fiyat"
                            placeholder="Fiyat">
                    </div>

                    <label>Açıklama</label>
                    <div class="form-group">
                        <input type="text" class="form-control" required name="teklif_aciklama" placeholder="Açıklama">
                    </div>

                    <label>Şehir <label style="text-transform: none;">ve</label> İlçe</label>
                    <div class="form-group">
                        <input class="form-control" type="text" id="city-input" required name="teklif_sehir_ilce"
                            placeholder="istanbul/eyüp">
                    </div>

                    <label>Daire Yarıçapı</label>
                    <input type="range" id="radius-slider" name="talep_cember_yaricap" min="70000" max="800000"
                        step="100" value="<?php echo $talepcek['talep_cember_yaricap'] ?>">

                    <label style="margin-top: 4px;">Konum</label>
                    <div id="map-detay-teklif" enlem="<?php echo $talepcek['talep_konum_enlem'] ?>"
                        boylam="<?php echo $talepcek['talep_konum_boylam'] ?>"
                        yaricap="<?= $talepcek['talep_cember_yaricap'] ?>" zoom="<?php
                          if ($talepcek['talep_cember_yaricap'] < 92000) {
                              echo '8';
                          } else if ($talepcek['talep_cember_yaricap'] < 185000) {
                              echo '7';
                          } elseif ($talepcek['talep_cember_yaricap'] < 395000) {
                              echo '6';
                          } else {
                              echo '5';
                          }
                          ?>">
                    </div>

                    <div class="button-group">
                        <button id="form-buton" type="submit" name="teklif_ver">Teklif Ver</button>
                        <button id="modal-kapat">İptal</button>
                    </div>

                    <input type="text" hidden id="talep_fiyat" value="<?php echo $talepcek['talep_fiyat'] ?>"
                        name="talep_fiyat">
                    <input type="text" hidden value="<?php echo $talep_id ?>" name="talep_id">
                    <input type="text" hidden id="teklif_cember_yaricap" name="teklif_cember_yaricap"
                        value="<?php echo $talepcek['talep_cember_yaricap'] ?>">
                    <input type="text" hidden name="teklif_konum_enlem" id="enlem">
                    <input type="text" hidden name="teklif_konum_boylam" id="boylam">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Product Details Page End Here -->

<?php require_once 'footer.php'; ?>

<script>

    let map, marker, circle;
    let mapteklif, markerteklif, circleteklif, searchTimeout;

    function initMap() {
        const mapElement = document.getElementById("map-detay");

        const lat = parseFloat(mapElement.getAttribute("enlem"));
        const lng = parseFloat(mapElement.getAttribute("boylam"));
        const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
        const zoom = parseInt(mapElement.getAttribute("zoom"));
        const location = { lat: lat, lng: lng };

        map = new google.maps.Map(mapElement, {
            center: location,
            zoom: zoom,
            streetViewControl: false,
            mapTypeControl: false,
        });

        marker = new google.maps.Marker({
            position: location,
            map: map,
        });

        circle = new google.maps.Circle({
            map: map,
            radius: yaricap,
            fillColor: "#0000FF",
            fillOpacity: 0.2,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
        });

        circle.bindTo("center", marker, "position");
    }

    function initMapTeklif() {
        const mapElement = document.getElementById("map-detay-teklif");

        const lat = parseFloat(mapElement.getAttribute("enlem"));
        const lng = parseFloat(mapElement.getAttribute("boylam"));
        const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
        const zoom = parseInt(mapElement.getAttribute("zoom"));
        const location = { lat: lat, lng: lng };

        mapteklif = new google.maps.Map(mapElement, {
            center: location,
            zoom: zoom,
            streetViewControl: false,
            mapTypeControl: false,
        });

        markerteklif = new google.maps.Marker({
            position: location,
            map: mapteklif,
            draggable: true, // Marker sürüklenebilir 
        });

        circleteklif = new google.maps.Circle({
            map: mapteklif,
            radius: yaricap,
            fillColor: "#0000FF",
            fillOpacity: 0.2,
            strokeColor: "#0000FF",
            strokeOpacity: 0.8,
            strokeWeight: 2,
        });

        updatePosition();

        circleteklif.bindTo("center", markerteklif, "position");

        google.maps.event.addListener(markerteklif, "dragend", updatePosition);

        // Yarıçapı kullanıcıdan alır ve günceller.
        document.getElementById("radius-slider").addEventListener("input", function () {
            const newRadius = parseInt(this.value, 10);
            circleteklif.setRadius(newRadius);
        });

        document.getElementById("radius-slider").addEventListener("change", function () {
            // Dairenin yeni yarıçapını input'a yaz
            const newRadius = parseInt(this.value, 10);
            document.getElementById("teklif_cember_yaricap").value = newRadius;
        });

        // Şehir girildiğinde haritayı otomatik güncelle
        document.getElementById("city-input").addEventListener("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(searchLocation, 400);

        });
    }

    function updatePosition() {                            // Harita üzerindeki konumu değiştirince 
        const lat = markerteklif.getPosition().lat().toFixed(6); // Marker enlemi
        const lng = markerteklif.getPosition().lng().toFixed(6); // Marker boylamı

        // Bilgileri inputlara yaz
        document.getElementById("enlem").value = lat;
        document.getElementById("boylam").value = lng;
    }

    function searchLocation() {                                                 // Arama çubuğundaki girilen veri için
        const city = document.getElementById("city-input").value.trim();

        if (city === "") return; // Boş giriş olursa işlemi yapma

        // Geocoding API ile adres bilgisini koordinata çevir
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: city }, (results, status) => {
            if (status === "OK") {
                const location = results[0].geometry.location;
                const lat = location.lat();  // Enlem (Latitude)
                const lng = location.lng();  // Boylam (Longitude)

                // Haritayı yeni konuma ayarla
                mapteklif.setCenter(location);
                mapteklif.setZoom(7);

                // Marker konumunu güncelle
                markerteklif.setPosition(location);

                // Lat ve Lng bilgilerini inputlara yazdır
                document.getElementById("enlem").value = lat;
                document.getElementById("boylam").value = lng;
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initMap();
        initMapTeklif();
    });

</script>