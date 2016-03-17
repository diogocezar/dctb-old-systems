<?php
/**
* Arquivo de configuração
*/
include("../conf/config.php");

/**
* Cerebro do sistema
*/
include("../cerebro/Cerebro.php");

$cerebro = new Cerebro();

$cerebro->neuronio("../neuronios/connection/"  , "Connection");
$cerebro->neuronio("../neuronios/database/"    , "DataBase");
$cerebro->neuronio("../neuronios/rss/"         , "NoticesRss");
$cerebro->neuronio("../neuronios/tree/"        , "Tree");
$cerebro->neuronio("../neuronios/session/"     , "Session");
$cerebro->neuronio("../classes/avaliacao/"     , "Avaliacao");
$cerebro->neuronio("../classes/comentarios/"   , "Comentarios");
$cerebro->neuronio("../classes/admin/"         , "Admin");
$cerebro->neuronio("../classes/noticiasrss/"   , "NoticiasRss");


$controlador = $cerebro->getFrameWork();
?>