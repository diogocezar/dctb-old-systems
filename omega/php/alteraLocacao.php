<?php
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
			
			$conteudo  = "Olá <b>$nomeCli</b>, um de nossos administradores confirmou sua locação.<br><br>";
			$conteudo .= "Você receberá o seu pedido conforme os dados solicitados na locação.<br><br>";
			$conteudo .= "Obrigado por sua preferência.";
			
			$titulo    = "Locação confirmada.";
			
			$email = new SendMail($titulo, $conteudo, $mailCli);
			$email->goMail();
		}
		
		break;
		
	case 'fechar':
		$sit = $situacao[2];
		$midias = retornaMidiasLoc($id);
		foreach($midias as $codigos){
			$db->Query("UPDATE {$tabela['midia']} SET mid_status = 'Não' WHERE mid_cod = $codigos");
		}
		break;
		
	case 'aguardando':
		$sit = $situacao[3];
		break;
}

$db->Query("UPDATE {$tabela['locacao']} SET loc_situacao = '$sit' WHERE loc_cod = $id");

echo "<script language=javascript>alert('A situação da locação foi alterada com sucesso !');javascript:history.go(-1);</script>";
?>