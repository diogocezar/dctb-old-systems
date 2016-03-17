/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Fun��es utilizadas para valida��o dos formul�rios
	
	# Padroniza��o dos nomes das fun��es :
	# pVal + nome da fun��o
	  | |
	  | `-> Valida��o
	  `---> Promotos
*/

function pValLogin(login, senha, form){
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

function pValContato(nome, email, assunto, mensagem, form){
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

function pValLoja(acao, titulo, endereco, telefone, descricao, foto, email, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('t�tulo'));
		setaFoco(titulo);
		erro = true;
	}
	if(endereco.value == ""){
		alert(retornaString('endere�o'));
		setaFoco(endereco);
		erro = true;
	}
	if(telefone.value == ""){
		alert(retornaString('telefone'));
		setaFoco(telefone);
		erro = true;
	}
	if(descricao.value == ""){
		alert(retornaString('descri��o'));
		setaFoco(descricao);
		erro = true;
	}
	if(acao != 'atualizar'){
		if(foto.value == ""){
			alert(retornaString('foto'));
			setaFoco(foto);
			erro = true;
		}
	}
	if(email.value != ""){
		if(email.value.indexOf('@') == -1 || email.value.indexOf('.') == -1){
			alert('O e-mail digitado n�o � valido');
			setaFoco(email);
			erro = true;
		}
	}
	if(erro == false){
		enviaForm(form);
	}
}

function pValDica(titulo, descricao, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('t�tulo'));
		setaFoco(titulo);
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

function pValServico(titulo, descricao, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('t�tulo'));
		setaFoco(titulo);
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