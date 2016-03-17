<?php
/**
* Arquivo para a configuraзгo da linguagem utilizada no sistema oriant.
* esse arquivo deverб ser incluнdo na pбgina principal do sistema onde a subistituiзгo das
* variбveis do template й feita.
*/

$language = $_GET['language'];

if(empty($language)){
	include('pt-br.php');
}
else{
	$pageLang = $language.'.php';
	include($pageLang);
}

?>