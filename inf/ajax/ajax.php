<?php
set_time_limit(0);
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getLista", "getLattes", "fix_string");
sajax_handle_client_request();

function fix_string ( $string ) {
 $pattern = array( 'Ã£', 'Ã¡', 'Ã ', 'Ã¢', 'Ã‚', 'Ã€', 'Ã<81>', 'Ãƒ', 'ÃŠ', 'Ãˆ', 'Ã‰', 'Ãª', 'Ã©', 'Ã¨', 'Ã<8d>', 'ÃŒ', 'Ä¨', 'ÃŽ', 'Ã­', 'Ã¬', 'Ã®', 'Ä©', 'Ã´', 'Ãµ', 'Ã³', 'Ã²', 'Ã´', 'Ã”', 'Ã•', 'Ã“', 'Ã“', 'Ã»', 'Ãº', 'Å©', 'Ã¹', 'u', 'Ã›', 'Ãš', 'Ã™', 'Å¨', 'Ã§', 'Ã‡' );

 $replace = array( 'ã', 'á', 'à', 'â', 'Â', 'À', 'Á', 'Ã', 'Ê', 'È', 'É', 'ê', 'é', 'è', 'Í', 'Ì', 'I', 'Î', 'í', 'ì', 'î', 'i', 'ô', 'õ', 'ó', 'ò', 'ô', 'Ô', 'Õ', 'Ó', 'Ó', 'û', 'ú', 'u', 'ù', 'u', 'Û', 'Ú', 'Ù', 'U', 'ç', 'Ç' );
 
 return str_replace( $pattern, $replace, $string );
}

function _utf8_decode($string)
{
  $tmp = $string;
  $count = 0;
  while (mb_detect_encoding($tmp)=="UTF-8")
  {
    $tmp = utf8_decode($tmp);
    $count++;
  }
 
  for ($i = 0; $i < $count-1 ; $i++)
  {
    $string = utf8_decode($string);
   
  }
  return $string;
 
}

function getLista(){
	$result = "";
	@$resultOriginal = join("", file("http://br.groups.yahoo.com/group/infcp/"));
	$qtdOriginal = strlen($resultOriginal);
	while(eregi('<div class="ygrp-msg">', $resultOriginal)){
		$search = strpos($resultOriginal,'<div class="ygrp-msg">');
		$saida  = trim(substr($resultOriginal, $search)); 
		$crop   = strpos($saida, '</div>');
		$cortaAtual = trim(substr($saida, 0, $crop));
		$result .= $cortaAtual."<br /><br />";
		$posicaoCortaOriginal = strpos($resultOriginal, $cortaAtual)+strlen($cortaAtual);
		$resultOriginal = trim(substr($resultOriginal, $posicaoCortaOriginal, $qtdOriginal));
	}	
	$saida = str_replace("/group/infcp/message/", "http://br.groups.yahoo.com/group/infcp/message/", $result);
	$array_replace = array('ã', 'á', 'à', 'â', 'Â', 'À', 'Á', 'Ã', 'Ê', 'È', 'É', 'ê', 'é', 'è', 'Í', 'Ì', 'I', 'Î', 'í', 'ì', 'î', 'i', 'ô', 'õ', 'ó', 'ò', 'ô', 'Ô', 'Õ', 'Ó', 'Ó', 'û', 'ú', 'u', 'ù', 'u', 'Û', 'Ú', 'Ù', 'U', 'ç', 'Ç');
	foreach($array_replace as $item){
		$saida = str_replace($item, rawurlencode($item), $saida);
	}
	return utf8_decode($saida);
}

function getLattes($endereco){
	$result = "";
	@$resultOriginal = join("", file($endereco));
	$search = strpos($resultOriginal,'<div class="container"/>');
	$saida  = trim(substr($resultOriginal, $search)); 
	$crop   = strpos($saida, '</div>');
	$cortaAtual = trim(substr($saida, 0, $crop));
	$resultOriginal = str_replace($cortaAtual, '', $resultOriginal);
	return rawurlencode($resultOriginal);
}
?>