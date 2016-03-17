/*
	Feito por : Diogo Cezar Teixeira Batista

	Utilidades.js
	Contém várias funções com as mais diversas utilidades
	básicas para organização do site
	
*/

/*Retorna uma string de erro */
function retornaString(msgstr){
	return("O campo " + msgstr + " está vazio");
}

/* Envia um formulário */
function enviaForm(form){
	form.submit();	
}

/* Limpa um campo passado como parâmetro */
function limpaValor(campo){
	campo.value = "";
}

/* Coloca o foco em um campo passado como parâmetro */
function setaFoco(campo){
	campo.focus();
}

/* Habilita/Desabilita um campo passado como parâmetro */
function habilitaCampo(campo){
	if(campo.disabled == true){
		limpaValor(campo);
		campo.disabled = false;
		setaFoco(campo);
	}
	else{
		limpaValor(campo);
		campo.disabled = true;
	}
}