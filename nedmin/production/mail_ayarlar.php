<?php require_once "header.php"; ?>
<?php
require_once '../netting/baglan.php';

//belirli veriyi çekme işlemi
$ayarsor = $db->prepare("select * from ayar where ayar_id=:id");
$ayarsor->execute(array(
    "id" => 0,
));
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Mail Ayarları<small>
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
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail SMTP Host
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="ayar_smtphost"
                                        value="<?php echo $ayarcek['ayar_smtphost'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail
                                    Adresi<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="ayar_smtpuser"
                                        value="<?php echo $ayarcek['ayar_smtpuser'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail
                                    Şifresi<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="ayar_smtppassword"
                                        value="<?php echo $ayarcek['ayar_smtppassword'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">SMTP Port<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="ayar_smtpport"
                                        value="<?php echo $ayarcek['ayar_smtpport'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Site
                                    Bakımda<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="ayar_bakim" required>

                                        <option value="1" <?php echo $ayarcek['ayar_bakim'] == '1' ? 'selected=""' : ''; ?>>Evet</option>
                                        <option value="0" <?php echo $ayarcek['ayar_bakim'] == '0' ? 'selected=""' : ''; ?>>Hayır </option>

                                    </select>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="mail_ayar_kaydet"
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