<?php
/*
	# CONEXAO.PHP

	[ Arquivo de configuraчуo do site da informсtica CEFET-PR CP ]
	
	O arquivo conexao.php tem como objetivo fazer a conexуo com o banco de dados
	щ nesse arquivo que ficam armazenadas as configuraчѕes para para conexуo.

*/

/* Inclue a classe de conexуo com o Banco de Dados MySQL */

include('./classes/mysql.class.php');

/* Instancia um novo objeto da classe incluida */

$MySQL = new MySQL();

/* Chama o mщtodo de conexуo com o banco de dados */

$MySQL->Conectar();
?>