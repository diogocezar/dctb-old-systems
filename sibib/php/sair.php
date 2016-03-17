<?php
/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* complementos
*/
include("../lib/library.php");
include("../lib/util.php");


/* guardando log */
$session = $controlador['session'];
$session->startSession();
$nome    = $session->retornaSession('sessNome',  false);
$nivel   = $session->retornaSession('sessNivel', false);
$ip = getIp();
$quando = getData(4)."#".getHora(":",1);
$adminInfos = array('ip:'     => $ip,
					'nome:'   => $nome,
					'quando:' => $quando
					);
registraLogAdmin($diretorio['log'], $adminInfos, false);

$session = $controlador['session'];
$session->startSession();
$session->limpaSessions();

echo "<script language=javascript>location.href='index.php'</script>";
?>