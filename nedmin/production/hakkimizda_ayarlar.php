<?php require_once "header.php"; ?>
<?php
require_once '../netting/baglan.php';

//belirli veriyi çekme işlemi
$hakkimizdasor = $db->prepare("select * from hakkimizda where hakkimizda_id=:id");
$hakkimizdasor->execute(array(
    "id" => 0,
));
$hakkimizdacek = $hakkimizdasor->fetch(PDO::FETCH_ASSOC);
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Hakkımızda Ayarları<small>
                                <?php
                                if (isset($_GET['durum']) && $_GET['durum'] == "ok") { ?>
                                    <b style="color: green;"> İşlem Başarılı. </b>
                                    <?php
                                } elseif (isset($_GET['durum']) && $_GET['durum'] == "no") { ?>
                                    <b style="color: red;"> İşlem Başarısız. </b>
                                    <?php
                                } ?>
                            </small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="../netting/islem.php" method="POST" id="demo-form2" data-parsley-validate
                            class="form-horizontal form-label-left">

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hakkımızda Başlık<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="hakkimizda_baslik"
                                        value="<?php echo $hakkimizdacek['hakkimizda_baslik'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanıtım Videosu Başlık<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="hakkimizda_video_baslik"
                                        value="<?php echo $hakkimizdacek['hakkimizda_video_baslik'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tanıtım Videosu<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="hakkimizda_video"
                                        value="<?php echo $hakkimizdacek['hakkimizda_video'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik Başlık<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="hakkimizda_icerik_baslik"
                                        value="<?php echo $hakkimizdacek['hakkimizda_icerik_baslik'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <!-- Ck Editör Başlangıç -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İçerik <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="ckeditor" id="editor1"
                                        name="hakkimizda_icerik"><?php echo $hakkimizdacek['hakkimizda_icerik']; ?></textarea>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vizyon Başlık<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="hakkimizda_vizyon_baslik"
                                        value="<?php echo $hakkimizdacek['hakkimizda_vizyon_baslik'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <!-- Ck Editör Başlangıç -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Vizyon<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="ckeditor" id="editor1"
                                        name="hakkimizda_vizyon"><?php echo $hakkimizdacek['hakkimizda_vizyon']; ?></textarea>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Misyon Başlık<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="hakkimizda_misyon_baslik"
                                        value="<?php echo $hakkimizdacek['hakkimizda_misyon_baslik'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <!-- Ck Editör Başlangıç -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Misyon<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="ckeditor" id="editor1"
                                        name="hakkimizda_misyon"><?php echo $hakkimizdacek['hakkimizda_misyon']; ?></textarea>
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

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="hakkimizda_ayar_kaydet"
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
<?php require_once "footer.php"; ?>