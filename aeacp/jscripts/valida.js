/*
	Feito por : Diogo Cezar Teixeira Batista

	Valida.js
	Faz a valida��o em v�rios formul�rios do sistema
	� feito por valida��es atrav�z de fun��es que retornam
	um resultado se o formulario confere ou n�o, com as informa��es
	inseridas
*/

/* Variaveis de exibi��o de erros */

function validaAdmin(nome, email, login, senha, confsenha, form){
	
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
	if(senha.value != confsenha.value){
		alert("As senha digitas n�o confrem");
		setaFoco(senha);
		erro = true;
	}	
	if(erro == false){
		enviaForm(form);
	}
}


function validaAdminAtu(nome, email, login, senha, form){
	
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


function validaNoticia(titulo, descricao, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('t�tulo'));
		setaFoco(titulo);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('not�cia'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}		
}

function validaParceiros(olink, descricao, form){
	var erro = false;
	
	if(olink.value == ""){
		alert(retornaString('link'));
		setaFoco(olink);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descri��o'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}		
}

function validaLogin(login, senha, form){
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