<?php
$title = "Talep Sayfası";
ob_start();
session_start();
if (isset($_SESSION['user_kullanici_mail'])) {
    require_once "header_user.php";
} else {
    require_once 'header.php';
}
$talep_id = substr(trim($_GET['talep_id']), 7);
$talepsor = $db->prepare("SELECT * FROM talep inner join kategori on talep.kategori_id=kategori.kategori_id where talep_id=:talep_id and talep_durum=:talep_durum");
$talepsor->execute(array(
    'talep_id' => $talep_id,
    'talep_durum' => 1
));

$talepcek = $talepsor->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once "arama-cubuk.php"; ?>

<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper">
            <ul>
                <li><a href="index.php">anasayfa</a><span> -</span></li>
                <li><a
                        href="kategori-<?= seo($talepcek['kategori_ad']) . "-" . $talepcek['kategori_id'] ?>"><?php echo $talepcek['kategori_ad'] ?></a><span>
                        -</span></li>
                <li> <?php echo $talepcek['talep_marka'] ?> </li>
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
                    <div class="single-banner">
                        <div id="map" enlem="<?php echo $talepcek['talep_konum_enlem'] ?>"
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

                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="fox-sidebar">
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <h3 class="sidebar-item-title">Product Price</h3>
                            <ul class="sidebar-product-price">
                                <li>$59.00</li>
                                <li>

                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <h3 class="sidebar-item-title">Product Information</h3>
                            <ul class="sidebar-product-info">
                                <li>Released On:<span> 1 January, 2016</span></li>
                                <li>Last Update:<span> 20 April, 2016</span></li>
                                <li>Download:<span> 613</span></li>
                                <li>Version:<span> 1.1</span></li>
                                <li>Compatibility:<span> Wordpress 4+</span></li>
                                <li>Compatible Browsers:<span> IE9, IE10, IE11, Firefox, Safari, Opera, Chrome</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <h3 class="sidebar-item-title">Product Author</h3>
                            <div class="sidebar-author-info">
                                <img src="img\profile\avatar.jpg" alt="product" class="img-responsive">
                                <div class="sidebar-author-content">
                                    <h3>PsdBoss</h3>
                                    <a href="#" class="view-profile">View Profile</a>
                                </div>
                            </div>
                            <ul class="sidebar-badges-item">
                                <li><img src="img\profile\badges1.png" alt="badges" class="img-responsive"></li>
                                <li><img src="img\profile\badges2.png" alt="badges" class="img-responsive"></li>
                                <li><img src="img\profile\badges3.png" alt="badges" class="img-responsive"></li>
                                <li><img src="img\profile\badges4.png" alt="badges" class="img-responsive"></li>
                                <li><img src="img\profile\badges5.png" alt="badges" class="img-responsive"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-8 col-sm-8 col-xs-12">
            <div class="inner-page-main-body product-width">

                <div class="product-tag-line">
                    <ul class="product-tag-item">
                        <li><a href="#"><i class="fa fa-shopping-cart"
                        aria-hidden="true"></i> Add To Cart</a></li>
                        <li><a href="#"><i class="fa fa-heart-o"
                        aria-hidden="true"></i> Add To Favourites</a></li>
                        <li><a href="#">Documentation</a></li>
                    </ul>
                    <ul class="social-default">
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
                                <li class="active"><a href="#description" data-toggle="tab" aria-expanded="false">Talep
                                        Detayları</a></li>
                                <li><a href="#review" data-toggle="tab" aria-expanded="false">Yorumlar</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="description">
                                    <p> <?php echo $talepcek['talep_detay'] ?> </p>
                                </div>
                                <div class="tab-pane fade" id="review">
                                    <p> Yorumlar burada olacak.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Product Details Page End Here -->

<?php require_once 'footer.php'; ?>

<script>

    let map, marker, circle, searchTimeout;
    function initMap() {

        const mapElement = document.getElementById("map");
        const lat = parseFloat(mapElement.getAttribute("enlem"));
        const lng = parseFloat(mapElement.getAttribute("boylam"));
        const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
        const zoom = parseInt(mapElement.getAttribute("zoom"));
        const location = { lat: lat, lng: lng };

        map = new google.maps.Map(document.getElementById("map"), {
            center: location,
            zoom: zoom,
            streetViewControl: false, // Sokak görünümü kontrolünü kaldırır
            mapTypeControl: false,  // map tipinin değiştirilmesini engeller.s
        });

        // Marker oluştur
        marker = new google.maps.Marker({
            position: location,
            map: map,
        });

        // Daire oluştur
        circle = new google.maps.Circle({
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
    }

    // Haritayı başlat
    window.onload = initMap;

</script>