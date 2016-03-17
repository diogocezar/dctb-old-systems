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
		$page['action'] = "adiciona.php?tipo=ecoturismo";
		$page['titulo'] = "Inserir Ecoturismo";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=ecoturismo&id=$id";
		$page['titulo'] = "Atualizar Ecoturismo";
		$sql = "SELECT 	nomeEcoturismo, descricaoEcoturismo, localizacaoEcoturismo, acessoEcoturismo, fotosEcoturismo, idTipoEcoturismo
		FROM {$tabela['ecoturismo']}
		WHERE idEcoturismo = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']        = $dados['nomeEcoturismo'];
		$page['descricao']   = $dados['descricaoEcoturismo'];
		$page['localizacao'] = $dados['localizacaoEcoturismo'];
		$page['acesso']      = $dados['acessoEcoturismo'];
		$page['fotos']       = $dados['fotosEcoturismo'];
		$page['tipo']        = $dados['idTipoEcoturismo'];
		break;
}

$opcoes = "";

$sql = "SELECT idTipoEcoturismo, nomeTipoEcoturismo FROM {$tabela['tipoecoturismo']} ORDER BY nomeTipoEcoturismo ASC";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$opcoes .= "<option value=\"{$dados['idTipoEcoturismo']}\"";
		if($dados['idTipoEcoturismo'] == $page['tipo']){
			$opcoes .= "selected";
		}
		$opcoes .= ">{$dados['nomeTipoEcoturismo']}</option>";
	}
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formEcoturismo.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_ecoturismo");

	/* Formulario */
		$template->setVariable("form_ecoturismo", "form_ecoturismo");
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
		$template->setVariable("campoNome", "eco_nome");
		$template->setVariable("campoDescricao", "eco_descricao");
		$template->setVariable("campoLocalizacao", "eco_localizacao");
		$template->setVariable("campoAcesso", "eco_acesso");
		$template->setVariable("campoFotos", "eco_fotos");
		$template->setVariable("comboTipoEcoturismo", "eco_combo_tipo");	
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorDescricao", $page['descricao']);
		$template->setVariable("valorLocalizacao", $page['localizacao']);
		$template->setVariable("valorAcesso", $page['acesso']);
		$template->setVariable("valorFotos", $page['fotos']);
		
	/* Preenchendo o combo */
	
		$template->setVariable("comboOpcoesEcoturismo", $opcoes);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "ecoValEcoturismo(document.form_ecoturismo.eco_nome, document.form_ecoturismo.eco_descricao, document.form_ecoturismo.eco_localizacao,  document.form_ecoturismo.eco_acesso, document.form_ecoturismo.eco_fotos, document.form_ecoturismo)");
		
$template->parseCurrentBlock("blk_ecoturismo");

$conteudo = $template->get();

include("includeInterna.php");
?>