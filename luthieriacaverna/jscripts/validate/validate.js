/*
 * Função para janela poup-up
 */
function abrir(url, largura, altura, scrool) {

   var left = 99;
   var top = 99;

   window.open(url, '', 'width='+largura+', height='+altura+', top='+top+', left='+left+', scrollbars='+scrool+', status=yes, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

}

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

function lrcpValLogin(login, senha, form){
	var erro = false;
	
	if(login.value == ""){
		alert(retornaString('login'));
		setaFoco(login);
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

function lrcpValDica(titulo, descricao, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function lrcpValNoticia(titulo, autor, descricao, form){
	var erro = false;

	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(autor.value == ""){
		alert(retornaString('autor'));
		setaFoco(autor);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function lrcpValTrabalho(titulo, foto, descricao, form){
	var erro = false;

	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(foto.value == ""){
		alert(retornaString('foto'));
		setaFoco(foto);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function lrcpValServico(titulo, descricao, form){
	var erro = false;

	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function lrcpValLink(titulo, vlink, descricao, form){
	var erro = false;

	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(vlink.value == ""){
		alert(retornaString('endereço'));
		setaFoco(vlink);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function lrcpValEquipe(nome, email, apresentacao, form){
	var erro = false;

	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(email.value == ""){
		alert(retornaString('e-mail'));
		setaFoco(email);
		erro = true;
	}
	else{
		if(email.value.indexOf('@') == -1 || email.value.indexOf('.') == -1){
			alert('O e-mail digitado não é valido');
			setaFoco(email);
			erro = true;
		}
	}
	if(apresentacao.value == ""){
		alert(retornaString('apresentação'));
		setaFoco(apresentacao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function lrcpValContato(nome, email, assunto, mensagem, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(email.value == ""){
		alert(retornaString('e-mail'));
		setaFoco(email);
		erro = true;
	}
	else{
		if(email.value.indexOf('@') == -1 || email.value.indexOf('.') == -1){
			alert('O e-mail digitado não é valido');
			setaFoco(email);
			erro = true;
		}
	}
	if(assunto.value == ""){
		alert(retornaString('assunto'));
		setaFoco(assunto);
		erro = true;
	}	
	if(mensagem.value == ""){
		alert(retornaString('mensagem'));
		setaFoco(mensagem);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function lrcpValDepoimento(nome, email, depoimento, form){
	var erro = false;

	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(email.value == ""){
		alert(retornaString('e-mail'));
		setaFoco(email);
		erro = true;
	}
	else{
		if(email.value.indexOf('@') == -1 || email.value.indexOf('.') == -1){
			alert('O e-mail digitado não é valido');
			setaFoco(email);
			erro = true;
		}
	}
	if(depoimento.value == ""){
		alert(retornaString('depoimento'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}
