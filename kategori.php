<?php
ob_start();
session_start();

if (isset($_SESSION['user_kullanici_mail'])) {
    require_once "header_user.php";
} else {
    require_once 'header.php';
}

if (isset($_GET['kategori_id'])) {

    $sayfada = 2;
    $kategori_id = $_GET['kategori_id'];
    $sorgu = $db->prepare("SELECT * FROM talep where talep_durum=:talep_durum and kategori_id=:kategori_id");
    $sorgu->execute(array(
        'talep_durum' => 1,
        'kategori_id' => $kategori_id
    ));
    $toplam_icerik = $sorgu->rowCount();
    $toplam_sayfa = ceil($toplam_icerik / $sayfada);
    // Eğer sayfa girdisi yoksa 1 varsayıyoruz
    $sayfa = isset($_GET['sayfa']) ? (int) $_GET['sayfa'] : 1;
    if ($sayfa < 1) {
        $sayfa = 1;
    }
    if ($sayfa > $toplam_sayfa) {
        $sayfa = $toplam_sayfa;
    }
    $limit = ($sayfa - 1) * $sayfada;

    $talepsor = $db->prepare("SELECT *, talep.kategori_id as talep_kategori FROM talep inner join vasitamarka on talep.talep_marka = vasitamarka.marka_id where talep_durum=:talep_durum and talep.kategori_id=:kategori_id order by talep_zaman desc limit $limit,$sayfada");
    $talepsor->execute(array(
        'talep_durum' => 1,
        'kategori_id' => $kategori_id,
    ));

    $say = $sorgu->rowCount();
}
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

<?php require_once "arama-cubuk.php"; ?>

<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper" style=" margin-top: -1rem; margin-bottom: -5rem;">
            <ul>
                <li><a href="index.php">anasayfa</a><span> -</span></li>
                <?php
                $kategori_id = $_GET['kategori_id'];
                $kategorisor = $db->prepare("SELECT * FROM kategori where kategori_id=:kategori_id");
                $kategorisor->execute(array(
                    'kategori_id' => $kategori_id,
                ));
                $kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)
                    ?>
                <li> <?php echo $kategoricek['kategori_ad'] ?> </li>

            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->

<div class="product-page-grid bg-secondary section-space-bottom" style="padding-top: 4.5rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 col-lg-push-3 col-md-push-4 col-sm-push-4">
                <div class="inner-page-main-body">
                    <div class="page-controls">
                        <div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-6">
                                <div class="layout-switcher">
                                    <ul>
                                        <li class="active"><a href="#gried-view" data-toggle="tab"
                                                aria-expanded="false"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="#list-view" data-toggle="tab" aria-expanded="true"><i
                                                    class="fa fa-list"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                <div class="page-controls-sorting">
                                    <div class="dropdown-sorting">
                                        <button class="dropdown-sorting-button" onclick="toggleDropdownSorting()">
                                            Gelişmiş sıralama <span class="arrow-sorting"><i
                                                    class="bi bi-chevron-down"></i></span>
                                        </button>
                                        <div class="dropdown-sorting-content" id="dropdown-sorting-menu"
                                            data-kategori-seo="<?php echo seo($kategoricek['kategori_ad']) ?>"
                                            data-kategori-id="<?php echo $_GET['kategori_id']; ?>">
                                            <div data-sort="fiyat_desc">Fiyata göre (Önce en yüksek)</div>
                                            <div data-sort="fiyat_asc">Fiyata göre (Önce en düşük)</div>
                                            <div data-sort="tarih_desc">Tarihe göre (Önce en yeni ilan)</div>
                                            <div data-sort="tarih_asc">Tarihe göre (Önce en eski ilan)</div>
                                            <div data-sort="km_asc">Km'ye göre (Önce en düşük)</div>
                                            <div data-sort="km_desc">Km'ye göre (Önce en yüksek)</div>
                                            <div data-sort="yil_asc">Yıla göre (Önce en eski)</div>
                                            <div data-sort="yil_desc">Yıla göre (Önce en yeni)</div>
                                            <div data-sort="adres_az">Adrese göre (A-Z)</div>
                                            <div data-sort="adres_za">Adrese göre (Z-A)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#dropdown-sorting-menu div").on("click", function () {
                            var sort = $(this).data("sort");
                            var kategoriId = $("#dropdown-sorting-menu").data("kategori-id");
                            var kategoriSeo = $("#dropdown-sorting-menu").data("kategori-seo");

                            // Yeni aktif öğeyi işaretle
                            $("#dropdown-sorting-menu div").removeClass("active");
                            $(this).addClass("active");

                            // Seçilen metni buton üzerine yaz
                            var secilenMetin = $(this).text().trim().substring(0, 18) + "...";
                            $(".dropdown-sorting-button").html(secilenMetin + ' <span class="arrow-sorting"><i class="bi bi-chevron-down"></i></span>');

                            $.ajax({
                                url: "../../nedmin/netting/ilan-filtre-api.php?kategori_id=" + kategoriId + "&kategori_seo=" + kategoriSeo + "&sayfa=1",
                                type: "POST",
                                data: { sort: sort },
                                success: function (response) {
                                    $("#ilanlar-alani").html(response);
                                    initMap();
                                },
                                error: function () {
                                    alert("Bir hata oluştu.");
                                }
                            });
                        });


                        // Sayfalama linklerine tıklanınca çalışır
                        $(document).on("click", ".pagination-link", function (e) {
                            e.preventDefault();

                            var sayfa = $(this).data("sayfa");
                            var kategoriId = $("#dropdown-sorting-menu").data("kategori-id");
                            var kategoriSeo = $("#dropdown-sorting-menu").data("kategori-seo");

                            // Aktif sıralama türünü bul
                            var sort = $("#dropdown-sorting-menu div.active").data("sort") || "tarih_desc";

                            $.ajax({
                                url: "../../nedmin/netting/ilan-filtre-api.php?kategori_id=" + kategoriId + "&kategori_seo=" + kategoriSeo + "&sayfa=" + sayfa,
                                type: "POST",
                                data: { sort: sort },
                                success: function (response) {
                                    $("#ilanlar-alani").html(response);
                                    initMap();
                                },
                                error: function () {
                                    alert("Sayfa yüklenemedi.");
                                }
                            });
                        });

                    </script>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active clear products-container" id="gried-view">
                            <div class="product-grid-view padding-narrow" id="ilanlar-alani">
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
                                <!--
                                <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                -->
                                <?php if ($toplam_sayfa > 1) { ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <ul class="pagination-align-left">
                                                <?php
                                                for ($s = 1; $s <= $toplam_sayfa; $s++) {
                                                    $aktifMi = ($s == $sayfa) ? 'style="background-color: rgba(231,76,60,255); color: white;"' : '';

                                                    if (!empty($_GET['kategori_id'])) {
                                                        $url = "kategori-{$_GET['sef']}-{$_GET['kategori_id']}?sayfa=$s";
                                                    } else {
                                                        $url = "kategori?sayfa=$s";
                                                    }

                                                    echo "<li><a href='$url' $aktifMi>$s</a></li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>

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

                                            <?php $s = 0;
                                            while ($s < $toplam_sayfa) {
                                                $s++; ?>
                                                <?php if (!empty($_GET['kategori_id'])) {

                                                    if ($s == $sayfa) { ?>

                                                        <li><a style="background-color: rgba(231,76,60,255); color: white;"
                                                                href="kategori-<?php echo $_GET['sef']; ?>-<?php echo $_GET['kategori_id'] ?>?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                                        </li>

                                                    <?php } else { ?>

                                                        <li><a
                                                                href="kategori-<?php echo $_GET['sef']; ?>-<?php echo $_GET['kategori_id'] ?>?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a>
                                                        </li>


                                                    <?php } ?>


                                                <?php } else {

                                                    if ($s == $sayfa) { ?>

                                                        <li><a style="background-color: rgba(231,76,60,255); color: white;"
                                                                href="kategori?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a></li>

                                                    <?php } else { ?>

                                                        <li><a href="kategori?sayfa=<?php echo $s; ?>"><?php echo $s; ?></a></li>

                                                    <?php } ?>
                                                <?php } ?>

                                            <?php } ?>

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

<script>
    $(document).ready(function () {
        $('.layout-switcher li a').on('click', function (e) {
            e.preventDefault();

            // Sekmelerde aktif sınıfı değiştir
            $('.layout-switcher li').removeClass('active');
            $(this).parent().addClass('active');

            // Tüm içerikleri gizle
            $('.tab-pane').removeClass('in active').hide();

            // Tıklanan sekmeye ait içeriği göster
            var target = $(this).attr('href'); // #list-view veya #gried-view
            $(target).addClass('in active').fadeIn();
        });
    });
</script>