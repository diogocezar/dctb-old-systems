<?php
set_time_limit(0);
/**
* Fun��es a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getLista", "getLattes", "fix_string");
sajax_handle_client_request();

function fix_string ( $string ) {
 $pattern = array( 'ã', 'á', '� ', 'â', 'Â', 'À', '�<81>', 'Ã', 'Ê', 'È', 'É', 'ê', 'é', 'è', '�<8d>', 'Ì', 'Ĩ', 'Î', 'í', 'ì', 'î', 'ĩ', 'ô', 'õ', 'ó', 'ò', 'ô', 'Ô', 'Õ', 'Ó', 'Ó', 'û', 'ú', 'ũ', 'ù', 'u', 'Û', 'Ú', 'Ù', 'Ũ', 'ç', 'Ç' );

 $replace = array( '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'I', '�', '�', '�', '�', 'i', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'u', '�', 'u', '�', '�', '�', 'U', '�', '�' );
 
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
	$array_replace = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'I', '�', '�', '�', '�', 'i', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'u', '�', 'u', '�', '�', '�', 'U', '�', '�');
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