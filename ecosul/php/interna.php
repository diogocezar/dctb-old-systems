<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Pagina interna */

$pag = $_GET['pag'];

if(empty($pag)){
	echo "<script language=javascript>alert('Voc� deve selecionar uma p�gina interna!');location.href='index.php'</script>";
}

$conteudo = file_get_contents('../html/'.$pag);

include('./includeInterna.php');
?>