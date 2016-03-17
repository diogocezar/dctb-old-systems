<?
# @classe. paginar
# @autor. Ronaldo Moreira Junior <elj0k3r@gmail.com>
# @versao. 0.2
# @descricao. Classe gen�rica de pagina��o.
# @TODO. adicionar rotina para verificar o link com mysql no construtor; adicionar op��es para o target na barra de navega��o ou at� mesmo comandos javascript como window.open

var $paginar_variaveis = array();
var $paginar_paginas = array();
var $paginar_mysql = array();
var $paginar_mensagens = array();

/*
@paginar().
@construtor.

@descricao. inicia as vari�veis necess�rias.
*/
function __construtor_paginar() {
	// VARIAVEIS
	$this->paginar_variaveis['PAGINA'] = "pagina"; // nome da variavel passada por url para o link das p�ginas. Ex: localhost/teste.php?pagina=1 -> 'pagina'
	$this->paginar_variaveis['SEPARADOR'] = " | "; // separador da barra de nave��o das p�ginas
	$this->paginar_paginas['POR_PAGINA'] = 50; // n�mero m�ximo de resultados exibidos por p�gina
	if(!$this->paginar_paginas['PAGINA']) $this->paginar_paginas['PAGINA'] = 1; // p�gina atual, caso n�o informada o padr�o � 1 (primeira)
	############### COMENTAR
	$this->paginar_variaveis['ANTERIOR'] = "<- anterior ";
	$this->paginar_variaveis['PROXIMA'] = " pr�xima ->";
	$this->paginar_variaveis['PRIMEIRA'] = "<< ";
	$this->paginar_variaveis['ULTIMA'] = " >>";
	// MENSAGENS (mensagens de erro/alerta)
	$this->paginar_mensagens['SEM_RESULTADOS'] = "<b>sem resultados</b>";
}

/*
@processar().
@parametro string $query.

@descricao. faz os c�lculos para constru��o da barra
*/
function paginar_processar($total) {
	$this->paginar_paginas['TOTAL'] = ceil($total/$this->paginar_paginas['POR_PAGINA']); // total de p�ginas
	$this->paginar_mysql['LIMITE'] = array(0=>(($this->paginar_paginas['PAGINA']-1)*$this->paginar_paginas['POR_PAGINA']),1=>$this->paginar_paginas['POR_PAGINA']); // calculo de limite para mysql
}

/*
@imprimir_paginas().
@parametro string $url.

@descricao. imprimi a barra de navega��o, use $url para indicar a p�gina de destino dos links
ex: 
voc� est� em http://localhost/teste/index.php
imprimir_paginas() imprimiria a barra de navega��o e os links ficariam desta forma: <a href="?pagina=1">1</a>
imprimir_paginas("news.php?categoria=3") imprimiria a barra de navega��o e os links ficariam desta forma: <a href="news.php?categoria=3&pagina=3">3</a>
*/	
function paginar_imprimir_paginas($url=false) {
	$paginas = '';
	if($this->paginar_paginas['TOTAL']) for($i=0;$i<$this->paginar_paginas['TOTAL'];$i++) $paginas .= "<a href=\"".(strstr($url,'?') ? $url."&".$this->paginar_variaveis['PAGINA']."=".($i+1) : "?".$this->paginar_variaveis['PAGINA']."=".($i+1))."\">".($i+1 == $this->paginar_paginas['PAGINA'] ? "<b>".($i+1)."</b>" : ($i+1))."</a>".($i < $this->paginar_paginas['TOTAL']-1 ? $this->paginar_variaveis['SEPARADOR'] : false);
	else $paginas = $this->paginar_mensagens['SEM_RESULTADOS'];
	return $paginas;
}

/*
@imprimir_pagina_atual().
@vazio.

@descricao. imprimi a p�gina atual e o n�mero total de p�ginas
ex:
estamos na p�gina 3 e temos um total de 9
imprimir_pagina_atual() imprimiria: p�gina <b>3</b> de <b>9</b>
*/
function paginar_imprimir_pagina_atual() {
	if($this->paginar_paginas['TOTAL']) return "p�gina <b>".$this->paginar_paginas['PAGINA']."</b> de <b>".$this->paginar_paginas['TOTAL']."</b>";
	else return $this->paginar_mensagens['SEM_RESULTADOS'];
}
########### COMENTAR
function paginar_javascript_barra_paginas($link="alert('[?PAGINA?]')",$pagina=1) {
	$paginas = '';
	if($this->paginar_paginas['TOTAL']) for($i=0;$i<$this->paginar_paginas['TOTAL'];$i++) $paginas .= ($i+1 != $pagina ? "<span style=\"cursor: hand\" onClick=\"".str_replace("[?PAGINA?]",($i+1),$link)."\">" : false).($i+1 == $pagina ? "<b>".($i+1)."</b>" : $i+1).($i+1 != $pagina ? "</span>" : false).($i < $this->paginar_paginas['TOTAL']-1 ? $this->paginar_variaveis['SEPARADOR'] : false);
	else $paginas = $this->paginar_mensagens['SEM_RESULTADOS'];
	return $paginas;
}

function paginar_anterior_proxima($metodo=false,$parametros=array()) {
	print $this->paginar_variaveis['ANTERIOR'];
	if($metodo) call_user_func_array(array($this,$metodo),$parametros);
	print $this->paginar_variaveis['PROXIMA'];
}

function paginar_ir_para_primeira_pagina($url=false) {
	if($this->paginar_paginas['TOTAL']) print "<a href=\"".(strstr($url,'?') ? $url."&".$this->paginar_variaveis['PAGINA']."=1" : "?".$this->paginar_variaveis['PAGINA']."=1")."\">".($this->paginar_paginas['PAGINA'] == 1 ? "<b>".($this->paginar_variaveis['PRIMEIRA'] ? $this->paginar_variaveis['PRIMEIRA'] : 1)."</b>" : ($this->paginar_variaveis['PRIMEIRA'] ? $this->paginar_variaveis['PRIMEIRA'] : 1))."</a>";
}

function paginar_ir_para_ultima_pagina($url=false) {
	if($this->paginar_paginas['TOTAL']) print "<a href=\"".(strstr($url,'?') ? $url."&".$this->paginar_variaveis['PAGINA']."=".$this->paginar_paginas['TOTAL'] : "?".$this->paginar_variaveis['PAGINA']."=".$this->paginar_paginas['TOTAL'])."\">".($this->paginar_paginas['PAGINA'] == $this->paginar_paginas['TOTAL'] ? "<b>".($this->paginar_variaveis['ULTIMA'] ? $this->paginar_variaveis['ULTIMA'] : $this->paginar_paginas['TOTAL'])."</b>" : ($this->paginar_variaveis['ULTIMA'] ? $this->paginar_variaveis['ULTIMA'] : $this->paginar_paginas['TOTAL']))."</a>";
}

function paginar_imprimir_paginas_cortando($valor=10,$anteriores=1) {
	if($this->paginar_paginas['TOTAL']) {
		$pedacos = ceil($this->paginar_paginas['TOTAL'] / $valor);
		for($pedaco_atual=0;$pedaco_atual<$pedacos;$pedaco_atual++) if($this->paginar_paginas['PAGINA'] < ($pedaco_atual*$valor)) break;
		for($i=($valor*($pedaco_atual-($anteriores+1 < $pedaco_atual+1 ? $anteriores+1 : 1)));$i<($valor*$pedaco_atual);$i++) if($i < $this->paginar_paginas['TOTAL']) print "<a href=\"".(strstr($url,'?') ? $url."&".$this->paginar_variaveis['PAGINA']."=".($i+1) : "?".$this->paginar_variaveis['PAGINA']."=".($i+1))."\">".($this->paginar_paginas['PAGINA'] == ($i+1) ? "<b>".($i+1)."</b>" : ($i+1))."</a>".($i < ($valor*$pedaco_atual)-1 && $i < $this->paginar_paginas['TOTAL']-1 ? $this->paginar_variaveis['SEPARADOR'] : false);
	}
}
?>