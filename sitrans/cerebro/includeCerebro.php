<?php
/* @@ DEBUG SERVER ONLINE @@ */
session_start();

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
$cerebro->neuronio("../neuronios/reportpdf/"   , "ReportPDF");

$cerebro->neuronio("../classes/sitrans/"       , "Usuario");
$cerebro->neuronio("../classes/sitrans/"       , "Nivel");
$cerebro->neuronio("../classes/sitrans/"       , "Pessoa");
$cerebro->neuronio("../classes/sitrans/"       , "Fornecedor");
$cerebro->neuronio("../classes/sitrans/"       , "Cliente");
$cerebro->neuronio("../classes/sitrans/"       , "FrequenciaColeta");
$cerebro->neuronio("../classes/sitrans/"       , "Agregado");
$cerebro->neuronio("../classes/sitrans/"       , "Categoria");
$cerebro->neuronio("../classes/sitrans/"       , "Veiculo");
$cerebro->neuronio("../classes/sitrans/"       , "Contato");

$cerebro->neuronio("../classes/sitransColeta/" , "Coleta");
$cerebro->neuronio("../classes/sitransColeta/" , "Status");
$cerebro->neuronio("../classes/sitransColeta/" , "Motivo");
$cerebro->neuronio("../classes/sitransColeta/" , "Restricao");
$cerebro->neuronio("../classes/sitransColeta/" , "Embalagem");

$cerebro->neuronio("../classes/sitransManifesto/" , "Conhecimento");
$cerebro->neuronio("../classes/sitransManifesto/" , "Manifesto");
$cerebro->neuronio("../classes/sitransManifesto/" , "StatusManifesto");
$cerebro->neuronio("../classes/sitransManifesto/" , "StatusConhecimento");

$cerebro->neuronio("../classes/sitransSaida/" , "SaidaManifesto");
$cerebro->neuronio("../classes/sitransSaida/" , "Entregas");
$cerebro->neuronio("../classes/sitransSaida/" , "BaixaConhecimento");

$controlador = $cerebro->getFrameWork();
?>