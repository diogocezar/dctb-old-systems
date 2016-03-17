/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Fun��es utilizadas para valida��o dos formul�rios
	
	# Padroniza��o dos nomes das fun��es :
	# kVal + nome da fun��o
	  | |
	  | `-> Valida��o
	  `---> Kompre
*/

function kValLogin(login, senha, form){
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

function kValCategoria(nome, descricao, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
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

function kValFabricante(nome, form){
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

function kValProduto(nome, peso, preco, quantidade, descricao, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(peso.value == ""){
		alert(retornaString('peso'));
		setaFoco(peso);
		erro = true;
	}
	if(preco.value == ""){
		alert(retornaString('pre�o'));
		setaFoco(preco);
		erro = true;
	}
	if(quantidade.value == ""){
		alert(retornaString('quantidade'));
		setaFoco(quantidade);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descricao'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function kValAdministrador(nome, email, login, senha, confi, form){
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
			alert('O e-mail digitado n�o � valido');
			setaFoco(email);
			erro = true;
		}
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
	if(confi.value == ""){
		alert(retornaString('confirmar senha'));
		setaFoco(confi);
		erro = true;
	}
	if(senha.value.length < 6 || confi.value.length < 6){
		alert('Sua senha deve ter no m�nimo 6 caracteres');	
		erro = true;
	}
	if(senha.value != confi.value){
		alert('As senhas digitadas n�o conferem !');
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}
