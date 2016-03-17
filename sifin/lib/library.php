<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
* Função para converter data do formato do banco para o formato utilizado
* Converte de YYYY-MM-DD para DD/MM/YYYY
*/
function desconverteData($data){
	$exp = explode("-", $data);
	$ano = $exp[0];
	$mes = $exp[1];
	$dia = $exp[2];
	return $dia.'/'.$mes.'/'.$ano;	
}

/*
* Função para converter data do formato do utilizado para formato do banco de dados
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

/*
* Função para colocar variavel de get
*/
function toGet($palavra){
	$palavra = str_replace(" ", "_", strtolower($palavra));
	return $palavra;
}

/*
* Função para retornar variavel de get
*/
function noToGet($palavra){
	$palavra = str_replace("_", " ", strtolower($palavra));
	return $palavra;
}

/*
* Função que limpa as quebras de linha
*/
function limpaQuebra($str){
	return str_replace("<br>", "", $str);
}

/*
* Função que troca a , por . de um valor
*/
function trocaVirgula($valor){
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", ".", $valor);
	return $valor;
}

/*
* Função que formata dinheiro
*/
function formataDinheiro($valor){
	return number_format($valor, 2, ',','.');
}
?>