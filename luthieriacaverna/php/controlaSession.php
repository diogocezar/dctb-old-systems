<?php
/**
* complementos
*/
include("../lib/library.php");
include("../lib/util.php");

$session = $controlador['session'];

$session->startSession();

$permitido   = false;
$registra    = false;
$passouLogin = false;

$login = $_POST['login'];
$senha = $_POST['senha'];

if(!empty($login) && !empty($senha)){

	$passouLogin = true;

	if($login == LOGIN_ADMIN && $senha == SENHA_ADMIN){
		$registra       = true;
		$permitido      = true;
		$id             = "-1";
		$nome           = "Administrador";
		$login          = LOGIN_ADMIN;
		$senha          = SENHA_ADMIN;
		$redireciona    = "administrar.php";
	}
	if($registra){
		$ip = getIp();
		$sessions = array('sessId'    => $id,
						  'sessNome'  => $nome,
						  'sessLogin' => $login,
						  'sessIp'    => $sessIp
						  );
		$session->__go_Session($sessions);
		
		/* guardando log */
		$quando = getData(4)."#".getHora(":",1);
		$adminInfos = array('ip:'     => $ip,
							'nome:'   => $nome,
							'quando:' => $quando
							);
		registraLogAdmin($diretorio['log'], $adminInfos, true);
	}
}

if(!empty($_SESSION['sessId'])){
	$permitido = true;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='index.php'</script>";
	exit();
}

if($passouLogin){
	echo "<script language=javascript>location.href='$redireciona'</script>";
	exit();
}
?>