<?php

include 'header.php';

//Belirli veriyi seçme işlemi
$kullanicisor = $db->prepare("SELECT * FROM kullanici");
$kullanicisor->execute();

?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Kullanıcı Listeleme<small>

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
                  <th>Yetki</th>
                  <th>K. Durum</th>
                  <th></th>
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
                      <?php if ($kullanicicek["kullanici_yetki"]==5) { ?>
                      <center> 
                        <button style="background-color: black;" class="btn btn-dark btn-xs"> --------------- </button>
                      </center>
                      <?php } else { ?>
                        <?php
                          if ($kullanicicek['kullanici_teklif_alma_verme'] == 0) { ?>
                            <center>
                              <button style="font-size: 1.1rem;" class="btn btn-danger btn-xs"> Başvurulmadı </button>
                            </center>
                            <?php } else if ($kullanicicek['kullanici_teklif_alma_verme'] == 1) { ?>
                              <center>
                                <button class="btn btn-primary btn-xs"> Başvuruldu </button>
                              </center>
                            <?php } else { ?>
                              <center> 
                                <button class="btn btn-success btn-xs"> Onaylandı </button>
                              </center>
                            <?php } ?>
                      <?php } ?>
                    </td>
                    <td><?php echo $kullanicicek['kullanici_yetki'] ?></td>

                    <td>
                      <center> <?php
                      if ($kullanicicek['kullanici_durum'] == 1) { ?>

                          <button class="btn btn-success btn-xs"> Aktif </button>

                        <?php } else { ?>

                          <button class="btn btn-danger btn-xs"> Pasif </button>

                        <?php } ?>
                      </center>
                    </td>


                    <td>
                      <center><a
                          href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>"><button
                            class="btn btn-primary btn-xs">Düzenle</button></a></center>
                    </td>
                    <!-- kullanıcı listesinden get ile gönderdik bu kullanıcı idyi ve orada ona göre sorgu çekilip ekrana yazdırılıcak. -->
                    <td>
                      <center><a
                          href="../netting/islem.php?kullanici_id=<?php echo $kullanicicek['kullanici_id'];?>&kullanici_sil=ok"><button
                            class="btn btn-danger btn-xs">Sil</button></a></center>
                    </td>
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