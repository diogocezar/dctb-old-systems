<?php
/**
* Arquivo para a configura��o da linguagem utilizada no sistema oriant.
* esse arquivo dever� ser inclu�do na p�gina principal do sistema onde a subistitui��o das
* vari�veis do template � feita.
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