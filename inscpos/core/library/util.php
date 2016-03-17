<?php
function getTime(){ 
	list($sec, $uSec) = explode(" ",microtime()); 
	return ($sec + $uSec);
}

function getIp($type = 0){

	switch($type){
			case 0 : return $_SERVER['REMOTE_ADDR']; break; // user ip
			case 1 : return $_SERVER['SERVER_ADDR']; break; // server ip
	}
}

function getMyDate($type = 0){
			
	$dayWeek = date("w");
	$month   = date("m");
	$day     = date("d");
	$year    = date("Y");
	
	$monthArray = array('01' => "janeiro",
				   	    '02' => "fevereiro",
					    '03' => "março",
					    '04' => "abril",
					    '05' => "maio",
					    '06' => "junho",
					    '07' => "julho",
					    '08' => "agosto",
					    '09' => "setembro",
					    '10' => "outubro",
					    '11' => "novembro",
					    '12' => "dezembro");
					  
	$dayArray    = array(0 => "Domingo",
					     1 => "Segunda",
					     2 => "Terça",
					     3 => "Quarta",
					     4 => "Quinta",
					     5 => "Sexta",
					     6 => "Sábado");
	
	$extDay    = $diaArray[$dayWeek];
	
	$extMonth  = $monthArray[$month];
	
	switch($type){
		case 0 : return "$extDay, $day de $extMonth de $year"; break; 
		case 1 : return $extDay; break; 
		case 2 : return ucfirst($extDay); break; 
		case 3 : return $day; break;
		case 4 : return $day."/".$month."/".$year;
	}
}

function getHour($separator, $format = 0){ /* $format -> 0 = 12 hours 1 = 24 hours */
	$hour12   = date("h");
	$hour24   = date("H");
	$minute   = date("i");
	$second  = date("s");
	
	switch($format){
		case 0 : return $hour12.$separator.$minute.$separator.$second; break;
		case 1 : return $hour24.$separator.$minute.$separator.$second; break;
	}
}

function getNowPage(){
	$nowPage      = $_SERVER['PHP_SELF'];
	$explodePage  = explode('/', $nowPage);
	$countExplode = count($explodePage);
	return $explodePage[($countExplode-1)];
}

function getNav(){
	return $_SERVER['HTTP_USER_AGENT'];
}
?>