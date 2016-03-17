/**
* function call_saveCookieSessionGroup(grupo)
*/
function call_saveCookieSessionGroup(grupo){
	hide();
	/* Salvando Cookie : javascript */
	setCookie(COOKIE_GRUPO, 'OK');
	setCookie(COOKIE_QUALG, grupo);
	
	/* Salvando Session : php */
	x_saveSessionGroup(grupo, return_saveCookieSessionGroup);
}

function return_saveCookieSessionGroup(retorno){
	/* Recarregando a página */
	window.top.location.href="../index.php";
}

/**
* call_changeSystem()
*/
function call_changeSystem(){
	var contexto = document.forms[idForm].contexto_orientacao;
	var combo    = document.forms[idForm].combo_tipo_orientacao;
	var tipo     = combo.item(combo.selectedIndex).value;
	var tipoName = combo.item(combo.selectedIndex).text;
	
	hide();
	
	offOriRelacionada();
	
	if(contexto[0].checked){
		contexto = contexto[0].value;
	}
	else{
		contexto = contexto[1].value;
	}
	
	addContDiv(idTipoOrientacao, tipoName);
	
	if(tipo == 'ori'){
		onOriRelacionada();
		contexto = null;
	}
	
	/* Salvando Cookie : javascript */
	setCookie(COOKIE_CONTE, contexto);
	setCookie(COOKIE_TIPOO, tipo);
	/* Salvando Session : php */
	x_changeSystem(contexto, tipo, return_changeSystem);
	
}

function return_changeSystem(retorno){
	call_getRelevance();
}

/**
* call_getGrupos()
*/
function call_getGrupos(){
	hide();
	x_getGrupos(return_getGrupos);	
}

function return_getGrupos(retorno){
	var objIframe = parent.frames[1];
	
	addContDiv(idInGrupos, url_decode(retorno));
	show();
	hideDiv(idInformacoes);
	hideDiv(idTipo);
	hideDiv(idBox);
	
	/* Recarregando o frame inferior para remover os links gerados */
	objIframe.window.location.reload();
}

/**
* addPheromone();
*/
function call_addPheromone(origem, destino){
	hide();
	x_addPheromone(origem, destino, return_addPheromone);
	return false;
}

function return_addPheromone(retorno){
	var objIframe = parent.frames[1];
	show();
	objIframe.window.location = url_decode(retorno);
}

/**
* deductPheromone();
*/
function call_deductPheromone(){
	hide();
	x_deductPheromone(return_deductPheromone);
	return false;
}

function return_deductPheromone(retorno){
	show();
}

/**
* getRelevance();
*/
function call_getRelevance(){
	var objIframe = parent.frames[1];
	var paginaAtual = objIframe.window.location;
	hide();
	x_getRelevance(paginaAtual, return_getRelevance);
	return false;
}

function return_getRelevance(retorno){
	addContDiv(idInformacoes, url_decode(retorno));
	showDiv(idInformacoes);
	showDiv(idTipo);
	showDiv(idBox);
	show();
}