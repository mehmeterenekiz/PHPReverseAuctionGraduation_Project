<?php
function formatAdSoyad($kullaniciAd, $kullaniciSoyad)
{
    // Adı boşluklara göre ayır
    $isimParcalariAd = explode(" ", trim($kullaniciAd));

    // İlk kısmı (ad) alın
    $ilkAd = $isimParcalariAd[0];

    // İkinci ad varsa büyük harf ve nokta ekle
    $kisaltmalarAd = "";
    if (count($isimParcalariAd) > 1) {
        for ($i = 1; $i < count($isimParcalariAd); $i++) {
            $kisaltmalarAd .= mb_strtoupper(mb_substr($isimParcalariAd[$i], 0, 1, "UTF-8"), "UTF-8") . "." . " ";
        }
    }

    // Eğer soyad boşsa işlemi atla
    $kisaltmaSoyad = "";
    if (!empty(trim($kullaniciSoyad))) {
        // Soyadını boşluklara göre ayır
        $isimParcalariSoyad = explode(" ", trim($kullaniciSoyad));

        // Eğer birden fazla soyad varsa son soyadı al
        $sonSoyad = end($isimParcalariSoyad);

        // Sadece son soyadın ilk harfini büyük harfle noktalı olarak yaz
        $kisaltmaSoyad = mb_strtoupper(mb_substr($sonSoyad, 0, 1, "UTF-8"), "UTF-8") . ".";
    }

    // Sonuç birleştir
    $sonuc = $ilkAd . " " . trim($kisaltmalarAd) . " " . trim($kisaltmaSoyad);

    return $sonuc;
}

function turkce_title_case($metin)
{
    $kelimeler = explode(' ', $metin);
    $sonuc = [];

    $donusum = array(
        'i' => 'İ',
        'ş' => 'Ş',
        'ğ' => 'Ğ',
        'ü' => 'Ü',
        'ö' => 'Ö',
        'ç' => 'Ç',
        'ı' => 'I'
    );

    foreach ($kelimeler as $kelime) {
        $ilkHarf = mb_substr($kelime, 0, 1, 'UTF-8');
        $kalan = mb_substr($kelime, 1, null, 'UTF-8');

        if (array_key_exists($ilkHarf, $donusum)) {
            $ilkHarf = $donusum[$ilkHarf];
        } else {
            $ilkHarf = mb_strtoupper($ilkHarf, 'UTF-8');
        }

        $sonuc[] = $ilkHarf . $kalan;
    }

    return implode(' ', $sonuc);
}
?>