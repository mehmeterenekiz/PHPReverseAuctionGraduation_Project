<?php

include 'header.php';

//Belirli veriyi seçme işlemi
$kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_teklif_alma_verme=:kullanici_teklif_alma_verme");
$kullanicisor->execute(array(

    "kullanici_teklif_alma_verme" => 2
));

?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Etkin Kullanıcılar<small>

                                <?php

                                if (isset($_GET['kullanici_sil']) and $_GET['kullanici_sil'] == "ok") { ?>

                                    <b style="color:green;">İşlem Başarılı</b>

                                <?php } elseif (isset($_GET['kullanici_sil']) and $_GET['kullanici_sil'] == "no") { ?>

                                    <b style="color:red;">İşlem Başarısız</b>

                                <?php }

                                ?>

                            </small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- Div İçerik Başlangıç -->

                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>S.No</th>
                                <th>ID</th>
                                <th>Kayıt Tarihi</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Mail Adresi</th>
                                <th>Telefon</th>
                                <th>K. Tip</th>
                                <th>Etkinlik</th>
                                <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $say = 0;

                                while ($kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC)) {
                                    $say++ ?>

                                    <tr>
                                        <td><?php echo $say ?></td>
                                        <td><?php echo $kullanicicek['kullanici_id'] ?></td>
                                        <td><?php echo $kullanicicek['kullanici_zaman'] ?></td>
                                        <td><?php echo $kullanicicek['kullanici_ad'] ?></td>
                                        <td><?php echo $kullanicicek['kullanici_soyad'] ?></td>
                                        <td><?php echo $kullanicicek['kullanici_mail'] ?></td>
                                        <td><?php echo $kullanicicek['kullanici_gsm'] ?></td>
                                        <td>
                                            <?php 
                                                if($kullanicicek['kullanici_tip'] == 'PERSONAL'){
                                                echo 'BİREYSEL';
                                                }else{
                                                echo 'KURUMSAL';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <center> <?php
                                            if ($kullanicicek['kullanici_teklif_alma_verme'] == 0) { ?>

                                                    <button class="btn btn-danger btn-xs"> Başvurulmadı </button>

                                                <?php } else if ($kullanicicek['kullanici_teklif_alma_verme'] == 1) { ?>

                                                        <button class="btn btn-primary btn-xs"> Başvuruldu </button>

                                                <?php } else { ?>

                                                        <button class="btn btn-success btn-xs"> Onaylandı </button>

                                                <?php } ?>
                                            </center>
                                        </td>

                                        <td>
                                            <center><a
                                                    href="kullanici-onay-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>"><button
                                                        class="btn btn-primary btn-xs">Başvuruyu İncele</button></a></center>
                                        </td>
                                        <!-- kullanıcı listesinden get ile göderdik bu kullanıcı idyi ve orada ona göre sorgu çekilip ekrana yazdırılıcak. -->
                                    </tr>

                                <?php }
                                ?>


                            </tbody>
                        </table>

                        <!-- Div İçerik Bitişi -->


                    </div>
                </div>
            </div>
        </div>




    </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>