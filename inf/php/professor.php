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
$lattes = "http://lattes.cnpq.br/1431388428304935";

switch($acao){
	case 'adicionar' :
		$page['action'] = "adiciona.php?tipo=professor";
		$page['titulo'] = "Inserir Professor";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=professor&id=$id";
		$page['titulo'] = "Atualizar Professor";
		$sql = "SELECT nomePro, nickPro, fotoPro, sitePro, descricaoPro, emailPro
		FROM {$tabela['professores']}
		WHERE idProfessores = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']      = $dados['nomePro'];
		$page['nick']      = $dados['nickPro'];
		$page['foto']      = $dados['fotoPro'];
		$page['site']      = $dados['sitePro'];
		$page['descricao'] = desconverteQuebra($dados['descricaoPro']);
		$page['email']     = $dados['emailPro'];		
		break;
}

/* Gerando informações do Lattes */



/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formProfessor.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_professor");

	/* Formulario */
		$template->setVariable("form_professor", "form_professor");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("nick", "Nick");
		$template->setVariable("foto", "Foto");
		$template->setVariable("site", "Site");
		$template->setVariable("descricao", "Descrição");
		$template->setVariable("email", "Email");
		
	/* Foto Cadastrada */
		if($acao == 'atualizar' && !empty($page['foto'])){
			$template->setCurrentBlock("blk_foto_cadastrada");
				$alt = $altura['pro'];
				$lar = $largura['pro'];
				$sca = $scalar['pro'];
				$tit = $page['nome'];
				$foto = "<a href = \"#\" onclick=\"abrir('showImg.php?loc={$page['foto']}&l=$lar&a=$alt&s=$sca&tit=$tit', $alt, $lar, 'no')\" class=\"linkPaginacao\">{$page['foto']}</a>";
				$template->setVariable("fotoCadastrada", $foto);	
			$template->parseCurrentBlock("blk_foto_cadastrada");		
		}

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "pro_nome");
		$template->setVariable("campoNick", "pro_nick");
		$template->setVariable("campoFoto", "pro_foto");
		$template->setVariable("campoSite", "pro_site");
		$template->setVariable("campoDescricao", "pro_descricao");
		$template->setVariable("campoEmail", "pro_email");		
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorNick", $page['nick']);
		$template->setVariable("valorFoto", $page['foto']);
		$template->setVariable("valorSite", $page['site']);
		$template->setVariable("valorDescricao", $page['descricao']);
		$template->setVariable("valorEmail", $page['email']);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValProf(document.form_professor.pro_nome, document.form_professor.pro_nick, document.form_professor.pro_site, document.form_professor.pro_descricao, document.form_professor.pro_email, document.form_professor)");
		
$template->parseCurrentBlock("blk_form_professor");

$conteudo = $template->get();
$tituloInterna = "Área Restrita";

include("includeInterna.php");
?>