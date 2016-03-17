<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
* Função que limita uma string para a quantidade de caracteres passada por parâmetro
*/
function limitaStr($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

/**
* Função que retorna um mktime de um timestamp.
*/
function returnMktime($timestamp){
	//2007-02-22 09:46:13.593

	$mes      = substr($timestamp, 5, 2);
	$diaNum   = substr($timestamp, 8, 2);
	$ano      = substr($timestamp, 0, 4);
	
	$hora     = substr($timestamp, 11, 2);
	$minuto   = substr($timestamp, 14, 2);
	$segundo  = substr($timestamp, 17, 2);
	
	$mktime = mktime($hora, $minuto, $segundo, $mes, $diaNum, $ano);
	
	return $mktime;
}

/**
* Função que altera o nome de uma página.
*/
function changePageName($pagina){
	$urlPag  = $pagina;
	$explode = explode("/", $pagina);
	$pagina  = $explode[count($explode)-1];
	$pagina  = ucfirst($pagina);
	if(strlen($pagina) > 15){
		$paginaCompleta = $pagina;
		$pagina = substr($pagina, 0, 15)."...";
		$comp   = "title=\"$paginaCompleta\"";
	}
	//$pagina  = "<a href = \"javascript:;\" onclick=\"call_addPheromone(parent.frames[1].window.location,'".$urlPag."')\" $comp>$pagina</a>";
	$pagina  = "<a href = \"$urlPag\" target=\"page\")\" $comp>$pagina</a>";
	return $pagina;
}

/**
* Função para calcular o tamanho da tag a ser exibida 
*/
function calculaValorTag($totalTag, $totalTagAtual){   
	$tamanhoTag  = ceil((100*$totalTagAtual)/$totalTag)*50;
	$tamanhoTag  = $tamanhoTag > 180 ? 180 : $tamanhoTag;
	$tamanhoTag  = $tamanhoTag < 80  ? 80  : $tamanhoTag;
	return $tamanhoTag;
}
?>