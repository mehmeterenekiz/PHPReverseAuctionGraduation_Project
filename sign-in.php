<?php
$title = "Giriş Yap";
require_once 'header.php'; ?>
<!-- Main Banner 1 Area Start Here -->
<div style="background-color: #c9d6ff; height:36rem;  margin: -322px 0 0 0;
  background: linear-gradient(to right, #e2e2e2, #c9d6ff);">
    <div class="container">

    </div>
</div>
<!-- Main Banner 1 Area End Here -->

<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '727955032708-pikvo35j0uuop9ga3e2q0l99di3b0paf.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/sign-in';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    header("location: nedmin/netting/kullanici-islem.php?name=$name&email=$email"); ?>

<?php } else { ?>

    <!-- Registration Page Area Start Here -->
    <div class="registration-page-area bg-secondary section-space-bottom" style="background-color: #c9d6ff;
  background: linear-gradient(to right, #e2e2e2, #c9d6ff);">
        <div class="container body_new">
            <div class="container_new" id="container_new">
                <div class="form-container_new sign-up_new">
                    <form action="nedmin/netting/kullanici-islem.php" method="POST">
                        <h1>Bir hesap oluşturun</h1>
                        <div class="social-icons_new">
                            <a href="<?php echo $client->createAuthUrl() ?>" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <span style="margin-top: -1rem; text-align: left !important;">ya da kayıt olmak için mail adresinizi
                            kullanın</span>
                        <input type="text" name="kullanici_ad_soyad" placeholder="Ad Soyad" required
                            autocomplete="new-password">
                        <input type="email" name="kullanici_mail" placeholder="E-Posta" required
                            style="text-transform: none;">

                        <div class="password-container">
                            <input type="password" name="kullanici_password_one" required class="password-field"
                                placeholder="Şifre" autocomplete="new-password">
                            <button type="button" class="toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="password-container">
                            <input type="password" name="kullanici_password_two" required class="password-field"
                                placeholder="Şifre">
                            <button type="button" class="toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <span style="margin-top: -0.5rem; text-align: left !important;">Şifreniz <strong> en az 10 karakter
                            </strong> olmalı. <strong> 1 büyük harf, 1 küçük harf </strong> ve <strong> rakam </strong>
                            içermelidir.</span>
                        <button type="submit" name="kullanici_kaydet">Kayıt ol</button>
                    </form>
                </div>
                <div class="form-container_new sign-in_new">
                    <form action="nedmin/netting/kullanici-islem.php" method="POST">
                        <h1>Giriş yap</h1>
                        <?php
                        if (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>
                            <div class="alert-box">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span class="font-opacity">E-posta adresiniz ve/veya şifreniz hatalı.</span>
                            </div>
                        <?php }
                        if (isset($_GET['durum']) and $_GET['durum'] == "izinsizerisim") { ?>
                            <div class="alert-box">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span class="font-opacity">Lütfen önce giriş yapınız.</span>
                            </div>
                        <?php } ?>
                        <div class="social-icons_new">
                            <a href="<?php echo $client->createAuthUrl() ?>" class="icon"><i
                                    class="fa-brands fa-google-plus-g"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <span style="margin-top: -1rem; text-align: left !important;">ya da giriş yapmak için mail
                            adresinizi kullanın</span>
                        <input type="email" placeholder="Email" name="kullanici_mail" required
                            style="text-transform: none !important;">

                        <div class="password-container">
                            <input type="password" class="password-field" placeholder="Şifre" required
                                name="kullanici_password" style="text-transform: none !important;">
                            <button type="button" class="toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <a href="#" class="sifremi_unuttum">Şifremi unuttum</a>
                        <button type="submit" name="kullanici_giris">Giriş yap</button>
                        <input type="text" hidden name="talep_url" value="<?php /* kullanıcının teklif vermek istediği ilanı giriş yapıldıktan sonra tekrar kullanıcıya vermek için göderiliyor. */
                        if (isset($_GET['sign-in'])) {
                            echo $_GET['sign-in'];
                        } ?>">
                    </form>
                </div>
                <div class="toggle-container_new">
                    <div class="toggle_new">
                        <div class="toggle-panel_new toggle-left_new">
                            <h1>Tekrar Hoşgeldiniz</h1>
                            <p>Zaten bir hesabınız var mı?</p>
                            <button class="hidden_new" id="login_new">Giriş Yap</button>
                        </div>
                        <div class="toggle-panel_new toggle-right_new">
                            <h1>Merhaba, Hoşgeldiniz</h1>
                            <p><span>reverse auction'da</span> hesap oluşturun, teklifleri kaçırmayın</p>
                            <button class="hidden_new" id="register_new">Kayıt ol </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<!-- Registration Page Area End Here -->
<?php require_once 'footer.php'; ?>