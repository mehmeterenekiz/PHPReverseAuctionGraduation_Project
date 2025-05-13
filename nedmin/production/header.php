<?php
ob_start();
session_start();
require_once '../netting/baglan.php';
require_once '../netting/fonksiyonlar.php';
require_once 'fonksiyon.php';

$kullanicisor = $db->prepare("select * from kullanici where kullanici_id=:kullanici_mail");
$kullanicisor->execute(array(
  "kullanici_mail" => $_SESSION["kullanici_mail"],
));
$say = $kullanicisor->rowCount();
$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

islemkontroladmin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin Paneli</title>
  <link rel="shortcut icon" type="x-icon" href="../../images/logo.png">

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->
  <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
  <link href="../build/css/new.css" rel="stylesheet">
</head>

<body class="nav-md page-contact-setting">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div style="padding-left: 7px;" class="navbar nav_title" style="border: 0;">
            <a href="index.php" class="site_title"> <img style="height: 30px; width: 30px; margin-bottom:5px;"
                src="../../images/logo.png"> <span>Reverse Auction</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Hoşgeldiniz</span>
              <h2> <?php echo $kullanicicek["kullanici_ad"] . " " . $kullanicicek["kullanici_soyad"] ?> </h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li style="margin-bottom: -0.6rem;"><a href="index.php"><i class="bi bi-house" id="color-font"
                      style="font-size: 18px; margin-right: 0.8rem;"></i> Anasayfa </a></li>
                <li><a><i class="bi bi-gear" id="color-font" style="font-size: 18px; margin-right: 1rem;"></i>Site
                    Ayarları
                    <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li style="margin-top: -0.5rem;" id="genelAyarlarLink"><a href="genel_ayarlar.php">Genel Ayarlar</a>
                    </li>
                    <li><a href="iletisim_ayarlar.php">İletişim Ayarlar</a></li>
                    <li><a href="api_ayarlar.php">Api Ayarlar</a></li>
                    <li><a href="sosyal_ayarlar.php">Sosyal Ayarlar</a></li>
                    <li><a href="mail_ayarlar.php">Mail Ayarlar</a></li>
                  </ul>
                </li>

                <li style="margin-bottom: -0.6rem;"><a href="hakkimizda_ayarlar.php"><i class="bi bi-info-lg"
                      id="color-font" style="font-size: 18px; margin-right: 0.9rem; margin-left: -0.2rem;"></i>
                    Hakkımızda </a></li>

                <li style="margin-bottom: -0.6rem;"><a href="menu.php"><i class="bi bi-list" id="color-font"
                      style="font-size: 18px; margin-right: 0.9rem; margin-left: -0.2rem;"></i>
                    Menüler </a></li>
                
                <li style="margin-bottom: -0.6rem;"><a href="kategori.php"><i class="bi bi-layers" id="color-font"
                      style="font-size: 18px; margin-right: 0.9rem; margin-left: -0.2rem;"></i>
                    Kategoriler </a></li>
                
                <li style="margin-bottom: -0.6rem;"><a href="talepler.php"><i class="bi bi-basket" id="color-font"
                  style="font-size: 18px; margin-right: 0.9rem; margin-left: -0.2rem;"></i>
                Talepler </a></li>

                <li style="margin-bottom: -0.6rem;"><a href="kullanici-listesi.php"><i class="bi bi-people"
                     id="color-font" style="font-size: 18px; margin-right: 0.9rem; margin-left: -0.2rem;"></i>
                    Kullanıcı Listesi </a></li>

                    <li style="margin-bottom: -0.6rem;"><a href="etkin-kullanicilar.php"><i class="bi bi-card-checklist" 
                style="font-size: 18px; color: white; margin-right: 0.9rem; margin-left: -0.2rem; color: lawngreen; "></i>
                   Etkin Kullanıcılar </a></li>

                <li style="margin-bottom: -0.6rem;"><a href="kullanici-onay.php"><i class="bi bi-card-list" 
                style="font-size: 18px; color: white; margin-right: 0.9rem; margin-left: -0.2rem; color: dodgerblue; "></i>
                    Kullanıcı Başvuruları </a></li>

              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <!-- <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div> -->
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav>
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                  aria-expanded="false">
                  <img src="images/img.jpg" alt="">
                  <?php
                  $kullaniciAd = $kullanicicek["kullanici_ad"];
                  $kullaniciSoyad = $kullanicicek["kullanici_soyad"];
                  $formattedAd = formatAdSoyad($kullaniciAd, $kullaniciSoyad);
                  // Sonucu yazdır
                  echo $formattedAd;
                  ?>

                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="javascript:;">Profil Bilgilerim</a></li>
                  <!-- <li>
                    <a href="javascript:;">
                      <span class="badge bg-red pull-right">50%</span>
                      <span>Settings</span>
                    </a>
                  </li> -->
                  <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i>Güvenli Çıkış</a></li>
                </ul>
              </li>

              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <li>
                    <a>
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                      <span>
                        <span>John Smith</span>
                        <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                        Film festivals used to be do-or-die moments for movie makers. They were where...
                      </span>
                    </a>
                  </li>
                  <li>
                    <div class="text-center">
                      <a>
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- /top navigation -->