<?php
session_start();

$session       = $controlador['session'];
$parametrosAdm = $controlador['parametrosadm'];
$parametrosAdm->__toFillGeneric();
$parametrosAdm->__get_db();

$permitido   = false;
$passouLogin = false;

$login = $_POST['cmpLogin'];
$senha = $_POST['cmpSenha'];

if(!empty($login) && !empty($senha)){

	$loginAdmin = $parametrosAdm->getLogin();
	$senhaAdmin = $parametrosAdm->getSenha();
	
	if($login == $loginAdmin && $senha == $senhaAdmin){		
		$session->salvaSession(SESSION_ADMIN, "sim");
		$session->salvaSession(SESSION_NOMEA, $login);			
		$permitido = true;
	}
}
else{
	$sessionPermitido = $controlador['session']->retornaSession(SESSION_ADMIN);
	if($sessionPermitido == "sim"){
		$permitido = true;		
	}
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='index.php'</script>";
	exit();
}
?>