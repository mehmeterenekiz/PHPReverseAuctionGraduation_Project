const container = document.getElementById('container_new');   /* sign in ve sign up js*/
const registerBtn = document.getElementById('register_new');
const loginBtn = document.getElementById('login_new');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.addEventListener('DOMContentLoaded', function() {
  const togglePasswordButtons = document.querySelectorAll('.toggle-password'); /* sign in ve sign up password js*/

  togglePasswordButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Şifre alanını bul
      const passwordField = this.previousElementSibling;
      
      if (passwordField) {
        // Şifre alanının tipini değiştir
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // İkonu değiştir
        this.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash-fill"></i>';
      }
    });
  });
});
