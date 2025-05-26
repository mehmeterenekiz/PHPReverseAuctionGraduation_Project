<?php
ob_start();
session_start();
$title = "Teklif & Talep Başvurusu";
require_once "header_user.php";
$kullanicibankasor = $db->prepare("SELECT * FROM banka where kullanici_id=:kullanici_mail");
$kullanicibankasor->execute(array(
    'kullanici_mail' => $_SESSION['user_kullanici_mail']
));
$kullanicibankacek = $kullanicibankasor->fetch(PDO::FETCH_ASSOC);

$kullanicifirmasor = $db->prepare("SELECT * FROM firma where kullanici_id=:kullanici_mail");
$kullanicifirmasor->execute(array(
    'kullanici_mail' => $_SESSION['user_kullanici_mail']
));
$kullanicifirmacek = $kullanicifirmasor->fetch(PDO::FETCH_ASSOC);

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

                <div class="settings-details tab-content">
                    <div class="tab-pane fade active in" id="teklif-al-ver-basvuru">
                        <h2 style="font-size: 2.3rem; text-transform: none !important; " class="title-section">Teklif &
                            Talep Oluşturabilmek için Aşağıdaki Bilgileri Doldurunuz</h2>
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
                                style="max-width:45.8%; position:absolute; margin-top: -5.25rem !important; margin-left:42.5rem !important;">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                    width="15" height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span style="text-transform:none;" class="font-opacity"> Başvuru Gönderildi. </span>
                            </div>
                        <?php } ?>

                        <div class="personal-info inner-page-padding">
                            <form action="nedmin/netting/kullanici-islem.php" method="POST" class="form-horizontal"
                                id="personal-info-form">
                                <?php if ($kullanicicek["kullanici_teklif_alma_verme"] == 0) { ?>
                                    <p style="font-size: 1.3rem; font-weight: 449; text-transform: none!important; ">
                                        Başvuru işleminizi tamamlamak için tüm bilgilerinizin eksiksiz ve doğru olarak
                                        girilmesine özen gösteriniz.
                                        Eksik ya da hatalı bilgi olduğunda başvurunuz iptal edilecektir.</p>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Kayıtlı E-Posta</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" disabled id="address2" type="email"
                                                name="kullanici_mail" required="required"
                                                value="<?php echo $kullanicicek['kullanici_mail'] ?>"
                                                style="text-transform: none;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Banka Adı</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" required="" id="last-name" type="text"
                                                name="banka_ad"
                                                value="<?php echo $kullanicibankacek ? $kullanicibankacek['banka_ad'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">IBAN <span id="iban-warning"
                                                style="color: red; display: none; font-size: 1.3rem;">
                                                <?php $uyari = 'iban eksik';
                                                echo "(" . turkce_title_case($uyari) . ")"; ?>
                                            </span> </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="iban-input" name="banka_iban" type="text"
                                                minlength="15" placeholder="TR__ ____ ____ ____ ____ ____ __" value="TR"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Hesap Ad Soyad</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" required="" id="last-name" type="text"
                                                name="banka_hesapadsoyad"
                                                value="<?php echo $kullanicibankacek ? $kullanicibankacek['banka_hesapadsoyad'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Ad</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" required="" id="address1" type="text"
                                                name="kullanici_ad" value="<?php echo $kullanicicek['kullanici_ad'] ?>">
                                        </div>
                                        <label class="col-sm-3 control-label">Soyad</label>
                                        <div class="col-sm-4" style="margin-left: -13.5rem;">
                                            <input class="form-control" required="" id="address1" type="text"
                                                name="kullanici_soyad"
                                                value="<?php echo $kullanicicek['kullanici_soyad'] ?>">
                                        </div>
                                    </div>

                                    <div class="date-picker">
                                        <label class="col-sm-3 control-label"
                                            style="margin-top: 1.8rem;">Bireysel/Kurumsal</label>
                                        <div class="dropdown" required=""
                                            style="margin-left: 3.1rem !important; margin-top: 1.2rem;">
                                            <select name="kullanici_tip" id="kullanici_tip">

                                                <option <?php echo ($kullanicicek["kullanici_tip"] == "PERSONAL") ? 'selected' : ''; ?> value="PERSONAL"> Bireysel </option>
                                                <option <?php echo ($kullanicicek["kullanici_tip"] == "PRIVATE_COMPANY") ? 'selected' : ''; ?> value="PRIVATE_COMPANY"> Kurumsal </option>

                                            </select>
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <div id="tc">

                                    </div>

                                    <div id="kurumsal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Firma Adı</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="first-name" type="text" name="firma_ad"
                                                    value="<?php echo $kullanicifirmacek ? $kullanicifirmacek['firma_ad'] : "" ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Firma Vergi Dairesi</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="last-name" type="text" name="firma_vdaire"
                                                    value="<?php echo $kullanicifirmacek ? $kullanicifirmacek['firma_vdaire'] : "" ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Firma Vergi Numarası</label>
                                            <div class="col-sm-9">
                                                <input class="form-control" id="last-name" type="text" name="firma_vno"
                                                    value="<?php echo $kullanicifirmacek ? $kullanicifirmacek['firma_vno'] : "" ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cep Telefonu</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" required="" type="tel" id="phone6"
                                                name="kullanici_gsm" placeholder="0(5--) --- -- --" minlength="14"
                                                maxlength="14" value="<?php echo $kullanicicek['kullanici_gsm'] ?>">
                                        </div>
                                        <label class="col-sm-3 control-label">İl</label>
                                        <div class="col-sm-4" style="margin-left: -13.5rem;">
                                            <input class="form-control" required="" id="address1" type="text"
                                                name="kullanici_il"
                                                value="<?php echo $kullanicicek ? $kullanicicek['kullanici_il'] : "" ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Onay</label>
                                        <div class="checkbox">
                                            <div class="col-sm-9">
                                                <label><input type="checkbox" required="" value="">Kullanım şartlarınıa
                                                    kabul ediyorum.</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-12" style="text-align: right; position:">
                                            <button type="submit" name="kullanici_teklif_basvuru" class="update-btn"
                                                id="login-update">
                                                Başvuruyu Tamamla
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                </form>
                            <?php } else if ($kullanicicek["kullanici_teklif_alma_verme"] == 1) { ?>

                                    <div class="alert-box-ok" style="display:block !important;">
                                        <svg style="margin-top:-0.2rem; padding-right: 0.2rem;" class="bi flex-shrink-0 me-2"
                                            width="22" height="22" role="img" aria-label="Success:">
                                            <use xlink:href="#check-circle-fill" />
                                        </svg>
                                        <span style="text-transform:none; font-size: 12.5px !important;" class="font-opacity">
                                            Başvurunuz onay aşamasında.
                                        </span>
                                        <span
                                            style="text-transform:none; font-size: 12.5px !important; display: block !important;"
                                            class="font-opacity">
                                            Başvurular genellikle 24 saat içerisinde incelenir ve sonuçlandırılır.
                                        </span>
                                    </div>
                            <?php } else { ?>

                                    <div class="alert-box-ok" style="display:block !important;">
                                        <svg style="margin-top:-0.2rem; padding-right: 0.2rem;" class="bi flex-shrink-0 me-2"
                                            width="22" height="22" role="img" aria-label="Success:">
                                            <use xlink:href="#check-circle-fill" />
                                        </svg>
                                        <span style="text-transform:none; font-size: 12.5px !important;" class="font-opacity">
                                            Başvurunuz onaylandı.
                                        </span>
                                        <span
                                            style="text-transform:none; font-size: 12.5px !important; display: block !important;"
                                            class="font-opacity">
                                            Teklif & Talep Yönetim Panelinden hesabınızı yönetebilirsiniz.
                                        </span>

                                    </div>

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
    $(document).ready(function () {
        $("#kullanici_tip").change(function () {
            var tip = $("#kullanici_tip").val();

            if (tip == "PERSONAL") {
                $("#kurumsal").hide();
                $("#kurumsal input").prop("required", false); // Kurumsal inputlarda required kaldırılır
                $("#tc").show();
                $("#tc input").prop("required", true); // TC kısmındaki inputlar required yapılır
            } else if (tip == "PRIVATE_COMPANY") {
                $("#kurumsal").show();
                $("#kurumsal input").prop("required", true); // Kurumsal inputlar required yapılır
                $("#tc").hide();
                $("#tc input").prop("required", false); // TC kısmındaki inputlarda required kaldırılır
            }
        }).change();
    });
</script>

<script>
    const phoneInput6 = document.getElementById("phone6");

    phoneInput6.addEventListener("input", function (e) {
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
        const phoneInput = document.getElementById("phone6");
        const phoneValue = phoneInput.value.replace(/\D/g, ""); // Sadece rakamları kontrol et

        // Minimum ve maksimum uzunluğu kontrol et
        if (phoneValue.length < 11 || phoneValue.length > 11) {
            event.preventDefault(); // Formun gönderilmesini engeller
            alert("Telefon numarası 11 karakter uzunluğunda olmalıdır (0(5--) --- -- -- formatında).");
        }
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ibanInput = document.getElementById('iban-input');

        ibanInput.addEventListener('input', function (e) {
            let value = ibanInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            // TR sabit olsun
            if (!value.startsWith('TR')) {
                value = 'TR' + value.replace(/^TR/, '');
            }

            // İlk 2 karakter (TR), sonraki 2 karakter (kontrol rakamları)
            let prefix = 'TR';
            let kontrol = value.substring(2, 4);
            let numbers = value.substring(4).replace(/\D/g, '').substring(0, 22); // 24 - 2 = 22 karakter

            // Format: TR + 2 kontrol + boşluk + 4'erli gruplar
            let formatted = prefix + kontrol;

            if (kontrol.length === 2) {
                formatted += ' ';
            }

            for (let i = 0; i < numbers.length; i += 4) {
                formatted += numbers.substring(i, i + 4) + ' ';
            }

            ibanInput.value = formatted.trim();
        });


        ibanInput.addEventListener('keydown', function (e) {
            const pos = ibanInput.selectionStart;

            // TR kısmını silmeye çalışma
            if ((e.key === 'Backspace' || e.key === 'Delete') && pos <= 2) {
                e.preventDefault();
                return;
            }

            // TR'den sonraki kısımda sadece sayı girilsin
            // TR kısmındaysa (0, 1, 2), engelleme yapma (TR zaten sabit)
            if (pos >= 2) {
                // Rakam değilse, engelle
                if (!e.key.match(/^[0-9]$/) &&
                    e.key !== 'Backspace' &&
                    e.key !== 'Delete' &&
                    e.key !== 'ArrowLeft' &&
                    e.key !== 'ArrowRight' &&
                    e.key !== 'Tab') {
                    e.preventDefault();
                }
            }
        });

        // TR kısmına tıklayıp yazmaya çalışmasın
        ibanInput.addEventListener('click', function (e) {
            if (ibanInput.selectionStart < 3) {
                ibanInput.setSelectionRange(ibanInput.value.length, ibanInput.value.length);
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('personal-info-form');
        const ibanInput = document.getElementById('iban-input');
        const warning = document.getElementById('iban-warning');

        form.addEventListener('submit', function (e) {
            const length = ibanInput.value.length;

            if (length < 32) {
                e.preventDefault(); // Formu gönderme
                warning.style.display = 'inline';
            } else {
                warning.style.display = 'none';
            }
        });
    });
</script>