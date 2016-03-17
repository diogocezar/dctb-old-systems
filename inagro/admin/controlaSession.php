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
	
	if($loginCS == LOGIN_ADMIN && $senhaCS == SENHA_ADMIN){
		$registraCS       = true;
		$permitidoCS      = true;
		$idCS             = "-1";
		$nomeCS           = "Administrador";
		$loginCS          = LOGIN_ADMIN;
		$senhaCS          = SENHA_ADMIN;
		$redirecionaCS    = "index.php";
		$nivelCS          = "1";
	}
	
	if($registraCS){
		$ipCS = getIp();
		$sessions = array('sessId'    => $idCS,
						  'sessNome'  => $nomeCS,
		                  'sessNivel' => $nivelCS,
						  'sessLogin' => $loginCS,
						  'sessIp'    => $ipCS
						  );
						  
		$session->__go_Session($sessions);
		
		/* guardando log */
		$quandoCS = getData(4)."#".getHora(":",1);
		$adminInfos = array('ip:'     => $ipCS,
							'nome:'   => $nomeCS,
							'nivel:'  => $nivelCS,
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