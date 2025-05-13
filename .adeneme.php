<?php

use Opencart\Catalog\Model\Localisation\Location;
$title = "Kullanıcı Bilgilerim";
ob_start();
session_start();
require_once "header_user.php";

?>

<?php require_once "arama-cubuk.php"; ?>


<input type="text" name="deneme" value = "naber">


<script>

    $(document).ready(function () {
    // 'deneme' input'unun değerini al
    var denemeDegeri = $("input[name='deneme']").val();

    // Değeri konsola yazdır
    console.log(denemeDegeri);
});
</script>



<?php require_once "footer.php"; ?>