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

/* transformando todos os campos enviados em letras maiúsculas */

foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}

$loginCS = $_POST['login'];
$senhaCS = $_POST['senha'];

if(!empty($loginCS) && !empty($senhaCS)){

	$passouLoginCS = true;
	$mensagemCS    = true;
	
	$administrador = $controlador['administrador'];
	$administrador->__toFillGeneric();
	$resultadoCS = $administrador->allowLogin($loginCS, $senhaCS);
	
	if($resultadoCS != false){
		$registraCS    = true;
		$idCS          = (string)$resultadoCS['id_administrador'];
		$nomeCS        = $resultadoCS['nome'];
		$loginCS       = $resultadoCS['login'];
		$senhaCS       = $resultadoCS['senha'];
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