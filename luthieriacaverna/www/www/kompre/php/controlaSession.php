<?
@$session = new Session();

$permitido = false;

$login = $_POST['login'];
$senha = $_POST['senha'];

if(!empty($login) && !empty($senha)){
	$resultado = $dataBase->query("SELECT adm_cod, adm_nome, adm_login, adm_senha FROM {$tabela['administradores']}");
	
	while($data = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		if($data['adm_login'] == $login && $data['adm_senha'] == $senha){
			$permitido = true;
			
			$ip    = getIp();
			$cod   = $data['adm_cod'];
			$cod   = (int)$cod;
			$nome  = retorna2Nomes($data['adm_nome']);
			$login = $data['adm_login'];

			$sessions = array('permitidoSession' => 'sim',
							  'codSession'       => '#'.$cod,
							  'nomeSession'      => $nome,
							  'loginSession'     => $login,
							  'ipSession'        => $ip
							 );
							 
			$session = new Session($sessions);
			
			/* Guardando Log */
			$adminInfos = array('ip:'     => $ip,
								'nome:'   => $data['adm_nome'],
								'quando:' => getData(4)."#".getHora(":",1)
								);
			
			registraLogAdmin($diretorio['logs'], $adminInfos, true);
		}
	}
	
	$resultado->free();
}
else{
	if($_SESSION['permitidoSession'] == 'sim'){
		$permitido = true;
		$cod   = sessionNum($session->retornaSession('codSession'));
		$cod   = (int)$cod;
		$nome  = $session->retornaSession('nomeSession');
		$login = $session->retornaSession('loginSession');
		$ip    = $session->retornaSession('ipSession');
	}
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
	exit();
}

?>