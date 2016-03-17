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

$cerebro->neuronio("../neuronios/connection/" , "Connection");
$cerebro->neuronio("../neuronios/database/"   , "DataBase");
$cerebro->neuronio("../neuronios/cookie/"     , "Cookie");
$cerebro->neuronio("../neuronios/session/"    , "Session");
$cerebro->neuronio("../neuronios/sendfile/"   , "SendFile");
$cerebro->neuronio("../neuronios/sendmail/"   , "SendMail");

$cerebro->neuronio("../classes/lrcp/"     , "Servico");
$cerebro->neuronio("../classes/lrcp/"     , "Equipe");
$cerebro->neuronio("../classes/lrcp/"     , "Dica");
$cerebro->neuronio("../classes/lrcp/"     , "Informacoes");
$cerebro->neuronio("../classes/lrcp/"     , "Link");
$cerebro->neuronio("../classes/lrcp/"     , "Noticia");
$cerebro->neuronio("../classes/lrcp/"     , "Trabalho");
$cerebro->neuronio("../classes/lrcp/"     , "Depoimento");

$controlador = $cerebro->getFrameWork();

?>