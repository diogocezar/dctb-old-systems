<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

if($op != 'cliente'){
	/* Arquivo de controle da Session */
	include('./controlaSession.php');
}

$continuar = false;

switch($op){
	case 'visitante' :
		$prefix = "O";
		$titulo = "Visitante";
		$continuar = false;
		$voltar = "javascript:history.go(-1);";
		
		$nome   = $_POST['nome'];
		$cidade = $_POST['cidade'];
		$email  = $_POST['email'];
				
		$valores = array(
			$nome,
			$cidade,
			$email
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['visitantes'], "idVisitante = $id", $campos['visitantes'], $valores);

		break;

	case 'cliente' :
		$prefix = "O";
		$titulo = "Cliente";
		$continuar = true;
		
		$nome = $_POST["nome_cliente"];
		$link = $_POST["link"];
		
		$valores = array(
			$nome,
			$link
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['clientes'], "idCliente = $id", $campos['clientes'], $valores);

		break;
		
	case 'newsletter':
		$prefix = "A";
		$titulo = "Newsletter";
		$continuar = true;
		
		$cmpTitulo = $_POST["titulo"];
		$descricao = $_POST["descricao"];
		$enviar    = $_POST["enviar"];

		$valores = array(
			$cmpTitulo,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['novidades'], "idNovidade = $id", $campos['novidades'], $valores);
		
		if($enviar == "sim"){
			/* Re-enviar para os clientes */
		}

		break;


	case 'admin':
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		
		$nome  = $_POST["adm_nome"];
		$login = $_POST["adm_login"];
		$senha = $_POST["adm_senha"];
		
		$valores = array(
			$nome,
			$login,
			$senha
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['administradores'], "idAdministrador = $id", $campos['administradores'], $valores);
		
		break;

	
	case 'servico' :
		$prefix = "O";
		$titulo = "Serviço";
		$continuar = true;
		
		$nome = $_POST["nome"];
		$descricao = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$nome,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['servicos'], "idServico = $id", $campos['servicos'], $valores);

		break;
		
	case 'texto' :
		$prefix = "O";
		$titulo = "Texto Institucional";
		$continuar = true;
		
		$texto = $_POST["texto"];
		
		$atualizar = new DataBase();
		
		$atualizar->Query("UPDATE {$tabela['configuracoes']} SET textoInstitucional = '$texto'");

		break;
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/atualiza.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>atualizad".strtolower($prefix)."</b> com sucesso.<br><br>";
if(empty($voltar)){ $voltar = 'administrar.php'; }
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";
$msg .= "</div>";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'finalizado.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_finalizado");
	$template->setVariable("conteudo", $msg);
$template->parseCurrentBlock("bloco_finalizado");

$template->show();
?>