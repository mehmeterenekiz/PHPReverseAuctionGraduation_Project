const phoneInput1 = document.getElementById("phone1");

phoneInput1.addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, ""); // Sadece rakamları al
  if (value.length > 11) value = value.slice(0, 11); // Maksimum 11 rakam
  if (value.length > 4) {
    // İlk 4 rakamdan sonra boşluk ekle
    value = value.slice(0, 4) + " " + value.slice(4);
  }
  if (value.length > 8) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 8) + " " + value.slice(8);
  }
  if (value.length > 11) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 11) + " " + value.slice(11);
  }
  e.target.value = value; // Güncellenmiş değeri geri yaz
});

const phoneInput2 = document.getElementById("phone2");

phoneInput2.addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, ""); // Sadece rakamları al
  if (value.length > 11) value = value.slice(0, 11); // Maksimum 11 rakam
  if (value.length > 4) {
    // İlk 4 rakamdan sonra boşluk ekle
    value = value.slice(0, 4) + " " + value.slice(4);
  }
  if (value.length > 8) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 8) + " " + value.slice(8);
  }
  if (value.length > 11) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 11) + " " + value.slice(11);
  }
  e.target.value = value; // Güncellenmiş değeri geri yaz
});

const phoneInput3 = document.getElementById("phone3");

phoneInput3.addEventListener("input", function (e) {
  let value = e.target.value.replace(/\D/g, ""); // Sadece rakamları al
  if (value.length > 11) value = value.slice(0, 11); // Maksimum 11 rakam
  if (value.length > 4) {
    // İlk 4 rakamdan sonra boşluk ekle
    value = value.slice(0, 4) + " " + value.slice(4);
  }
  if (value.length > 8) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 8) + " " + value.slice(8);
  }
  if (value.length > 11) {
    // 8. rakamdan sonra tekrar boşluk ekle
    value = value.slice(0, 11) + " " + value.slice(11);
  }
  e.target.value = value; // Güncellenmiş değeri geri yaz
});

