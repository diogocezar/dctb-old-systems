<?php

/* this file manager system session */

$session = $brain_controller['session'];

$allowedSC  = false;
$recordsSC  = false;
$nowLoginSC = false;

$loginSC = $_POST['login'];
$passSC  = $_POST['password'];

if(!empty($loginSC) && !empty($passSC)){
	
	$nowLoginSC = true;
	$messageSC  = true;
	
	
	$admin = $brain_controller['administrador'];
	$admin->__toFillGeneric();
	$resultSC = $admin->allowLogin($loginSC, $passSC);

	if($resultSC != false){
		$recordsSC  = true;
		$idSC       = (string)$resultSC['idadministrador'];
		$nameSC     = $resultSC['nome'];
		$loginSC    = $resultSC['login'];
		$passSC     = $resultSC['senha'];
		$curCodSC   = $resultSC['idcurso'];
		$redirectSC = "index.php";
	}
	
	if($recordsSC){
		$ipSC = getIp();
		$sessions = array('sessIdUser' => $idSC,
						  'sessCurCod' => $curCodSC,
						  'sessName'   => $nameSC,
						  'sessLogin'  => $loginSC,
						  'sessIp'     => $ipSC
						  );
						  
		$session->__go_Session($sessions);
		
		/* recording log */
		$whenSC = getMyDate(4)."#".getHour(":",1);
		$adminInformation = array('ip:'   => $ipSC,
							      'name:' => $nameSC,
							      'when:' => $whenSC
							      );
		
		registerLogAdmin($conf['files']['log'], $adminInformation, true);
	}
}

if(!empty($_SESSION['sessIdUser'])){
	$allowedSC = true;
}

if($allowedSC != true){
	if($messageSC == true){
		echo "<script language=javascript>alert('Desculpe, você não foi identificado no sistema.');location.href='login.php'</script>";
	}
	else{
		echo "<script language=javascript>location.href='login.php'</script>";
	}
	exit();
}

if($nowLoginSC){
	echo "<script language=javascript>location.href='$redireciona'</script>";
	exit();
}
?>