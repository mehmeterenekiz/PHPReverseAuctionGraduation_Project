<style>
    .modal-sifremi-unuttum {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.568);
        z-index: 9999;
    }

    .modal-sifremi-unuttum form {
        display: flex;
        flex-direction: column;
        width: 30%;
        min-height: 20%;
        padding: 2rem;
        background: white;
        border-radius: 5px;
    }

    .modal-sifremi-unuttum label {
        font-size: 1.2rem;
        margin-bottom: 0.5px;
    }

    .modal-sifremi-unuttum .form-group {
        display: flex;
        flex-direction: column;
        width: 100%;
        align-items: center;
        margin-bottom: 10px;
    }

    .modal-sifremi-unuttum .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 1.2rem;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-sifremi-unuttum .button-group {
        display: flex;
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }

    .modal-sifremi-unuttum .button-group #modal-kapat:hover {
        background: rgb(87, 87, 87);
        color: white;
    }

    .modal-sifremi-unuttum .button-group button {
        width: 100%;
        /* Butonları eşit genişlikte yap */
        padding: 10px;
        font-size: 1.2rem;
        border-radius: 5px;
        cursor: pointer;
    }

    .modal-sifremi-unuttum #form-buton {
        background: #2553a1;
        color: white;
        border: 0;
        border-radius: 2rem;
        font-size: 1.2rem;
        padding: 0.5rem 1rem;
        cursor: pointer;
    }

    .modal-sifremi-unuttum #form-buton:hover {
        background: rgb(18, 54, 116);
    }
</style>

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
                            <a href="<?php echo $client->createAuthUrl() ?>" class="icon"><i
                                    class="fa-brands fa-google-plus-g"></i></a>
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
                        <?php }
                        if (isset($_GET['durum']) and $_GET['durum'] == "kullaniciyok") { ?>
                            <div class="alert-box">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span class="font-opacity">Kayıtlı email adresi yok.</span>
                            </div>
                        <?php }
                        if (isset($_GET['durum']) and $_GET['durum'] == "mailgonderildi") { ?>
                            <div class="alert-box-ok">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2" width="15"
                                    height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span class="font-opacity">Yeni şifreniz mail adresinize gönderildi.</span>
                            </div>
                        <?php }
                        if (isset($_GET['durum']) and $_GET['durum'] == "mailgonderilemedi") { ?>
                            <div class="alert-box">
                                <span class="icon"><i class="bi bi-exclamation-circle"></i></span>
                                <span class="font-opacity">Mail gönderim işlemi başarısız lütfen daha sonra tekrar
                                    deneyiniz</span>
                            </div>
                        <?php } if (isset($_GET['durum']) and $_GET['durum'] == "kullanici_dogrulama") { ?>
                            <div class="alert-box-ok">
                                <svg style="margin-top:-0.2rem; padding-right: 0.4rem;" class="bi flex-shrink-0 me-2" width="15"
                                    height="15" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill" />
                                </svg>
                                <span class="font-opacity">Doğrulama maili gönderildi, kontrol ediniz.</span>
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

                        <a href="#" class="sifremi_unuttum" onclick="start(this)">Şifremi unuttum</a>
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

<div class="modal-sifremi-unuttum">
    <form action="nedmin/netting/send-mail-sifremi-unuttum.php" method="POST" id="teklif-pop-up">
        <label>Email</label>
        <div class="form-group">
            <input type="email" class="form-control" required name="kullanici_email" style="text-transform: lowercase;"
                placeholder="Email adresinizi giriniz">
        </div>

        <div class="button-group">
            <button id="form-buton" type="submit" name="sifremi_unuttum">Yeni Şifre Talep Et</button>
            <button id="modal-kapat" hidden>İptal</button>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.querySelector(".modal-sifremi-unuttum");
        const modalKapat = document.getElementById("modal-kapat");
        const modalButton = document.querySelectorAll(".sifremi_unuttum");

        modalButton.forEach(button => {
            button.addEventListener("click", (event) => {
                event.preventDefault();

                modal.style.display = "flex";
                document.body.style.overflow = "hidden";
            });
        });

        modalKapat.addEventListener("click", (event) => {
            event.preventDefault();
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        });

        modal.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
                document.body.style.overflow = "auto";
            }
        });

    });

</script>