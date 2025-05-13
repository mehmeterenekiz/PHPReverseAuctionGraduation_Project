<?php
require_once 'header.php';
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Menu Ekleme<small>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Adı<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="menu_ad" placeholder="Menü Adını Giriniz"
                                        required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            
                            <!-- Ck Editör Başlangıç -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Detay<span
                                class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="ckeditor" id="editor1"
                                name="menu_detay"></textarea>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Url<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="menu_url" placeholder="Menü Url Giriniz"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü Sıra<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="tel" id="phone1" name="menu_sira" placeholder="Menü Sıra Giriniz (1-99)"
                                        required="required" minlength="1" maxlength="2"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Menü
                                    Durum<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="menu_durum" required>

                                        <option value="1"> Aktif </option>
                                        <option value="0"> Pasif </option>

                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="menu_id"
                                value="<?php echo $menucek['menu_id'] ?>"> 

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="menu_kaydet"
                                        class="btn btn-success">Kaydet</button>
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

<?php require_once 'footer.php'; ?>