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

$cpf = retiraSeparadores($_POST['cpf']);

if(empty($cpf)){
		echo "<script language=javascript>javascript:history.go(-1);</script>";
		exit();
}

$sql = "SELECT e.ema_email, u.usu_nome, u.usu_sobrenome, u.usu_login, u.usu_senha
        FROM {$tabela['email']} e, {$tabela['usuario']} u, {$tabela['cliente']} c
        WHERE c.cli_cpf = '$cpf' AND c.usu_cod = u.usu_cod AND u.ema_id = e.ema_id LIMIT 1";

$resultado = $dataBase->query($sql);
$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

if(!empty($dados)){

	/* Enviando o email para o administrador do site */
	
	$titulo     = "Reenvio de sua senha : ";
	
	$nome       = $dados['usu_nome']."".$dados['usu_sobrenome'];
	
	$conteudo   = "Olá, <b>$nome.</b><br><br>";
	$conteudo  .= "Você solicitou um lembrete para suas informações necessárias para o acesso ao site Locadora Omega<br><br>";
	$conteudo  .= "Como o solicitado seguem as informações : <br><br>";
	$conteudo  .= "Login : <b>{$dados['usu_login']}</b><br>";
	$conteudo  .= "Senha : <b>{$dados['usu_senha']}</b>";
	
	$email = new SendMail($titulo, $conteudo, $dados['ema_email']);
	
	$email->goMail();
	
	echo "<script language=javascript>alert('Seus dados foram enviados para e-mail : ".'\n'." {$dados['ema_email']}');javascript:history.go(-1);</script>";

}
else{
	echo "<script language=javascript>alert('Desculpe mas o CPF digitado não consta em nosso banco de dados.');javascript:history.go(-1);</script>";
}
?>