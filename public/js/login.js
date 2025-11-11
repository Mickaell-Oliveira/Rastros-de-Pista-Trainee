function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password');
    
    if (passwordField.type === 'password') {
        // Mostra a senha
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        // Esconde a senha
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}

// Adiciona event listener quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    const toggleIcon = document.querySelector('.toggle-password');
    if (toggleIcon) {
        toggleIcon.addEventListener('click', togglePassword);
    }
});