<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("addCategoria", "login", "logout", "rmvCategoria");
sajax_handle_client_request();

function addCategoria($nome, $feed, $ordem){
	global $controlador;
	@$tree = $controlador['tree'];
	$tree->__go_Tree(true);
	if($tree->addMenu($nome, $feed, $ordem)){
		return true;
	}
	else{
		return false;
	}
}

function login($login, $senha){
	global $controlador;
	$admin = $controlador['admin'];
	$session = $controlador['session'];
	return $admin->allowAdmin($login, $senha, $session);
}

function logout(){
	global $controlador;
	$session = $controlador['session'];
	$session->removeSession(SESSION_PERMITIDO);
	$session->removeSession(SESSION_LOGIN);
	$session->removeSession(SESSION_ID);
	$session->removeSession(SESSION_NOME);
}

function rmvCategoria($id){
	global $controlador;
	@$tree = $controlador['tree'];
	$tree->__go_Tree(true);
	if($tree->rmvMenu($id)){
		return true;
	}
	else{
		return false;
	}
}
?>