/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Funções utilizadas para validação dos formulários
	
	# Padronização dos nomes das funções :
	# rVal + nome da função
	  | |
	  | `-> Validação
	  `---> Rrdecoracoes
*/

function rValLogin(login, senha, form){
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

function rValTexto(form){
	enviaForm(form);
}

function rValCancelar(email, form){
	var erro = false;
	
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
	if(erro == false){
		enviaForm(form);
	}
}

function rValVisitante(nome, cidade, email, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(cidade.value == ""){
		alert(retornaString('cidade'));
		setaFoco(cidade);
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
	if(erro == false){
		enviaForm(form);
	}
}

function rValServico(nome, descricao, form){
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

function rValCliente(nome, lLink, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(lLink.value == ""){
		alert(retornaString('link'));
		setaFoco(lLink);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function rValNews(titulo, form){
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

function rValAdmin(nome, login, senha, confirma, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
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
	if(confirma.value == ""){
		alert(retornaString('confirmar senha'));
		setaFoco(confi);
		erro = true;
	}
	if(senha.value.length < 6 || confirma.value.length < 6){
		alert('Sua senha deve ter no mínimo 6 caracteres');	
		erro = true;
	}
	if(senha.value != confirma.value){
		alert('As senhas digitadas não conferem !');
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function rValContato(nome, email, assunto, mensagem, form){
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