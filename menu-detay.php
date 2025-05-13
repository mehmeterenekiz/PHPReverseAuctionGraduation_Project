<?php require_once 'header.php'; ?>
<?php
require_once 'nedmin/netting/baglan.php';
//belirli veriyi çekme işlemi
$menusor = $db->prepare("select * from menu where menu_seourl=:sef");
$menusor->execute(array(
    "sef" => $_GET['sef'],
));
$menucek = $menusor->fetch(PDO::FETCH_ASSOC);
?>

<?php require_once "arama-cubuk.php"; ?>

<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper">
            <ul>
                <li><a href="index.php">Home</a><span> -</span></li>
                <li> <?php echo $menucek["menu_ad"] ?> </li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->
<!-- About Page Start Here -->
<div class="about-page-area bg-secondary section-space-bottom">
    <div class="container">
        <h2 class="title-section"><?php echo $menucek['menu_ad'] ?> </h2>
        <div class="inner-page-details inner-page-padding">
            

    
            <p style="margin-top: -1rem;"> <?php echo $menucek['menu_detay'] ?> </p>
 

           
        </div>
    </div>
</div>
<!-- About Page End Here -->

<?php require_once 'footer.php'; ?>