window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.header_new'); // Navbar'ı seçiyoruz
  
    // Sayfa kaydırması 60vh'yi geçtiğinde navbar'ı gizle
    if (window.scrollY >= window.innerHeight * 0.6) {
      navbar.classList.remove('visible'); // 'visible' sınıfını kaldır
      navbar.style.transform = 'translateY(-130%)';  // Navbar'ı yukarıya kaydır
    } else {
      navbar.classList.add('visible'); // 'visible' sınıfını ekle
      navbar.style.transform = 'translateY(0)';  // Navbar'ı eski yerine getir
    }
  });