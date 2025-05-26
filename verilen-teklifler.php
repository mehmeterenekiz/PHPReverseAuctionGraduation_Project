<?php
ob_start();
session_start();
$title = "Verilen Teklifler";
require_once "header_user.php";

$user_kullanici_id = $_SESSION['user_kullanici_mail'];
$kontrol_aktiflik = $db->prepare("SELECT * FROM kullanici WHERE kullanici_id=:user_kullanici_id");
$kontrol_aktiflik->execute(array(
    'user_kullanici_id' => $user_kullanici_id
));

$kontrolaktiflikcek = $kontrol_aktiflik->fetch(PDO::FETCH_ASSOC);

if ($kontrolaktiflikcek['kullanici_teklif_alma_verme'] == 0 || $kontrolaktiflikcek['kullanici_teklif_alma_verme'] == 1) {
    header("location: ../../teklif-al-ver-basvuru?durum=aktifdegil");
    exit;
}

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
        z-index: 1000;
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
                <li><a href="index.php">Anasayfa</a><span> -</span></li>
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
                        <h2 class="title-section">Verdiğim Teklifler</h2>
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

                        <?php
                        if (isset($_GET['durum']) and $_GET['durum'] == "guncellendi") { ?>
                            <div class="alert-box-ok"
                                style="max-width:32.5%; position:absolute; margin-top: -5.25rem !important; margin-left:27.6rem !important;">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                    width="15" height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span style="text-transform:none;" class="font-opacity">Vermiş olduğunuz teklifiniz güncellendi.</span>
                            </div>
                        <?php } ?>

                        

                        <div class="personal-info inner-page-padding" style="padding: 25px 25px 5px 25px !important;">
                        <?php 
                            $teklifsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id inner join kullanici on kullanici.kullanici_id = talep.kullanici_id inner join teklif on talep.talep_id = teklif.talep_id where teklif.teklif_veren_kullanici_id=:kullanici_id order by teklif_zaman desc");
                            $teklifsor->execute(array(
                                'kullanici_id' => $_SESSION['user_kullanici_mail']   // kulllanici id geliyor aslında
                            ));

                            $say = $teklifsor->rowCount();
                        ?>
                        
                        <?php if ($say==0) { ?>    
                            <div class="info-box"
                                    style="display:block !important; margin: -6px 25px 25px 10px !important;">

                                    <span class="icon" style="font-size: 18px; color: blue; padding-right: 1rem;" ><i class="bi bi-info-square"></i></span>

                                    <span style="text-transform:none; font-size: 13px !important;" class="font-opacity">
                                        Vermiş olduğunuz herhangi bir teklifiniz bulunmamaktadır.
                                    </span>
                            </div>
                        <?php } else { ?> 
                            <table class="table table-striped yeni">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" style="width: 190px;">Talep</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Verilen Teklif</th>
                                        <th scope="col">Teklif Durumu</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $teklifsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id inner join kullanici on kullanici.kullanici_id = talep.kullanici_id inner join teklif on talep.talep_id = teklif.talep_id where teklif.teklif_veren_kullanici_id=:kullanici_id order by teklif_zaman desc");
                                    $teklifsor->execute(array(
                                        'kullanici_id' => $_SESSION['user_kullanici_mail']   // kulllanici id geliyor aslında
                                    ));

                                    $say = 1;

                                    while ($teklifcek = $teklifsor->fetch(PDO::FETCH_ASSOC)) { ?>

                                        <tr>
                                            <th scope="row"> <?php echo $say ?> </th>
                                            <td>
                                                <a
                                                    href="nedmin/netting/kullanici-islem?talep_url_teklif=talep-<?= seo($teklifcek['talep_ad']) . "-" . $teklifcek['talep_id'] ?>">
                                                    <div class="map" enlem="<?php echo $teklifcek['talep_konum_enlem'] ?>"
                                                        boylam="<?php echo $teklifcek['talep_konum_boylam'] ?>"
                                                        yaricap="<?= $teklifcek['talep_cember_yaricap'] ?>" zoom="<?php
                                                          if ($teklifcek['talep_cember_yaricap'] < 92000) { // 6 numara
                                                              echo '7';
                                                          } else if ($teklifcek['talep_cember_yaricap'] < 185000) {  // 1 numara
                                                              echo '6';
                                                          } elseif ($teklifcek['talep_cember_yaricap'] < 395000) {
                                                              echo '5';
                                                          } else {
                                                              echo '4';
                                                          }
                                                          ?>"></div>

                                                    <?php
                                                    if ($teklifcek['teklif_onay_durum'] == 4) { ?>
                                                        <div class="map-container">
                                                            <div class="text" style="color: red; opacity: 0.8;">
                                                                reddedildi
                                                            </div>
                                                        </div>
                                                    <?php }
                                                    if ($teklifcek['teklif_onay_durum'] == 3) { ?>
                                                        <div class="map-container">
                                                            <div class="text" style="color: blue;">
                                                                onaylandı
                                                            </div>
                                                        </div>
                                                    <?php } else if ($teklifcek['talep_durum'] == 2 || $teklifcek['talep_durum'] == 3) { ?>
                                                            <div class="map-container">
                                                                <div class="text">
                                                                    kaldırıldı
                                                                </div>
                                                            </div>
                                                    <?php } ?>

                                                </a>
                                            </td>
                                            <td style="text-align: center;"><?php echo $teklifcek['kategori_ad'] ?></td>
                                            <td style="text-align: center;"><?php echo $teklifcek['teklif_fiyat'] . " TL" ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                if ($teklifcek['teklif_onay_durum'] == 0) { ?>
                                                    <p style="color: orange;">Teklifiniz İletildi</p>
                                                <?php } else if ($teklifcek['teklif_onay_durum'] == 1) { ?>
                                                        <p style="color:rgb(7, 183, 186);">Fiyat Revizesi İsteniyor </p>
                                                <?php } else if ($teklifcek['teklif_onay_durum'] == 2) { ?>
                                                        <p style="color:rgb(7, 183, 186);">Revize Teklifiniz İletildi </p>
                                                <?php } else if ($teklifcek['teklif_onay_durum'] == 3) { ?>
                                                            <p style="color: blue;"> Teklifiniz Onaylandı </p>
                                                            <p> Talep Sahibi Bilgileri</p>
                                                            <p style="margin-top: -2rem; font-weight: 700; color: black;">
                                                        <?php echo $teklifcek['kullanici_ad'] ?>
                                                            </p>
                                                            <p style="margin-top: -2rem; font-weight: 700; color: black;">
                                                        <?php echo $teklifcek['kullanici_gsm'] ?>
                                                            </p>
                                                <?php } else if ($teklifcek['teklif_onay_durum'] == 4) { ?>
                                                                <p style="color: red;">Teklifiniz Reddedildi </p>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php
                                                 if ($teklifcek['talep_durum'] == 0 || $teklifcek['talep_durum'] == 1) { ?>
                                                    <?php
                                                    if ($teklifcek['teklif_onay_durum'] == 2 || $teklifcek['teklif_onay_durum'] == 3 || $teklifcek['teklif_onay_durum'] == 4) { ?>

                                                        <a href="#" id="cart-button" class="teklif-duzenle-btn"
                                                            data-id="<?php echo $teklifcek['teklif_id']; ?>">
                                                            <button class="btn btn-primary btn-xs" onclick="start(this)">Teklifi
                                                                İncele</button>
                                                        </a>
                                                        
                                                    <?php } else if ($teklifcek['teklif_onay_durum'] == 1) { ?>

                                                            <a href="#" id="cart-button" class="teklif-duzenle-btn"
                                                                data-id="<?php echo $teklifcek['teklif_id']; ?>">
                                                                <button class="btn btn-primary btn-xs" onclick="start(this)">Fiyatı Revize Et</button>
                                                            </a>

                                                    <?php } else { ?>

                                                            <a href="#" id="cart-button" class="teklif-duzenle-btn"
                                                                data-id="<?php echo $teklifcek['teklif_id']; ?>">
                                                                <button class="btn btn-primary btn-xs" onclick="start(this)">Teklifi
                                                                    Düzenle</button>
                                                            </a>

                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <a href="#" id="cart-button" class="teklif-duzenle-btn"
                                                        data-id="<?php echo $teklifcek['teklif_id']; ?>">
                                                        <button class="btn btn-primary btn-xs" onclick="start(this)">Teklifi
                                                            İncele</button>
                                                    </a>
                                                <?php } ?>
                                            </td>

                                            <script type="text/javascript">
                                                function start(button) {
                                                    var teklifId = $(button).parent("a").data("id");
                                                    console.log("Teklif ID:", teklifId);

                                                    $.ajax({
                                                        url: '../../nedmin/netting/backend.php',
                                                        type: 'POST',
                                                        dataType: 'JSON',
                                                        data: { teklif_id: teklifId },
                                                        success: function (response) {
                                                            console.log("Başarılı Yanıt:", response);

                                                            if (response.status) {
                                                                var teklifData = response.data;

                                                                $('input[name="teklif_fiyat"]').val(teklifData.teklif_fiyat);
                                                                $('input[name="teklif_aciklama"]').val(teklifData.teklif_aciklama);
                                                                $('input[name="teklif_sehir_ilce"]').val(teklifData.teklif_sehir_ilce);
                                                                $('input[name="teklif_cember_yaricap"]').val(teklifData.teklif_cember_yaricap);
                                                                $('input[name="teklif_cember_yaricapp"]').val(teklifData.teklif_cember_yaricap);
                                                                $('input[name="teklif_fiyat_old"]').val(teklifData.teklif_fiyat);
                                                                $('input[name="teklif_id"]').val(teklifData.teklif_id);
                                                                $('input[name="teklif_onay_durum"]').val(teklifData.teklif_onay_durum);
                                                                
                                                                var mapDiv = document.getElementById("map-detay-teklif");

                                                                var enlem = parseFloat(teklifData.teklif_konum_enlem);
                                                                var boylam = parseFloat(teklifData.teklif_konum_boylam);
                                                                var yaricap = parseFloat(teklifData.teklif_cember_yaricap);
                                                                var zoom;
                                                                if (yaricap < 92000) {
                                                                    zoom = 8;
                                                                } else if (yaricap < 185000) {
                                                                    zoom = 7;
                                                                } else if (yaricap < 395000) {
                                                                    zoom = 6;
                                                                } else {
                                                                    zoom = 5;
                                                                }

                                                                mapDiv.setAttribute("enlem", enlem);
                                                                mapDiv.setAttribute("boylam", boylam);
                                                                mapDiv.setAttribute("yaricap", yaricap);
                                                                mapDiv.setAttribute("zoom", zoom);

                                                                console.log(parseFloat(mapDiv.getAttribute("enlem")));
                                                                console.log(parseFloat(mapDiv.getAttribute("boylam")));
                                                                console.log(parseFloat(mapDiv.getAttribute("yaricap")));
                                                                console.log(parseFloat(mapDiv.getAttribute("zoom")));

                                                                initMapTeklif();

                                                                // Butonun disabled olmasını kontrol et
                                                                var buton_duzenle = document.getElementById("form-buton");
                                                                var buton_iptal = document.getElementById("modal-kapat");

                                                                if (teklifData.teklif_onay_durum == "3" || teklifData.teklif_onay_durum == "4") {
                                                                    buton_duzenle.hidden = true;
                                                                    buton_iptal.hidden = true;
                                                                } else if(teklifData.teklif_onay_durum == "1" || teklifData.teklif_onay_durum == "2") {

                                                                    $('input[name="teklif_aciklama"]').prop('disabled', true);
                                                                    $('input[name="teklif_sehir_ilce"]').prop('disabled', true);
                                                                    $('input[name="teklif_cember_yaricap"]').prop('disabled', true);

                                                                    document.getElementById("teklif-pop-up").addEventListener("submit", function () {
                                                                        $('input[name="teklif_aciklama"]').prop('disabled', false);
                                                                        $('input[name="teklif_sehir_ilce"]').prop('disabled', false);
                                                                        $('input[name="teklif_cember_yaricap"]').prop('disabled', false);
                                                                    });


                                                                    if(teklifData.teklif_onay_durum == "2"){
                                                                        $('input[name="teklif_fiyat"]').prop('disabled', true);
                                                                        buton_duzenle.hidden = true;
                                                                        buton_iptal.hidden = true;
                                                                    }

                                                                    const buton = document.getElementById("form-buton");
                                                                    buton.textContent = "Revize Et"
                                                                    
                                                                    function toggleDraggable() {
                                                                        // Eğer marker tanımlıysa, draggable özelliğini kontrol et
                                                                        if (typeof markerteklif !== 'undefined') {
                                                                            const isDraggable = markerteklif.getDraggable();
                                                                            
                                                                            // Draggable özelliğini tersine çevir
                                                                            markerteklif.setDraggable(!isDraggable);
                                                                            
                                                                            // Durumla ilgili bir çıktı yazalım
                                                                            console.log("Draggable durum: " + !isDraggable);
                                                                        } else {
                                                                            console.log("Marker henüz tanımlanmadı.");
                                                                        }
                                                                    }
                                                                    toggleDraggable();
                                                                }
                                                                else {
                                                                  
                                                                }

                                                            } else {
                                                                alert(response.message);
                                                            }
                                                        },
                                                        error: function (err) {
                                                            console.log("Hata:", err.statusText);
                                                        }
                                                    });
                                                }
                                            </script>

                                            <td style="max-width:135px; text-align: center;">
                                                <?php
                                                if ($teklifcek['teklif_onay_durum'] == 0 || $teklifcek['teklif_onay_durum'] == 1 || $teklifcek['teklif_onay_durum'] == 2) { ?>

                                                    <a onclick="return confirm('Bu teklifi geri çekmek istediğinizden emin misiniz?')"
                                                        href="nedmin/netting/kullanici-islem?teklif_kaldir=ok&teklif_id=<?php echo $teklifcek['teklif_id'] ?>"><button
                                                            class="btn btn-danger btn-xs">Teklifi Geri Çek</button></a>

                                                <?php } else { ?>

                                                    <a
                                                        href="nedmin/netting/kullanici-islem?teklif_kaldir=ok&teklif_id=<?php echo $teklifcek['teklif_id'] ?>"><button
                                                            disabled class="btn btn-danger btn-xs">Teklifi Geri Çek</button></a>

                                                <?php } ?>
                                                <input hidden type="text" id="talep_fiyat" value="<?php echo $teklifcek['talep_fiyat'] ?>">
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

                <div class="modal">
                    <form action="nedmin/netting/kullanici-islem.php" method="POST" id="teklif-pop-up">
                        <label>Fiyat 
                        <span id="uyari_mesaji_teklif" style="color:red; font-size: 1rem; display:none;">
                                <?php echo "(revize teklifiniz, son teklifinizden yüksek olamaz!)" ?> </span>
                        
                        <span id="uyari_mesaji_talep" style="color:red; font-size: 1rem; display:none;">
                                <?php echo "(vereceğiniz teklif, talep fiyatından yüksek olamaz!)" ?> </span>
                        
                        <span id="uyari_mesaji_revize" style="color:blue; font-size: 1rem; display:none;">
                                <?php echo "(revize teklifinizi verirken dikkatli olunuz, tekrardan güncelleme yapamazınız.)" ?> </span>

                        </label>
                        <div class="form-group">
                            <input type="text" class="form-control rakam" required name="teklif_fiyat" id="teklif_fiyat"
                                placeholder="Fiyat">
                        </div>

                        <label>Açıklama</label>
                        <div class="form-group">
                            <input type="text" class="form-control" required name="teklif_aciklama"
                                placeholder="Açıklama">
                        </div>

                        <label>Şehir <label style="text-transform: none;">ve</label> İlçe</label>
                        <div class="form-group">
                            <input class="form-control" type="text" id="city-input" required name="teklif_sehir_ilce"
                                placeholder="istanbul/eyüp">
                        </div>

                        <label>Daire Yarıçapı</label>
                        <input type="range" id="radius-slider" name="teklif_cember_yaricap" min="70000" max="800000"
                            step="100">

                        <label style="margin-top: 4px;">Konum</label>
                        <div id="map-detay-teklif" name = "map-detay-teklif" >
                        </div>

                        <div class="button-group">
                            <button id="form-buton" type="submit" name="teklif_duzenle">Teklifi Güncelle</button>
                            <button id="modal-kapat">İptal</button>
                        </div>

                        <input type="text" hidden id="teklif_id" name="teklif_id">
                        <input type="text" hidden id="teklif_cember_yaricap" name="teklif_cember_yaricapp">
                        <input type="text" hidden name="teklif_konum_enlem" id="enlem">
                        <input type="text" hidden name="teklif_konum_boylam" id="boylam">
                        <input type="text" hidden name="teklif_onay_durum" id="teklif_onay_durum">
                        <input type="text" hidden id="teklif_fiyat_old" name="teklif_fiyat_old">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    </form>
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

    var markerteklif;
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

    document.getElementById('form-buton').addEventListener('click', function (event) {
        const teklifFiyat = document.getElementById('teklif_fiyat').value;
        const teklifFiyatOld = document.getElementById('teklif_fiyat_old').value;
        const talepFiyat = document.getElementById('talep_fiyat').value;
        const teklif_onay_durum = document.getElementById('teklif_onay_durum').value;

        const fiyatTalep = parseInt(talepFiyat.replace(/\./g, ''), 10);
        const fiyatTeklifOld = parseInt(teklifFiyatOld.replace(/\./g, ''), 10);
        const fiyatTeklif = parseInt(teklifFiyat.replace(/\./g, ''), 10);

        if (isNaN(fiyatTeklif) || fiyatTeklifOld <= fiyatTeklif && teklif_onay_durum == 1) {
            event.preventDefault();
            document.getElementById('uyari_mesaji_teklif').style.display = 'inline';
        } else if (fiyatTalep < fiyatTeklif && teklif_onay_durum == 0)
            document.getElementById('uyari_mesaji_talep').style.display = 'inline';
        else {
            document.getElementById('uyari_mesaji_teklif').style.display = 'none';
            document.getElementById('uyari_mesaji_talep').style.display = 'none';
        }
    });

</script>