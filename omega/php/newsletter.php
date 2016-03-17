<?php
/* Setando tempo limite da página para infinito (Caso o email demore para ser enviado) */
set_time_limit(0);

/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

@$session = new Session();

$permitido = false;

if($_SESSION['permitidoSession'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('codSession'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nomeSession');
	$login = $session->retornaSession('loginSession');
	$tipo = sessionNum($session->retornaSession('tipoSession'));
	$tipo = (int)$tipo;
}

if($permitido != true){
		echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
		exit();
}

$news = bbcode(converteQuebra($_POST['news']));

if(empty($news)){
		echo "<script language=javascript>javascript:history.go(-1);</script>";
		exit();
}

$sql = "SELECT DISTINCT ema_email, ema_send_news
        FROM {$tabela['email']}
        WHERE ema_send_news = 'Sim'";	

$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){

	/* Enviando o email para o administrador do site */
	
	$titulo    = "Novidade Locadora Omega : ";
	
	$email = new SendMail($titulo, $news, $dados['ema_email']);
	
	$email->goMail();

}

echo "<script language=javascript>alert('As informações foram enviadas com sucesso para os destinatários !');javascript:history.go(-1);</script>";
?>