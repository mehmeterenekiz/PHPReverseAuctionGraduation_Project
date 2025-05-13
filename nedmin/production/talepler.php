<?php

include 'header.php';

//Belirli veriyi seçme işlemi
$talepsor = $db->prepare("SELECT * FROM talep order by talep_id DESC");
$talepsor->execute();

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Talepler<small>

                <?php if (isset($_GET['durum']) and $_GET['durum'] == "ok") { ?>

                  <b style="color:green;">İşlem Başarılı...</b>

                <?php } elseif (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>

                  <b style="color:red;">İşlem Başarısız...</b>

                <?php } ?>

              </small></h2>

            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>

            <!-- <div align="right">
              <a href="talep-ekle.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>

            </div>
          -->
          </div>
          <div class="x_content">


            <!-- Div İçerik Başlangıç -->

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
              cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Talep Ad</th>
                  <th>Talep Fiyat</th>
                  <th>Öne Çıkar</th>
                  <th>Durum</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>

              <tbody>

                <?php

                $say = 0;

                while ($talepcek = $talepsor->fetch(PDO::FETCH_ASSOC)) {
                  $say++ ?>
                  <tr>
                    <td width="20"><?php echo $say ?></td>
                    <td><?php echo $talepcek['talep_ad'] ?></td>
                    <td><?php echo $talepcek['talep_fiyat'] ?></td>
                    <td>
                      <center>
                      <?php

                      if ($talepcek['talep_one_cikar'] == 0) { ?>

                          <a
                            href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id'] ?>&talep_one=1&talep_one_cikar=ok"><button
                              class="btn btn-success btn-xs">Ön Çıkar</button></a>

                        <?php } elseif ($talepcek['talep_one_cikar'] == 1) { ?>

                          <a
                            href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id'] ?>&talep_one=0&talep_one_cikar=ok"><button
                              class="btn btn-danger btn-xs">Kaldır</button></a>

                        <?php } ?>

                      </center>
                    </td>


                    <td>
                      <center><?php

                      if ($talepcek['talep_durum'] == 1) { ?>

                          <a
                            href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id'] ?>&talep_one=3&talep_onay=ok">
                            <button class="btn btn-success btn-xs">Talep Aktif</button> </a>

                        <?php } else if ($talepcek['talep_durum'] == 0) { ?>

                            <a
                              href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id'] ?>&talep_one=1&talep_onay=ok">
                              <button class="btn btn-warning btn-xs">Onay Bekliyor</button> </a>

                        <?php } else if ($talepcek['talep_durum'] == 2) { ?>

                              <button class="btn btn-dark btn-xs">K. T. Kaldırıldı</button>

                        <?php } else if ($talepcek['talep_durum'] == 3) { ?>

                                <a
                                  href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id'] ?>&talep_one=1&talep_onay=ok">
                                  <button class="btn btn-dark btn-xs">A. T. Kaldırıldı</button> </a>

                        <?php } ?>
                      </center>


                    </td>


                    <td>
                      <center><a href="talep-duzenle.php?talep_id=<?php echo $talepcek['talep_id']; ?>"><button
                            class="btn btn-primary btn-xs">Düzenle</button></a></center>
                    </td>
                    <td>
                      <center><a onclick=" return confirm('Bu ürünü silmek istediğinizden emin misiniz?')"
                          href="../netting/islem.php?talep_id=<?php echo $talepcek['talep_id']; ?>&talep_sil=ok"><button
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