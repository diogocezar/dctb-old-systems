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
		$page['action'] = "adiciona.php?tipo=disciplina";
		$page['titulo'] = "Inserir Disciplina";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=disciplina&id=$id";
		$page['titulo'] = "Atualizar Disciplina";
		$sql = "SELECT nomeDi, periodoDi, cargaHorariaDi, objetivosDi, ementasDi
		FROM {$tabela['disciplinas']}
		WHERE idDisciplinas = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']         = $dados['nomeDi'];
		$page['periodo']      = $dados['periodoDi'];
		$page['cargaHoraria'] = $dados['cargaHorariaDi'];
		$page['objetivos']    = desconverteQuebra($dados['objetivosDi']);
		$page['ementas']      = desconverteQuebra($dados['ementasDi']);
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formDisciplina.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_disciplina");

	/* Formulario */
		$template->setVariable("form_disciplina", "form_disciplina");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("periodo", "Período");
		$template->setVariable("cargaHoraria", "Carga Horária");
		$template->setVariable("objetivos", "Objetivos");
		$template->setVariable("ementas", "Ementas");
		
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "dis_nome");
		$template->setVariable("campoPeriodo", "dis_periodo");
		$template->setVariable("campoCargaHoraria", "dis_carga_horaria");
		$template->setVariable("campoObjetivos", "dis_objetivos");
		$template->setVariable("campoEmentas", "dis_ementas");
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorPeriodo", $page['periodo']);
		$template->setVariable("valorCargaHoraria", $page['cargaHoraria']);
		$template->setVariable("valorObjetivos", $page['objetivos']);
		$template->setVariable("valorEmentas", $page['ementas']);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValDisc(document.form_disciplina.dis_nome, document.form_disciplina.dis_periodo, document.form_disciplina.dis_carga_horaria, document.form_disciplina.dis_objetivos, document.form_disciplina.dis_ementas,  document.form_disciplina)");
		
$template->parseCurrentBlock("blk_form_disciplina");

$conteudo = $template->get();
$tituloInterna = "Área Restrita";

include("includeInterna.php");
?>