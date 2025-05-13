<?php
$currentPage = $_SERVER['REQUEST_URI']; // URL'nin tamamını alıyoruz
?>

<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    <ul class="settings-title">
        <li>
            <p>Hesap Bilgilerim</p>
        </li>

        <li class="<?= (strpos($currentPage, 'teklif-al-ver-basvuru') !== false) ? 'active' : '' ?>">
            <a href="teklif-al-ver-basvuru"> Teklif & Talep Başvurusu </a>
        </li>

        <li class="<?= (strpos($currentPage, 'kullanici') !== false) ? 'active' : '' ?>">
            <a href="kullanici">Kullanıcı Bilgilerim</a>
        </li>

        <li class="<?= (strpos($currentPage, 'adres') !== false) ? 'active' : '' ?>">
            <a href="adres">Adres Bilgilerim</a>
        </li>

        <li class="<?= (strpos($currentPage, 'sifrem') !== false) ? 'active' : '' ?>">
            <a href="sifrem">Şifre Değişikliği</a>
        </li>
    </ul>

    <?php if ($kullanicicek["kullanici_teklif_alma_verme"] == 2) { ?>
        <hr>
        <ul class="settings-title">
            <li>
                <p> Teklif & Talep </p>
            </li>

            <li class="<?= (strpos($currentPage, 'talep-olustur') !== false) ? 'active' : '' ?>">
                <a href="talep-olustur"> Talep oluştur </a>
            </li>

            <li class="<?= (strpos($currentPage, 'taleplerim') !== false) ? 'active' : '' ?>">
                <a href="taleplerim.php"> Taleplerim </a>
            </li>

            <li class="<?= (strpos($currentPage, 'alinan-teklifler') !== false) ? 'active' : '' ?>">
                <a href="alinan-teklifler">Aldığım Teklifler</a>
            </li>

            <li class="<?= (strpos($currentPage, 'verilen-teklifler') !== false) ? 'active' : '' ?>">
                <a href="verilen-teklifler">Verdiğim Teklifler</a>
            </li>
        </ul>

        <hr>
        <ul class="settings-title">
            <li>
                <p> Mesajlar & Favoriler </p>
            </li>

            <li
                class="<?= (strpos($currentPage, 'mesajlarim') !== false || strpos($currentPage, 'mesaj-detay') !== false) ? 'active' : '' ?>">
                <a href="mesajlarim"> mesajlarım </a>
            </li>

            <li class="<?= (strpos($currentPage, 'favorilerim') !== false) ? 'active' : '' ?>">
                <a href="favorilerim"> favorilerim </a>
            </li>

        </ul>

    <?php } ?>

</div>