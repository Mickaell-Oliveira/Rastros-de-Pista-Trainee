const tela = document.querySelector('#tela');


function abrirModal(idModal)
{
	document.getElementById(idModal).style.display = "flex";

}

function fecharModal(idModal)
{

	document.getElementById(idModal).style.display = "none";

}