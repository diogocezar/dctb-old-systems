<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("excluirFoto");
sajax_handle_client_request();

function excluirFoto($tabela, $foto, $key, $url){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
		
	$sql  = "";
	$sql .= "UPDATE $tabela SET ";
	$sql .= $foto;
	$sql .= " = ";
	$sql .= "''";
	$sql .= " WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);
	
	$url = rawurldecode($url);
	
	if(file_exists($url)){
		unlink($url);
	}
}
?>