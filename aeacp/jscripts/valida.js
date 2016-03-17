/*
	Feito por : Diogo Cezar Teixeira Batista

	Valida.js
	Faz a validação em vários formulários do sistema
	é feito por validações atravéz de funções que retornam
	um resultado se o formulario confere ou não, com as informações
	inseridas
*/

/* Variaveis de exibição de erros */

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
		alert("As senha digitas não confrem");
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
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('notícia'));
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
		alert(retornaString('descrição'));
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