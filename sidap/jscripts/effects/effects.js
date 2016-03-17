function onOriRelacionada(){
	hideDiv(idBoxOpcoesCO);
	showDiv(idBoxOpcoesCOO);
}

function offOriRelacionada(){
	hideDiv(idBoxOpcoesCOO);
	showDiv(idBoxOpcoesCO);
}

/**
* Função para adicionar um conteúdo em uma div.
*/
function addContDiv(id, conteudo){
	div = document.getElementById(id);
	div.innerHTML = conteudo;
}


/**
* Função que esconde um div com determinada id.
*/
function hideDiv(id){
	div = document.getElementById(id);
	//document.getElementById(id).style.border = '';
	div.style.visibility = 'hidden';
	div.style.display = 'none';
	
}

/**
* Função que mostra um div com determinada id.
*/
function showDiv(id){
	div = document.getElementById(id);
	div.style.visibility = 'visible';
	div.style.display = '';
	
}

/**
* Função que esconde os elementos para efeito de loading.
*/
function hide(){
	hideDiv(idContainer);
	showDiv(idLoading);
	//hideDoc();
}

/**
* Função que mostra os elementos e esconde o loading.
*/
function show(){
	showDiv(idContainer);
	hideDiv(idLoading);
	//showDoc();
}

/**
* Função que esconde tudo o que é mostrado no frame filho.
*/
function hideDoc(){
	//var objIframe = parent.frames[1];
	//objIframe.document.body.style.display = 'none';
}

/**
* Função que mostra tudo o que é mostrado no frame filho.
*/
function showDoc(doc){
	//var objIframe = parent.frames[1];
	//objIframe.document.body.style.display = '';
}