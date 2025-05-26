<?php
require_once 'baglan.php';
require_once 'fonksiyonlar.php';
require_once '../production/fonksiyon.php';

$sort = $_POST['sort'] ?? 'tarih_desc';

$orderBy = "ORDER BY talep_id DESC"; // default sıralama
switch ($sort) {
    case "fiyat_desc":
        $orderBy = "ORDER BY talep_fiyat DESC";
        break;
    case "fiyat_asc":
        $orderBy = "ORDER BY talep_fiyat ASC";
        break;
    case "tarih_desc":
        $orderBy = "ORDER BY talep_zaman DESC";
        break;
    case "tarih_asc":
        $orderBy = "ORDER BY talep_zaman ASC";
        break;
    case "km_asc":
        $orderBy = "ORDER BY talep_min_km ASC";
        break;
    case "km_desc":
        $orderBy = "ORDER BY talep_max_km DESC";
        break;
    case "yil_asc":
        $orderBy = "ORDER BY talep_min_yil ASC";
        break;
    case "yil_desc":
        $orderBy = "ORDER BY talep_max_yil DESC";
        break;
    case "adres_az":
        $orderBy = "ORDER BY talep_sehir ASC";
        break;
    case "adres_za":
        $orderBy = "ORDER BY talep_sehir DESC";
        break;
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

    $talepsor = $db->prepare("SELECT * FROM talep 
    INNER JOIN vasitamarka ON talep.talep_marka = vasitamarka.marka_id 
    WHERE talep_durum=:talep_durum AND talep.kategori_id=:kategori_id 
    $orderBy 
    LIMIT $limit,$sayfada");

    $talepsor->execute(array(
        'talep_durum' => 1,
        'kategori_id' => $kategori_id,
    ));

    $say = $sorgu->rowCount();
}


if (isset($_GET['marka_id'])) {

    $sayfada = 2;
    $marka_id = $_GET['marka_id'];
    $sorgu = $db->prepare("SELECT * FROM talep where talep_durum=:talep_durum and talep_marka=:talep_marka");
    $sorgu->execute(array(
        'talep_durum' => 1,
        'talep_marka' => $marka_id
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

    $talepsor = $db->prepare("SELECT * FROM talep 
    INNER JOIN vasitamarka ON talep.talep_marka = vasitamarka.marka_id 
    WHERE talep_durum=:talep_durum AND talep.talep_marka=:talep_marka 
    $orderBy 
    LIMIT $limit,$sayfada");

    $talepsor->execute(array(
        'talep_durum' => 1,
        'talep_marka' => $marka_id,
    ));

    $say = $sorgu->rowCount();
}

?>

<div id="ilanlar-alani" class="row">
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

                <a href="talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>">
                    <div class="item-content">
                        <div class="item-info">
                            <h5>
                                <?php
                                $ad = turkce_title_case($talepcek['talep_ad']); // önce baş harfleri büyüt
                                echo mb_strlen($ad, 'UTF-8') > 26 ? mb_substr($ad, 0, 26, 'UTF-8') . '...' : $ad;
                                ?>
                            </h5>

                            <span> <?php echo $talepcek['marka_ad'] ?> </span>
                            <span style="text-transform: none;">
                                <?php
                                $sehir = turkce_title_case($talepcek['talep_sehir']);
                                echo "- " . (mb_strlen($sehir, 'UTF-8') > 10 ? mb_substr($sehir, 0, 10, 'UTF-8') . '...' : $sehir);
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
<?php if ($toplam_icerik > 1) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="pagination-align-left">
                <?php if ($toplam_sayfa > 1) { ?>
                    <?php
                    if (isset($_GET['kategori_id'])) {
                        for ($s = 1; $s <= $toplam_sayfa; $s++) {
                            $activeClass = ($s == $sayfa) ? 'style="background-color: rgba(231,76,60,255); color: white;"' : '';
                            echo "<li><a href='#' class='pagination-link' data-sayfa='$s' $activeClass>$s</a></li>";
                        }
                    } else {
                        for ($s = 1; $s <= $toplam_sayfa; $s++) {
                            $activeClass = ($s == $sayfa) ? 'style="background-color: rgba(231,76,60,255); color: white;"' : '';
                            echo "<li><a href='#' class='pagination-link' data-sayfa='$s' $activeClass>$s</a></li>";
                        }
                    }
                    ?>
                <?php } ?>

            </ul>
        </div>
    </div>
<?php } ?>