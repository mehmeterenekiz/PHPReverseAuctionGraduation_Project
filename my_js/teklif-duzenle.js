document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".modal");
    const modalKapat = document.getElementById("modal-kapat");
    const modalButton = document.querySelectorAll(".teklif-duzenle-btn");
    
    modalButton.forEach(button => {
        button.addEventListener("click", (event) => {
            event.preventDefault(); 
            
            modal.style.display = "flex"; 
            document.body.style.overflow = "hidden"; 
        });
    });

    modalKapat.addEventListener("click", (event) => {
        event.preventDefault();
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    });

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    });

    window.addEventListener("DOMContentLoaded", () => {
        const inputs = document.querySelectorAll(".rakam");

        inputs.forEach(input => {
            input.addEventListener("input", (e) => {
                let value = e.target.value;

                // Sadece rakam harici karakterleri temizle
                value = value.replace(/[^0-9]/g, "");

                // Sayıyı 3 haneli gruplara ayır ve nokta ekle
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                e.target.value = value;
            });
        });
    });

    document.getElementById('form-buton').addEventListener('click', function (event) {
        const teklifFiyat = document.getElementById('teklif_fiyat').value;
        const talepFiyat = document.getElementById('talep_fiyat').value;

        const fiyatTalep = parseInt(talepFiyat.replace(/\./g, ''), 10);
        const fiyatTeklif = parseInt(teklifFiyat.replace(/\./g, ''), 10);

        if (isNaN(fiyatTeklif) || fiyatTalep < fiyatTeklif) {
            event.preventDefault();
            document.getElementById('uyari_mesaji').style.display = 'inline';
        } else {
            document.getElementById('uyari_mesaji').style.display = 'none';
        }
    });


});
