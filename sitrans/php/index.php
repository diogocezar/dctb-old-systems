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


$titulo    = 'Atualiza��es do sistema';
$conteudo .= 'Caro colaborador, <br><br>';
$conteudo .= 'Fique sempre atento a esse informativo para conhecer as atualiza��es do sistema.<br><br>';
$conteudo .= '<ol>';
$conteudo .= '<li>Para visualizar os detalhes dos registros � necess�rio clicar sobre os mesmos;</li>';
$conteudo .= '<li>O gerenciamento de coletas s� mostrar� informa��es caso o colaborador digite alguma informa��o relativa a coleta;</li>';
$conteudo .= '</ol>';
$conteudo .= '<br>';
$conteudo .= 'Qualquer d�vida, queira reportar a equipe de desenvolvimento. <br><br>';
$conteudo .= 'Obrigado e bom trabalho.';

$vencimentosDiarios = false;
$exiteAjax          = false;


if(!empty($opCliente)){
	$conteudo = TEXTO_LOGIN_CLIENTE;
	$titulo   = "";
	/* incluindo conteudo na p�gina interna espec�fica para cliente*/
	include("../php/includeInternaCliente.php");	
}
else{
	/* incluindo conteudo na p�gina interna */
	include("../php/includeInterna.php");	
}
?>