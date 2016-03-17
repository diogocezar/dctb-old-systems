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

$cerebro->neuronio("../classes/sifin/"        , "Banco");
$cerebro->neuronio("../classes/sifin/"        , "Conta");
$cerebro->neuronio("../classes/sifin/"        , "Contato");
$cerebro->neuronio("../classes/sifin/"        , "Nivel");
$cerebro->neuronio("../classes/sifin/"        , "Parcela");
$cerebro->neuronio("../classes/sifin/"        , "Periodicidade");
$cerebro->neuronio("../classes/sifin/"        , "Pessoa");
$cerebro->neuronio("../classes/sifin/"        , "PessoaFisica");
$cerebro->neuronio("../classes/sifin/"        , "PessoaJuridica");
$cerebro->neuronio("../classes/sifin/"        , "TipoDocumento");
$cerebro->neuronio("../classes/sifin/"        , "Usuario");

$controlador = $cerebro->getFrameWork();
?>