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