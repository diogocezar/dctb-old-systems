/* Coloca o foco em um campo passado como par�metro */
function setaFoco(campo){
	campo.focus();
}

/* Retorna uma string de erro */
function retornaString(msgstr){
	return("O campo " + msgstr + " est� vazio");
}

/* Envia um formul�rio */
function enviaForm(form){
	form.submit();	
}

/* Coloca o foco no proximo campo ao presisonar enter */
function pulaCampoNoEnter(campoDestino, e){
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
* Envia o forumario somente se todos os campos passados como par�meto estiverem preenchidos
* onclick = "validaForm(document.formulario.campo1, document.formulario.campo2, ... document.formulario.campoN, document.formulario)"
*/

function validaAlterar(senha, nova_senha, confima_senha, form){
	var erro = false;
	
	if(senha.value == ""){
		alert(retornaString('senha'));
		setaFoco(senha);
		erro = true;
	}
	if(nova_senha.value == ""){
		alert(retornaString('nova senha'));
		setaFoco(nova_senha);
		erro = true;
	}
	if(confima_senha.value == ""){
		alert(retornaString('confirma��o de senha'));
		setaFoco(confima_senha);
		erro = true;
	}
	if(confima_senha.value != nova_senha.value){
		alert('As senhas digitadas n�o s�o iguais');
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaCurso(nome, inicio, termino, periodo_insc, periodo_matr, turno, vagas, taxa, matricula, mensalidade, apresentacao, objetivos, certificado, resumo, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(inicio.value == ""){
		alert(retornaString('in�cio do curso'));
		setaFoco(inicio);
		erro = true;
	}
	if(termino.value == ""){
		alert(retornaString('t�rmino do curso'));
		setaFoco(termino);
		erro = true;
	}
	if(periodo_insc.value == ""){
		alert(retornaString('per�odo de inscri��o'));
		setaFoco(periodo_insc);
		erro = true;
	}
	if(periodo_matr.value == ""){
		alert(retornaString('per�odo de matr�cula'));
		setaFoco(periodo_matr);
		erro = true;
	}
	if(turno.value == ""){
		alert(retornaString('turno'));
		setaFoco(turno);
		erro = true;
	}
	if(vagas.value == ""){
		alert(retornaString('vagas'));
		setaFoco(vagas);
		erro = true;
	}
	if(taxa.value == ""){
		alert(retornaString('taxa de inscri��o'));
		setaFoco(taxa);
		erro = true;
	}
	if(matricula.value == ""){
		alert(retornaString('matricula'));
		setaFoco(matricula);
		erro = true;
	}
	if(mensalidade.value == ""){
		alert(retornaString('mensalidade'));
		setaFoco(mensalidade);
		erro = true;
	}
	if(apresentacao.value == ""){
		alert(retornaString('apresentacao'));
		setaFoco(apresentacao);
		erro = true;
	}
	if(objetivos.value == ""){
		alert(retornaString('objetivos'));
		setaFoco(objetivos);
		erro = true;
	}
	if(certificado.value == ""){
		alert(retornaString('certificado'));
		setaFoco(certificado);
		erro = true;
	}
	if(resumo.value == ""){
		alert(retornaString('resumo'));
		setaFoco(resumo);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaContato(nome, email, form){
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
	if(erro == false){
		enviaForm(form);
	}
}

function validaNoticia(titulo, conteudo, form){
	var erro = false;

	if(titulo.value == ""){
		alert(retornaString('titulo'));
		setaFoco(titulo);
		erro = true;
	}
	if(conteudo.value == ""){
		alert(retornaString('conteudo'));
		setaFoco(conteudo);
		erro = true;
	}
	if(erro == false){
		enviaForm(form);
	}
}

function validaDisciplina(nome, carga, descricao, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
	}
	if(carga.value == ""){
		alert(retornaString('carga'));
		setaFoco(carga);
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

function validaProfessor(nome, email, form){
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

function validaAdm(nome, login, senha, email, form){
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
	if(erro == false){
		enviaForm(form);
	}
}

function validaInscricao(nome, cpf, rg, orgaoEmissor, data_nascimento, rua, numero, bairro, cidade, cep, telefone, email, form){
	var erro = false;
	
	if(nome.value == ""){
		alert(retornaString('nome'));
		setaFoco(nome);
		erro = true;
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
	if(orgaoEmissor.value == ""){
		alert(retornaString('org�o emissor'));
		setaFoco(orgaoEmissor);
		erro = true;
	}
	if(data_nascimento.value == ""){
		alert(retornaString('data de nacimento'));
		setaFoco(data_nascimento);
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
	if(telefone.value == ""){
		alert(retornaString('telefone'));
		setaFoco(telefone);
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
	if(erro == false){
		enviaForm(form);
	}
}

/*
###################################################################
*/

/* Verifica se o arquivo tem extens�o .xls
 * arquivo - Arquivo com a extens�o.
 */
function isArquivosXls(arquivo) {
	arquivo = arquivo.substring(arquivo.length - 6, arquivo.length);
	indice = arquivo.indexOf(".");
	extMasc = new String(arquivo.slice(indice, arquivo.length));
	
	if (extMasc != ".xls") {
		alert("Formato de arquivo inv�lido.");
		return false;
	}
	
	return true;
}

/* Limita o n�mero de carecteres digitado em um textArea.
 * obj - Campo textarea.
 * tam - Tamanho m�ximo de catacteres permitidos.
 */
function fctTamCaracter_JS(obj, tam) { 
	if ((obj.value.length + 1) > tam) {
		alert("Voc� ultrapassou o limite de caracteres permitido pelo campo.\nReformule novamente o texto.");
	}
	if (obj.value.length == tam) { 
		window.event.keyCode = 0;
	}
}

/* Limita o n�mero de caracteres colados no textArea.
 * obj - Campo textarea.
 * tam - Tamanho m�ximo de catacteres permitidos na colagem.
 */
function fctLimitaColar_JS(obj, tam) { 
	if (obj.value.length > tam) { 
		alert("O texto a colar � maior do que o restante permitido como entrada.");
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
	 * Verifica a vari�vel st, caso seja 1, formata com casas
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
 * Verifica se o valor passado � valido para uma formula ou condi��o.
 */
function isCaraceterValidoFormulas(valor) {
	if (valor == '[' || valor == ']' || valor == '{' || valor == '}' || valor == ' ') {
		return false;
	} else {
		return true;
	}
}

/*
 * Verifica se o id�ntificador da f�rmula � valido.
 */
function isIdFormulaValido(valor) {
	id = new String(valor);
	if (id.charAt(0) == '@' && valor.indexOf("@", 1) == -1) {
		return true;
	} else {
		alert('Identificador de f�rmula inv�lido');
		return false;
	}
}

/* Verifica se o arquivo tem extens�o de imagem suportado pelo IE
 * arquivo - Arquivo com a extens�o.
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
	alert("Formato de arquivo inv�lido.");
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
			alert("Verifique se o campo obrigatorio est� selecionado");
			return false;
		}
	}
		return true;
}

/*
 * Formata n�meros com casas decimais
 * Par�metros de entrada:
 *    campo:      campo a ser formatado.
 *    tammax:     n�o � necess�rio passar valor.
 *    teclapres:  evento relacionado ao campo.
 *    tamdecimal: n�o � necess�rio passar valor.
 * Ex. de como usar:
 *    onkeypress="FormataNumerosDecimais(this, 0, event, 0)" onkeydown="backspace(this, event)"
 * **Obs. usar junto com a fun��o backspace.
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
 * Se currency � false, retorna o valor sem apenas com os n�meros. Se �
 * true, os dois �ltimos caracteres s�o considerados as casas decimais.
 */
 
function demaskvalue(valor, currency){
	var val2 = '';
	var strCheck = '0123456789';
	var len = valor.length;
	if (len== 0){
		return 0.00;
	}
	if (currency ==true) {	

		/* Elimina os zeros � esquerda a vari�vel  <i> passa a ser a 
		 * localiza��o do primeiro caractere ap�s os zeros e val2 cont�m 
		 * os caracteres (descontando os zeros � esquerda).
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
			/* currency � false: retornamos os valores COM os zeros � 
			 * esquerda, sem considerar os �ltimos 2 algarismos como 
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
	 *	Executa a formata��o ap�s o backspace nos navegadores !document.all
	 */
	
	if (whichCode == 8 && !documentall) {	
	
	/*
	 *Previne a a��o padr�o nos navegadores
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
	 *Executa o Formata Reais e faz o format currency novamente ap�s o backspace
	 */
	
	FormataReais(obj,'.',',',event);
	
}

/*
 * Essa fun��o basicamente altera o  backspace nos input com m�scara 
 * reais para os navegadores IE e opera. O IE n�o detecta o keycode 8 no
 * evento keypress, por isso, tratamos no keydown. Como o opera suporta
 * o infame document.all, tratamos dele na mesma parte do c�digo.
 */

function backspace(obj,event){
	var whichCode = (window.Event) ? event.which : event.keyCode;
	if (whichCode == 8 && documentall) {	
		var valor = obj.value;
		var x = valor.substring(0, valor.length-1);
		var y = demaskvalue(x, true).formatCurrency();
		obj.value = ""; //necess�rio para o opera
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
	
	//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra fun��o no keydown
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
	 * O trecho abaixo previne a a��o padr�o nos navegadores. N�o 
	 * estamos inserindo o caractere normalmente, mas via script.
	 */

	if (e.preventDefault){ //standart browsers
			e.preventDefault()
	}else{ // internet explorer
			e.returnValue = false
	}

	var key = String.fromCharCode(whichCode);  // Valor para o c�digo da Chave
	if (strCheck.indexOf(key) == -1) return false;  // Chave inv�lida
	
	/*
	 * Concatenamos ao value o keycode de key, se esse for um n�mero
	 */
	fld.value += key;
	var len = fld.value.length;
	var bodeaux = demaskvalue(fld.value, true).formatCurrency();
	fld.value=bodeaux;
	
	/*
	 * Essa parte da fun��o t�o somente move o cursor para o final no 
	 * opera. Atualmente n�o existe como mov�-lo no konqueror.
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
 * Formata n�meros sem casas decimais
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
 * Formata qualquer tipo de m�scara com tamanho fixo passada como par�metro
 * G�cen Ex. de como usar: onkeypress="formatAll(this, '###.###.###-##')"
 * Recomenda-se n�o usar diretamente crie sua pr�pria fun��o de mascara
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
 * Verifica se a tecla digitada � um n�mero
 * G�cen
 */
function isNum(obj,event)
{
    var str = obj.value;
    var Tecla = event.which;
    if(Tecla == null)
        Tecla = event.keyCode;

    if ( Tecla < 48 || Tecla > 59 ){
        event.returnValue = false;
		alert("S� devem ser digitados n�meros!")
        return false;
    }
    event.returnValue = true;
    return true;
}

/*
 * Mascara de Cep
 * G�cen, Ex. de como usar: onkeypress="formatCep(this,event)"
 */
function formatCep(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##.###-###')
	}
}

/*
 * Mascara de CNPJ
 * G�cen, Ex. de como usar: onkeypress="formatCNPJ(this,event)"
 */
function formatCNPJ(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##.###.###/####-##')
	}	
}

/*
 * M�scara de CPF
 * Ex. de como usar: onkeypress="formatCPF(this, event)"
 */
function formatCPF(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '###.###.###-##');
	}
}

/*
 * M�scara de data 
 * Ex. de como usar: onkeypress="formatDate(this, event)"
 */
function formatDate(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '##/##/####');
	}
}

/*
 * Mascara de fone
 * G�cen, Ex. de como usar: onkeypress="formatFone(this,event)"
 */
function formatFone(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##-####-####')
	}	
}

/*
 * Remove um determinado caractere de uma string
 * G�cen
 */
function cleanStr(str, char)
{
  while((cx=str.indexOf(char))!=-1)
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
* deve-se utilizar juntamente com a fun��o formatPoint(obj, event)
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
 * G�cen
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
 * Valida checkbox, verificando se ele � nulo.
 * checkbox - objeto a ser validado.
 * msg - mensagem a ser exibida ao usu�rio.
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