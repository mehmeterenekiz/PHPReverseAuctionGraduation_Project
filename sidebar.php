<style>
.fox-sidebar {
    margin-top: -2.4rem;
    margin-left: -0.2rem !important;
    max-height: 385px;
    max-width: 240px;
    overflow-y: auto;
    padding-top: 10px;
    padding-bottom: 10px;
    scrollbar-width: thin;         /* Firefox için */
    scrollbar-color: #ccc transparent;  /* Firefox için */
    border: 1px solid #dfdfdf;
}

.fox-sidebar::-webkit-scrollbar {
    width: 20px;
    margin-left: 10px; 
}

.fox-sidebar::-webkit-scrollbar-track {
    background: transparent;
}
.fox-sidebar::-webkit-scrollbar-button {
    height: 0;
    width: 0;
    background: none;
}
.fox-sidebar::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
    border: 2px solid transparent;
}
</style>

<div class="fox-sidebar" style="margin-left: -2.2rem;">

    <div class="sidebar-item">
        <div class="sidebar-item-inner">
            <h3 class="sidebar-item-title">
                <?php if (isset($_GET['kategori_id'])) { ?>
                    <?php

                    $kategori_id = $_GET['kategori_id'];
                    $kategorisor = $db->prepare("SELECT * FROM kategori where kategori_id=:kategori_id");
                    $kategorisor->execute(array(
                        'kategori_id' => $kategori_id,
                    ));
                    $kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)
                        ?>
                    <?php echo $kategoricek['kategori_ad'] ?>
                <?php } else { ?>

                    kategoriler

                <?php } ?>
            </h3>
            <ul class="sidebar-categories-list">

                <?php

                if (isset($_GET['kategori_id'])) { ?>
                    <?php
                    $kategori_id = $_GET['kategori_id'];
                    $markarsor = $db->prepare("SELECT * FROM kategori inner join vasitamarka on kategori.kategori_id = vasitamarka.kategori_id  where kategori.kategori_id=:kategori_id order by marka_ad asc");
                    $markarsor->execute(array(
                        'kategori_id' => $kategori_id   // kategori onay durumu geliyor.
                    ));
                    while ($markacek = $markarsor->fetch(PDO::FETCH_ASSOC)) { ?>

                        <li style="font-size: 1.35rem;"><a
                                href="marka-<?= seo($markacek['marka_ad']) . "-" . $markacek['marka_id'] ?>"><?php echo $markacek['marka_ad'] ?></a>
                            <span>

                                <?php
                                $marka_id = $markacek['marka_id'];
                                $talepsay = $db->prepare("SELECT count(talep_marka) as talepsayisi FROM talep where talep_marka=:marka_id and talep_durum=:talep_durum");
                                $talepsay->execute(array(
                                    'marka_id' => $marka_id,
                                    'talep_durum' => 1
                                ));
                                $saycek = $talepsay->fetch(PDO::FETCH_ASSOC);

                                echo "(" . $saycek['talepsayisi'] . ")";
                                ?>

                            </span>
                        </li>

                    <?php } ?>

                <?php } else if (isset($_GET['marka_id'])) {  echo "naber"; ?>

                    

                <?php } else { ?>
                    <?php
                    $kategorisor = $db->prepare("SELECT * FROM kategori where kategori_durum=:kategori_durum order by kategori_sira");
                    $kategorisor->execute(array(
                        'kategori_durum' => 1   // kategori onay durumu geliyor.
                    ));
                    while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) { ?>

                        <li><a
                                href="kategori-<?= seo($kategoricek['kategori_ad']) . "-" . $kategoricek['kategori_id'] ?>"><?php echo $kategoricek['kategori_ad'] ?></a>
                            <span>

                                <?php
                                $kategori_id = $kategoricek['kategori_id'];
                                $talepsay = $db->prepare("SELECT count(kategori_id) as talepsayisi FROM talep where kategori_id=:kategori_id and talep_durum=:talep_durum");
                                $talepsay->execute(array(
                                    'kategori_id' => $kategori_id,
                                    'talep_durum' => 1
                                ));
                                $saycek = $talepsay->fetch(PDO::FETCH_ASSOC);

                                echo "(" . $saycek['talepsayisi'] . ")";
                                ?>

                            </span>
                        </li>

                    <?php } ?>
                <?php } ?>


            </ul>
        </div>
    </div>
    <!-- <div class="sidebar-item">
        <div class="sidebar-item-inner">
            <h3 class="sidebar-item-title">Price Range</h3>
            <div id="price-range-wrapper" class="price-range-wrapper">
                <div id="price-range-filter"></div>
                <div class="price-range-select">
                    <div class="price-range" id="price-range-min"></div>
                    <div class="price-range" id="price-range-max"></div>
                </div>
                <button class="sidebar-full-width-btn disabled" type="submit" value="Login"><i class="fa fa-search"
                        aria-hidden="true"></i>Search</button>
            </div>
        </div>
    </div> -->
</div>