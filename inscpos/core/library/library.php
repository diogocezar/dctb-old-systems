<?php
/* @@ DEBUG SERVER ONLINE @@ */
function uc_latin1($str){
	if(is_string($str)){
		$str = rawurldecode($str);
		$str = str_replace('а', 'А', $str);
		$str = str_replace('б', 'Б', $str);
		$str = str_replace('в', 'В', $str);
		$str = str_replace('г', 'Г', $str);
		$str = str_replace('з', 'З', $str);
		$str = str_replace('и', 'И', $str);
		$str = str_replace('й', 'Й', $str);
		$str = str_replace('к', 'К', $str);
		$str = str_replace('м', 'М', $str);
		$str = str_replace('н', 'Н', $str);
		$str = str_replace('т', 'Т', $str);
		$str = str_replace('у', 'У', $str);
		$str = str_replace('ф', 'Ф', $str);
		$str = str_replace('ъ', 'Ъ', $str);
		$str = strtoupper($str);
	}
    return $str; 
}
/* FIM */

/*
* Funзгo para converter data do utilizado para o formato do banco
*/
function converteData($data){
	$exp = explode("/", $data);
	$ano = $exp[2];
	$mes = $exp[1];
	$dia = $exp[0];
	return $ano.'-'.$mes.'-'.$dia;
}

/*
* Funзгo para converter data do formato do banco para o formato utilizado
*
function desconverteData($data){
	$exp = explode("-", $data);
	$ano = $exp[2];
	$mes = $exp[0];
	$dia = $exp[1];
	return $dia.'/'.$mes.'/'.$ano;
}

/*
* Funзгo para converter data do formato do banco para o formato utilizado
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

function registerLogAdmin($file, $administrador, $login){
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

function getNum($id){
	$exp = explode('#',$id);
	return $exp[1];
}
?>