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

/* Arquivo de controle da Session */
include('./controlaSession.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

$continuar = false;

switch($op){
	case 'loja' :
		$prefix = "A";
		$titulo = "Loja";
		$continuar = true;
		
		$camTitulo = $_POST["titulo"];
		$endereco  = converteQuebra($_POST["endereco"]);
		$telefone  = converteQuebra($_POST["telefone"]);
		$email     = $_POST['email'];
		$contatos  = converteQuebra($_POST["contatos"]);
		$descricao = converteQuebra($_POST["descricao"]);
		$arquivo   = $_FILES['arquivo'];
		
		/* Selecionando a foto do banco */		
		$sql = "SELECT loj_foto_url FROM {$tabela['lojas']} WHERE loj_cod = $id";	
		$urlFoto = $dataBase->getOne($sql);
		
		if($arquivo['error'] != 4){ // Se a foto não estiver vazia.
			/* Apagando foto anterior */
			if(is_file($urlFoto)){
				unlink($urlFoto);
			}
			/* Enviando a foto da loja */
			$sendFile = new SendFile($arquivo, $diretorio['lojas']);
			$nomeFoto  = $sendFile->getNome();
		}
		else{
			$nomeFoto = $urlFoto;
		}

		$valores = array(
			$camTitulo,
			$endereco,
			$telefone,
			$email,
			$contatos,
			$descricao,
			$nomeFoto
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['lojas'], "loj_cod = $id", $campos['lojas'], $valores);
		
		break;

	case 'dica' :
		$prefix = "A";
		$titulo = "Dica";
		$continuar = true;
		
		$camTitulo = $_POST["titulo"];
		$descricao = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$camTitulo,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['dicas'], "dic_cod = $id", $campos['dicas'], $valores);

		break;
	
	case 'servico' :
		$prefix = "O";
		$titulo = "Serviço";
		$continuar = true;
		
		$camTitulo = $_POST["titulo"];
		$descricao = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$camTitulo,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['servicos'], "ser_cod = $id", $campos['servicos'], $valores);

		break;
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/atualiza.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>atualizad".strtolower($prefix)."</b> com sucesso.<br><br>";
if(empty($voltar)){ $voltar = 'administrar.php'; }
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";
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

$show = $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* Bloco Menu */
$template->setCurrentBlock("bloco_menu");
	$i = 0;
	foreach($menu as $replace => $link){
		$template->setVariable($replace, $link);
	}
$template->parseCurrentBlock("bloco_menu");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("conteudoInterno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>