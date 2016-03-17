<?php
/* Incluindo classes */
include('../classes/Session.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');


@$session = new Session();

if($_SESSION['permitidoSession'] == 'sim'){
	$nome  = $_SESSION['nomeSession'];
	$ip    = $_SESSION['ipSession'];
}

/* Guardando Log */
$adminInfos = array('ip:'     => $ip,
					'nome:'   => $nome,
					'quando:' => getData(4)."#".getHora(":",1)
					);

registraLogAdmin($diretorio['log'], $adminInfos, false);

$session->limpaSessions();

echo "<script language=javascript>location.href='login.php'</script>";
?>