<?php
/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");
/**
* arquivo de configuraчуo
*/
include("../conf/config.php");

/** 
* O Tamanho щ uma variavel inteira, que representa : 
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

$photo = $controlador['photo'];

switch($tamanho){
	case 1  : $photo->__go_Photo($localizacao, LARGURA_MINIATURA, ALTURA_MINIATURA, $scalar); break; 
	case 2  : $photo->__go_Photo($localizacao, LARGURA_GRANDE   , ALTURA_GRANDE   , $scalar); break;
	default : 
		if(!empty($largura) && !empty($altura)){
			$photo->__go_Photo($localizacao, $largura, $altura, $scalar);
		}
		else{
			$erroImg = new Errors($erro['ALTU_LARG_VAZIA']);		
		}
	break;
}
?>