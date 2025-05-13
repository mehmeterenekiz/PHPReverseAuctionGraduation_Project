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

    .ilan-model {
        font-size: 14px;
        color: #666;
    }

    .ilan-konum {
        font-size: 13px;
        color: #999;
    }
</style>

<style>
    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }

    /* .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        } */


    .chat .chat-header {
        padding-bottom: -4rem;
        border-bottom: 1px solid #ccc;
    }

    .chat .chat-header .chat-about {
        float: left;
        padding-left: 10px;
    }

    .chat .chat-history {
        padding: 20px;
        border-bottom: 2px solid #fff;
        max-height: 40rem;
        min-height: 20rem;
        overflow-y: auto;
    }

    .chat .chat-history ul {
        padding: 0;
    }

    .chat .chat-history ul li {
        list-style: none;
        margin-bottom: 30px;
    }

    .chat .chat-history ul li:last-child {
        margin-bottom: 0px;
    }

    .chat .chat-history .message-data {
        margin-bottom: 15px;
    }

    .chat .chat-history .message-data-time {
        color: #434651;
        padding-left: 6px;
        font-size: 1.3rem;
    }

    .chat .chat-history .message {
        color: #444;
        padding-right: 3rem !important;
        padding: 10px 12px;
        line-height: 26px;
        font-size: 14px;
        border-radius: 7px;
        display: inline-block;
        position: relative;
        max-width: 46rem;
        min-width: 14rem;
        word-wrap: break-word;
        text-align: left;
        text-transform: none;
    }

    .chat .chat-history .message:after {
        bottom: 100%;
        left: 7%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #fff;
        border-width: 10px;
        margin-left: -10px;
    }

    .chat .chat-history .my-message {
        background: #efefef;
    }

    .chat .chat-history .my-message:after {
        bottom: 100%;
        left: 30px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #efefef;
        border-width: 10px;
        margin-left: -10px;
    }

    .chat .chat-history .other-message {
        background: #e8f1f3;
        text-align: left;
    }

    .chat .chat-history .other-message:after {
        border-bottom-color: #e8f1f3;
        left: 93%;
    }

    .chat .chat-message {
        padding: 20px;
    }

    .online,
    .offline,
    .me {
        margin-right: 2px;
        font-size: 8px;
        vertical-align: middle;
    }

    .online {
        color: #86c541;
    }

    .offline {
        color: #e47297;
    }

    .me {
        color: #1d8ecd;
    }

    .float-right {
        float: right;
    }

    .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }

    h5 {
        margin-bottom: 1rem !important;
        margin-top: 1rem;
    }

    .input-wrapper {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .form-control {
        flex: 1;
        height: 35px;
        font-size: 14px;
        padding: 5px 10px;
        box-sizing: border-box;
        text-transform: none;
    }

    .form-control::placeholder {
        text-transform: none;
    }

    .send-icon {
        background-color: rgb(68, 149, 230);
        border-color: transparent;
        margin-left: 10px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 540;
        color: white;
        border: 1px solid #ccc;
        padding: 9px;
        border-radius: 3px;
        width: 8rem;
        opacity: 0.5;
    }

    .send-icon:enabled:hover {
        background-color: rgb(14, 105, 197);
    }


    @media only screen and (max-width: 767px) {
        .chat-app .people-list {
            height: 465px;
            width: 100%;
            overflow-x: auto;
            background: #fff;
            left: -400px;
            display: none;
        }

        .chat-app .people-list.open {
            left: 0;
        }

        .chat-app .chat {
            margin: 0;
        }

        .chat-app .chat .chat-header {
            border-radius: 0.55rem 0.55rem 0 0;
        }

        .chat-app .chat-history {
            height: 300px;
            overflow-x: auto;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 992px) {
        .chat-app .chat-list {
            height: 650px;
            overflow-x: auto;
        }

        .chat-app .chat-history {
            height: 600px;
            overflow-x: auto;
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
        .chat-app .chat-list {
            height: 480px;
            overflow-x: auto;
        }

        .chat-app .chat-history {
            height: calc(100vh - 350px);
            overflow-x: auto;
        }
    }
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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

<?php

if (isset($_GET['kime'])) { ?>
    <?php
    $talep_id_mesaj = (int) $_GET['talep_id'];
    $kimden_mesaj = (int) $_GET['kime'];
    $kullanici_id_mesaj = (int) $_SESSION['user_kullanici_mail'];

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
}
?>

<!-- Settings Page Start Here -->
<div class="settings-page-area bg-secondary section-space-bottom">
    <div class="container">
        <div class="row settings-wrapper">

            <?php require_once "sidebar-user.php" ?>

            <?php
            $talepsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id inner join kullanici on talep.kullanici_id = kullanici.kullanici_id inner join vasitamarka on talep.talep_marka = vasitamarka.marka_id where talep.talep_id=:talep_id");
            $talepsor->execute(array(
                'talep_id' => $_GET['talep_id']
            ));

            $talepcek = $talepsor->fetch(PDO::FETCH_ASSOC)
                ?>

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">


                <div class="settings-details tab-content">
                    <div class="tab-pane fade active in" id="Personal">
                        <h2 class="title-section" style="font-size: 1.6rem;">
                            Mesajlarım </h2>
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

                            <a
                                href="nedmin/netting/kullanici-islem?talep_url_taleplerim=talep-<?= seo($talepcek['talep_ad']) . "-" . $talepcek['talep_id'] ?>">
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
                                            <div class="ilan-fiyat"><?php echo $talepcek['talep_fiyat'] ?> TL</div>
                                        </div>
                                        <div class="ilan-model"> <?php echo $talepcek['marka_ad'] ?> </div>
                                        <div class="ilan-konum"> <?php echo $talepcek['talep_sehir'] ?> </div>
                                    </div>
                                </div>
                            </a>

                            <?php
                            $kime_id = isset($_GET['kime']) ? $_GET['kime'] : null;

                            $kullanicisor = $db->prepare("SELECT kullanici_ad, kullanici_soyad FROM kullanici WHERE kullanici_id = :kime_id");
                            $kullanicisor->execute(array(
                                'kime_id' => $kime_id
                            ));

                            $kimecek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <div class="row clearfix">
                                <div class="col-lg-12">
                                    <div class="card chat-app">
                                        <div class="chat">

                                            <div class="chat-header clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="chat-about">
                                                            <h5>
                                                                <?php if (isset($_GET['kime'])) {

                                                                    echo $kimecek['kullanici_ad'] . " " . $kimecek['kullanici_soyad'];

                                                                } else { ?>

                                                                    <?php echo $talepcek['kullanici_ad'] . " " . $talepcek['kullanici_soyad'];

                                                                } ?>
                                                            </h5>
                                                            <!-- <small>Last seen: 2 hours ago</small> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $kimden = $_SESSION['user_kullanici_mail'];

                                            $talep_sahibi_id = $talepcek['kullanici_id']; // bu talebi açan kişi
                                            $talep_id = $talepcek['talep_id'];

                                            if ($kimden == $talep_sahibi_id) {
                                                // Talep sahibi ben isem, karşı taraf ilk mesaj atan kişidir
                                                $kime = $_GET['kime'];
                                            } else {
                                                // Talep sahibi değilsem, kime zaten talep sahibidir
                                                $kime = $talep_sahibi_id;
                                            }


                                            $talep_id = $talepcek['talep_id'];

                                            $veri = $db->prepare("SELECT * FROM mesaj WHERE ((kimden=:kimden AND kime=:kime) 
                                                OR (kimden=:kime AND kime=:kimden)) AND talep_id=:talep_id 
                                                ORDER BY mesaj_zaman");
                                            $veri->execute(array(':kimden' => $kimden, ':kime' => $kime, ':talep_id' => $talep_id));

                                            ?>
                                            <div class="chat-history">
                                                <ul class="m-b-0 butun-mesajlar">

                                                    <?php while ($mesajlar = $veri->fetch(PDO::FETCH_ASSOC)) {

                                                        if ($mesajlar["kimden"] == $kimden) { ?>
                                                            <li class="clearfix" id="other-messagee">
                                                                <div class="message-data text-right">
                                                                    <span class="message-data-time">
                                                                        <?php
                                                                        $tarih = $mesajlar["mesaj_zaman"];
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
                                                                <div class="message other-message float-right"
                                                                    style="position: relative;">
                                                                    <?php echo $mesajlar["mesaj_detay"] ?>

                                                                    <?php if ($mesajlar["mesaj_okunma"] == 1) { ?>

                                                                        <span
                                                                            style="position: absolute; bottom: 2rem; right: 0.5rem;">
                                                                            <i class="fa-solid fa-check mesaj-goruldu"
                                                                                style="position: absolute; right: 0.7rem;"></i>
                                                                            <i class="fa-solid fa-check mesaj-goruldu"
                                                                                style="position: absolute; right: 0.2rem; clip-path: inset(0 0 0 0.2rem);"></i>
                                                                        </span>

                                                                    <?php } else { ?>

                                                                        <span
                                                                            style="position: absolute; bottom: 2rem; right: 0.5rem;">
                                                                            <i class="fa-solid fa-check mesaj-gorulmedi"
                                                                                style="position: absolute; right: 0.7rem;"></i>
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
                                                                        $tarih = $mesajlar["mesaj_zaman"];
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
                                                                    <?php echo $mesajlar["mesaj_detay"] ?>
                                                                </div>
                                                            </li>
                                                        <?php } ?>

                                                    <?php } ?>

                                                </ul>
                                            </div>
                                            <div class="input-wrapper">
                                                <input type="text" class="form-control" name="mesaj-input"
                                                    id="mesaj-input" placeholder="Mesajınızı buraya yazın"
                                                    oninput="kontrolEt()">

                                                <input type="text" hidden name="kime" value="<?php echo $kime ?>">
                                                <input type="text" hidden name="kimden"
                                                    value="<?php echo $_SESSION['user_kullanici_mail'] ?>">
                                                <input type="text" hidden name="talep_id"
                                                    value="<?php echo $talepcek['talep_id']; ?>">

                                                <button type="button" class="send-icon" onclick="start(this)"
                                                    id="gonder-btn" disabled>
                                                    <span>Gönder</span>
                                                </button>
                                            </div>

                                            <script>
                                                var kime, kimden, talep_id, mesaj;
                                                var intervalBasladi = false;
                                                var oncekiMesajSayisi = 0;

                                                function start(button) {
                                                    kime = $("input[name='kime']").val();
                                                    kimden = $("input[name='kimden']").val();
                                                    talep_id = $("input[name='talep_id']").val();
                                                    mesaj = $("input[name='mesaj-input']").val();

                                                    $.ajax({
                                                        url: "../../nedmin/netting/mesajlar-api.php?mode=insert",
                                                        type: "POST",
                                                        data: {
                                                            kime: kime,
                                                            kimden: kimden,
                                                            talep_id: talep_id,
                                                            mesaj: mesaj,
                                                        },
                                                        success: function (result) {
                                                            $("input[name='mesaj-input']").val("");
                                                            console.log(result);
                                                            veriCek(true); // scroll yapılacak
                                                        },
                                                    });
                                                }

                                                function veriCek(scrollZorla = false) {
                                                    $.ajax({
                                                        url: "../../nedmin/netting/mesajlar-api.php?mode=get",
                                                        type: "POST",
                                                        data: {
                                                            kime: kime,
                                                            kimden: kimden,
                                                            talep_id: talep_id,
                                                        },
                                                        success: function (result) {
                                                            $(".butun-mesajlar").html(result);

                                                            var yeniMesajSayisi = $(".butun-mesajlar li").length;

                                                            if (yeniMesajSayisi > oncekiMesajSayisi || scrollZorla) {
                                                                var chatHistory = document.querySelector('.chat .chat-history');
                                                                if (chatHistory) {
                                                                    chatHistory.scrollTop = chatHistory.scrollHeight;
                                                                }
                                                            }

                                                            oncekiMesajSayisi = yeniMesajSayisi;
                                                        },
                                                    });
                                                }

                                                $(document).ready(function () {
                                                    kime = $("input[name='kime']").val();
                                                    kimden = $("input[name='kimden']").val();
                                                    talep_id = $("input[name='talep_id']").val();

                                                    // Başlatıldığında hemen bir defa veri çek
                                                    veriCek();

                                                    if (!intervalBasladi) {
                                                        setInterval(function () {
                                                            veriCek();
                                                        }, 1000);
                                                        intervalBasladi = true;
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mesajInput = document.getElementById('mesaj-input');
        const gonderBtn = document.getElementById('gonder-btn');

        if (mesajInput) {
            mesajInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    if (!gonderBtn.disabled) {
                        gonderBtn.click(); // Gönder butonuna tıkla
                    }
                }
            });
        }

        function kontrolEt() {
            if (mesajInput && gonderBtn) {
                if (mesajInput.value.trim() === "") {
                    gonderBtn.disabled = true;
                    gonderBtn.style.opacity = "0.5";
                    gonderBtn.style.cursor = "not-allowed";
                } else {
                    gonderBtn.disabled = false;
                    gonderBtn.style.opacity = "1";
                    gonderBtn.style.cursor = "pointer";
                }
            }
        }

        // Input değiştiğinde buton kontrolünü yap
        if (mesajInput) {
            mesajInput.addEventListener('input', kontrolEt);
        }
    });
</script>

<script>
    function scrollToBottom() {
        var chatHistory = document.querySelector('.chat .chat-history');
        if (chatHistory) {
            chatHistory.scrollTop = chatHistory.scrollHeight;
        }
    }

    document.addEventListener('DOMContentLoaded', scrollToBottom);
</script>

<!-- <script>
    var kime, kimden, talep_id, mesaj;

    function start(button) {
        kime = $("input[name='kime']").val();
        kimden = $("input[name='kimden']").val();
        talep_id = $("input[name='talep_id']").val();
        mesaj = $("input[name='mesaj-input']").val();

        $.ajax({
            url: "../../nedmin/netting/mesajlar-api.php?mode=insert",
            type: "POST",
            data: {
                kime: kime,
                kimden: kimden,
                talep_id: talep_id,
                mesaj: mesaj,
            },
            success: function (result) {
                $("input[name='mesaj-input']").val("");
                console.log(result);
            },
        });

        function veriCek() {
            $.ajax({
                url: "../../nedmin/netting/mesajlar-api.php?mode=get",
                type: "POST",
                data: {
                    kime: kime,
                    kimden: kimden,
                    talep_id: talep_id,
                    mesaj: mesaj,
                },
                success: function (result) {
                    $(".butun-mesajlar").html(result);

                },
            });
        }

        setInterval(veriCek, 1000);

    }
</script> -->