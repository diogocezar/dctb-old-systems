<?php
include('../classes/Photo.php');
include('../classes/IniFile.php');

$ini = new IniFile("../pikture/config/gerais.ini");
$gerais = $ini->getIni(false);

/** 
* O Tamanho é uma variavel inteira, que representa : 
* 0       => Miniatura
* 1       => Grande
* Default => Personalizado ( Passado pelo GET )
*/

$tamanho = $_GET['t'];

$largura = $_GET['l'];
$altura  = $_GET['a'];

$scalar  = $_GET['s'];

if($scalar == "sim"){ $scalar = true; } else { $scalar = false; }

$localizacao = $_GET['loc'];

$expBarra   = explode('/', $localizacao);
$nomeComExt = $expBarra[count($expBarra)-1];
$expPonto   = explode('.', $nomeComExt);
$extensao   =  '.'.$expPonto[1];

switch($extensao){
	case 'jpeg':
	case 'jpg' :
		if (!function_exists("imagejpeg")){
			$erroImg = new Errors($erro['LIB_TO_JPG_INVA']);		
		}	 
		break;
		
	case 'gif':
		if (!function_exists("imagegif")){
			$erroImg = new Errors($erro['LIB_TO_GIF_INVA']);		
		}	 
		break;
		
	case 'png':
		if (!function_exists("imagepng")){
			$erroImg = new Errors($erro['LIB_TO_PNG_INVA']);		
		}	 
		break;
}

switch($tamanho){
	case 1  : $Photo = new Photo($localizacao, $gerais['larguraCapa'],      $gerais['alturaCapa'],      $scalar); break; 
	case 2  : $Photo = new Photo($localizacao, $gerais['larguraMiniatura'], $gerais['alturaMiniatura'], $scalar); break; 
	default : 
		if(!empty($largura) && !empty($altura)){
			$Photo = new Photo($localizacao, $largura, $altura, $scalar);
		}
		else{
			$erroImg = new Errors($erro['ALTU_LARG_VAZIA']);		
		}
	break;
}
?>