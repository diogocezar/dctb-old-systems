<?php
/**
* Verificando a opção para cadastro direto do cliente
*/
$opCliente = $_GET['tcliente'];

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

if(empty($opCliente)){
	/* guardando log */
	$session = $controlador['session'];
	$session->startSession();
	$nome    = $session->retornaSession('sessNome',  false);
	$nivel   = $session->retornaSession('sessNivel', false);
	$ip = getIp();
	$quando = getData(4)."#".getHora(":",1);
	$adminInfos = array('ip:'     => $ip,
						'nivel:'  => $nivel,
						'nome:'   => $nome,
						'quando:' => $quando
						);
	registraLogAdmin($diretorio['log'], $adminInfos, false);
}
else{
	/* guardando log */
	$session = $controlador['session'];
	$session->startSession();
	$nomeCL    = $session->retornaSession('sessNomeContato',  false);
	$idCL   = $session->retornaSession('sessIdContato', false);
	$empresaIdCL   = $session->retornaSession('sessIdEmpresa', false);
	$empresaNomeCL   = $session->retornaSession('sessNomeEmpresa', false);
	$ipCL = getIp();
	$quandoCL = getData(4)."#".getHora(":",1);
	$adminInfos = array('ip:'        => $ipCL,
						'contato:'   => $nomeCL,
						'idcontato:' => $idCL,
						'empresa:'   => $empresaNomeCL,
						'idempresa:' => $empresaIdCL,
						'quando:'    => $quandoCL
						);
	registraLogAdmin($diretorio['logCliente'], $adminInfos, false);
}

$session = $controlador['session'];
$session->startSession();
$session->limpaSessions();

if(empty($opCliente)){
	echo "<script language=javascript>location.href='index.php'</script>";
}
else{
	echo "<script language=javascript>location.href='index.php?tcliente=sim'</script>";
}
?>