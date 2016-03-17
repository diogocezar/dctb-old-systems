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
		$page['action'] = "adiciona.php?tipo=cidade";
		$page['titulo'] = "Inserir Cidade";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=cidade&id=$id";
		$page['titulo'] = "Atualizar Cidade";
		$sql = "SELECT 	nomeCidade, descricaoCidade, localizacaoCidade, acessoCidade, fotosCidade
		FROM {$tabela['cidades']}
		WHERE idCidade = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']        = $dados['nomeCidade'];
		$page['descricao']   = $dados['descricaoCidade'];
		$page['localizacao'] = $dados['localizacaoCidade'];
		$page['acesso']      = $dados['acessoCidade'];
		$page['fotos']       = $dados['fotosCidade'];
		
		/* Resgatando os ítens da lista de Atividades */
		$sql = "SELECT a.idAtividades, nomeAtividade FROM {$tabela['atividadescidades']} ac, {$tabela['atividades']} a WHERE a.idAtividades = ac.idAtividades AND idCidade = $id ORDER BY nomeAtividade ASC";
		$resultado = $dataBase->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaAtividades .= "<option value=\"{$dados['idAtividades']}\"";
				$listaAtividades .= ">".$dados['nomeAtividade']."</option>";
			}
		}
		
		/* Resgatando os ítens da lista de Ecoturismos */
		$sql = "SELECT e.idEcoturismo, nomeEcoturismo FROM {$tabela['cidadesecoturismo']} ce, {$tabela['ecoturismo']} e WHERE e.idEcoturismo = ce.idEcoturismo AND idCidade = $id ORDER BY nomeEcoturismo ASC";
		$resultado = $dataBase->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaEcoturismos .= "<option value=\"{$dados['idEcoturismo']}\"";
				$listaEcoturismos .= ">".$dados['nomeEcoturismo']."</option>";
			}
		}		
		break;
}

$atividades = "";

$sql = "SELECT idAtividades, nomeAtividade FROM {$tabela['atividades']}";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$atividades .= "<option value=\"{$dados['idAtividades']}\"";
		$atividades .= ">{$dados['nomeAtividade']}</option>";
	}
}

$ecoturismos = "";

$sql = "SELECT idEcoturismo, nomeEcoturismo FROM {$tabela['ecoturismo']}";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$ecoturismos .= "<option value=\"{$dados['idEcoturismo']}\"";
		$ecoturismos .= ">{$dados['nomeEcoturismo']}</option>";
	}
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formCidade.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_cidade");

	/* Formulario */
		$template->setVariable("form_cidade", "form_cidade");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("descricao", "Descrição");
		$template->setVariable("localizacao", "Localização");
		$template->setVariable("acesso", "Acesso");
		$template->setVariable("fotos", "Fotos");
		
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "cid_nome");
		$template->setVariable("campoDescricao", "cid_descricao");
		$template->setVariable("campoLocalizacao", "cid_localizacao");
		$template->setVariable("campoAcesso", "cid_acesso");
		$template->setVariable("campoFotos", "cid_fotos");
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorDescricao", $page['descricao']);
		$template->setVariable("valorLocalizacao", $page['localizacao']);
		$template->setVariable("valorAcesso", $page['acesso']);
		$template->setVariable("valorFotos", $page['fotos']);
		
		$template->setVariable("comboAtividades", "combo_atividades");
		$template->setVariable("listAtividades", "list_atividades[]");
		$template->setVariable("listAtividadesID", "list_atividades");
		
		$template->setVariable("comboEcoturismos", "combo_ecoturismos");
		$template->setVariable("listEcoturismos", "list_ecoturismos[]");
		$template->setVariable("listEcoturismosID", "list_ecoturismos");
		
	/* Preenchimento dos Combos */
		$template->setVariable("comboAtividadesOpcoes", $atividades);
		$template->setVariable("comboEcoturismosOpcoes", $ecoturismos);	
		
	/* Preenchimento das Listas */
		$template->setVariable("listAtividadesOpcoes", $listaAtividades);
		$template->setVariable("listEcoturismosOpcoes", $listaEcoturismos);	
		
	/* Java Script Add and Rmv */
		$template->setVariable("addAtividade", "adicionaLista('combo_atividades', 'list_atividades')");
		$template->setVariable("rmvAtividade", "retiraLista('list_atividades')");
		$template->setVariable("addEcoturismo", "adicionaLista('combo_ecoturismos', 'list_ecoturismos')");
		$template->setVariable("rmvEcoturismo", "retiraLista('list_ecoturismos')");

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "ecoValCidade(document.form_cidade.cid_nome, document.form_cidade.cid_descricao, document.form_cidade.cid_localizacao,  document.form_cidade.cid_acesso, document.form_cidade.cid_fotos, 'list_atividades', 'list_ecoturismos', document.form_cidade)");
		
$template->parseCurrentBlock("blk_cidade");

$conteudo = $template->get();

include("includeInterna.php");
?>