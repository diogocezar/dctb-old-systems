<?php
/**
* Conjunto de funções Uteis :
*/

/**
* I N Í C I O  F U  N Ç Õ E S 
*/

function getTime(){ 
	list($sec, $uSec) = explode(" ",microtime()); 
	return ($sec + $uSec);
}

function getIp($tipo = 0){

	switch($tipo){
			case 0 : return $_SERVER['REMOTE_ADDR']; break; // Ip do Usuário
			case 1 : return $_SERVER['SERVER_ADDR']; break; // Ip do Servidor
	}
}

function getData($tipo = 0){
			
	$diaSemana  = date("w");
	$mes        = date("m");
	$diaNum     = date("d");
	$ano        = date("Y");
	$mesArray   = array(01 => "janeiro",
				   	    02 => "fevereiro",
					    03 => "março",
					    04 => "abril",
					    05 => "maio",
					    06 => "junho",
					    07 => "julho",
					    08 => "agosto",
					    09 => "setembro",
					    10 => "outubro",
					    11 => "novembro",
					    12 => "dezembro");
					  
	$diaArray    = array(0 => "Domingo",
					     1 => "Segunda-feira",
					     2 => "Terça-feira",
					     3 => "Quarta-feira",
					     4 => "Quinta-feira",
					     5 => "Sexta-feira",
					     6 => "Sábado");
	
	$extDia  = $diaArray[$diaSemana];
	$extMes  = $mesArray[$mes];
	
	switch($tipo){
		case 0 : return "$extDia, $diaNum de $extMes de $ano"      ; break; // Data total por extenso
		case 1 : return $extDia                                    ; break; // Dia da Semana
		case 2 : return ucfirst($extDia)                           ; break; // Mês
		case 3 : return $diaNum         						   ; break; // Dia do Mês
	}
}

function getHora($separador, $formato = 0){ /* $FORMATO -> 0 = 12 horas 1 = 24 horas */
	$hora12   = date("h");
	$hora24   = date("H");
	$minuto   = date("i");
	$segundo  = date("s");
	
	switch($formato){
		case 0 : return $hora12.$separador.$minuto.$separador.$segundo; break;
		case 1 : return $hora24.$separador.$minuto.$separador.$segundo; break;
	}
}

function getPaginaAtual(){
	$paginaAtual   = $_SERVER['PHP_SELF'];
	$explodePagina = explode('/', $paginaAtual);
	$qtdExplode    = count(explodePagina);
	return $explodePagina[($qtdExplode-1)];
}

function getNav(){
	return $_SERVER['HTTP_USER_AGENT'];
}

/**
* F I M   F U  N Ç Õ E S 
*/
?>