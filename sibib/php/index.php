<?php
/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include fun��es ajax
*/
include("../ajax/ajax.php");

/**
* controle de sess�o
*/
$mensagemCS = false; // mensagem de entrada negada
include("controlaSession.php");

$titulo   = 'Bem vindo ao SIBIB';
$conteudo = 'Pequeno texto descrevendo o sistema.';

include('includeInterna.php');
?>
