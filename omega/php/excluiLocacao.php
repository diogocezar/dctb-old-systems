<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

$permitido = false;

@$session = new Session();

if($_SESSION['usuarioSession'] == 'sim'){
	$codUser  = $session->retornaSession('codSession');
	$permitido = true;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='index.php'</script>";
}
else{

	$id = $_GET['id'];
	
	$db = new DataBase();
	
	/* Excluindo a loca��o */
	
	$db->Query("DELETE FROM {$tabela['locacao']} WHERE cli_cpf = '$codUser' AND loc_cod = $id");
	
	/* Setando as m�dias como dispon�veis */
	
	$midias = retornaMidiasLoc($id);
	foreach($midias as $codigos){
		$db->Query("UPDATE {$tabela['midia']} SET mid_status = 'Sim' WHERE mid_cod = $codigos");
	}
	
	/* Excluindo relacionamentos de Produtos e Midias */
	
	$db->Query("DELETE FROM {$tabela['midia_locacao']} WHERE loc_cod = $id");
	$db->Query("DELETE FROM {$tabela['produtos_locacao']} WHERE loc_cod = $id");

	/* Enviando um email de aviso para o administrador */
	
	$sql = "SELECT usu.ema_id, usu.usu_nome, usu.usu_sobrenome
	FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli, {$tabela['locacao']} loc
	WHERE cli.usu_cod = usu.usu_cod AND cli.cli_cpf = $codUser";	
	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	
	$clienteInfos['nome']          = $dados['usu_nome'];
	$clienteInfos['sobrenome']     = $dados['usu_sobrenome'];
	$clienteInfos['email']         = retornaEmail($dados['ema_id']);
	
	$nomeCli = $clienteInfos['nome']." ".$clienteInfos['sobrenome'];
	$mailCli = $clienteInfos['email'];

	$conteudo  = "Ol� administrador.<br><br>";
	$conteudo .= "O cliente <b>$nomeCli</b> excluiu uma loca��o que estava aguardando autoriza��o.<br><br>";
	
	$titulo    = "Loca��o excluida.";
	
	$email = new SendMail($titulo, $conteudo, $mailCli);
	$email->goMail();
	
	echo "<script language=javascript>alert('Sua loca��o foi cancelada.');javascript:history.go(-1);</script>";
}
?>