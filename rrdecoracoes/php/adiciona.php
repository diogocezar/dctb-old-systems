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

if($op != 'visitante'){
	/* Arquivo de controle da Session */
	include('./controlaSession.php');
}

$continuar = false;

switch($op){
	case 'visitante' :
		$prefix = "O";
		$titulo = "Visitante";
		$voltar = "javascript:history.go(-1);";
		
		$nome   = $_POST['nome'];
		$cidade = $_POST['cidade'];
		$email  = $_POST['email'];
				
		$valores = array(
			$nome,
			$cidade,
			$email
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['visitantes'], $campos['visitantes'], $valores);

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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['clientes'], $campos['clientes'], $valores);

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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['novidades'], $campos['novidades'], $valores);
		
		if($enviar == "sim"){
			/* Enviar para os clientes */
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['administradores'], $campos['administradores'], $valores);
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['servicos'], $campos['servicos'], $valores);

		break;
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/adiciona.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>inserid".strtolower($prefix)."</b> com sucesso.<br><br>";
if(empty($voltar)){ $voltar = 'administrar.php'; }
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";
if($continuar == true){
	$msg .= "<br><br><input name=\"Continuar\" type=\"button\" class=\"botao\" id=\"Continuar\" value=\"» Continuar cadastrando\" onclick=\"javascript:history.go(-1);\" />";
}
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