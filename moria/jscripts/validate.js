/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Funções utilizadas para validação dos formulários
	
	# Padronização dos nomes das funções :
	# kVal + nome da função
	  | |
	  | `-> Validação
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
		alert(retornaString('descrição'));
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
		alert(retornaString('preço'));
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
			alert('O e-mail digitado não é valido');
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
		alert('Sua senha deve ter no mínimo 6 caracteres');	
		erro = true;
	}
	if(senha.value != confi.value){
		alert('As senhas digitadas não conferem !');
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}
