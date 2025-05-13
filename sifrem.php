<?php
ob_start();
session_start();
$title = "Şifre Değişikliği";
require_once "header_user.php";

$kullanicisor = $db->prepare("select * from kullanici where kullanici_id=:user_kullanici_mail");
$kullanicisor->execute(array(
    "user_kullanici_mail" => $_SESSION["user_kullanici_mail"],
));

$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

?>

<?php require_once "arama-cubuk.php"; ?>

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
<!-- Settings Page Start Here -->
<div class="settings-page-area bg-secondary section-space-bottom">
    <div class="container">
        <div class="row settings-wrapper">

            <?php require_once "sidebar-user.php" ?>


            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <form action="nedmin/netting/kullanici-islem.php" method="POST" class="form-horizontal"
                    id="personal-info-form">
                    <div class="settings-details tab-content">
                        <div class="tab-pane fade active in" id="Sifre">
                            <h2 class="title-section">Şifre Değişikliği</h2>
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

                            <?php if (isset($_GET['sifrem']) and $_GET['sifrem'] == "eskisifrehata") { ?>
                                <div class="alert-box"
                                    style="max-width:19.5%; height: 3.8rem !important; position:absolute; margin-top: -5.25rem !important; margin-left:25rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity"> Eski şifre eşleşmiyor.</span>
                                </div>
                            <?php } ?>

                            <?php if (isset($_GET['sifrem']) and $_GET['sifrem'] == "sifreleruyusmuyor") { ?>
                                <div class="alert-box"
                                    style="max-width:22%; height: 3.8rem !important; position:absolute; margin-top: -5.25rem !important; margin-left:25rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity"> Yeni şifreler
                                        eşleşmiyor.</span>
                                </div>
                            <?php } ?>

                            <?php if (isset($_GET['sifrem']) and $_GET['sifrem'] == "eksiksifre") { ?>
                                <div class="alert-box"
                                    style="max-width:38%; height: 3.8rem !important; position:absolute; margin-top: -5.25rem !important; margin-left:25rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity"> Yeni şifreniz 10 ile 64
                                        karakter arasında olmalıdır.</span>
                                </div>
                            <?php } ?>

                            <?php
                            if (isset($_GET['sifrem']) and $_GET['sifrem'] == "ok") { ?>
                                <div class="alert-box-ok"
                                    style="max-width:16.5%; position:absolute; margin-top: -5.25rem !important; margin-left:25rem !important;">
                                    <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2"
                                        width="15" height="15" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <span style="text-transform:none;" class="font-opacity">Şifre güncellendi.</span>
                                </div>
                            <?php } ?>

                            <?php if (isset($_GET['sifrem']) and $_GET['sifrem'] == "no") { ?>
                                <div class="alert-box"
                                    style="max-width:20%; height: 3.8rem !important; position:absolute; margin-top: -5.25rem !important; margin-left:25rem !important;">
                                    <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                    <span style="text-transform:none;" class="font-opacity">Şifre güncellenemedi.</span>
                                </div>
                            <?php } ?>

                            <div class="personal-info inner-page-padding">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Eski Şifre</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" style="max-width: 35%;" id="first-name"
                                            type="password" required name="kullanici_password_old"
                                            autocomplete="new-password">
                                    </div>
                                    <button type="button" class="toggle-password"
                                        style="position: absolute !important; margin-right: 46.5rem !important; margin-top: 11rem; ">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Yeni Şifre</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" style="max-width: 35%;" id="last-name"
                                            type="password" required name="kullanici_password_new1">
                                    </div>
                                    <button type="button" class="toggle-password"
                                        style="position: absolute !important; margin-right: 46.5rem !important; margin-top: 16.5rem; ">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tekrar Yeni Şifre</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" style="max-width: 35%;" id="last-name"
                                            type="password" required name="kullanici_password_new2">
                                    </div>
                                    <button type="button" class="toggle-password"
                                        style="position: absolute !important; margin-right: 46.5rem !important; margin-top: 22rem; ">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12" style="text-align: right;">
                                        <button type="submit" name="kullanici_sifre_duzenle" class="update-btn"
                                            id="login-update">
                                            Güncelle
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Settings Page End Here -->
<?php require_once 'footer.php'; ?>