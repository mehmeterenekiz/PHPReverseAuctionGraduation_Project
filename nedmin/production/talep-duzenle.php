<?php

include 'header.php';


$talepsor = $db->prepare("SELECT * FROM talep where talep_id=:id");
$talepsor->execute(array(
  'id' => $_GET['talep_id']
));

$talepcek = $talepsor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Talep Düzenleme <small>

                <?php

                if (isset($_GET['durum']) and $_GET['durum'] == "ok") { ?>

                  <b style="color:green;">İşlem Başarılı...</b>

                <?php } elseif (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>

                  <b style="color:red;">İşlem Başarısız...</b>

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
            <br />

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate
              class="form-horizontal form-label-left">

              <!-- Kategori seçme başlangıç -->

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Seç<span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">

                  <?php
                  $talep_id = $talepcek['kategori_id'];

                  $kategorisor = $db->prepare("SELECT * FROM kategori order by kategori_sira asc ");
                  $kategorisor->execute();

                  ?>
                  <select class="select2_multiple form-control" required="" name="kategori_id">


                    <?php

                    while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) {

                      $kategori_id = $kategoricek['kategori_id'];

                      ?>

                      <option <?php if ($kategori_id == $talep_id) {
                        echo "selected='select'";
                      } ?>
                        value="<?php echo $kategoricek['kategori_id']; ?>"><?php echo $kategoricek['kategori_ad']; ?>
                      </option>

                    <?php } ?>

                  </select>
                </div>
              </div>


              <!-- kategori seçme bitiş -->


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Ad <span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="talep_ad" value="<?php echo $talepcek['talep_ad'] ?>"
                    required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Ck Editör Başlangıç -->

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Detay <span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                  <textarea class="ckeditor" id="editor1"
                    name="talep_detay"><?php echo $talepcek['talep_detay']; ?></textarea>
                </div>
              </div>

              <script type="text/javascript">

                CKEDITOR.replace('editor1',

                  {

                    filebrowserBrowseUrl: 'ckfinder/ckfinder.html',

                    filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',

                    filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',

                    filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

                    filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

                    filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

                    forcePasteAsPlainText: true

                  }

                );

              </script>

              <!-- Ck Editör Bitiş -->


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Fiyat <span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="talep_fiyat" value="<?php echo $talepcek['talep_fiyat'] ?>"
                    class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Keyword <span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="talep_keyword"
                    value="<?php echo $talepcek['talep_keyword'] ?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Öne Çıkar<span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="heard" class="form-control" name="talep_one_cikar" required>

                    <option value="1" <?php echo $talepcek['talep_one_cikar'] == '1' ? 'selected=""' : ''; ?>>Evet</option>
                    <option value="0" <?php echo $talepcek['talep_one_cikar'] == '0' ? 'selected=""' : ''; ?>>Hayır
                    </option>

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Durum<span
                    class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="heard" class="form-control" name="talep_durum" required>

                    <option value="1" <?php echo $talepcek['talep_durum'] == '1' ? 'selected=""' : ''; ?>>Aktif</option>
                    <option value="3" <?php echo $talepcek['talep_durum'] == '3' ? 'selected=""' : ''; ?>>Pasif</option>

                  </select>
                </div>
              </div>


              <input type="hidden" name="talep_id" value="<?php echo $talepcek['talep_id'] ?>">


              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="talep_duzenle" class="btn btn-success">Güncelle</button>
                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>


</div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>