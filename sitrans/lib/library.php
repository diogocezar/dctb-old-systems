<?php
/**
* Conjunto de funções específicas para o site :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

/*
* Função para converter data do formato do banco para o formato utilizado
* dataSimples  - Converte de YYYY-MM-DD para DD/MM/YYYY
* !dataSimples - Converte de TIME STAMP para DD/MM/YYY - H:M:S
*/
function desconverteData($data, $dataSimples = false){
	if(!$dataSimples){
		$dataSub = substr($data, 0, 10);
		$horaSub = substr($data, 10, strlen($data));
		$exp = explode("-", $dataSub);
		$ano = $exp[0];
		$mes = $exp[1];
		$dia = $exp[2];
		$exp = explode(":", $horaSub);
		$hor = $exp[0];
		$min = $exp[1];
		$seg = substr($exp[2], 0, 2);
		return $dia.'/'.$mes.'/'.$ano.' -'.$hor.':'.$min.':'.$seg;
	}
	else{
		$exp = explode("-", $data);
		$ano = $exp[0];
		$mes = $exp[1];
		$dia = $exp[2];
		return $dia.'/'.$mes.'/'.$ano;	
	}
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

/* @@ DEBUG SERVER ONLINE @@ */
function uc_latin1($str){
	$str = rawurldecode($str);
	$str = str_replace('à', 'À', $str);
	$str = str_replace('á', 'Á', $str);
	$str = str_replace('â', 'Â', $str);
	$str = str_replace('ã', 'Ã', $str);
	$str = str_replace('ç', 'Ç', $str);
	$str = str_replace('è', 'È', $str);
	$str = str_replace('é', 'É', $str);
	$str = str_replace('ê', 'Ê', $str);
	$str = str_replace('ì', 'Ì', $str);
	$str = str_replace('í', 'Í', $str);
	$str = str_replace('ò', 'Ò', $str);
	$str = str_replace('ó', 'Ó', $str);
	$str = str_replace('ô', 'Ô', $str);
	$str = str_replace('ú', 'Ú', $str);
    return strtoupper($str);
}
/* FIM */
?>