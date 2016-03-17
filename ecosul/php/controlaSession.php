<?
@$session = new Session();

$permitido = false;

$login = $_POST['login'];
$senha = $_POST['senha'];

if(!empty($login) && !empty($senha)){
	if($login == "admin" && $senha == "admin"){
			$permitido = true;	
					
			$sessIp    = getIp();
			$sessNome  = "admin";
			
			$_SESSION['permitidoSession'] = "sim";
			$_SESSION['ipSession'] = $sessIp;
			$_SESSION['nomeSession'] = $sessNome;

			
			/* Guardando Log */
			$adminInfos = array('ip:'     => $ip,
								'nome:'   => "admin",
								'quando:' => getData(4)."#".getHora(":",1)
								);
			
			registraLogAdmin($diretorio['log'], $adminInfos, true);
	}
}
else{
	if($_SESSION['permitidoSession'] == 'sim'){
		$permitido = true;
		$sessIp    = $_SESSION['ipSession'];
		$sessNome  = $_SESSION['nomeSession'];
	}
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
	exit();
}
?>