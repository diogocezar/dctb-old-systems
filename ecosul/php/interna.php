<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Pagina interna */

$pag = $_GET['pag'];

if(empty($pag)){
	echo "<script language=javascript>alert('Você deve selecionar uma página interna!');location.href='index.php'</script>";
}

$conteudo = file_get_contents('../html/'.$pag);

include('./includeInterna.php');
?>