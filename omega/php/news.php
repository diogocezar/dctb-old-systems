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

$email = $_POST['email'];

$opcao = $_POST['opnews'];

switch($opcao){
	case 'cadastrar':
		if(!existeEmail($email)){
			insereEmail($email, "Sim");
			echo "<script language=javascript>alert('Obrigado, seu e-mail foi cadastrado com sucesso !');location.href='index.php'</script>";
		}
		else{
			echo "<script language=javascript>alert('Desculpe, esse e-mail j� consta em nosso banco de dados.');location.href='index.php'</script>";
		}
		break;
	case 'remover':
		$sql = "SELECT count(*) as qtd
				FROM {$tabela['email']} ema, {$tabela['usuario']} usu
				WHERE usu.ema_id = ema.ema_id AND ema.ema_email = '$email'";
		$resultado = $dataBase->query($sql);
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		if($dados['qtd'] > 0){
			echo "<script language=javascript>alert('Esse email n�o pode ser removido, pois est� relacionado com um usu�rio de nosso site.".'\n'.
			     "Para cancelar o envio de nossos e-mails, desmarque a op��o correspondente em seu painel de controle.');location.href='index.php'</script>";
		}
		else{
			$dataBase->query("DELETE FROM {$tabela['email']} WHERE ema_email = '$email'");
			echo "<script language=javascript>alert('Obrigado, seu e-mail foi removido com sucesso !');location.href='index.php'</script>";
		}
		break;
}
?>