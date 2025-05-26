<?php
require_once 'nedmin/netting/baglan.php';
require_once 'nedmin/production/fonksiyon.php';
require_once 'nedmin/netting/fonksiyonlar.php';

$ayarsor = $db->prepare("select * from ayar where ayar_id=:id");
$ayarsor->execute(array(
    "id" => 0,
));
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html class="no-js" lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content=" <?php echo $ayarcek['ayar_description'] ?> ">
    <meta name="keywords" content=" <?php echo $ayarcek['ayar_keywords'] ?> ">
    <meta name="author" content=" <?php echo $ayarcek['ayar_author'] ?> ">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php
        if (empty($title)) {
            echo $ayarcek['ayar_title'];
        } else {
            echo $title;
        } ?>

    </title>
    <link rel="shortcut icon" type="x-icon" href="<?php echo $ayarcek['ayar_logo'] ?>">

    <!-- jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boostrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css\normalize.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css\main.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css\bootstrap.min.css">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="css\animate.min.css">

    <!-- Font-awesome CSS-->
    <link rel="stylesheet" href="css\font-awesome.min.css">

    <!-- Owl Caousel CSS -->
    <link rel="stylesheet" href="vendor\OwlCarousel\owl.carousel.min.css">
    <link rel="stylesheet" href="vendor\OwlCarousel\owl.theme.default.min.css">

    <!-- Main Menu CSS -->
    <link rel="stylesheet" href="css\meanmenu.min.css">

    <!-- Datetime Picker Style CSS -->
    <link rel="stylesheet" href="css\jquery.datetimepicker.css">

    <!-- ReImageGrid CSS -->
    <link rel="stylesheet" href="css\reImageGrid.css">

    <!-- Switch Style CSS -->
    <link rel="stylesheet" href="css\hover-min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Modernizr Js -->
    <script src="js\modernizr-2.8.3.min.js"></script>

    <!-- jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        html,
        body {
            background-color: #f4f6f5;
        }
    </style>
</head>

<body>
    <div id="preloader"></div>
    <header class="header_new">
        <a href="/" class="logo">
            <img src=" <?php echo $ayarcek['ayar_logo'] ?> " alt="logo">
        </a>
        <nav class="navbar_new">
            <a href="index.php" class="menu_activation">Anasayfa</a>

            <?php
            //Belirli veriyi seçme işlemi
            $menusor = $db->prepare("SELECT * FROM menu where menu_durum=:menu_durum order by menu_sira asc limit 6");
            $menusor->execute(array(
                "menu_durum" => 1,
            ));

            while ($menucek = $menusor->fetch(PDO::FETCH_ASSOC)) { ?>
                <a href="
            
            <?php

            if (!empty($menucek["menu_url"])) {

                echo $menucek["menu_url"];

            } else {

                echo "sayfa-" . seo($menucek["menu_ad"]);
            }
            ?>
            " class="menu_activation"><?php echo $menucek["menu_ad"] ?> </a>
            <?php } ?>
            <!-- <div class="menu-kategoriler">
                <div class="dropdown-kategoriler">
                    <a id="dropdown-btn-kategoriler" class="menu_activation">Kategoriler</a>
                    <div class="dropdown-content-kategoriler">
                        <div id="category-1-new">
                            <a href="#category1" id="category-1">Otomobil</a>
                        </div>
                        <div id="category-2-new">
                            <a href="#category2" id="category-2">Gayrimenkul</a>
                        </div>
                    </div>
                </div>
            </div> -->
        </nav>

        <div class="buttons">
            <button>
                <div class="menu">
                    <div class="dropdown">
                        <a href="sign-in.php" id="dropdown-btn" class="menu_activation">Giriş Yap</a>
                        <div class="dropdown-content">
                            <div id="login-new">
                                <a href="sign-in" id="login">Giriş Yap</a>
                            </div>
                            <div id="signup-new">
                                <a href="sign-up" id="signup">Kayıt Ol</a>
                            </div>

                        </div>
                    </div>
                </div>
            </button>
            <!-- <button id="favori">
                <a href="sign-in"><i class="fa-regular fa-heart"></i><span>2</span></a>
            </button>
            <button id="favori">
                <a href="#"><i class="bi bi-envelope"></i><span>2</span></a>
            </button> -->
            <!-- <button id="sepet">
                <div class="cart-area">
                    <a href="sign-in"><i class="bi bi-cart3"></i><span>2</span></a>
                </div>
            </button> -->
        </div>
    </header>

    <script>

        document.addEventListener("DOMContentLoaded", function () { /* bulunulan menünün konumunu belirten border-bottom */
            const currentPath = window.location.pathname;

            // Tüm menü elemanlarını seç
            const menuItems = document.querySelectorAll('.menu_activation');

            menuItems.forEach(item => {                  //! js dosyasında scripti görmüyor
                const itemPath = new URL(item.href).pathname;

                // Eğer anasayfadaysak ve URL localhost ise
                if ((currentPath === '/' || currentPath === '/index.php') &&
                    (item.href.includes('index.php') || item.href.endsWith('/'))) {
                    item.classList.add('active1');
                }
                // Diğer sayfaları kontrol et
                else if (itemPath === currentPath) {
                    item.classList.add('active1');
                }

                else if ((currentPath === '/sign-up.php' || currentPath === '/sign-in.php') &&
                    (itemPath === '/sign-in.php')) {
                    item.classList.add('active1');
                }
            });
        });

        const currentPath = window.location.pathname;
        const itemPath = '/sign-in.php';
        const signInBtn = document.getElementById('dropdown-btn');

        if ((currentPath === '/sign-up.php' || currentPath === '/sign-in.php') && (itemPath === '/sign-in.php')) {
            signInBtn.classList.add('active1');
        } else if ((currentPath === '/sign-up.php' || currentPath === '/sign-in.php') && (itemPath === '/sign-in')) {
            signInBtn.classList.add('active1');
        } else if ((currentPath === '/sign-up' || currentPath === '/sign-in') && (itemPath === '/sign-in')) {
            signInBtn.classList.add('active1');
        } else if ((currentPath === '/sign-up' || currentPath === '/sign-in') && (itemPath === '/sign-in.php')) {
            signInBtn.classList.add('active1');
        }

    </script>

    <!--! header end -->
    <!-- Header Area End Here -->