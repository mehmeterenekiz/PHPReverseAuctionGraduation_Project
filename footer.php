<style>
    .social-media a {
        color: #ffffff;
        text-transform: capitalize;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        margin-top: 0.9rem;
        transition: color 0.3s ease;
    }

    .social-media a:hover span {
        text-decoration: underline;
    }

    .social-media i {
        margin-right: 10px;
        flex-shrink: 0;
    }

    .social-media span {
        display: inline-block;
    }
</style>

<!-- Footer Area Start Here -->
<footer>
    <div class="footer-area-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="footer-box">
                        <h3 class="title-bar-left title-bar-footer">İletişim</h3>
                        <ul class="corporate-address">
                            <li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $ayarcek['ayar_gsm'] ?> </li>
                            <li><i class="fa fa-fax" aria-hidden="true"></i> <?php echo $ayarcek['ayar_tel'] ?> </li>
                            <li class="footer_font"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <?php echo $ayarcek['ayar_mail'] ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="footer-box">
                        <h3 class="title-bar-left title-bar-footer">Bize Katıl</h3>
                        <ul class="featured-links">
                            <li>
                                <ul>
                                    <li><a href="index">Anasayfa</a></li>
                                    <li><a href="sign-up">Kullanıcı Ol</a></li>
                                    <li><a href="#">Reklam</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="footer-box">
                        <h3 class="title-bar-left title-bar-footer">Gizlilik & Kullanım</h3>
                        <ul class="featured-links">
                            <li>
                                <ul>
                                    <li><a href="#">Yardım Merkezi</a></li>
                                    <li><a href="#">Sözleşmeler ve Kurallar</a></li>
                                    <li><a href="#">Hesap Sözleşmesi</a></li>
                                    <li><a href="#">Kullanım Koşulları</a></li>
                                    <li><a href="#">Kişisel Verilerin Korunması</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="footer-box">
                        <h3 class="title-bar-left title-bar-footer">Bizi Takip Edin</h3>
                        <ul class="social-media">
                            <ul class="social-media">
                                <li><a href="<?php echo $ayarcek['ayar_facebook'] ?>"><i
                                            class="fa-brands fa-facebook"></i><span>Facebook</span></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_twitter'] ?>"><i
                                            class="fa-brands fa-twitter"></i><span>X</span></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_youtube'] ?>"><i
                                            class="fa-brands fa-linkedin"></i><span>Linkedin</span></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_instagram'] ?>"><i
                                            class="fa-brands fa-instagram"></i><span>Instagram</span></a></li>
                                <li><a href="<?php echo $ayarcek['ayar_linkedin'] ?>"><i
                                            class="fa-brands fa-youtube"></i><span>Youtube</span></a></li>
                            </ul>

                        </ul>
                        <!-- <div class="newsletter-area">
                            <h3>Newsletter Sign Up!</h3>
                            <div class="input-group stylish-input-group">
                                <input type="text" placeholder="Enter your e-mail here" class="form-control">
                                <span class="input-group-addon">
                                    <button type="submit">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .container p{
            text-transform: none;
        }
    </style>
    <div class="footer-area-bottom">
        <div class="container">
            <p style="color: #ffffff;" ><?php echo $ayarcek['ayar_author'] ?></p>
        </div>
    </div>
</footer>
<!-- Footer Area End Here -->
</div>
<!-- Main Body Area End Here -->

<script src="https://cdn.ckeditor.com/4.21.0/basic/ckeditor.js"></script>

<!-- Plugins js -->
<script src="js/plugins.js" type="text/javascript"></script>

<!-- Bootstrap js -->
<script src="js/bootstrap.min.js" type="text/javascript"></script>

<!-- WOW JS -->
<script src="js/wow.min.js"></script>

<!-- Owl Cauosel JS -->
<script src="vendor/OwlCarousel/owl.carousel.min.js" type="text/javascript"></script>

<!-- Meanmenu Js -->
<script src="js/jquery.meanmenu.min.js" type="text/javascript"></script>

<!-- Srollup js -->
<script src="js/jquery.scrollUp.min.js" type="text/javascript"></script>

<!-- jquery.counterup js -->
<script src="js/jquery.counterup.min.js"></script>
<script src="js/waypoints.min.js"></script>

<!-- Isotope js -->
<script src="js/isotope.pkgd.min.js" type="text/javascript"></script>

<!-- Gridrotator js -->
<script src="js/jquery.gridrotator.js" type="text/javascript"></script>

<!-- Custom Js -->
<script src="js/main.js" type="text/javascript"></script>

<!-- Google Maps Api -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $ayarcek['ayar_maps'];?>"></script>

<script src="/my_js/sign-up.js"> </script>
<script src="/my_js/header.js"> </script>
<script src="/my_js/talep-detay.js"> </script>
<script src="/my_js/teklif-duzenle.js"> </script>

</body>

</html>