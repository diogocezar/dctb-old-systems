/**
* Fun��o que carrega o frame superior ap�s o frame inferior estar carregado.
*/
function refreshFrame(idFrame, pagina){
	frames[idFrame].window.location.href = pagina;
}

/**
* Fun��o que faz as prepara��es para a extra��o dos links.
*/
function goExtractLinks(){
	var objIframe = parent.frames[1];
	
	hide();
	
	objIframe.window.onunload = new Function("parent.frames[0].window.location.reload();");
	
	executeFunctions();		
}

function executeFunctions(){
	extractLinks();
	call_getRelevance();
}

/**
* Fun��o que faz a extra��o dos links.
*/
function extractLinks(){
	var objIframe = parent.frames[1];
	var links     = objIframe.document.getElementsByTagName('a');
	var total     = links.length;
	var i;
	
	for(i=0; i<total; i++){
		var letrasDominio = DOMINIO.length;
		var dominioLink = links[i].href.substring(0,letrasDominio);
		if(dominioLink == DOMINIO){
			var origem = objIframe.window.location;
			var destino = links[i].href;
			links[i].onclick = new Function("call_addPheromone('"+origem+"','"+destino+"');");
			links[i].href = conLinkJava;
		}
		else{
			links[i].target = '_top';
		}
	}
	//show();
	hideDiv(idGrupos);
}