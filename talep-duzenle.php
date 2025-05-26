<?php
ob_start();
session_start();
$title = "Talep Düzenle";
require_once "header_user.php";

$talepsor = $db->prepare("SELECT * FROM talep INNER JOIN kategori ON talep.kategori_id = kategori.kategori_id where talep.kullanici_id=:kullanici_id and talep.talep_id=:talep_id order by talep_zaman desc");
$talepsor->execute(array(
    'kullanici_id' => $_SESSION['user_kullanici_mail'],   // kulllanici id geliyor aslında
    'talep_id' => $_GET['talep_id']
));
$talepcek = $talepsor->fetch(PDO::FETCH_ASSOC);
?>

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
                <form action="nedmin/netting/kullanici-islem.php" method="POST" class="form-horizontal"
                    id="personal-info-form">
                    <div class="settings-details tab-content">
                        <div class="tab-pane fade active in" id="Talep">
                            <h2 class="title-section">Talep Düzenle</h2>
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
                                    style="max-width:22.5%; position:absolute; margin-top: -5.25rem !important; margin-left:23.6rem !important;">
                                    <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                        width="15" height="15" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <span style="text-transform:none;" class="font-opacity">Talep Oluşturuldu.</span>
                                </div>
                            <?php }
                            if (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>
                                <div class="alert-box"
                                    style="max-width:26%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left:26rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity">Adres Oluşturulamadı.</span>
                                </div>
                            <?php } ?>

                            <?php
                            if (isset($_GET['talep_duzenle']) and $_GET['talep_duzenle'] == "ok") { ?>
                                <div class="alert-box-ok"
                                    style="max-width:22.5%; position:absolute; margin-top: -5.25rem !important; margin-left:23.6rem !important;">
                                    <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                        width="15" height="15" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <span style="text-transform:none;" class="font-opacity">Talep Oluşturuldu.</span>
                                </div>
                            <?php }
                            if (isset($_GET['talep_duzenle']) and $_GET['talep_duzenle'] == "no") { ?>
                                <div class="alert-box"
                                    style="max-width:26%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left:26rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity">Adres Oluşturulamadı.</span>
                                </div>
                            <?php } ?>

                            <div class="personal-info inner-page-padding">

                                <div class="date-picker">
                                    <label class="col-sm-3 control-label" style="margin-top: 1.8rem;">Kategori</label>
                                    <div class="dropdown" style="margin-left: 3.1rem !important; margin-top: 1.2rem;">
                                        <select name="kategori_id" id="kategori_id" style="width: 171.5px;">

                                            <?php
                                            $kategorisor = $db->prepare("SELECT * FROM kategori order by kategori_sira asc ");
                                            $kategorisor->execute();

                                            while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) { ?>

                                                <option value="<?php echo $kategoricek['kategori_id'] ?>" <?php echo $kategoricek['kategori_ad']==$talepcek['kategori_ad'] ? 'selected' : '';   ?> >
                                                    <?php echo $kategoricek['kategori_ad'] ?>
                                                </option>

                                            <?php } ?>
                                        </select>

                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Talep Adı</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" required value="<?php echo $talepcek['talep_ad'] ?>"
                                            style="height: 4rem !important; text-transform:none; " name="talep_ad"
                                            placeholder="Talep Adı">
                                    </div>
                                </div>

                                <div class="date-picker" id="marka">
                                    <label class="col-sm-3 control-label" style="margin-top: 1.8rem;">Marka</label>
                                    <div class="dropdown" style="margin-left: 3.1rem !important; margin-top: 1.2rem;">
                                        <select name="talep_marka" style="width: 171.5px;">

                                            <?php
                                            $markasor = $db->prepare("SELECT * FROM vasitamarka order by marka_ad asc ");
                                            $markasor->execute();

                                            while ($markacek = $markasor->fetch(PDO::FETCH_ASSOC)) { ?>

                                                <option value="<?php echo $markacek['marka_id'] ?>" <?php echo $markacek['marka_id']==$talepcek['talep_marka'] ? 'selected' : '';   ?>>
                                                    <?php echo $markacek['marka_ad'] ?>
                                                </option>

                                            <?php } ?>
                                        </select>

                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Yıl</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" id="talep_min_yil" required value="<?php echo $talepcek['talep_min_yil'] ?>"
                                            style="height: 4rem !important; text-transform:none;" name="talep_min_yil"
                                            placeholder="Min">
                                    </div>

                                    <label class="col-sm-1 control-label">----</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" id="talep_max_yil" required value="<?php echo $talepcek['talep_max_yil'] ?>"
                                            style="height: 4rem !important; text-transform:none; " name="talep_max_yil"
                                            placeholder="Max">
                                    </div>
                                </div>

                                <div class="form-group" id="yakit_tipi">
                                    <label class="col-sm-3 control-label">Yakıt Tipi</label>
                                    <div class="col-sm-9">
                                        <div class="filter-container">
                                            <label>
                                                <input type="checkbox" name="yakit[]" <?php echo str_contains($talepcek['talep_yakit_tipi'], "Benzin") ? 'checked' : ''; ?> value="Benzin">
                                                <span>Benzin</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="yakit[]" <?php echo str_contains($talepcek['talep_yakit_tipi'], "BenzinLPG") ? 'checked' : ''; ?> value="Benzin&LPG">
                                                <span>Benzin & LPG</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="yakit[]" <?php echo str_contains($talepcek['talep_yakit_tipi'], "Dizel") ? 'checked' : ''; ?> value="Dizel">
                                                <span>Dizel</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="yakit[]" <?php echo str_contains($talepcek['talep_yakit_tipi'], "Hybrid") ? 'checked' : ''; ?> value="Hybrid">
                                                <span>Hybrid</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="yakit[]" <?php echo str_contains($talepcek['talep_yakit_tipi'], "Elektrik") ? 'checked' : ''; ?> value="Elektrik">
                                                <span>Elektrik</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="kasa_tipi">
                                    <label class="col-sm-3 control-label">Kasa Tipi</label>
                                    <div class="col-sm-9">
                                        <div class="filter-container">
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "Cabrio") ? 'checked' : ''; ?> value="Cabrio">
                                                <span>Cabrio</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "Coupe") ? 'checked' : ''; ?> value="Coupe">
                                                <span>Coupe</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "Hatchback") ? 'checked' : ''; ?> value="Hatchback">
                                                <span>Hatchback</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "Sedan") ? 'checked' : ''; ?> value="Sedan">
                                                <span>Sedan</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "SUV") ? 'checked' : ''; ?> value="SUV">
                                                <span>SUV</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kasa[]" <?php echo str_contains($talepcek['talep_kasa_tipi'], "MPV") ? 'checked' : ''; ?> value="MPV">
                                                <span>MPV</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="kapi_sayisi">
                                    <label class="col-sm-3 control-label">Kapı Sayısı</label>
                                    <div class="col-sm-9">
                                        <div class="filter-container">
                                            <label>
                                                <input type="checkbox" name="kapi[]" <?php echo str_contains($talepcek['talep_kapi_sayisi'], "3") ? 'checked' : ''; ?> value="3">
                                                <span>3</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kapi[]" <?php echo str_contains($talepcek['talep_kapi_sayisi'], "4") ? 'checked' : ''; ?> value="4">
                                                <span>4</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="kapi[]" <?php echo str_contains($talepcek['talep_kapi_sayisi'], "5") ? 'checked' : ''; ?> value="5">
                                                <span>5</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="vites_tipi">
                                    <label class="col-sm-3 control-label">Vites Tipi</label>
                                    <div class="col-sm-9">
                                        <div class="filter-container" style="width:76.5%; ">
                                            <label>
                                                <input type="checkbox" name="vites[]" <?php echo str_contains($talepcek['talep_vites_tipi'], "Manuel") ? 'checked' : ''; ?> value="Manuel">
                                                <span>Manuel</span>
                                            </label>
                                            <label>
                                                <input type="checkbox" name="vites[]" <?php echo str_contains($talepcek['talep_vites_tipi'], "Otomatik") ? 'checked' : ''; ?> value="Otomatik">
                                                <span>Otomatik</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="km">
                                    <label class="col-sm-3 control-label">km</label>
                                    <div class="col-sm-3">
                                        <input class="form-control rakam" type="text" id="talep_min_km" required value="<?php echo $talepcek['talep_min_km'] ?>"
                                            style="height: 4rem !important; text-transform:none; " name="talep_min_km"
                                            placeholder="Min">
                                    </div>

                                    <label class="col-sm-1 control-label">----</label>
                                    <div class="col-sm-3">
                                        <input class="form-control rakam" type="text" id="talep_max_km" required value="<?php echo $talepcek['talep_max_km'] ?>"
                                            style="height: 4rem !important; text-transform:none; " name="talep_max_km"
                                            placeholder="Max">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Fiyat</label>
                                    <div class="col-sm-3">
                                        <input class="form-control rakam" type="text" id="talep_fiyat" required value="<?php echo $talepcek['talep_fiyat'] ?>"
                                            style="height: 4rem !important; text-transform:none;" name="talep_fiyat"
                                            placeholder="Fiyat">
                                    </div>

                                    <div class="col-sm-6" style="margin-top: 0.5rem;">
                                        <label>
                                            <input type="checkbox" name="talep_uzeri_teklif" value="1" <?php echo str_contains($talepcek['talep_uzeri_teklif'], "1") ? 'checked' : ''; ?>
                                                style="margin-left: -1.5rem;  width: 14px; height: 14px; top: 0.3rem !important; position: relative;">
                                            <span
                                                style="font-size: 1.2rem; font-weight: 449; text-transform: none!important;">
                                                Kullanıcılar istediğiniz fiyatın üzerinde teklifler verilebilsin mi?
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="controls">
                                    <div class="form-group">
                                        <label for="city-input" class="col-sm-3 control-label">Şehir</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" type="text" id="city-input" required value="<?php echo $talepcek['talep_sehir'] ?>"
                                                style="height: 4rem !important; text-transform:none; "
                                                name="talep_sehir" placeholder="Şehir adı giriniz">
                                        </div>

                                        <!-- 
                                        <button class="update-btn-new" type="button"
                                            style=" font-weight: 390; margin-top: 0.24rem; position: relative; margin-left: 0.1rem;"
                                            onclick="searchLocation()" >Haritayı Güncelle </button>
                                        -->

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Çember Çapı</label>
                                        <div class="col-sm-9">
                                            <input type="range" id="radius-slider" class="yaricap"
                                                min="70000" max="800000" step="100" cap="<?php echo $talepcek['talep_cember_yaricap'] ?>" value="<?php echo $talepcek['talep_cember_yaricap'] ?>">
                                        </div>
                                    </div>

                                    <!-- <div class="date-picker">
                                        <label class="col-sm-3 control-label" for="daire_yaricap"
                                            style="margin-top: 1.8rem;">Daire Yarıçapı</label>
                                        <div class="dropdown" style="margin-left: 3.1rem !important;">
                                            <select name="talep_daire_yaricap" id="daire_yaricap"
                                                style="width: 171.5px;">
                                                <option value="70000">1</option>
                                                <option value="80000">2</option>
                                                <option value="90000">3</option>
                                                <option value="100000">4</option>
                                                <option value="130000">5</option>
                                                <option value="160000">6</option>
                                                <option value="190000">7</option>
                                                <option value="220000">8</option>
                                                <option value="250000">9</option>
                                                <option value="280000">10</option>
                                                <option value="350000">11</option>
                                                <option value="420000">12</option>
                                                <option value="540000">13</option>
                                                <option value="660000">14</option>
                                            </select>

                                            <i class="fa fa-angle-down" aria-hidden="true"
                                                style="position: absolute; margin-right: 2.4rem;"></i>
                                        </div>
                                        <button class="update-btn-new" type="button"
                                            style=" width: 142px; font-weight: 300; margin-left: -0.8rem;"
                                            onclick="updateRadius()">Yarıçapı
                                            Güncelle</button>
                                    </div>
                                </div> -->

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Konum</label>
                                        <div class="col-sm-9">
                                            <div id="map" enlem="<?php echo $talepcek['talep_konum_enlem'] ?>"
                                            boylam="<?php echo $talepcek['talep_konum_boylam'] ?>"></div>
                                        </div>
                                    </div>

                                    <!-- Ck Editör Başlangıç -->
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep
                                            Açıklaması
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12"> 
                                            <textarea class="ckeditor" id="editor1" name="talep_detay" required 
                                                placeholder="Talep Açıklaması" style="text-transform: lowercase !important;"> <?php echo $talepcek['talep_detay'] ?> </textarea>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        CKEDITOR.replace('editor1',
                                            {

                                                filebrowserBrowseUrl: 'ckfinder/ckfinder.html',

                                                filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',

                                                filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',

                                                filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                                                filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                                                filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

                                                forcePasteAsPlainText: true
                                            }
                                        );
                                    </script>
                                    <!-- Ck Editör Bitiş -->

                                    <input type="text" hidden name="talep_id" value="<?php echo $talepcek['talep_id'] ?>">
                                    <input type="text" hidden name="talep_cember_yaricap" id="talep_cember_yaricap" value="<?php echo $talepcek['talep_cember_yaricap'] ?>" >
                                    <input type="text" hidden name="talep_konum_enlem" id="enlem">
                                    <input type="text" hidden name="talep_konum_boylam" id="boylam">

                                    <div class="form-group">
                                        <div class="col-sm-12" style="text-align: right; position:">
                                            <button type="submit" name="talep_duzenle" class="update-btn" 
                                                id="login-update">
                                                Güncelle
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Settings Page End Here -->
<?php require_once 'footer.php'; ?>

<script>

    window.addEventListener("DOMContentLoaded", () => {
        const inputs = document.querySelectorAll(".rakam");

        inputs.forEach(input => {
            input.addEventListener("input", (e) => {
                let value = e.target.value;

                // Sadece rakam harici karakterleri temizle
                value = value.replace(/[^0-9]/g, "");

                // Sayıyı 3 haneli gruplara ayır ve nokta ekle
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                e.target.value = value;
            });
        });
    });

    let map, marker, circle, searchTimeout;
    function initMap() {

        const mapElement = document.getElementById("map");
        const lat = parseFloat(mapElement.getAttribute("enlem"));
        const lng = parseFloat(mapElement.getAttribute("boylam"));

        const yaricapElement = document.querySelector(".yaricap");
        const yaricap = parseFloat(yaricapElement.getAttribute("cap"));

        const location = { lat: lat, lng: lng };

        map = new google.maps.Map(document.getElementById("map"), {
            center: location,
            zoom: 8,
            streetViewControl: false, // Sokak görünümü kontrolünü kaldırır
            mapTypeControl: false,  // map tipinin değiştirilmesini engeller.s
        });

        // Marker oluştur
        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true, // Marker sürüklenebilir 
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

        // Başlangıçta bilgileri güncelle
        updatePosition();

        google.maps.event.addListener(marker, "dragend", updatePosition);

        // Marker ile daireyi bağla
        circle.bindTo("center", marker, "position");

        // Yarıçapı kullanıcıdan alır ve görsel çemberi günceller.
        document.getElementById("radius-slider").addEventListener("input", function () {
            const newRadius = parseInt(this.value, 10);
            circle.setRadius(newRadius);
        });

        // seçilen yaricapi inputa aktarır
        document.getElementById("radius-slider").addEventListener("input", function () {
            // Dairenin yeni yarıçapını input'a yaz
            const newRadius = parseInt(this.value, 10);
            document.getElementById("talep_cember_yaricap").value = newRadius;
        });

        // Şehir girildiğinde haritayı otomatik güncelle
        document.getElementById("city-input").addEventListener("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(searchLocation, 400);
        });
    }

    function updatePosition() {                            // Harita üzerindeki konumu değiştirince 
        const lat = marker.getPosition().lat().toFixed(6); // Marker enlemi
        const lng = marker.getPosition().lng().toFixed(6); // Marker boylamı

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
                map.setCenter(location);
                map.setZoom(8);

                // Marker konumunu güncelle
                marker.setPosition(location);

                // Lat ve Lng bilgilerini inputlara yazdır
                document.getElementById("enlem").value = lat;
                document.getElementById("boylam").value = lng;
            }
        });
    }

    // Haritayı başlat
    window.onload = initMap;

    // Min yıl input'u için sadece rakam girilmesi
    document.getElementById("talep_min_yil").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Sadece rakamları kabul et
    });

    // Max yıl input'u için sadece rakam girilmesi
    document.getElementById("talep_max_yil").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Sadece rakamları kabul et
    });

    // Min km input'u için sadece rakam girilmesi
    document.getElementById("talep_min_km").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Sadece rakamları kabul et
    });

    // Max km input'u için sadece rakam girilmesi
    document.getElementById("talep_max_km").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Sadece rakamları kabul et
    });

    // Fiyat
    document.getElementById("talep_fiyat").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');  // Sadece rakamları kabul et
    });

</script>

<script>
    $(document).ready(function () {
        $("#kategori_id").change(function () {
            var id = $(this).val();

            if (id == "14") {
                $("#marka, #yakit_tipi, #kasa_tipi, #kapi_sayisi, #vites_tipi, #km").show();
            } else if (id == "15") {
                $("#marka, #yakit_tipi, #kasa_tipi, #kapi_sayisi, #vites_tipi, #km").hide();
            }
        }).change();

        $("form").submit(function () {
            var id = $("#kategori_id").val();
            if (id == "15") {
                // Tüm input/select alanlarının değerini temizle
                $("#marka input, #marka select, \
              #yakit_tipi input, #yakit_tipi select, \
              #kasa_tipi input, #kasa_tipi select, \
              #kapi_sayisi input, #kapi_sayisi select, \
              #vites_tipi input, #vites_tipi select, \
              #km input, #km select").each(function () {

                    if ($(this).is(':checkbox') || $(this).is(':radio')) {
                        $(this).prop('checked', false);
                    } else {
                        $(this).val('');
                    }
                });

                $("#marka select").val("1");
             }
        });
    });
</script>