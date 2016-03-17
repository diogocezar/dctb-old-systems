/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Conjunto de funções utilizadas em todo o site
*/

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

/* Funções para BBCODE */

function getMozSelection(txtarea) {
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd==1 || selEnd==2) selEnd=selLength;
	return (txtarea.value).substring(selStart, selEnd);
}

function mozWrap(txtarea, lft, rgt) {
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd==1 || selEnd==2) selEnd=selLength;
	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + lft + s2 + rgt + s3;
}

function IEWrap(lft, rgt) {
	strSelection = document.selection.createRange().text;
	if (strSelection!="") {
	document.selection.createRange().text = lft + strSelection + rgt;
	}
}

function wrapSelection(txtarea, lft, rgt) {
	if (document.all) {IEWrap(lft, rgt);}
	else if (document.getElementById) {mozWrap(txtarea, lft, rgt);}
}
function wrapSelectionWithLink(txtarea) {
	var my_link = prompt("Adicione a url:","http://");
	if (my_link != null) {
		lft="[URL=" + my_link + ":FECHA]";
		rgt="[/URL]";
		wrapSelection(txtarea, lft, rgt);
	}
	return;
}

function wrapSelectionWithImg(txtarea) {
	var my_link = prompt("Adicione a imagem:","http://");
	if (my_link != null) {
		lft="[IMG]" + my_link + "[/IMG]";
		txtarea.value += lft;
	}
	return;
}	

function Limpa(txtarea){
	txtarea.value = '';
}

/* Fim das funções BBCODE */

/* Funções para Inserção na ListBox */

function adicionaLista(opcao, lista){
	
	opcao = document.getElementById(opcao);
	lista = document.getElementById(lista);
	achou = false;
	
	/* Procura pelo elemento */
	for(i=0; i<lista.length; i++){
		if(lista.item(i).value == opcao.value){
			achou = true;
		}
	}
	
	if(achou == false){	
		var obj = document.createElement("OPTION");
		var val = opcao.item(opcao.selectedIndex).value;
		var txt = opcao.item(opcao.selectedIndex).text;
		obj.value = val;
		obj.text = txt;
		//lista.add(obj);
		try {
        	lista.add(obj, null);
    	}
    	catch(ex) {
      		lista.add(obj); // IE only
    	}
	}
}
function retiraLista(lista){
	lista = document.getElementById(lista);
	if(lista.selectedIndex > -1){
		lista.remove(lista.selectedIndex);
	}
	else{
		alert("Seleciona uma opção para ser removida");
	}
}
function selecionaTodosLista(lista){
	lista = document.getElementById(lista);
	for(i=0; i< lista.length; i++){
		lista.item(i).selected = true;
	}
}
function desmarcaTodosLista(lista){
	lista = document.getElementById(lista);
	for(i=0; i< lista.length; i++){
		lista.item(i).selected = false;
	}
}
/* Fim das funções para a ListBox */


function goCombo(combo, page){
	opcao = document.getElementById(combo);
	if(opcao.value != '#'){
		document.location.href=page+'?id='+opcao.value;
	}
}

/* Função para janela Poup-Up */

function abrir(url, largura, altura, scrool) {

   var width = largura;
   var height = altura;

   var left = 99;
   var top = 99;

   window.open(url, '', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars='+scrool+', status=yes, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

}

/* Fim da função para janela Poup-Up */
