<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Incluindo sAjax */
include('../classes/sAjax/Sajax.php');

/* Funções executadas pelo sAjax */
function salvaEmail($email, $cpf){
	global $dataBase;
	global $tabela;	
	
	/* Selecionando usuário que está com o id do email */
	$sql = "SELECT ema_id FROM {$tabela['usuario']} u, {$tabela['cliente']} c WHERE c.usu_cod = u.usu_cod AND c.cli_cpf = $cpf";
	$resultado = $dataBase->getRow($sql);
	$idEmail   = $resultado[0];	
	
	/* Salvando o novo e-mail */
	$sql = "UPDATE {$tabela['email']} SET ema_email = '$email' WHERE ema_id =  $idEmail";
	$dataBase->Query($sql);
}

/* Configurando o sAjax */

sajax_init();

$sajax_debug_mode = 0;

sajax_export("salvaEmail");

sajax_handle_client_request();

/* Bloco JavaScript sAjax */

$funcaoJs  = "function executado(){
				alert('e-mail alterado com sucesso !');
              }";

$funcaoJs .= "function salvaEmail(email, cpf){
				  x_salvaEmail(email, cpf, executado);
              }";

$permitido = false;

@$session = new Session();

/* Caputando cpf do cliente em detalhe */

$id = $_GET['cliente'];

if($_SESSION['permitidoSession'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('codSession'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nomeSession');
	$login = $session->retornaSession('loginSession');
	$tipo = sessionNum($session->retornaSession('tipoSession'));
	$tipo = (int)$tipo;
}

if($permitido != true || empty($id)){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
}
else{
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'detalhesCliente.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco JavaScript sAjax */
	$template->setCurrentBlock("bloco_javascript_sajax");
		$template->setVariable("sajax_javascript", sajax_show_javascript());
		$template->setVariable("funcoes_javascript", $funcaoJs);	
	$template->parseCurrentBlock("bloco_javascript_sajax");
		
	/* Bloco do Login */
	$template->setCurrentBlock("bloco_detalhes_cliente");
	
			$sql = "SELECT cli.cli_cpf, cli.usu_cod, cli.cli_rg, cli.cli_rua, cli.cli_numero, cli.cli_bairro, cli.cli_complemento, cli.cli_telefone, cli.cli_celular, 
			               cli.cli_data_nascimento, tx.txe_localizacao, tx.txe_valor, usu.usu_cod, usu.ema_id, usu.usu_nome, usu.usu_sobrenome,
						   usu.usu_login, usu.usu_senha, usu.tip_id_user
			        FROM {$tabela['usuario']} usu, {$tabela['cliente']} cli, {$tabela['taxa_entrega']} tx
			        WHERE cli.cli_cpf = '$id'
				    AND cli.usu_cod = usu.usu_cod
				    AND cli.txe_cod = tx.txe_cod";
				   
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$clienteInfos['nome']          = $dados['usu_nome'];
			$clienteInfos['sobrenome']     = $dados['usu_sobrenome'];
			$clienteInfos['email']         = retornaEmail($dados['ema_id']);
			$clienteInfos['news']          = retornaNews($dados['ema_id']);
			$clienteInfos['login']         = $dados['usu_login'];
			$clienteInfos['senha']         = $dados['usu_senha'];
			$clienteInfos['tip_id_user']   = $dados['tip_id_user'];
			
			$clienteInfos['cpf']           = $dados['cli_cpf'];
			$clienteInfos['rg']            = $dados['cli_rg'];
			$clienteInfos['rua']           = $dados['cli_rua'];
			$clienteInfos['numero']        = $dados['cli_numero'];
			$clienteInfos['bairro']        = $dados['cli_bairro'];
			$clienteInfos['complemento']   = $dados['cli_complemento'];
			
			$clienteInfos['telefone']      = $dados['cli_telefone'];
			$clienteInfos['telefone_cel']  = $dados['cli_celular'];
			$clienteInfos['nascimento']    = converteData($dados['cli_data_nascimento']);
			$taxa                          = $dados['txe_localizacao']." (<b>".number_format($dados['txe_valor'], 2, ',','.')."</b>)";
			$clienteInfos['taxa']          = $taxa;
			
		/* Forms */
				
			$template->setVariable("btnSalvar", "salvar");
			$template->setVariable("onClickSalvar", "salvaEmail(campoEmail.value, $id)");
			$template->setVariable("campoEmail", "campoEmail");
						
		/* Titulo */
		
			$template->setVariable("tituloDetalhesCliente", "Detalhes do Cliente ");
			$template->setVariable("titulo", "Detalhes do Cliente");
	
		/* Campos */	
			$template->setVariable("nome", $clienteInfos['nome']);
			$template->setVariable("sobre", $clienteInfos['sobrenome']);
			$template->setVariable("email", $clienteInfos['email']);
			$template->setVariable("news", $clienteInfos['news'] );
			$template->setVariable("cpf", $clienteInfos['cpf']);
			$template->setVariable("rg", $clienteInfos['rg']);
			
			$template->setVariable("rua", $clienteInfos['rua']);
			$template->setVariable("numero", $clienteInfos['numero']);
			$template->setVariable("bairro", $clienteInfos['bairro']);
			$template->setVariable("complemento", $clienteInfos['complemento']);			
			$template->setVariable("telefone", $clienteInfos['telefone']);
			$template->setVariable("celular", $clienteInfos['telefone_cel']);
			$template->setVariable("nascimento", $clienteInfos['nascimento']);
			$template->setVariable("taxa", $clienteInfos['taxa']);
			$template->setVariable("login", $clienteInfos['login']);
			
	$template->parseCurrentBlock("bloco_detalhes_cliente");
	
	$template->show();
}
?>