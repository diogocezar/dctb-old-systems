<?
	session_start();
	$_SESSION = array();
	session_destroy();
	header ( "Location: http://sifin.xbrain.com.br" );
?> 