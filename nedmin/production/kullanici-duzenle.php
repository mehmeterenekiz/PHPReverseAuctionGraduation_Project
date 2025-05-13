<?php

require_once 'header.php';

$kullanicisor = $db->prepare("SELECT * FROM kullanici where kullanici_id=:id");
$kullanicisor->execute(array(
    'id' => $_GET['kullanici_id'] // kullanıcı listesinden get ile aldık bu kullanıcı idyi.
));

$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

$kullanicifirmasor = $db->prepare("SELECT * FROM firma where kullanici_id=:id");
$kullanicifirmasor->execute(array(
    'id' => $_GET['kullanici_id'] // kullanıcı listesinden get ile aldık bu kullanıcı idyi.
));

$kullanicifirmacek = $kullanicifirmasor->fetch(PDO::FETCH_ASSOC);

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Kullanıcı Düzenleme <small>
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

                            <?php

                            $zaman = explode(" ", $kullanicicek['kullanici_zaman']);

                            ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı ID<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_id" disabled=""
                                        value="<?php echo $kullanicicek['kullanici_id'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mail
                                    Adresi<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_mail" disabled=""
                                        value="<?php echo $kullanicicek['kullanici_mail'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Tarihi
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="date" id="first-name" name="kullanici_tc" disabled=""
                                        value="<?php echo $zaman[0]; ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kayıt Saati
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="time" id="first-name" name="kullanici_tc" disabled=""
                                        value="<?php echo $zaman[1]; ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Tipi
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_tip" disabled
                                        value="<?php 
                                        if($kullanicicek['kullanici_tip'] == 'PERSONAL'){
                                            echo 'Bireysel';
                                        }
                                        else{
                                            echo 'Kurumsal';
                                        }
                                        ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div> 

                            <?php 
                                if($kullanicicek['kullanici_tip'] == 'PRIVATE_COMPANY'){ ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Firma Adı
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="firma_ad" disabled=""
                                                value="<?php echo $kullanicifirmacek['firma_ad'] ?>" required="required"
                                                class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Firma Vergi Dairesi
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="firma_vdaire" disabled=""
                                                value="<?php echo $kullanicifirmacek['firma_vdaire'] ?>" required="required"
                                                class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Firma Vergi Numarası
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="first-name" name="firma_vno" disabled=""
                                                value="<?php echo $kullanicifirmacek['firma_vno'] ?>" required="required"
                                                class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>                                
                            <?php  } ?>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Telefon
                                    Numarası<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="tel" id="phone3" name="kullanici_gsm" disabled=""
                                        value="<?php echo $kullanicicek['kullanici_gsm'] ?>" required="required"
                                        minlength="14" maxlength="14"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ad<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_ad"
                                        value="<?php echo $kullanicicek['kullanici_ad'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Soyad<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_soyad"
                                        value="<?php echo $kullanicicek['kullanici_soyad'] ?>" required="required"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">İl
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="kullanici_il"
                                        value="<?php echo $kullanicicek['kullanici_il'] ?>"
                                        class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı Yetkisi
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="kullanici_yetki" required>

                                        <option value="1" <?php echo $kullanicicek['kullanici_yetki'] == '1' ? 'selected' : ''; ?>> 1 </option>
                                        <option value="2" <?php echo $kullanicicek['kullanici_yetki'] == '2' ? 'selected' : ''; ?>> 2 </option>
                                        <option value="3" <?php echo $kullanicicek['kullanici_yetki'] == '3' ? 'selected' : ''; ?>> 3 </option>
                                        <option value="4" <?php echo $kullanicicek['kullanici_yetki'] == '4' ? 'selected' : ''; ?>> 4 </option>
                                        <option value="5" <?php echo $kullanicicek['kullanici_yetki'] == '5' ? 'selected' : ''; ?>> 5 </option>

                                    </select>
                                </div>
                            </div>        
                                    
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kullanıcı
                                    Durum<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="heard" class="form-control" name="kullanici_durum" required>

                                        <option value="1" <?php echo $kullanicicek['kullanici_durum'] == '1' ? 'selected' : ''; ?>> Aktif </option>
                                        <option value="0" <?php echo $kullanicicek['kullanici_durum'] == '0' ? 'selected' : ''; ?>> Pasif </option>

                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="kullanici_id"
                                value="<?php echo $kullanicicek['kullanici_id'] ?>">

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="kullanici_duzenle"
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

<?php require_once 'footer.php'; ?>