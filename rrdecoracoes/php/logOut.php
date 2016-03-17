<?php
/* Incluindo classes */
include('../classes/Session.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');


@$session = new Session();

if($_SESSION['permitidoSession'] == 'sim'){
	$nome  = $session->retornaSession('nomeSession');
	$ip    = $session->retornaSession('ipSession');
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