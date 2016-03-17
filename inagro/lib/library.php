<?php
/**
* Conjunto de fun��es espec�ficas para o site :
*/

/**
* I N � C I O  F U  N � � E S 
*/

/*
* Fun��o para converter data do formato do banco para o formato utilizado
* Converte de YYYY-MM-DD para DD/MM/YYYY
*/
function desconverteData($data){
	if(empty($data)) return;
	if(eregi('-', $data)){
		$exp = explode("-", $data);
		$ano = $exp[0];
		$mes = $exp[1];
		$dia = $exp[2];
		return $dia.'/'.$mes.'/'.$ano;	
	}
	else{
		return $data;
	}
}

/*
* Fun��o para converter data do formato do utilizado para formato do banco de dados
* Converte de DD/MM/YYYY para YYYY-MM-DD
*/
function converteData($data){
	$exp = explode("/", $data);
	$ano = $exp[2];
	$mes = $exp[1];
	$dia = $exp[0];
	return $ano.'-'.$mes.'-'.$dia;	
}


/*
* Fun��o que converte todas as quebras de linha \n em quebras de linha em html <br>
*/
function converteQuebra($str){
	return str_replace("\n", "<br>", $str);
}

/*
* Fun��o que desconverte todas as quebras de linha \n em quebras de linha em html <br>
*/
function desconverteQuebra($str){
	return str_replace("<br>", "\n", $str);
}

/*
* Fun��o que limita uma string para a quantidade de caracteres passada por par�metro
*/
function limitaStr($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

/**
* Fun��o que registra o login de um determinado administrador.
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
* Fun��o para retornar uma session num�rica 
*/
function sessionNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}

/*
* Fun��o para colocar variavel de get
*/
function toGet($palavra){
	$palavra = str_replace(" ", "_", strtolower($palavra));
	return $palavra;
}

/*
* Fun��o para retornar variavel de get
*/
function noToGet($palavra){
	$palavra = str_replace("_", " ", strtolower($palavra));
	return $palavra;
}

/*
* Fun��o que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}

/*
* Fun��o que troca a , por . de um valor
*/
function trocaVirgula($valor){
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	return $valor;
}

/*
* Fun��o que formata dinheiro
*/
function formataDinheiro($valor){
	return number_format($valor, 2, ',','.');
}
?>