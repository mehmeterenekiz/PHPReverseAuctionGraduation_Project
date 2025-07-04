<?php

include 'header.php';

$kategorisor = $db->prepare("SELECT * FROM kategori where kategori_id=:id");
$kategorisor->execute(array(
    'id' => $_GET['kategori_id'] // dkategori listesinden get ile aldık bu dkategori idyi.
));

$kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Kategori Düzenleme <small>
                                <?php

                                if (isset($_GET['durum']) and $_GET['durum'] == "ok") { ?>

                                    <b style="color:green;">İşlem Başarılı.</b>

                                <?php } elseif (isset($_GET['durum']) and $_GET['durum'] == "no") { ?>

                                    <b style="color:red;">İşlem Başarısız.</b>

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

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori
                                    Adı<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kategori_ad"
                                        value="<?php echo $kategoricek['kategori_ad'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori
                                    Sıra<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="tel" id="phone1" minlength="1" maxlength="2" name="kategori_sira"
                                        value="<?php echo $kategoricek['kategori_sira'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori
                                    Durum<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="kategori_durum" required>

                                        <option value="1" <?php echo $kategoricek['kategori_durum'] == '1' ? 'selected' : ''; ?>> Aktif </option>
                                        <option value="0" <?php echo $kategoricek['kategori_durum'] == '0' ? 'selected' : ''; ?>> Pasif </option>

                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="kategori_id" value="<?php echo $kategoricek['kategori_id'] ?>">

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="kategori_duzenle"
                                        class="btn btn-success">Güncelle</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>