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

function sifinValLogin(login, senha, form){
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

function sifinValUsuario(nome, login, senha, form){
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
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValNivel(descricao, form){
	var erro = false;

	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValBanco(descricao, form){
	var erro = false;

	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValTipoDocumento(descricao, form){
	var erro = false;

	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValPeriodicidade(descricao, qtdnumerico, form){
	var erro = false;

	if(descricao.value == ""){
		alert(retornaString('descrição'));
		setaFoco(descricao);
		erro = true;
	}
	if(qtdnumerico.value == ""){
		alert(retornaString('quantidade numérica'));
		setaFoco(qtdnumerico);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValPessoa(endereco, bairro, cidade, cep, fone, fax, site, form){
	var erro = false;

	if(endereco.value == ""){
		alert(retornaString('endereço'));
		setaFoco(endereco);
		erro = true;
	}
	if(bairro.value == ""){
		alert(retornaString('bairro'));
		setaFoco(bairro);
		erro = true;
	}
	if(cidade.value == ""){
		alert(retornaString('cidade'));
		setaFoco(cidade);
		erro = true;
	}
	if(cep.value == ""){
		alert(retornaString('cep'));
		setaFoco(cep);
		erro = true;
	}
	if(fone.value == ""){
		alert(retornaString('telefone'));
		setaFoco(fone);
		erro = true;
	}
	if(fax.value == ""){
		alert(retornaString('fax'));
		setaFoco(fax);
		erro = true;
	}
	if(site.value == ""){
		alert(retornaString('site'));
		setaFoco(site);
		erro = true;
	}	
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValPessoafisica(cpf, rg, nome, sobrenome, endereco, bairro, cidade, cep, fone, fax, site, form){
	var erro = false;

	if(cpf.value == ""){
		alert(retornaString('cpf'));
		setaFoco(cpf);
		erro = true;
	}
	if(rg.value == ""){
		alert(retornaString('rg'));
		setaFoco(rg);
		erro = true;
	}
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(sobrenome.value == ""){
		alert(retornaString('sobrenome'));
		setaFoco(sobrenome);
		erro = true;
	}	
	if(erro == false){
		sifinValPessoa(endereco, bairro, cidade, cep, fone, fax, site, form);
	}	
}

function sifinValPessoajuridica(cnpj, inscricaoestadual, inscricaomunicipal, razaosocial, nomefantasia, compramin, endereco, bairro, cidade, cep, fone, fax, site, form){
	var erro = false;

	if(cnpj.value == ""){
		alert(retornaString('cnpj'));
		setaFoco(cnpj);
		erro = true;
	}
	if(inscricaoestadual.value == ""){
		alert(retornaString('inscrição estadual'));
		setaFoco(inscricaoestadual);
		erro = true;
	}
	if(inscricaomunicipal.value == ""){
		alert(retornaString('inscrição municipal'));
		setaFoco(inscricaomunicipal);
		erro = true;
	}
	if(razaosocial.value == ""){
		alert(retornaString('razão social'));
		setaFoco(razaosocial);
		erro = true;
	}	
	if(nomefantasia.value == ""){
		alert(retornaString('nome fantasia'));
		setaFoco(nomefantasia);
		erro = true;
	}
	if(compramin.value == ""){
		alert(retornaString('compramin'));
		setaFoco(compramin);
		erro = true;
	}
	if(erro == false){
		sifinValPessoa(endereco, bairro, cidade, cep, fone, fax, site, form);
	}	
}

function sifinValContato(nome, email, form){
	var erro = false;
	
    var comboPf = document.getElementById('comboPessoaFisica');
    var comboPj = document.getElementById('comboPessoaJuridica');
	
	if(comboPf.disabled == true && comboPj.disabled == true){
		alert('Selecione uma pessoa física ou jurídica.');
		erro = true;
	}
	
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
	if(erro == false){
		enviaForm(form);
	}	
}

function sifinValConta(documento, descricao, form){
	var erro = false;
	
    var comboPf = document.getElementById('comboPessoaFisica');
    var comboPj = document.getElementById('comboPessoaJuridica');
	
	if(comboPf.disabled == true && comboPj.disabled == true){
		alert('Selecione uma pessoa física ou jurídica.');
		erro = true;
	}
	
	if(gerouParcelas == false){
		alert('Gere as parcelas para cadastrar uma conta.');
		erro = true;
	}
	
	if(documento.value == ""){
		alert(retornaString('documento'));
		setaFoco(documento);
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