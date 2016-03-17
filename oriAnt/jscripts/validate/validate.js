/* Coloca o foco em um campo passado como parâmetro */
function setaFoco(campo){
	campo.focus();
}

/* Retorna uma string de erro */
function retornaString(msgstr){
	return("O campo " + msgstr + " está vazio");
}

/* Envia um formulário */
function enviaForm(form){
	form.submit();	
}

/* Coloca o foco no proximo campo ao presisonar enter */
function pulaCampoNoEnter(campoDestino){
	try{
		var e = window.event;
		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
		if (keyCode == 13){
			setaFoco(campoDestino);
		}
	}
	catch(ex){}
}

/* Envia formulario ao presionar enter */
function enviaLoginOnEnter(login, senha, form){
	try{
		var e = window.event;
		var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;
		if (keyCode == 13){
			serValLogin(login, senha, form);
		}
	}
	catch(ex){}
}

/* validações */

function validaLogin(usuario, senha, form){
	var erro = false;
	
	if(usuario.value == ""){
		alert(retornaString('usuário'));
		setaFoco(usuario);
		erro = true;
	}
	if(senha.value == ""){
		alert(retornaString('senha'));
		setaFoco(senha);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}