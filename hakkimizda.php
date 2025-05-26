<?php 
$title="Hakkımızda";
require_once 'header.php'; ?>
<?php
require_once 'nedmin/netting/baglan.php';
//belirli veriyi çekme işlemi
$hakkimizdasor = $db->prepare("select * from hakkimizda where hakkimizda_id=:id");
$hakkimizdasor->execute(array(
    "id" => 0,
));
$hakkimizdacek = $hakkimizdasor->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once "arama-cubuk.php"; ?>

<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper">
            <ul>
                <li><a href="index.php">Anasayfa</a><span> -</span></li>
                <li>About US</li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->
<!-- About Page Start Here -->
<div class="about-page-area bg-secondary section-space-bottom">
    <div class="container">
        <h2 class="title-section"><?php echo $hakkimizdacek['hakkimizda_baslik'] ?> </h2>
        <div class="inner-page-details inner-page-padding">
            <h3><?php echo $hakkimizdacek['hakkimizda_video_baslik'] ?></h3>

            <?php ?>
            <p style="margin-top: -1rem;"><iframe width="560" height="315"
                    src="https://www.youtube.com/embed/<?php echo $hakkimizdacek['hakkimizda_video'] ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> </p>
            <?php ?>

            <h3><?php echo $hakkimizdacek['hakkimizda_icerik_baslik'] ?></h3>
            <?php ?>
            <p style="margin-top: -1rem;"> <?php echo $hakkimizdacek['hakkimizda_icerik'] ?> </p>
            <?php ?>

            <h3><?php echo $hakkimizdacek['hakkimizda_vizyon_baslik'] ?></h3>
            <?php ?>
            <p style="margin-top: -1rem;"> <?php echo $hakkimizdacek['hakkimizda_vizyon'] ?> </p>
            <?php ?>

            <h3><?php echo $hakkimizdacek['hakkimizda_misyon_baslik'] ?></h3>
            <?php ?>
            <p style="margin-top: -1rem;"> <?php echo $hakkimizdacek['hakkimizda_misyon'] ?> </p>
            <?php ?>
        </div>
    </div>
</div>
<!-- About Page End Here -->

<?php require_once 'footer.php'; ?>