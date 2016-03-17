<?php
/**
* arquivo de configuraчуo
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

/* definiчѕes para pсgina interna */
$pagina = getPaginaAtual();
$escopo = "Sobre a Empresa";
$caminho = "Pсgina Inicial";

/* objeto */
$objeto = $controlador['informacoes'];
$objeto->__toFillGeneric();
$objeto->__get_db();

$conteudo = $objeto->getHistorico();

include('includeInterna.php');
?>