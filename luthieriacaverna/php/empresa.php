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
* biblioteca de funcoes
*/
include("../lib/library.php");
include("../lib/util.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Sobre a Empresa";
$caminho = "P�gina Inicial";

/* objeto */
$objeto = $controlador['informacoes'];
$objeto->__toFillGeneric();
$objeto->__get_db();

$conteudo = $objeto->getHistorico();

include('includeInterna.php');
?>