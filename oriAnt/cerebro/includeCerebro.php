<?php
/* @@ DEBUG SERVER ONLINE @@ */
session_start();

/**
* Arquivo de configuração
*/
include("../conf/config.php");

/**
* Cerebro do sistema
*/
include("../cerebro/Cerebro.php");

$cerebro = new Cerebro();

$cerebro->neuronio("../neuronios/connection/" , "Connection");
$cerebro->neuronio("../neuronios/database/"   , "DataBase");
$cerebro->neuronio("../neuronios/cookie/"     , "Cookie");
$cerebro->neuronio("../neuronios/session/"    , "Session");
$cerebro->neuronio("../classes/oriant/"       , "Grupo");
$cerebro->neuronio("../classes/oriant/"       , "Feromonio");
$cerebro->neuronio("../classes/oriant/"       , "Pagina");
$cerebro->neuronio("../classes/oriant/"       , "OriAnt");
$cerebro->neuronio("../classes/oriant/"       , "ParametrosAdm");

$controlador = $cerebro->getFrameWork();
?>