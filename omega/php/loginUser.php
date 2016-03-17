<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Fazendo a verificação no banco de dados se o usuário e/ou senha são válidos */

$permitido = false;

$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

@$session = new Session();

$session->limpaSessions();

$resultado = $dataBase->query("SELECT cli.cli_cpf, cli.cli_bloqueado, usu.usu_nome, usu.usu_sobrenome, usu.usu_login, usu.usu_senha
                               FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli
							   WHERE cli.usu_cod = usu.usu_cod AND tip_id_user = 1");

while($data = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($data['usu_login'] == $usuario && $data['usu_senha'] == $senha){	
		if($data['cli_bloqueado'] != "Não"){
			echo "<script language=javascript>alert('Desculpe mas você foi bloqueado de nosso site.');location.href='index.php'</script>";
		}
		else{
			$sessions = array('usuarioSession'   => 'sim',
							  'codSession'       => $data['cli_cpf'],
							  'nomeSession'      => limitaStr($data['usu_nome'], 30),
							  'loginSession'     => $data['usu_login']
							 );
			$session = new Session($sessions);
			$permitido = true;
		}
	}
}

$resultado->free();

echo "<script language=javascript>location.href='index.php'</script>";
?>