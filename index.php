<?php
ob_start();
session_start();

if (isset($_SESSION['user_kullanici_mail'])) {
    require_once "header_user.php";
} else {
    require_once 'header.php';
}

$talepsor = $db->prepare("SELECT *, talep.kategori_id as talep_kategori FROM talep inner join vasitamarka on talep.talep_marka = vasitamarka.marka_id where talep_durum=:talep_durum order by talep_one_cikar desc, talep_zaman desc limit 40");
$talepsor->execute(array(
    'talep_durum' => 1   // talep onay durumu geliyor.
));

?>
<style>
    .map {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 130px;
        border: 1px solid #ccc;
        pointer-events: none;
        /* harita tıklanamaz oldu */
        cursor: default;
    }

    .map .gm-fullscreen-control,
    .map .gm-zoom-in,
    .map .gm-zoom-out,
    .map .gm-control-active {
        pointer-events: auto;
        /* Bu butonlara tıklanabilirlik ekledik */
        cursor: pointer;
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

    /* Zoom butonlarının konumunu değiştir */
    .gm-bundled-control-on-bottom {
        bottom: 65px !important;
        right: 24px !important;
    }

    .gm-bundled-control {
        transform: scale(0.65);
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

    th {
        border: 1px solid #ddd;
    }

    td {
        display: table-cell;
        border: 1px solid #ddd;
        padding: 5px !important;
        font-size: 1.3rem;
    }
</style>

<!-- Main Banner 1 Area Start Here -->
<div class="main-banner2-area">
    <div class="container">
        <div class="main-banner2-wrapper">
            <h1>tek tıkla talebini oluştur</h1>
            <p>otomobil & ev</p>
            <form action="arama-detay.php" method="POST">
                <div class="banner-search-area input-group">
                    <input class="form-control" required minlength="3" name="searchkeywords"
                        placeholder="Aradığınız kategori veya markayı yazınız. . ." type="text">
                    <span class="input-group-addon">
                        <button type="submit" name="searchsayfa">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <?php if(isset($_SESSION['csrf_token'])) {?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<!-- Main Banner 1 Area End Here -->
<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper" style=" margin-top: -1rem; margin-bottom: -5rem;">
            <ul>
                <li></li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->
<div class="product-page-grid bg-secondary section-space-bottom" style="padding-top: 3.5rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 col-lg-push-3 col-md-push-4 col-sm-push-4">
                <div class="inner-page-main-body" style="margin-top: -2.6rem;">
                    <div style="border-bottom: 1px solid #d7d7d7; font-size: 1.4rem; padding-bottom: 0.3rem;">
                        anasayfa <span style="text-transform: none;">ekran</span>ı
                    </div>
                    <div class="tab-content" style="margin-top: 1.6rem;">
                        <div role="tabpanel" class="tab-pane fade in active clear products-container" id="gried-view">
                            <div class="product-grid-view padding-narrow">
                                <div class="row">
                                    <?php
                                    while ($talepcek = $talepsor->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                            <div class="single-item-grid">
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

                                                <a
                                                    href="talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>">
                                                    <div class="item-content">
                                                        <div class="item-info">
                                                            <h5>
                                                                <?php
                                                                $ad = turkce_title_case($talepcek['talep_ad']); // önce baş harfleri büyüt
                                                                echo mb_strlen($ad, 'UTF-8') > 24 ? mb_substr($ad, 0, 24, 'UTF-8') . '...' : $ad;
                                                                ?>
                                                            </h5>

                                                            <?php if($talepcek['talep_kategori']==14) { ?>

                                                                <span> <?php echo $talepcek['marka_ad'] . " -"  ?> </span>
                                                            
                                                            <?php } else{ ?>


                                                            <?php } ?>
                                                            <span style="text-transform: none;">
                                                                <?php
                                                                $sehir = turkce_title_case($talepcek['talep_sehir']);
                                                                echo "" . (mb_strlen($sehir, 'UTF-8') > 10 ? mb_substr($sehir, 0, 10, 'UTF-8') . '...' : $sehir);
                                                                ?>
                                                            </span>
                                                            <div class="price">
                                                                <?php echo $talepcek['talep_fiyat'] . " " . "TL" ?>
                                                            </div>
                                                        </div>
                                                        <!--  
                                                        <div class="item-profile">
                                                            <div class="profile-title">
                                                                <div class="img-wrapper"><img src="img\profile\1.jpg"
                                                                        alt="profile" class="img-responsive img-circle"></div>
                                                                <span>PsdBosS</span>
                                                            </div>
                                                            
                                                                <div class="profile-rating">
                                                                    <ul>
                                                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                        <li>(<span> 05</span> )</li>
                                                                    </ul>
                                                                </div>
                                                            
                                                        </div>
                                                    -->
                                                    </div>
                                            </div>
                                        </div>
                                        </a>
                                    <?php } ?>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ul class="pagination-align-left">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade clear products-container" id="list-view">
                            <div class="product-list-view">

                                <div class="single-item-list">
                                    <div class="item-img">
                                        <img src="img\product\36.jpg" alt="product" class="img-responsive">
                                        <div class="trending-sign" data-tips="Trending"><i class="fa fa-bolt"
                                                aria-hidden="true"></i></div>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-info">
                                            <div class="item-title">
                                                <h3><a href="#">Responsive APP</a></h3>
                                                <span>APP</span>
                                                <p>Pimply dummy text of the printing and typesetting industry. </p>
                                            </div>
                                            <div class="item-sale-info">
                                                <div class="price">$15</div>
                                                <div class="sale-qty">Sales ( 11 )</div>
                                            </div>
                                        </div>
                                        <div class="item-profile">
                                            <div class="profile-title">
                                                <div class="img-wrapper"><img src="img\profile\1.jpg" alt="profile"
                                                        class="img-responsive img-circle"></div>
                                                <span>PsdBosS</span>
                                            </div>
                                            <div class="profile-rating-info">
                                                <ul>
                                                    <li>
                                                        <ul class="profile-rating">
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                            <li>(<span> 05</span> )</li>
                                                        </ul>
                                                    </li>
                                                    <li><i class="fa fa-comment-o" aria-hidden="true"></i>( 10 )</li>
                                                    <li><i class="fa fa-heart-o" aria-hidden="true"></i>( 20 )</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ul class="pagination-align-left">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 col-lg-pull-9 col-md-pull-8 col-sm-pull-8">
                <?php require_once 'sidebar.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

<script>
    function toggleDropdownSorting() {
        var menu = document.getElementById("dropdown-sorting-menu");
        menu.classList.toggle("show");
    }

    // Dropdown dışında bir yere tıklanınca menüyü kapat
    document.addEventListener("click", function (event) {
        var dropdownSorting = document.querySelector(".dropdown-sorting");
        var menu = document.getElementById("dropdown-sorting-menu");

        if (!dropdownSorting.contains(event.target)) {
            menu.classList.remove("show");
        }
    });

    let maps = [];
    let markers = [];
    let circles = [];

    function initMap() {
        // Varsayılan başlangıç konumu
        // Tüm .map sınıfına sahip elementleri seç
        const mapElements = document.querySelectorAll(".map");

        mapElements.forEach((mapElement, index) => {

            const lat = parseFloat(mapElement.getAttribute("enlem"));
            const lng = parseFloat(mapElement.getAttribute("boylam"));
            const yaricap = parseFloat(mapElement.getAttribute("yaricap"));
            const zoom = parseInt(mapElement.getAttribute("zoom"));
            const location = { lat: lat, lng: lng };

            function isDraggable() {
                return window.innerWidth > 2000; // 2000 pikselden büyükse sürüklenebilir
            }

            // Yeni bir harita oluştur
            let map = new google.maps.Map(mapElement, {
                center: location,
                zoom: zoom,
                zoomControl: true,
                streetViewControl: false, // Sokak görünümü kontrolünü kaldırır
                mapTypeControl: false,  // map tipinin değiştirilmesini engeller
                draggable: isDraggable(), // Ekran boyutuna göre draggable ayarı
            });

            // Tam ekran modu kontrolü ve draggable güncelleme
            function updateDraggable() {
                if (window.innerWidth > 2000 || document.fullscreenElement) {
                    map.setOptions({ draggable: true });
                } else {
                    map.setOptions({ draggable: false });
                }
            }

            // Sayfa boyutu değiştiğinde draggable özelliğini güncelle
            window.addEventListener("resize", updateDraggable);

            // Tam ekran durumunu dinle
            document.addEventListener("fullscreenchange", updateDraggable);
            document.addEventListener("webkitfullscreenchange", updateDraggable);
            document.addEventListener("mozfullscreenchange", updateDraggable);
            document.addEventListener("MSFullscreenChange", updateDraggable);

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

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".product-grid-view a").forEach(function (link) {
            link.addEventListener("click", function (event) {
                // Eğer tıklanan öğe bir "map" içindeki bir eleman ise yönlendirmeyi engelledik
                if (event.target.closest(".map")) {
                    event.preventDefault();
                }
            });
        });
    });


</script>