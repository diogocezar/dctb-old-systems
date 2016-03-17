<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/


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
	$pagina  = "<a href = \"javascript:;\" onclick=\"call_addPheromone(parent.frames[1].window.location,'".$urlPag."')\">$pagina</a>";
	return $pagina;
}

/**
* Função que retransforma o conteúdo em html.
*/
function clean($content, $utf8){
	$pattern = array ("/&lt;/","/&gt;/","/&quot;/","/&amp;/","/&#39;/");
	$replace = array ("<",">","\"","&","'");
	$content = stripslashes(preg_replace($pattern,$replace,$content));
	if($utf8){
		return utf8_decode($content);
	}
	else{
		return $content;
	}
}

/**
* Função que verifica se o adminsitrador está logado.
*/
function allowedAdmin(){
	if($_SESSION[SESSION_PERMITIDO] == "sim"){
		return true;
	}
	else{
		return false;
	}
}

/**
* Função para escrever as estrelas.
*/
function escreveEstrelas($estrelas){

    $imagem_on  = "<img src=\"../images/avaliacao/estrela_on.gif\" border=\"0\">";
    $imagem_off = "<img src=\"../images/avaliacao/estrela_off.gif\" border=\"0\">";
	
	$retorno = "";

	for($i=1; $i<11; $i++){
		if($i <= $estrelas){
			$retorno .= $imagem_on;
		}
		else{
			$retorno .= $imagem_off;
		}
	}
	
	return $retorno;
}

/**
* Função converter timestamp em string.
*/
function timestamp2str($s,$divHora, $divData){
	$ano = $s[0].$s[1].$s[2].$s[3];
	$mes = $s[4].$s[5];
	$dia = $s[6].$s[7];
	
	$hora    = $s[8].$s[9];
	$minuto  = $s[10].$s[11];
	$segundo = $s[12].$s[13];
	
	$strData = $dia.$divData.$mes.$divData.$ano;
	$strHora = $hora.$divHora.$minuto.$divHora.$segundo;
	
	return $strData." ".$strHora;
}
?>