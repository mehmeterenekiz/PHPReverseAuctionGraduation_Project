<?php 
$title="Kayıt Ol";
require_once 'header.php'; ?>
<!-- Main Banner 1 Area Start Here -->
<div style="background-color: #c9d6ff; height:36rem;  margin: -322px 0 0 0;
  background: linear-gradient(to right, #e2e2e2, #c9d6ff);">
    <div class="container">

    </div>
</div>
<!-- Main Banner 1 Area End Here -->
<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary section-space-bottom" style="background-color: #c9d6ff;
  background: linear-gradient(to right, #e2e2e2, #c9d6ff);">
    <div class="container body_new">
        <div class="container_new active" id="container_new">
            <div class="form-container_new sign-up_new">
                <form action="nedmin/netting/kullanici-islem.php" method="POST">
                    <h1>Bir hesap oluşturun</h1>
                    <?php
                    if (isset($_GET['durum']) and $_GET['durum'] == "farklisifre") { ?>
                        <div class="alert-box">
                            <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                            <span>Girdiğiniz şifreler eşleşmiyor.</span>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['durum']) and $_GET['durum'] == "mukerrerkayit") { ?>
                        <div class="alert-box">
                            <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                            <span class="font-opacity">Bu e-posta adresi kullanılamaz. Lütfen başka bir e-posta adresi
                                deneyiniz.</span>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['durum']) && (str_contains($_GET['durum'], "karakter") || str_contains($_GET['durum'], "buyukharf"))) { ?>
                        <div class="alert-box">
                            <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                            <span class="font-opacity">Şifreniz 10 ile 64 karakter arasında olmalıdır.</span>
                        </div>
                    <?php } ?>
                    <?php
                    if (isset($_GET['durum']) and $_GET['durum'] == "basarisiz") { ?>
                        <div class="alert-box">
                            <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                            <span>Kayıt işlemi başarısız.</span>
                        </div>
                    <?php } ?>


                    <div class="social-icons_new">
                        <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                    <span style="margin-top: -1rem; text-align: left !important;">ya da kayıt olmak için mail adresinizi
                        kullanın</span>
                    <input type="text" name="kullanici_ad_soyad" placeholder="Ad Soyad" autocomplete="new-password">
                    <input type="email" name="kullanici_mail" placeholder="E-Posta" style="text-transform: none;">

                    <div class="password-container">
                        <input type="password" name="kullanici_password_one" class="password-field" placeholder="Şifre"
                            autocomplete="new-password" style="text-transform: none;">
                        <button type="button" class="toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="password-container">
                        <input type="password" name="kullanici_password_two" class="password-field" placeholder="Şifre"
                            style="text-transform: none;">
                        <button type="button" class="toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>



                    <?php
                    // Duruma göre CSS sınıfı belirleyin
                    $EksikKarakterDurumu = (isset($_GET['durum']) && str_contains($_GET['durum'], "karakter")) ? 'alert-color' : '';
                    $EksikBuyukHarfDurumu = (isset($_GET['durum']) && str_contains($_GET['durum'], "buyukharf")) ? 'alert-color' : '';
                    $EksikKucukHarfDurumu = (isset($_GET['durum']) && str_contains($_GET['durum'], "kucukharf")) ? 'alert-color' : '';
                    $EksikRakamDurumu = (isset($_GET['durum']) && str_contains($_GET['durum'], "rakam")) ? 'alert-color' : '';
                    ?>
                    <span style="margin-top: -1rem; text-align: left !important; ">Şifreniz <strong
                            class="<?php echo $EksikKarakterDurumu; ?>"> en az 10 karakter </strong> olmalı. <strong
                            class="<?php echo $EksikBuyukHarfDurumu; ?>"> 1 büyük harf,</strong> <strong
                            class="<?php echo $EksikKucukHarfDurumu; ?>"> 1 küçük harf </strong> ve <strong
                            class="<?php echo $EksikRakamDurumu; ?>"> rakam </strong> içermelidir.</span>
                    <button type="submit" name="kullanici_kaydet">Kayıt ol</button>
                </form>
            </div>
            <div class="form-container_new sign-in_new">
                <form action="nedmin/netting/kullanici-islem.php" method="POST">
                    <h1>Giriş yap</h1>
                    <div class="social-icons_new">
                        <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                    <span style="margin-top: -1rem; text-align: left !important;">ya da giriş yapmak için mail
                        adresinizi kullanın</span>
                    <input type="email" placeholder="Email" name="kullanici_mail"
                        style="text-transform: none !important;">

                    <div class="password-container">
                        <input type="password" class="password-field" placeholder="Şifre" name="kullanici_password"
                            style="text-transform: none !important;">
                        <button type="button" class="toggle-password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <a href="#" class="sifremi_unuttum">Şifremi unuttum</a>
                    <button type="submit" name="kullanici_giris">Giriş yap</button>
                </form>
            </div>
            <div class="toggle-container_new">
                <div class="toggle_new">
                    <div class="toggle-panel_new toggle-left_new">
                        <h1>Merhaba, Hoşgeldiniz</h1>
                        <p>Zaten bir hesabınız var mı?</p>
                        <button class="hidden_new" id="login_new">Giriş Yap</button>
                    </div>
                    <div class="toggle-panel_new toggle-right_new">
                        <h1>Tekrar Hoşgeldiniz</h1>
                        <p><span>reverse auction'da</span> hesap oluşturun, teklifleri kaçırmayın</p>
                        <button class="hidden_new" id="register_new">Kayıt ol</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Registration Page Area End Here -->
<?php require_once 'footer.php'; ?>