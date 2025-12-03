
const tela = document.querySelector('#tela');


function abrirModal(idModal)
{
	document.getElementById(idModal).style.display = "flex";
	document.body.style.overflow = "hidden";
}

function fecharModal(idModal)
{

	document.getElementById(idModal).style.display = "none";
	document.body.style.overflow = "auto";
}

//olho  do modal
document.addEventListener('DOMContentLoaded', function() {
    const olhos = document.querySelectorAll('.toggle-password');
    olhos.forEach(olho => {
        olho.addEventListener('click', function() {
            const inputSenha = this.previousElementSibling;
            if (inputSenha) {
                const type = inputSenha.getAttribute('type') === 'password' ? 'text' : 'password';
                inputSenha.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash'); 
                this.classList.toggle('fa-eye'); 
            }
        });
    });


window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.classList.add('hidden');
            event.target.style.display = '';
        }
    }



});