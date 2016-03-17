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
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$page['action'] = "adiciona.php?tipo=atividade";
		$page['titulo'] = "Inserir Atividade";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=atividade&id=$id";
		$page['titulo'] = "Atualizar Atividade";
		$sql = "SELECT 	nomeAtividade, descricaoAtividade, localizacaoAtividade, acessoAtividade, fotosAtividade, idTipoAtividade
		FROM {$tabela['atividades']}
		WHERE idAtividades = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']        = $dados['nomeAtividade'];
		$page['descricao']   = $dados['descricaoAtividade'];
		$page['localizacao'] = $dados['localizacaoAtividade'];
		$page['acesso']      = $dados['acessoAtividade'];
		$page['fotos']       = $dados['fotosAtividade'];
		$page['tipo']        = $dados['idTipoAtividade'];
		break;
}

$opcoes = "";

$sql = "SELECT idTipoAtividade, nomeTipoAtividade FROM {$tabela['tipoatividade']} ORDER BY nomeTipoAtividade ASC";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$opcoes .= "<option value=\"{$dados['idTipoAtividade']}\"";
		if($dados['idTipoAtividade'] == $page['tipo']){
			$opcoes .= "selected";
		}
		$opcoes .= ">{$dados['nomeTipoAtividade']}</option>";
	}
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formAtividade.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_atividade");

	/* Formulario */
		$template->setVariable("form_atividade", "form_atividade");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("descricao", "Descrição");
		$template->setVariable("localizacao", "Localização");
		$template->setVariable("acesso", "Acesso");
		$template->setVariable("fotos", "Fotos");
		$template->setVariable("tipo", "Tipo");
		
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "ati_nome");
		$template->setVariable("campoDescricao", "ati_descricao");
		$template->setVariable("campoLocalizacao", "ati_localizacao");
		$template->setVariable("campoAcesso", "ati_acesso");
		$template->setVariable("campoFotos", "ati_fotos");
		$template->setVariable("comboTipoAtividade", "ati_combo_tipo");	
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorDescricao", $page['descricao']);
		$template->setVariable("valorLocalizacao", $page['localizacao']);
		$template->setVariable("valorAcesso", $page['acesso']);
		$template->setVariable("valorFotos", $page['fotos']);
		
	/* Preenchendo o combo */
	
		$template->setVariable("comboOpcoesAtividade", $opcoes);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "ecoValAtividade(document.form_atividade.ati_nome, document.form_atividade.ati_descricao, document.form_atividade.ati_localizacao, document.form_atividade.ati_acesso, document.form_atividade.ati_fotos, document.form_atividade)");
		
$template->parseCurrentBlock("blk_atividade");

$conteudo = $template->get();

include("includeInterna.php");
?>