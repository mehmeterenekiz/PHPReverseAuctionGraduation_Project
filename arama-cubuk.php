<!-- Main Banner 1 Area Start Here -->
<div class="main-banner2-area" style="height:36rem;">
    <div class="container">
        <div class="main-banner2-wrapper">
            <p>otomobil & ev</p>
            <form action="arama-detay.php" method="POST">
                <div class="banner-search-area input-group">
                    <input class="form-control" required minlength="3" name="searchkeywords" placeholder="Aradığınız kategori veya markayı yazınız. . ." type="text">
                    <span class="input-group-addon">
                        <button type="submit" name="searchsayfa">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <?php if(isset($_SESSION['csrf_token'])) {?>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<!-- Main Banner 1 Area End Here -->
 