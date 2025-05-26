<?php

use Opencart\Catalog\Model\Localisation\Location;
$title = "Kullanıcı Bilgilerim";
ob_start();
session_start();
require_once "header_user.php";
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
                        <div class="tab-pane fade active in" id="Personal">
                            <h2 class="title-section">Kullanıcı Bilgilerim</h2>
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
                            if (isset($_GET['bilgiler']) and $_GET['bilgiler'] == "ok") { ?>
                                <div class="alert-box-ok"
                                    style="max-width:24.5%; position:absolute; margin-top: -5.25rem !important; margin-left:30rem !important;">
                                    <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                        width="15" height="15" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <span style="text-transform:none;" class="font-opacity">Kullanıcı bilgileri
                                        güncellendi.</span>
                                </div>
                            <?php }
                            if (isset($_GET['bilgiler']) and $_GET['bilgiler'] == "no") { ?>
                                <div class="alert-box"
                                    style="max-width:28%; height: 3.8rem  position:absolute; margin-top: -5.25rem !important; margin-left:30rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity">Kullanıcı bilgileri
                                        güncellenemedi.</span>
                                </div>
                            <?php } ?>

                            <div class="personal-info inner-page-padding">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Ad</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" required id="address1" type="text"
                                            name="kullanici_ad"
                                            value="<?php echo $kullanicicek['kullanici_ad'] ?>">
                                    </div>
                                    <label class="col-sm-3 control-label">Soyad</label>
                                    <div class="col-sm-4" style="margin-left: -13.5rem;">
                                        <input class="form-control" id="address1" type="text"
                                            name="kullanici_soyad"
                                            value="<?php echo $kullanicicek['kullanici_soyad'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Kayıtlı E-Posta</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" disabled id="address2" type="email" name="kullanici_mail"
                                            required="required" value="<?php echo $kullanicicek['kullanici_mail'] ?>"
                                            style="text-transform: none;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Cep Telefonu</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="tel" id="phone4" name="kullanici_gsm"
                                            placeholder="0(5--) --- -- --" minlength="14" maxlength="14"
                                            value="<?php echo $kullanicicek['kullanici_gsm'] ?>">
                                    </div>
                                </div>
                                <?php
                                // Doğum tarihi çekme işlemi
                                $dogum_tarihi = $kullanicicek['kullanici_dogum_tarihi']; // Örnek: 2000-10-20
                                if (!empty($dogum_tarihi) && count(explode('-', $dogum_tarihi)) === 3) {
                                    list($yil, $ay, $gun) = explode('-', $dogum_tarihi);
                                }
                                ?>
                                <div class="date-picker">
                                    <label class="col-sm-3 control-label" style="margin-top: 1.7rem; padding-left: 1.7rem;">Doğum
                                        Tarihi</label>
                                    <div class="dropdown">
                                        <select id="day" name="day">

                                            <option value="00" disabled hidden <?php echo ($gun == '00') ? 'selected' : ''; ?>>Gün</option>
                                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php echo ($gun == $i) ? 'selected' : ''; ?>>
                                                    <?php echo $i; ?>
                                                </option>
                                            <?php } ?>


                                        </select>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="dropdown">
                                        <select id="month" name="month">

                                            <!-- Ay seçenekleri -->
                                            <option value="00" disabled hidden <?php echo ($ay == '00') ? 'selected' : ''; ?>>Ay</option>
                                            <option value="01" <?php echo $ay == '01' ? 'selected' : ''; ?>>Ocak
                                            </option>
                                            <option value="02" <?php echo $ay == '02' ? 'selected' : ''; ?>>Şubat
                                            </option>
                                            <option value="03" <?php echo $ay == '03' ? 'selected' : ''; ?>>Mart
                                            </option>
                                            <option value="04" <?php echo $ay == '04' ? 'selected' : ''; ?>>Nisan
                                            </option>
                                            <option value="05" <?php echo $ay == '05' ? 'selected' : ''; ?>>Mayıs
                                            </option>
                                            <option value="06" <?php echo $ay == '06' ? 'selected' : ''; ?>>Haziran
                                            </option>
                                            <option value="07" <?php echo $ay == '07' ? 'selected' : ''; ?>>Temmuz
                                            </option>
                                            <option value="08" <?php echo $ay == '08' ? 'selected' : ''; ?>>Ağustos
                                            </option>
                                            <option value="09" <?php echo $ay == '09' ? 'selected' : ''; ?>>Eylül
                                            </option>
                                            <option value="10" <?php echo $ay == '10' ? 'selected' : ''; ?>>Ekim
                                            </option>
                                            <option value="11" <?php echo $ay == '11' ? 'selected' : ''; ?>>Kasım
                                            </option>
                                            <option value="12" <?php echo $ay == '12' ? 'selected' : ''; ?>>Aralık
                                            </option>
                                            <!-- Daha fazla seçenek -->

                                        </select>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                    <div class="dropdown">
                                        <select id="year" name="year">

                                            <!-- Yıl seçenekleri -->
                                            <option value="0000" disabled hidden <?php echo ($yil == '0000') ? 'selected' : ''; ?>>Yıl</option>
                                            <?php for ($i = date("Y") - 12; $i > 1950; $i--) { ?>
                                                <option value="<?php echo $i ?>" <?php
                                                   echo $yil == $i ? 'selected' : '';
                                                   ?>> <?php echo $i ?> </option>
                                            <?php } ?>
                                            <!-- Daha fazla seçenek -->
                                        </select>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12" style="text-align: right; position:">
                                        <button type="submit" name="kullanici_bilgiler_duzenle" class="update-btn"
                                            id="login-update">
                                            Güncelle
                                        </button>
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
    const phoneInput4 = document.getElementById("phone4");

    phoneInput4.addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, ""); // Sadece rakamları al
        if (value.length > 11) value = value.slice(0, 11); // Maksimum 11 rakam
        if (value.length > 4) {
            // İlk 4 rakamdan sonra boşluk ekle
            value = value.slice(0, 4) + " " + value.slice(4);
        }
        if (value.length > 8) {
            // 8. rakamdan sonra tekrar boşluk ekle
            value = value.slice(0, 8) + " " + value.slice(8);
        }
        if (value.length > 11) {
            // 8. rakamdan sonra tekrar boşluk ekle
            value = value.slice(0, 11) + " " + value.slice(11);
        }
        e.target.value = value; // Güncellenmiş değeri geri yaz
    });
</script>

<script>
    document.getElementById("personal-info-form").addEventListener("submit", function (event) {
        const phoneInput = document.getElementById("phone4");
        const phoneValue = phoneInput.value.replace(/\D/g, ""); // Sadece rakamları kontrol et

        // Minimum ve maksimum uzunluğu kontrol et
        if ((phoneValue.length > 1 && phoneValue.length < 11) || phoneValue.length > 11) {
            event.preventDefault(); // Formun gönderilmesini engeller
            alert("Telefon numarası 11 karakter uzunluğunda olmalıdır (0(5--) --- -- -- formatında).");
        }
    });
</script>

