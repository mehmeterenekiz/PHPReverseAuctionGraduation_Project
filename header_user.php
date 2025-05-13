<?php
require_once 'nedmin/netting/baglan.php';
require_once 'nedmin/netting/fonksiyonlar.php';
require_once 'nedmin/production/fonksiyon.php';
islemkontroluser();
//belirli veriyi çekme işlemi
$ayarsor = $db->prepare("select * from ayar where ayar_id=:id");
$ayarsor->execute(array(
    "id" => 0,
));
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);

$kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_id=:kullanici_mail");
$kullanicisor->execute(array(
    'kullanici_mail' => $_SESSION['user_kullanici_mail']
));

$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html class="no-js" lang="">

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

    <link rel="shortcut icon" type="x-icon" href="../../images/logo.png">

    <!-- jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
            <img src="<?php echo $ayarcek['ayar_logo'] ?> " alt="logo">
        </a>
        <?php
        $currentPage = $_SERVER['REQUEST_URI']; // URL'nin tamamını alıyoruz
        ?>
        <nav class="navbar_new">
            <a href="index.php" class="menu_activation">Anasayfa</a>
            <a href="alinan-teklifler"
                class="<?= (strpos($currentPage, 'alinan-teklifler') !== false) ? 'menu_activation' : '' ?>">Alınan
                Teklifler</a>
            <a href="verilen-teklifler"
                class="<?= (strpos($currentPage, 'verilen-teklifler') !== false) ? 'menu_activation' : '' ?>">Verilen
                Teklifler</a>
            <a href="talep-olustur"
                class="<?= (strpos($currentPage, 'talep-olustur') !== false) ? 'menu_activation' : '' ?>">Talep
                Oluştur</a>

            <!--
            <div class="menu-kategoriler">
                <div class="dropdown-kategoriler">
                    <a id="dropdown-btn-kategoriler" class="menu_activation no-hover">Kategoriler</a>
                    <div class="dropdown-content-kategoriler">
                        <div id="category-1-new">
                            <a href="#category1" id="category-1">Otomobil</a>
                        </div>
                        <div id="category-2-new">
                            <a href="#category2" id="category-2">Gayrimenkul</a>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </nav>
        <div class="buttons">
            <button id="favori">
                <a href="favoriler"><i class="fa-regular fa-heart"></i> </a>
            </button>

            <?php
            $mesajsay = $db->prepare("SELECT count(mesaj_okunma) as say FROM mesaj where mesaj_okunma=:mesaj_okunma and kime=:kime");
            $mesajsay->execute(array(
                'mesaj_okunma' => '0',
                'kime' => $_SESSION['user_kullanici_mail']
            ));

            $mesajsay = $mesajsay->fetch(PDO::FETCH_ASSOC);
            ?>

            <button id="mesaj">
                <a href="mesajlarim"><i class="bi bi-envelope"></i><span><?php echo $mesajsay['say'] ?></span></a>
            </button>
            <!-- <button id="sepet" style="margin-left: -0.3rem; margin-right: -0.2rem ">
                <div class="cart-area">
                    <a href="#"><i class="bi bi-cart3" style="padding-bottom:3rem;"></i><span
                            style="margin-top: 0.19rem;">2</span></a>
                    <ul style="margin-top: 0.5rem;">
                        <li>
                            <div class="cart-single-product">
                                <div class="media">
                                    <div class="pull-left cart-product-img">
                                        <a href="#">
                                            <img class="img-responsive" alt="product" src="img\product\more2.jpg">
                                        </a>
                                    </div>
                                    <div class="media-body cart-content">
                                        <ul>
                                            <li>
                                                <h1><a href="#">Product Title Here</a></h1>
                                                <h2><span>Code:</span> STPT600</h2>
                                            </li>
                                            <li>
                                                <p>X 1</p>
                                            </li>
                                            <li>
                                                <p>$49</p>
                                            </li>
                                            <li>
                                                <a class="trash" href="#"><i class="fa fa-trash-o"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="cart-single-product">
                                <div class="media">
                                    <div class="pull-left cart-product-img">
                                        <a href="#">
                                            <img class="img-responsive" alt="product" src="img\product\more3.jpg">
                                        </a>
                                    </div>
                                    <div class="media-body cart-content">
                                        <ul>
                                            <li>
                                                <h1><a href="#">Product Title Here</a></h1>
                                                <h2><span>Code:</span> STPT460</h2>
                                            </li>
                                            <li>
                                                <p>X 1</p>
                                            </li>
                                            <li>
                                                <p>$75</p>
                                            </li>
                                            <li>
                                                <a class="trash" href="#"><i class="fa fa-trash-o"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <table class="table table-bordered sub-total-area">
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td>$124</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>$30</td>
                                    </tr>
                                    <tr>
                                        <td>Vat(20%)</td>
                                        <td>$18.8</td>
                                    </tr>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td>$112.8</td>
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                        <li>
                            <ul class="cart-checkout-btn">
                                <li><a href="cart.htm" class="btn-find"><i class="fa fa-shopping-cart"
                                            aria-hidden="true"></i>Go
                                        to Cart</a></li>
                                <li><a href="check-out.htm" class="btn-find"><i class="fa fa-share"
                                            aria-hidden="true"></i>Go to
                                        Checkout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </button> -->

            <button>
                <i class="bi bi-person user-icon"></i>
            </button>

            <button style="margin-bottom: -1.8rem;">
                <div class="user-account-info" style="padding-bottom:2.6rem;">
                    <div class="user-account-info-controler" style=" width:12rem;">
                        <div class="user-account-title" style="text-align: center; margin-left:-2.5rem;">
                            <?php
                            if (isset($_SESSION['user_kullanici_mail'])) { ?>
                                <div class="user-account-name" style="padding-left: 0.2rem !important; font-size: 1.5rem;"> <?php

                                $kullaniciAd = $kullanicicek["kullanici_ad"];
                                $kullaniciSoyad = $kullanicicek["kullanici_soyad"];
                                $formattedAd = formatAdSoyad($kullaniciAd, $kullaniciSoyad);
                                // Sonucu yazdır
                                echo $formattedAd;

                                ?> </div>
                            <?php } else {
                                header("location:../../sign-in.php?durum=no");
                                ?>
                            <?php } ?>

                        </div>
                        <div class="user-account-dropdown">
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </div>
                    </div>
                    <!-- <style>
                        .profile-page li::before {
                            content: none !important;
                        }
                    </style> -->
                    <!-- <style>
                        ul.profile-page li a {
                            position: relative;
                            display: inline-block;
                            text-decoration: none;
                            color: var(--black-color);
                        }

                        ul.profile-page li a::after {
                            content: "";
                            position: absolute;
                            bottom: 0;
                            left: 29%;
                            /* soldan %10 içeri başlasın */
                            width: 66%;
                            /* toplam genişliği biraz azalt */
                            height: 1px;
                            background-color: #000;
                            opacity: 0;
                            transform: scaleX(0);
                            transform-origin: center;
                            transition: opacity 0.3s ease, transform 0.3s ease;
                        }


                        ul.profile-page li a:hover::after {
                            opacity: 1;
                            transform: scaleX(1);
                        }
                    </style> -->

                    <ul class="profile-page">
                        <span style="margin-top:-0.5rem;">
                            <?php echo $kullanicicek["kullanici_ad"] . " " . $kullanicicek["kullanici_soyad"]; ?>
                        </span>
                        <li style="margin-top:-1rem;"><a href="mesajlarim">Mesajlarım</a></li>
                        <li><a href="#">Favorilerim</a></li>
                        <li><a href="
                        <?php if ($kullanicicek["kullanici_teklif_alma_verme"] == 2) {
                            echo "kullanici";
                        } else {
                            echo "teklif-al-ver-basvuru";
                        } ?>
                        ">Hesabım</a></li>
                        <li><a href="logout">Çıkış Yap</a></li>
                    </ul>
                </div>
            </button>
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

    </script>

    <!--! header end -->
    <!-- Header Area End Here -->