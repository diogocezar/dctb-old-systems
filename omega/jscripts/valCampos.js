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
	if (document.layers){
		Key = e.which;
	}
	else{
		Key = window.event.keyCode;
	}
	if (Key == 13){
		setaFoco(campoDestino);
	}
}

/* Envia formulario ao presionar enter */
function enviaFormNoEnter(form, e){
	if (document.layers){
		Key = e.which;
	}
	else{
		Key = window.event.keyCode;
	}
	if (Key == 13){
		enviaForm(form);
	}
}

/*
* Funções para enviar formulários da página principal e interna
*/

function exclui(form){
	form.action = "carrinho.php?acao=excluir";	
	enviaForm(form);
}

function atualiza(form){
	form.action = "carrinho.php?acao=atualizar";	
	enviaForm(form);
}

function addProduto(qtd, estoque, url){
	if(qtd.value == ""){
		qtd.value = 1;
	}
	if( (estoque.value * 1) >= (qtd.value * 1) ){
		if(qtd.value != ""){
			location.href = url+'&qtd='+qtd.value;
		}
		else{
			location.href = url;
		}
	}
	else{
		alert('Estoque insuficiente para atender o seu pedido.');	
	}
}

function entrar(usuario, senha, form){
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

function buscar(nome, form){
	var erro = false;
	
	if(nome.value != ""){
		if(nome.value.length < 3){
			alert('Digite um nome com pelo menos 3 caracteres.');
			setaFoco(nome);
			erro = true;
		}
	}
	if(erro == false){
		enviaForm(form);
	}
}

function news(email, form){
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

/*
* Envia o forumario somente se todos os campos passados como parâmeto estiverem preenchidos
* onclick = "validaForm(document.formulario.campo1, document.formulario.campo2, ... document.formulario.campoN, document.formulario)"
*/

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

function validaAdministrador(nome, sobre, email, login, senha, confi, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(sobre.value == ""){
		alert(retornaString('sobre nome'));
		setaFoco(sobre);
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

function validaAtor(nome, form){
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

function validaCategoria(nome, descricao, temp_loc, preco, form){
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
	if(temp_loc.value == ""){
		alert(retornaString('tempo de locação'));
		setaFoco(temp_loc);
		erro = true;
	}
	if(preco.value == ""){
		alert(retornaString('preço'));
		setaFoco(preco);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}


function validaClassificacao(classificacao, idade, form){
	var erro = false;

	if(classificacao.value == ""){
		alert(retornaString('classificação'));
		setaFoco(classificacao);
		erro = true;
	}
	if(idade.value == ""){
		alert(retornaString('idade recomendada'));
		setaFoco(idade);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaDiretor(nome, form){
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

function validaEnquete(pergunta, resposta1, resposta2, resposta3, resposta4, form){
	var erro = false;

	if(pergunta.value == ""){
		alert(retornaString('pergunta'));
		setaFoco(pergunta);
		erro = true;
	}
	if(resposta1.value == ""){
		alert(retornaString('resposta 1'));
		setaFoco(resposta1);
		erro = true;
	}
	if(resposta2.value == ""){
		alert(retornaString('resposta 2'));
		setaFoco(resposta2);
		erro = true;
	}
	if(resposta3.value == ""){
		alert(retornaString('resposta 3'));
		setaFoco(resposta3);
		erro = true;
	}
	if(resposta4.value == ""){
		alert(retornaString('resposta 4'));
		setaFoco(resposta4);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaFilme(titulo, titulo_ori, ano, duracao, sinopse, dist, lista1, lista2, lista3, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('título'));
		setaFoco(titulo);
		erro = true;
	}
	if(titulo_ori.value == ""){
		alert(retornaString('título original'));
		setaFoco(titulo_ori);
		erro = true;
	}
	if(ano.value == ""){
		alert(retornaString('ano'));
		setaFoco(ano);
		erro = true;
	}
	if(duracao.value == ""){
		alert(retornaString('duracao'));
		setaFoco(duracao);
		erro = true;
	}
	if(sinopse.value == ""){
		alert(retornaString('sinopse'));
		setaFoco(sinopse);
		erro = true;
	}
	if(dist.value == ""){
		alert(retornaString('distribuidora'));
		setaFoco(dist);
		erro = true;
	}
	if(erro == false){
		selecionaTodosLista(lista1)
		selecionaTodosLista(lista2)
		selecionaTodosLista(lista3)
		enviaForm(form);
	}
}

function validaGenero(nome, descricao, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
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

function validaMidia(codigo, audio, legenda, regiao, formato, form){
	var erro = false;
	
	if(codigo.value == ""){
		alert(retornaString('código'));
		setaFoco(codigo);
		erro = true;
	}
	if(audio.value == ""){
		alert(retornaString('audio'));
		setaFoco(audio);
		erro = true;
	}
	if(legenda.value == ""){
		alert(retornaString('legenda'));
		setaFoco(legenda);
		erro = true;
	}
	if(regiao.value == ""){
		alert(retornaString('região'));
		setaFoco(regiao);
		erro = true;
	}
	if(formato.value == ""){
		alert(retornaString('formato'));
		setaFoco(formato);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaNovidade(titulo, conteudo, form){
	var erro = false;
	
	if(titulo.value == ""){
		alert(retornaString('titulo'));
		setaFoco(titulo);
		erro = true;
	}
	if(conteudo.value == ""){
		alert(retornaString('conteúdo'));
		setaFoco(conteudo);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaProdutos(nome, qtd, preco, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(qtd.value == ""){
		alert(retornaString('quantidade'));
		setaFoco(qtd);
		erro = true;
	}
	if(preco.value == ""){
		alert(retornaString('preco'));
		setaFoco(preco);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaTipo(tipo, form){
	var erro = false;
	
	if(tipo.value == ""){
		alert(retornaString('tipo'));
		setaFoco(tipo);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaTx(localizacao, valor, form){
	var erro = false;
	
	if(localizacao.value == ""){
		alert(retornaString('localização'));
		setaFoco(localizacao);
		erro = true;
	}
	if(valor.value == ""){
		alert(retornaString('valor'));
		setaFoco(valor);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaFeriado(nome, data, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
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

/*
###################################################################
*/

function validaCadastro(nome, sobre, email, login, senha, confi, cpf, rg, rua, numero, bairro, telefone, nascimento, form){
	
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(sobre.value == ""){
		alert(retornaString('sobre nome'));
		setaFoco(sobre);
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
	if(rua.value == ""){
		alert(retornaString('rua'));
		setaFoco(rua);
		erro = true;
	}
	if(numero.value == ""){
		alert(retornaString('numero'));
		setaFoco(numero);
		erro = true;
	}
	if(bairro.value == ""){
		alert(retornaString('bairro'));
		setaFoco(bairro);
		erro = true;
	}
	if(telefone.value == ""){
		alert(retornaString('telefone'));
		setaFoco(telefone);
		erro = true;
	}
	if(nascimento.value == ""){
		alert(retornaString('data de nascimento'));
		setaFoco(nascimento);
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

/*
###################################################################
*/

function validaContato(nome, email, telefone, cidade, comentario, form){
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
	if(telefone.value == ""){
		alert(retornaString('telefone'));
		setaFoco(telefone);
		erro = true;
	}	
	if(cidade.value == ""){
		alert(retornaString('cidade'));
		setaFoco(cidade);
		erro = true;
	}	
	if(comentario.value == ""){
		alert(retornaString('comentario'));
		setaFoco(comentario);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function redefineContato(nome, email, telefone, cidade, comentario){
	nome.value = "";
	email.value = "";
	telefone.value = "";
	cidade.value = "";
	comentario.value = "";
}

/*
###################################################################
*/

/* Verifica se o arquivo tem extensão .xls
 * arquivo - Arquivo com a extensão.
 */
function isArquivosXls(arquivo) {
	arquivo = arquivo.substring(arquivo.length - 6, arquivo.length);
	indice = arquivo.indexOf(".");
	extMasc = new String(arquivo.slice(indice, arquivo.length));
	
	if (extMasc != ".xls") {
		alert("Formato de arquivo inválido.");
		return false;
	}
	
	return true;
}

/* Limita o número de carecteres digitado em um textArea.
 * obj - Campo textarea.
 * tam - Tamanho máximo de catacteres permitidos.
 */
function fctTamCaracter_JS(obj, tam) { 
	if ((obj.value.length + 1) > tam) {
		alert("Você ultrapassou o limite de caracteres permitido pelo campo.\nReformule novamente o texto.");
	}
	if (obj.value.length == tam) { 
		window.event.keyCode = 0;
	}
}

/* Limita o número de caracteres colados no textArea.
 * obj - Campo textarea.
 * tam - Tamanho máximo de catacteres permitidos na colagem.
 */
function fctLimitaColar_JS(obj, tam) { 
	if (obj.value.length > tam) { 
		alert("O texto a colar é maior do que o restante permitido como entrada.");
		obj.value = obj.value.substring(0,tam);
	}
}

function FormataValor(campo,tammax,teclapres,st,tamdecimal) {

    /*
     * Caso tamdecimal seja nulo, assume-se 4 casas decimais
     */
    if (tamdecimal == null) { 
       tamdecimal = 4;
    }
    
    if (st == null) {
       st = 1;
    }

	/*
	 * Verifica a variável st, caso seja 1, formata com casas
	 * decimais, caso seja 2, formata sem casas decimais
	 */
    switch (st) {
    	case 1: FormataNumerosDecimais(campo,tammax,teclapres,tamdecimal); break;
    	case 2: FormataNumerosInteiros(campo,tammax,teclapres); break;
    	default: teclapres.returnValue = false;
    }
}

/**
 * Formata dados como porcentagem
 */
 
function FormataPorcentagem(campo,tammax,teclapres) {
	var tecla = teclapres.keyCode;
	vr = campo.value;
	vr = vr.replace( ",", "" );
	vr = vr.replace( ".", "" );
	vr = vr.replace( "%", "" );
	if (vr.indexOf('0') == 0){
		vr = vr.substring(1, vr.length);
		if (vr.indexOf('0') == 0){
			vr = vr.substring(1, vr.length);
		}
	}

	tam = vr.length;
	
	if (tam >= tammax) {
		teclapres.returnValue = false;
		return; 
	}
	
	if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

	if (tecla == 8 ){  vr = vr.substring(0, vr.length-1); }

	if ( (tecla == 8) || (tecla >= 48 && tecla <= 57) ){
		if ( tam < 2 ){
	 		campo.value = '0,0' + vr + String.fromCharCode(teclapres.keyCode) ; }
		if ( tam == 2 ){
	 		campo.value = '0,' + vr + String.fromCharCode(teclapres.keyCode) ; }
	 	if ( tam >= 3 ){
	 		campo.value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam ) + String.fromCharCode(teclapres.keyCode) ; }
	}
	teclapres.returnValue = false;
}

/*
 * Verifica se o valor passado é valido para uma formula ou condição.
 */
function isCaraceterValidoFormulas(valor) {
	if (valor == '[' || valor == ']' || valor == '{' || valor == '}' || valor == ' ') {
		return false;
	} else {
		return true;
	}
}

/*
 * Verifica se o idêntificador da fórmula é valido.
 */
function isIdFormulaValido(valor) {
	id = new String(valor);
	if (id.charAt(0) == '@' && valor.indexOf("@", 1) == -1) {
		return true;
	} else {
		alert('Identificador de fórmula inválido');
		return false;
	}
}

/* Verifica se o arquivo tem extensão de imagem suportado pelo IE
 * arquivo - Arquivo com a extensão.
 */
function isArquivoImagem(arquivo) {
	arquivo = arquivo.substring(arquivo.length - 6, arquivo.length);
	indice = arquivo.indexOf(".");
	ext = new String(arquivo.slice(indice, arquivo.length));
	if (ext == ".bmp") {
		return true;				
	}
	else {
		if (ext == ".jpeg") {
			return true;				
		}
		else {
			if (ext == ".jpg") {
				return true;
			}
			else {
				if (ext == ".gif") {
					return true;
				}
				else {
					if (ext ==".png") {
						return true;
					}
				}
			}
		}
	}
	alert("Formato de arquivo inválido.");
	return false;
}


/*
 *Valida checkbox
 */
function ValidaCheckboxObr(formName, nomeCampo){
	var form = document.forms[formName];
	obj=form.elements[nomeCampo];
	for (counter = 0; counter < obj.length; counter++){
		if (!obj[0].checked)
		{ 
			alert("Verifique se o campo obrigatorio está selecionado");
			return false;
		}
	}
		return true;
}

/*
 * Formata números com casas decimais
 * Parâmetros de entrada:
 *    campo:      campo a ser formatado.
 *    tammax:     não é necessário passar valor.
 *    teclapres:  evento relacionado ao campo.
 *    tamdecimal: não é necessário passar valor.
 * Ex. de como usar:
 *    onkeypress="FormataNumerosDecimais(this, 0, event, 0)" onkeydown="backspace(this, event)"
 * **Obs. usar junto com a função backspace.
 */
 
function FormataNumerosDecimais(campo,tammax,teclapres,tamdecimal) {
	if (campo.value.length < campo.maxLength)  {
		reais(campo, teclapres);
	} else {
		teclapres.returnValue = false;
	}
}

documentall = document.all;

function formatamoney(c) {
    var t = this; if(c == undefined) c = 2;		
    var p, d = (t=t.split("."))[1].substr(0, c);
    for(p = (t = t[0]).length; (p -= 3) >= 1;) {
	        t = t.substr(0, p) + "." + t.substr(p);
    }
    return t + "," + d + Array(c + 1 - d.length).join(0);
}

String.prototype.formatCurrency=formatamoney

/*
 * Se currency é false, retorna o valor sem apenas com os números. Se é
 * true, os dois últimos caracteres são considerados as casas decimais.
 */
 
function demaskvalue(valor, currency){
	var val2 = '';
	var strCheck = '0123456789';
	var len = valor.length;
	if (len== 0){
		return 0.00;
	}
	if (currency ==true) {	

		/* Elimina os zeros à esquerda a variável  <i> passa a ser a 
		 * localização do primeiro caractere após os zeros e val2 contém 
		 * os caracteres (descontando os zeros à esquerda).
		 */
		
		for(var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ',')) break;
		
		for(; i < len; i++) {
			if (strCheck.indexOf(valor.charAt(i)) != -1) val2 += valor.charAt(i);
		}

		if (val2.length==0) return "0.00";
		if (val2.length==1) return "0.0" + val2;
		if (val2.length==2) return "0." + val2;
		
		var parte1 = val2.substring(0, val2.length - 2);
		var parte2 = val2.substring(val2.length - 2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;
		
	} else {
			/* currency é false: retornamos os valores COM os zeros à 
			 * esquerda, sem considerar os últimos 2 algarismos como 
			 * casas decimais .
			 */
			val3 = "";
			for (var k = 0; k < len; k++) {
				if (strCheck.indexOf(valor.charAt(k)) != -1) val3 += valor.charAt(k);
			}			
	return val3;
	}
}

function reais(obj,event){
	
	var whichCode = (window.Event) ? event.which : event.keyCode;
	
	/*
	 *	Executa a formatação após o backspace nos navegadores !document.all
	 */
	
	if (whichCode == 8 && !documentall) {	
	
	/*
	 *Previne a ação padrão nos navegadores
	 */
		if (event.preventDefault){ //standart browsers
				event.preventDefault();
			}else{ // internet explorer
				event.returnValue = false;
		}
		var valor = obj.value;
		var x = valor.substring(0,valor.length-1);
		obj.value= demaskvalue(x,true).formatCurrency();
		return false;
	}
	
	/*
	 *Executa o Formata Reais e faz o format currency novamente após o backspace
	 */
	
	FormataReais(obj,'.',',',event);
	
}

/*
 * Essa função basicamente altera o  backspace nos input com máscara 
 * reais para os navegadores IE e opera. O IE não detecta o keycode 8 no
 * evento keypress, por isso, tratamos no keydown. Como o opera suporta
 * o infame document.all, tratamos dele na mesma parte do código.
 */

function backspace(obj,event){
	var whichCode = (window.Event) ? event.which : event.keyCode;
	if (whichCode == 8 && documentall) {	
		var valor = obj.value;
		var x = valor.substring(0, valor.length-1);
		var y = demaskvalue(x, true).formatCurrency();
		obj.value = ""; //necessário para o opera
		obj.value += y;
		if (event.preventDefault){ //standart browsers
				event.preventDefault();
			}else{ // internet explorer
				event.returnValue = false;
		}
		return false;
	}
}

function FormataReais(fld, milSep, decSep, e) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;
	
	//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown
	if (whichCode == 0 ) return true;
	if (whichCode == 9 ) return true;  //tecla tab
	if (whichCode == 13) return true;  //tecla enter
	if (whichCode == 16) return true;  //shift internet explorer
	if (whichCode == 17) return true;  //control no internet explorer
	if (whichCode == 27 ) return true; //tecla esc
	if (whichCode == 34 ) return true; //tecla end
	if (whichCode == 35 ) return true; //tecla end
	if (whichCode == 36 ) return true; //tecla home

	/*
	 * O trecho abaixo previne a ação padrão nos navegadores. Não 
	 * estamos inserindo o caractere normalmente, mas via script.
	 */

	if (e.preventDefault){ //standart browsers
			e.preventDefault()
	}else{ // internet explorer
			e.returnValue = false
	}

	var key = String.fromCharCode(whichCode);  // Valor para o código da Chave
	if (strCheck.indexOf(key) == -1) return false;  // Chave inválida
	
	/*
	 * Concatenamos ao value o keycode de key, se esse for um número
	 */
	fld.value += key;
	var len = fld.value.length;
	var bodeaux = demaskvalue(fld.value, true).formatCurrency();
	fld.value=bodeaux;
	
	/*
	 * Essa parte da função tão somente move o cursor para o final no 
	 * opera. Atualmente não existe como movê-lo no konqueror.
	 */
	if (fld.createTextRange) {
		var range = fld.createTextRange();
		range.collapse(false);
		range.select();
	} else if (fld.setSelectionRange) {
	    fld.focus();
	    var length = fld.value.length;
	    fld.setSelectionRange(length, length);
	}
	return false;	
}

/*
 * Formata números sem casas decimais
 */
 
function FormataNumerosInteiros(campo,tammax,teclapres) {
	var tecla = teclapres.keyCode;
	
	vr = campo.value;
	vr = vr.replace( ".", "" );
	tam = vr.length;

	if (tam >= tammax) {
		teclapres.returnValue = false;
		return; 
	}
	
	if (tam < tammax && tecla != 8) { 
	   tam = vr.length + 1 ;
	}

	if (tecla == 8 ){	tam = tam - 1 ; }

	if ((tecla == 8) || (tecla >= 48 && tecla <= 57)) {
	    
	 	if ( tam < 3) {
	 	   campo.value = vr;
	 	} else {
	 	   if ((tam > 3) && (tam <=6)) {
	 	      campo.value = vr.substr(0, (tam - 3)) + '.' + vr.substr((tam - 3), tam);
	 	   }
	 	}	 	
	} else {
		teclapres.returnValue = false;
	}
}


/*
 * Formata qualquer tipo de máscara com tamanho fixo passada como parâmetro
 * Gécen Ex. de como usar: onkeypress="formatAll(this, '###.###.###-##')"
 * Recomenda-se não usar diretamente crie sua própria função de mascara
 * pode seguir como exemplo formatCep
 */
function formatAll(src, mask) {
	var i = src.value.length;
	var saida = mask.substring(i,i+1);
	var ascii = event.keyCode;
    if (saida == "#") {
		return;
	} 
	else {
		src.value += saida;
		i += 1
		saida = mask.substring(i,i+1);
		return; 
	}
	
}


/*
 * Verifica se a tecla digitada é um número
 * Gécen
 */
function isNum(obj,event)
{
    var str = obj.value;
    var Tecla = event.which;
    if(Tecla == null)
        Tecla = event.keyCode;

    if ( Tecla < 48 || Tecla > 59 ){
        event.returnValue = false;
		alert("Só devem ser digitados números!")
        return false;
    }
    event.returnValue = true;
    return true;
}

/*
 * Mascara de Cep
 * Gécen, Ex. de como usar: onkeypress="formatCep(this,event)"
 */
function formatCep(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##.###-###')
	}
}

/*
 * Mascara de CNPJ
 * Gécen, Ex. de como usar: onkeypress="formatCNPJ(this,event)"
 */
function formatCNPJ(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##.###.###/####-##')
	}	
}

/*
 * Máscara de CPF
 * Ex. de como usar: onkeypress="formatCPF(this, event)"
 */
function formatCPF(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '###.###.###-##');
	}
}

/*
 * Máscara de data 
 * Ex. de como usar: onkeypress="formatDate(this, event)"
 */
function formatDate(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '##/##/####');
	}
}

/*
 * Mascara de fone
 * Gécen, Ex. de como usar: onkeypress="formatFone(this,event)"
 */
function formatFone(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##-####-####')
	}	
}

/*
 * Remove um determinado caractere de uma string
 * Gécen
 */
function cleanStr(str, chare)
{
  while((cx=str.indexOf(chare))!=-1)
  {		
    str = str.substring(0,cx)+str.substring(cx+1);
  }
  return(str);
}

/*
* Formata o valor com pontos a cada 3 casas
*/

function formatPoint(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '###.###.###');
	}
}

/*
* Remove os pontos
* deve-se utilizar juntamente com a função formatPoint(obj, event)
* mais sua chamada deve ser feita no evento onkeypress
**/

function removePoint(obj, event){
	var tecla = event.keyCode;
	value = obj.value;
	if (tecla == 8 && obj != null && value.charAt(value.length - 2) == '.') {
		obj.value = value.substring(0, value.length - 1);
	}
}
/*
 * Remove todos os caracteres de mascara
 * Gécen
 */
function cleanMask(str)
{
  str = cleanStr(str,'-');
  str = cleanStr(str,'/');
  str = cleanStr(str,',');
  str = cleanStr(str,'.');
  str = cleanStr(str,'(');
  str = cleanStr(str,')');
  str = cleanStr(str,' ');
  return str;
  
}

/*
 * Valida checkbox, verificando se ele é nulo.
 * checkbox - objeto a ser validado.
 * msg - mensagem a ser exibida ao usuário.
 */
function selectCheckbox(checkbox, msg) 
{
	var obj = checkbox;
	var exe = null;
	for (var i = 0; i < obj.length; i++) {
		if (obj[i].checked) {
			exe += 'a';
		}
	}
	if (exe == null) {
		alert('Selecione um ' + msg);
	}
	return;
}