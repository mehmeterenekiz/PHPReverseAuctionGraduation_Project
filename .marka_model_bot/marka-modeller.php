<?php
require_once "class.php";

$html = file_get_html('https://www.sahibinden.com/kategori/otomobil');

foreach($html->find('img') as $element )
    echo $element -> src . '<br>';


?>
