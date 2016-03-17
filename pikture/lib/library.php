<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
* Função que converte todas as quebras de linha \n em quebras de linha em html <br>
*/
function converteQuebra($str){
	return str_replace("\n", "<br>", $str);
}

/*
* Função que desconverte todas as quebras de linha \n em quebras de linha em html <br>
*/
function desconverteQuebra($str){
	return str_replace("<br>", "\n", $str);
}

/**
* Função que registra o login de um determinado administrador.
*/
function registraLogAdmin($file, $administrador, $login){
	if($login){
		$strPut = "[LOGIN]";
	}
	else{
		$strPut = "[LOGOUT]";
	}
	foreach($administrador as $indice => $valor){
		$strPut .= $indice.$valor.";";
	}
	$strPut .= "\n";
	$fp = fopen($file, "a+");
	fputs($fp, $strPut, 1024);	
}

/*
* Função para retornar uma session numérica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

?>