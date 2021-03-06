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
	
	formataReais(obj,'.',',',event);
	
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

function formataReais(fld, milSep, decSep, e) {
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
function formatAll(src, mask, event) {
	var i = src.value.length;
	var saida = mask.substring(i,i+1);
	var ascii = event.keyCode;
    if (saida == "#" || ascii == 8) {
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
    var tecla = event.which;
    if(tecla == null)
        tecla = event.keyCode;
    if (tecla < 48 || tecla > 59){
		if(tecla != 8 && tecla != 0){
			// impede que a tecla seja escrita no txtfield
			event.preventDefault();
			event.returnValue = false;
			alert("S� devem ser digitados n�meros!");
			return false;
		}
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
		formatAll(obj, '##.###-###', event)
	}
}

/*
 * Mascara de Hora
 * G�cen, Ex. de como usar: onkeypress="formatHora(this,event)"
 */
function formatHora(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##:##', event)
	}
}

/*
 * Mascara de CNPJ
 * G�cen, Ex. de como usar: onkeypress="formatCNPJ(this,event)"
 */
function formatCNPJ(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##.###.###/####-##', event)
	}	
}

/*
 * M�scara de Inscri��o Estadual
 * Ex. de como usar: onkeypress="formatIE(this, event)"
 */
function formatIE(obj, event) {
	isNum(obj, event);
}

/*
 * M�scara de N�mero de Benef�cio
 * Ex. de como usar: onkeypress="formatNB(this, event)"
 */
function formatNB(obj, event) {
	if (isNum(obj, event)){
		formatAll(obj, '###.###.###-#', event)
	}	
}

/*
 * M�scara de Inscri��o Municipal
 * Ex. de como usar: onkeypress="formatIM(this, event)"
 */
function formatIM(obj, event) {
	isNum(obj, event);
}

/*
 * M�scara de Registro Geral
 * Ex. de como usar: onkeypress="formatRG(this, event)"
 */
function formatRG(obj, event) {
	isNum(obj, event);
}

/*
 * M�scara de CPF
 * Ex. de como usar: onkeypress="formatCPF(this, event)"
 */
function formatCPF(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '###.###.###-##', event);
	}
}

/*
 * M�scara de data 
 * Ex. de como usar: onkeypress="formatDate(this, event)"
 */
function formatDate(obj, event) {
	if (isNum(obj, event)) {
		formatAll(obj, '##/##/####', event);
	}
}

/*
 * Mascara de fone
 * G�cen, Ex. de como usar: onkeypress="formatFone(this,event)"
 */
function formatFone(obj, event){
	if (isNum(obj, event)){
		formatAll(obj, '##-####-####', event)
	}	
}

/*
 * Remove um determinado caractere de uma string
 * G�cen
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