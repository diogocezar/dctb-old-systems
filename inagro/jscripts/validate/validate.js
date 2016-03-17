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

function login(login, senha, form){
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


function noticia(titulo, descricao, data, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('titulo'));
		setaFoco(titulo);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(data.value == ""){
		alert(retornaString('data'));
		setaFoco(data);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function empresa(nome, descricao, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
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

function evento(titulo, descricao, data, form){
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
	if(data.value == ""){
		alert(retornaString('data'));
		setaFoco(data);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function linkk(titulo, urllink, descricao, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(urllink.value == ""){
		alert(retornaString('link'));
		setaFoco(urllink);
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

function download(titulo, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function parceiro(nome, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	
	if(erro == false){
		enviaForm(form);
	}	
}