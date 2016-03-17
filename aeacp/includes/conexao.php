<?php
/*
	# CONEXAO.PHP

	[ Arquivo de configura��o do site da inform�tica CEFET-PR CP ]
	
	O arquivo conexao.php tem como objetivo fazer a conex�o com o banco de dados
	� nesse arquivo que ficam armazenadas as configura��es para para conex�o.

*/

/* Inclue a classe de conex�o com o Banco de Dados MySQL */

include('./classes/mysql.class.php');

/* Instancia um novo objeto da classe incluida */

$MySQL = new MySQL();

/* Chama o m�todo de conex�o com o banco de dados */

$MySQL->Conectar();
?>