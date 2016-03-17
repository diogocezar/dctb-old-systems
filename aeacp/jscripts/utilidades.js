/*
	Feito por : Diogo Cezar Teixeira Batista

	Utilidades.js
	Cont�m v�rias fun��es com as mais diversas utilidades
	b�sicas para organiza��o do site
	
*/

/*Retorna uma string de erro */
function retornaString(msgstr){
	return("O campo " + msgstr + " est� vazio");
}

/* Envia um formul�rio */
function enviaForm(form){
	form.submit();	
}

/* Limpa um campo passado como par�metro */
function limpaValor(campo){
	campo.value = "";
}

/* Coloca o foco em um campo passado como par�metro */
function setaFoco(campo){
	campo.focus();
}

/* Habilita/Desabilita um campo passado como par�metro */
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