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
	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
		$continuar = true;
		
		$nomeCat     = $_POST["nome"];
		$descricao   = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$nomeCat,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['categorias'], "cat_cod = $id", $campos['categorias'], $valores);
		
		break;

	case 'fabricante' :
		$prefix = "O";
		$titulo = "Fabricante";
		$continuar = true;
		
		$nomeFab     = $_POST["nome"];
		$telefone    = $_POST["telefone"];
		$website     = $_POST["website"];
		
		$valores = array(
			$nomeFab,
			$telefone,
			$website
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['fabricantes'], "fab_cod = $id", $campos['fabricantes'], $valores);
		
		break;
	
	case 'produto' :
		$prefix = "O";
		$titulo = "Produto";
		$continuar = true;
		
		$nomePro         = $_POST["nome"];
		$peso            = limpaPreco($_POST["peso"]);
		$preco           = $_POST["preco"];
		$qtd             = $_POST["qtd"];
		$disponibilidade = $_POST["disponibilidade"];
		$classificacao   = $_POST["classificacao"];
		$promocao        = $_POST["promocao"];
		$descricao       = converteQuebra($_POST["descricao"]);		
		$especificacao   = converteQuebra($_POST["especificacao"]);
		$dadosTecnicos   = converteQuebra($_POST["dados_tecnicos"]);
		$itensInclusos   = converteQuebra($_POST["itens_inclusos"]);
		$garantia        = converteQuebra($_POST["garantia"]);
		$categoria       = $_POST["categoria"];
		$fabricante      = $_POST["fabricante"];

		$arquivos        = @sortArquivos($_FILES['arquivos']);
		
		$valores = array(
			$nomePro,
			$peso,
			$preco,
			$qtd,
			$disponibilidade,
			$classificacao,
			$promocao,
			$descricao,
			$especificacao,
			$dadosTecnicos,
			$itensInclusos,
			$garantia,
			$categoria,
			$fabricante
		);
		
		/* Inserindo Produto */
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['produtos'], "pro_cod = $id", $campos['produtos'], $valores);
		
		/* Inserindo as Imagens */
		
		if(!empty($arquivos[0]['name'])){

			$codProduto = $id;
			
			$passou = true;
			
			$inserir = new DataBase();
			
			/* Setando todas fotos como secundárias */
			$sql = "UPDATE {$tabela['produtos_fotos']} SET pro_fot_principal = 'N' WHERE pro_cod = $codProduto";
			$dataBase->Query($sql);

			
			foreach($arquivos as $indice => $valor){
				/* Upload de imagens */
				$sendFile = new SendFile($arquivos[$indice], $diretorio['produtos']);
				$nomeFoto  = $sendFile->getNome();
				/* Cadastrando a Foto no Banco de Dados */
				$codFoto = cadastraFoto($nomeFoto);
				/* Cadastro no Banco de Dados */
				if($passou){ $fotoPrincipal = "S"; $passou = false; } else{ $fotoPrincipal = "N"; }
				$valores = array($codProduto, $codFoto, $fotoPrincipal);
				$inserir->Insert($tabela['produtos_fotos'], $campos['produtos_fotos'], $valores);
			}
		}

		break;
	
	case 'administrador' :
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		
		$nomeAdm  = $_POST["nome"];
		$email    = $_POST["email"];
		$loginAdm = $_POST["loginCad"];
		$senha    = $_POST["senhaCad"];				
		
		$valores = array(
			$nomeAdm,
			$email,
			$loginAdm,
			$senha
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['administradores'], "adm_cod = $id", $campos['administradores'], $valores);
		
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

$templateHtmlName = 'templateAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO_KOMPRE);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");	
	$template->setVariable("admin",  "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
	$template->setVariable("logoff", "<a href=\"logout.php\"><img src=\"../images/botLogoff.gif\" border = \"0\"></a>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $msg);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>