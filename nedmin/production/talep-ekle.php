<?php
include 'header.php';
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

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />

                        <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
                        <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate
                            class="form-horizontal form-label-left">



                            <!-- Kategori seçme başlangıç -->


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori
                                    Seç<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">

                                    <?php

                                    $kategorisor = $db->prepare("select * from kategori where kategori_ust=:kategori_ust order by kategori_sira");
                                    $kategorisor->execute(array(
                                        'kategori_ust' => 0
                                    ));

                                    ?>
                                    <select class="select2_multiple form-control" required="" name="kategori_id">


                                        <?php

                                        while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) {

                                            $kategori_id = $kategoricek['kategori_id'];

                                            ?>

                                            <option value="<?php echo $kategoricek['kategori_id']; ?>">
                                                <?php echo $kategoricek['kategori_ad']; ?>
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
                                    <input type="text" id="first-name" name="talep_ad" placeholder="Talep adını giriniz"
                                        required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <!-- Ck Editör Başlangıç -->

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Detay
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <textarea class="ckeditor" id="editor1" name="talep_detay"></textarea>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Fiyat
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="talep_fiyat"
                                        placeholder="Talep fiyat giriniz" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep Keyword
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="talep_keyword"
                                        placeholder="Talep keyword giriniz"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Talep
                                    Durum<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="talep_durum" required>


                                        <option value="1">Aktif</option>
                                        <option value="0">Pasif</option>



                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="talep_ekle" class="btn btn-success">Kaydet</button>
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