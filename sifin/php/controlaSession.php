<?php
/**
* complementos
*/
include("../lib/library.php");
include("../lib/util.php");

$session = $controlador['session'];

$session->startSession();

$permitidoCS   = false;
$registraCS    = false;
$passouLoginCS = false;

$loginCS = $_POST['loginCS'];
$senhaCS = $_POST['senhaCS'];

if(!empty($loginCS) && !empty($senhaCS)){

	$passouLoginCS = true;
	$mensagemCS    = true;
	
	$usuario = $controlador['usuario'];
	$usuario->__toFillGeneric();
	$resultadoCS = $usuario->allowLogin($loginCS, $senhaCS);
	
	if($resultadoCS != false){
		$registraCS    = true;
		$idCS          = (string)$resultadoCS['id'];
		$nomeCS        = $resultadoCS['nome'];
		$loginCS       = $resultadoCS['login'];
		$senhaCS       = $resultadoCS['senha'];
		$nivelCS       = (string)$resultadoCS['nivel'];
		$redirecionaCS = "index.php";
	}
	
	if($registraCS){
		$ipCS = getIp();
		$sessions = array('sessId'    => $idCS,
		                  'sessNivel' => $nivelCS,
						  'sessNome'  => $nomeCS,
						  'sessLogin' => $loginCS,
						  'sessIp'    => $ipCS
						  );
						  
		$session->__go_Session($sessions);
		
		/* guardando log */
		$quandoCS = getData(4)."#".getHora(":",1);
		$adminInfos = array('ip:'     => $ipCS,
							'nivel:'  => $nivelCS,
							'nome:'   => $nomeCS,
							'quando:' => $quandoCS
							);
		registraLogAdmin($diretorio['log'], $adminInfos, true);
	}
}

if(!empty($_SESSION['sessId'])){
	$permitidoCS = true;
}

if($permitidoCS != true){
	if($mensagemCS == true){
		echo "<script language=javascript>alert('Desculpe, você não foi identificado no sistema.');location.href='login.php'</script>";
	}
	else{
		echo "<script language=javascript>location.href='login.php'</script>";
	}
	exit();
}

if($passouLoginCS){
	echo "<script language=javascript>location.href='$redireciona'</script>";
	exit();
}
?>