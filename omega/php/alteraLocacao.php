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
		echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='login.php'</script>";
		exit();
}

$id         = $_GET['id'];

$travaEnvio = $_GET['trava'];

$altera     = $_GET['altera'];

$db = new DataBase();

switch($altera){
	case 'locar':
		$sit = $situacao[1];
		$midias = retornaMidiasLoc($id);
		foreach($midias as $codigos){
			$db->Query("UPDATE {$tabela['midia']} SET mid_status = 'Sim' WHERE mid_cod = $codigos");
		}
		if(empty($travaEnvio)){
			/* Resgatando dados do cliente para envio do e-mail */
			
				$sql = "SELECT usu.ema_id, usu.usu_nome, usu.usu_sobrenome
				FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli, {$tabela['locacao']} loc
				WHERE loc.cli_cpf = cli.cli_cpf AND cli.usu_cod = usu.usu_cod AND loc.loc_cod = $id";	
				
				$resultado = $dataBase->query($sql);
				$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
				
				$clienteInfos['nome']          = $dados['usu_nome'];
				$clienteInfos['sobrenome']     = $dados['usu_sobrenome'];
				$clienteInfos['email']         = retornaEmail($dados['ema_id']);
				
				$nomeCli = $clienteInfos['nome']." ".$clienteInfos['sobrenome'];
				$mailCli = $clienteInfos['email'];
			
			/* Enviando o email para o administrador do site */
			
			$conteudo  = "Ol� <b>$nomeCli</b>, um de nossos administradores confirmou sua loca��o.<br><br>";
			$conteudo .= "Voc� receber� o seu pedido conforme os dados solicitados na loca��o.<br><br>";
			$conteudo .= "Obrigado por sua prefer�ncia.";
			
			$titulo    = "Loca��o confirmada.";
			
			$email = new SendMail($titulo, $conteudo, $mailCli);
			$email->goMail();
		}
		
		break;
		
	case 'fechar':
		$sit = $situacao[2];
		$midias = retornaMidiasLoc($id);
		foreach($midias as $codigos){
			$db->Query("UPDATE {$tabela['midia']} SET mid_status = 'N�o' WHERE mid_cod = $codigos");
		}
		break;
		
	case 'aguardando':
		$sit = $situacao[3];
		break;
}

$db->Query("UPDATE {$tabela['locacao']} SET loc_situacao = '$sit' WHERE loc_cod = $id");

echo "<script language=javascript>alert('A situa��o da loca��o foi alterada com sucesso !');javascript:history.go(-1);</script>";
?>