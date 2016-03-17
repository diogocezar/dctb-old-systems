<?php
/**
* Funções a serem executadas pelo ajax.
*/
/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 1;
sajax_export("getGrupos", "addPheromone", "deductPheromone", "getRelevance", "changeSystem", "saveSessionGroup");
sajax_handle_client_request();

function saveSessionGroup($grupo){
	global $controlador;
	
	$controlador['session']->salvaSession(SESSION_GRUPO, 'OK');
	$controlador['session']->salvaSession(SESSION_QUALG, $grupo);
	
	$controlador['grupo']->__get_db($grupo);
	$controlador['grupo']->setCont($controlador['grupo']->getCont()+1);
	$controlador['grupo']->update();
}

function changeSystem($contexto, $tipo){
	global $controlador;
	
	$controlador['session']->salvaSession(SESSION_CONTE, $contexto);
	$controlador['session']->salvaSession(SESSION_TIPOO, $tipo);
}

function getGrupos(){

	global $controlador;
	
	$controlador['oriant']->setGrupo($controlador['grupo']);
	$retorno = $controlador['oriant']->getGroups();
	
	return rawurlencode($retorno);
}


function addPheromone($origem, $destino){

	global $controlador;

	$grupo   = $controlador['cookie']->retornaCookie(COOKIE_QUALG);
	
	$origem  = strtolower($origem);
	$destino = strtolower($destino);
	
	$controlador['oriant']->setOrigem($origem);
	$controlador['oriant']->setDestino($destino);
	$controlador['oriant']->setGrupo($grupo);
	$controlador['oriant']->setFeromonio($controlador['feromonio']);
	$controlador['oriant']->setPagina($controlador['pagina']);
	$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);
	
	$controlador['oriant']->addPheromone();
	
	deductPheromone(); // Subtraindo o feromônio ao clique.
	
	return rawurlencode($destino);
}

function deductPheromone(){

	global $controlador;
	
	$controlador['oriant']->setFeromonio($controlador['feromonio']);
	$controlador['oriant']->setPagina($controlador['pagina']);
	$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);

	$controlador['oriant']->deductPheromone();
	
}

function getRelevance($paginaAtual){

	global $controlador;
		
	$grupo    = $controlador['cookie']->retornaCookie(COOKIE_QUALG);
	
	$tipo     = $controlador['cookie']->retornaCookie(COOKIE_TIPOO);
	$contexto = $controlador['cookie']->retornaCookie(COOKIE_CONTE);
	
	if(empty($tipo) || empty($contexto)){	
		$tipo     = $controlador['session']->retornaSession(SESSION_TIPOO);
		$contexto = $controlador['session']->retornaSession(SESSION_CONTE);
	}
	
	if(empty($tipo) || empty($contexto)){	
		$tipo     = TIPO_PADRAO;
		$contexto = CONTEXTO_PADRAO;
	}
	
	$tipo_contex = $tipo.'$'.$contexto;
	
	$paginaAtual = strtolower($paginaAtual);
	
	$controlador['oriant']->setFeromonio($controlador['feromonio']);
	$controlador['oriant']->setPagina($controlador['pagina']);
	$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);

	$retorno = $controlador['oriant']->getRelevance($tipo_contex, $paginaAtual, $grupo);
	
	return rawurlencode($retorno);
}

?>