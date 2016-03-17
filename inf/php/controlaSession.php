<?php
@$session = new Session();

session_start();

$permitido = false;

$login = $_POST['login'];
$senha = $_POST['senha'];

$sessIp = getIp();

/* Guardando Log de Tentativas */
$loginInfo = array('ip:'     => $sessIp,
					'login:'  => $login,
					'senha:'  => $senha,
					'quando:' => getData(4)."#".getHora(":",1)
					);

registraLogAdmin($diretorio['log_login'], $loginInfo, true);


if(!empty($login) && !empty($senha)){
	$resultado = $dataBase->query("SELECT idAdministradores, nomeAd, loginAd, senhaAd FROM {$tabela['administradores']}");
	
	while($data = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		if($data['loginAd'] == anti_sql_injection($login) && $data['senhaAd'] == anti_sql_injection($senha)){
			$permitido = true;
			
			$sessCod   = $data['idAdministradores'];
			$sessCod   = (int)$sessCod;
			$sessNome  = retorna2Nomes($data['nomeAd']);
			$sessLogin = $data['loginAd'];

			$sessions = array('permitidoSession' => 'sim',
							  'codSession'       => '#'.$sessCod,
							  'nomeSession'      => $sessNome,
							  'loginSession'     => $sessLogin,
							  'ipSession'        => $sessIp
							 );
							 
			$session = new Session($sessions);
			
			/* Guardando Log */
			$adminInfos = array('ip:'     => $sessIp,
								'nome:'   => $data['nomeAd'],
								'quando:' => getData(4)."#".getHora(":",1)
								);
			
			registraLogAdmin($diretorio['log'], $adminInfos, true);
		}
	}
	
	$resultado->free();
}
else{
	if($_SESSION['permitidoSession'] == 'sim'){
		$permitido = true;
		$sessCod   = sessionNum($session->retornaSession('codSession'));
		$sessCod   = (int)$sessCod;
		$sessNome  = $session->retornaSession('nomeSession');
		$sessLogin = $session->retornaSession('loginSession');
		$sessIp    = $session->retornaSession('ipSession');
	}
}

if($permitido != true){
	/* Verificando número de tentativas */
	
	if(empty($_SESSION['tentativas'])){
		$_SESSION['tentativas'] = 1;
	}
	else{
		$_SESSION['tentativas'] = $_SESSION['tentativas'] + 1;
	}
	
	if($_SESSION['tentativas'] == 4){
		$_SESSION['bloqueado'] = 'sim';
	}
	
	if($_SESSION['bloqueado'] == 'sim'){
		echo "<script language=javascript>alert('Desculpe mas você está temporariamente bloqueado em nosso sistema de login.');location.href='index.php'</script>";
		exit();
	}

	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
	exit();
}
?>