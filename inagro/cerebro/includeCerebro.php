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

$cerebro->neuronio("../neuronios/session/"    , "Session");
$cerebro->neuronio("../neuronios/connection/" , "Connection");
$cerebro->neuronio("../neuronios/database/"   , "DataBase");
$cerebro->neuronio("../neuronios/cookie/"     , "Cookie");
$cerebro->neuronio("../neuronios/sendfile/"   , "SendFile");
$cerebro->neuronio("../neuronios/sendmail/"   , "SendMail");
$cerebro->neuronio("../neuronios/photo/"      , "Photo");
$cerebro->neuronio("../neuronios/pikture/"    , "Pikture");

$cerebro->neuronio("../classes/inagro/"       , "Empresa");
$cerebro->neuronio("../classes/inagro/"       , "Evento");
$cerebro->neuronio("../classes/inagro/"       , "Noticia");
$cerebro->neuronio("../classes/inagro/"       , "Download");
$cerebro->neuronio("../classes/inagro/"       , "Link");
$cerebro->neuronio("../classes/inagro/"       , "Parceiro");

$controlador = $cerebro->getFrameWork();
?>