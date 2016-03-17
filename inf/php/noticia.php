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

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Extraindo variaveis do navegador */
$acao  = anti_sql_injection($_GET['acao']);
$id    = anti_sql_injection($_GET['id']);

switch($acao){
	case 'adicionar' :
		$page['action'] = "adiciona.php?tipo=noticia";
		$page['titulo'] = "Inserir Notícia";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=noticia&id=$id";
		$page['titulo'] = "Atualizar Notícia";
		$sql = "SELECT 	tituloNo, descricaoNo, imagemNo
		FROM {$tabela['noticias']}
		WHERE idNoticias = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['tituloNot']  = $dados['tituloNo'];
		$page['descricao']  = desconverteQuebra($dados['descricaoNo']);
		$page['imagem']     = $dados['imagemNo'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formNoticia.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_noticia");

	/* Formulario */
		$template->setVariable("form_noticia", "form_noticia");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("tituloNoticia", "Título da notícia");
		$template->setVariable("descricao", "Descrição");
		$template->setVariable("imagem", "Imagem");
		
	/* Nomes dos Campos */
		$template->setVariable("campoTitulo", "not_titulo");
		$template->setVariable("campoDescricao", "not_descricao");
		$template->setVariable("campoImagem", "not_imagem");
			
	/* Valores dos Campos */
		$template->setVariable("valorTitulo", $page['tituloNot']);
		$template->setVariable("valorDescricao", $page['descricao']);
		$template->setVariable("valorImagem", $page['imagem']);
		
	/* Foto Cadastrada */
		if($acao == 'atualizar' && !empty($page['imagem'])){
			$template->setCurrentBlock("blk_foto_cadastrada");
				$alt = $altura['not'];
				$lar = $largura['not'];
				$sca = $scalar['not'];
				$tit = $page['tituloNot'];
				$img = "<a href = \"#\" onclick=\"abrir('showImg.php?loc={$page['imagem']}&l=$lar&a=$alt&s=$sca&tit=$tit', $alt, $lar, 'no')\" class=\"linkPaginacao\">{$page['imagem']}</a>";
				$template->setVariable("fotoCadastrada", $img);	
			$template->parseCurrentBlock("blk_foto_cadastrada");		
		}

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValNoticia(document.form_noticia.not_titulo, document.form_noticia)");
		
$template->parseCurrentBlock("blk_form_noticia");

$conteudo = $template->get();
$tituloInterna = "Área Restrita";

include("includeInterna.php");
?>