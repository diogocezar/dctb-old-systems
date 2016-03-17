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

$cerebro->neuronio("../neuronios/session/"     , "Session");
$cerebro->neuronio("../neuronios/connection/"  , "Connection");
$cerebro->neuronio("../neuronios/database/"    , "DataBase");

$cerebro->neuronio("../classes/sibib/" , "Acervo");
$cerebro->neuronio("../classes/sibib/" , "AcervoLocacao");
$cerebro->neuronio("../classes/sibib/" , "Administrador");
$cerebro->neuronio("../classes/sibib/" , "Autor");
$cerebro->neuronio("../classes/sibib/" , "Editora");
$cerebro->neuronio("../classes/sibib/" , "Locacao");
$cerebro->neuronio("../classes/sibib/" , "Tipoacervo");
$cerebro->neuronio("../classes/sibib/" , "Usuario");

$controlador = $cerebro->getFrameWork();
?>