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
$cerebro->neuronio("../neuronios/cookie/"      , "Cookie");
$cerebro->neuronio("../neuronios/sendfile/"    , "SendFile");
$cerebro->neuronio("../neuronios/sendmail/"    , "SendMail");

$cerebro->neuronio("../classes/sidap/" , "Usuario");
$cerebro->neuronio("../classes/sidap/" , "Nivel");
$cerebro->neuronio("../classes/sidap/" , "Cliente");
$cerebro->neuronio("../classes/sidap/" , "Agenda");
$cerebro->neuronio("../classes/sidap/" , "Grupo");
$cerebro->neuronio("../classes/sidap/" , "Tipo");

$controlador = $cerebro->getFrameWork();
?>