<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo sAjax */
include('../classes/sAjax/Sajax.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Funções executadas pelo sAjax */
function removeImagem($produto, $fotCod){
	global $dataBase;
	global $tabela;
	
	/* Contando as fotos do produto */
	$sql = "SELECT count(fot_cod) FROM {$tabela['produtos_fotos']} WHERE pro_cod = $produto";
	$resultado    = $dataBase->getRow($sql);
	$quantasFotos = $resultado[0];
	
	if($quantasFotos < 2){
		return -2;
	}
	
	/* Capiturando a URL a ser excluida */
	$sql = "SELECT fot_url FROM {$tabela['fotos']} WHERE fot_cod = $fotCod";
	$resultado = $dataBase->getRow($sql);
	$urlFoto   = $resultado[0];
	
	/* Excluindo foto */
	$sql = "DELETE FROM {$tabela['fotos']} WHERE fot_cod = $fotCod";
	$dataBase->Query($sql);
	
	/* Excluindo relacionamento da foto com o produto */
	$sql = "DELETE FROM {$tabela['produtos_fotos']} WHERE fot_cod = $fotCod";
	$dataBase->Query($sql);
	
	/* Selecionando a nova foto padrão */
	$sql = "SELECT fot_cod FROM {$tabela['produtos_fotos']} WHERE pro_cod = $produto ORDER BY fot_cod ASC LIMIT 1";
	$resultado = $dataBase->getRow($sql);
	$novoPrincipal = $resultado[0];
	
	/* Setando a nova foto padrão */
	$sql = "UPDATE {$tabela['produtos_fotos']} SET pro_fot_principal = 'S' WHERE fot_cod = $novoPrincipal";
	$dataBase->Query($sql);
	
	/* Deletando as imagens */
	if(file_exists($urlFoto)){
		@unlink($urlFoto);
	}
	
	/* Verificando se ainda existe foto para o produto */
	$sql = "SELECT fot_cod FROM {$tabela['produtos_fotos']} WHERE pro_cod = $produto";
	$resultado = $dataBase->getRow($sql);
	if(!empty($resultado[0])){
		return $fotCod;
	}
	else{
		return -1;
	}
}

/* Configurando o sAjax */

sajax_init();

$sajax_debug_mode = 0;

sajax_export("removeImagem");

sajax_handle_client_request();

/* Bloco JavaScript sAjax */

$funcaoJs  = "function executado(foto){
				  if(foto == -2){
				  	  alert('Uma imagem deve ficar setada como imagem PRINCIPAL, você deve inserir outra imagem para poder excluir a atual!');
				  }
				  if(foto == -1){
					  document.all.mE3.style.display='none';
				  }
				  else{
					  var panel = eval('document.all.atu_'+foto+'.style.display=\'none\'');
				  }
              }";

$funcaoJs .= "function removeImagem(produto, codigo){
				  x_removeImagem(produto, codigo, executado);
              }";

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$produto['action'] = "adiciona.php?tipo=produto";
		$produto['titulo'] = "Inserir produto";
		break;
	
	case 'atualizar' :
		$produto['action'] = "atualiza.php?tipo=produto&id=$id";
		$produto['titulo'] = "Atualizar produto";
		$sql = "SELECT pro_cod, pro_nome, pro_peso, pro_preco, pro_qtd, pro_disponibilidade, pro_classificacao, pro_promocao, pro_descricao, pro_especificacao, pro_dados_tecnicos, pro_itens_inclusos, pro_garantia, cat_cod, fab_cod
		FROM {$tabela['produtos']}
		WHERE pro_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$produto['cod']             = $dados['pro_cod'];
		$produto['nome']            = $dados['pro_nome'];
		$produto['peso']            = $dados['pro_peso'];
		$produto['preco']           = $dados['pro_preco'];
		$produto['qtd']             = $dados['pro_qtd'];
		$produto['disponibilidade'] = $dados['pro_disponibilidade'];
		$produto['classificacao']   = $dados['pro_classificacao'];
		$produto['promocao']        = $dados['pro_promocao'];
		$produto['descricao']       = desconverteQuebra($dados['pro_descricao']);
		$produto['especificacao']   = desconverteQuebra($dados['pro_especificacao']);
		$produto['dados_tecnicos']  = desconverteQuebra($dados['pro_dados_tecnicos']);
		$produto['itens_inclusos']  = desconverteQuebra($dados['pro_itens_inclusos']);
		$produto['garantia']        = desconverteQuebra($dados['pro_garantia']);
		$produto['categoria']       = $dados['cat_cod'];
		$produto['fabricante']      = $dados['fab_cod'];
		break;
}

$IniFile = new IniFile($diretorio['opcoes']);
$aDisp = $IniFile->getIni(true);

/* Gerando combo dos pesos */
	for($i=1;$i<31;$i++){
		$pesos .= "<option value=\"$i\"";
		if($produto['peso'] == $i){
			$pesos .= "selected";
		}
		$pesos .= ">$i</option>";
	}

/* Gerando combo das disponibilidades */
	foreach($aDisp["sessionOpcoesDisponibilidade"] as $indice => $valor){
		$disponibilidade .= "<option value=\"$valor\"";
		if($produto['disponibilidade'] == $valor){
			$disponibilidade .= "selected";
		}
		$disponibilidade .= ">$valor</option>";
	}

/* Gerando combo das classificações */
	foreach($aDisp["sessionOpcoesClassificação"] as $indice => $valor){
		$classificacao .= "<option value=\"$valor\"";
		if($produto['classificacao'] == $valor){
			$classificacao .= "selected";
		}
		$classificacao .= ">$valor</option>";
	}

/* Gerando combo das categorias */
$sql = "SELECT cat_cod, cat_nome FROM {$tabela['categorias']} ORDER BY cat_nome";
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$categoria .= "<option value=\"{$dados['cat_cod']}\"";
	if($produto['categoria'] == $dados['cat_cod']){
		$categoria .= "selected";
	}
	$categoria .= ">{$dados['cat_nome']}</option>";
}

/* Gerando combo dos fabricantes */
$sql = "SELECT fab_cod, fab_nome FROM {$tabela['fabricantes']} ORDER BY fab_nome ASC";
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$fabricantes .= "<option value=\"{$dados['fab_cod']}\"";
	if($produto['fabricante'] == $dados['fab_cod']){
		$fabricantes .= "selected";
	}
	$fabricantes .= ">{$dados['fab_nome']}</option>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formProdutos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco JavaScript sAjax */
$template->setCurrentBlock("bloco_javascript_sajax");
	$template->setVariable("sajax_javascript", sajax_show_javascript());
	$template->setVariable("funcoes_javascript", $funcaoJs);	
$template->parseCurrentBlock("bloco_javascript_sajax");

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_produtos");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formProduto", "form_produto");
		$template->setVariable("actionProduto", $produto['action']);
	
	/* Titulos */
		$template->setVariable("tituloProduto", $produto['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("comboPeso", "peso");
		$template->setVariable("campoPreco", "preco");
		$template->setVariable("campoQtd", "qtd");
		$template->setVariable("comboDisponibilidade", "disponibilidade");
		$template->setVariable("comboClassificacao", "classificacao");
		$template->setVariable("comboPromocao", "promocao");
		$template->setVariable("campoDescricao", "descricao");
		$template->setVariable("campoEspecificacao", "especificacao");
		$template->setVariable("campoDadosTecnicos", "dados_tecnicos");
		$template->setVariable("campoItensInclusos", "itens_inclusos");
		$template->setVariable("campoGarantia", "garantia");
		$template->setVariable("comboCategoria", "categoria");
		$template->setVariable("comboFabricante", "fabricante");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $produto['nome']);
		$template->setVariable("valorPeso", $produto['peso']);
		$template->setVariable("valorPreco", $produto['preco']);
		$template->setVariable("valorQtd", $produto['qtd']);
		$template->setVariable("valorDescricao", $produto['descricao']);
		$template->setVariable("valorEspecificacao", $produto['especificacao']);
		$template->setVariable("valorDadosTecnicos", $produto['dados_tecnicos']);
		$template->setVariable("valorItensInclusos", $produto['itens_inclusos']);
		$template->setVariable("valorGarantia", $produto['garantia']);
	
	/* Preenchendo Combos */
		$template->setVariable("comboPesoOpcoes", $pesos);
		$template->setVariable("comboDisponibilidadesOpcoes", $disponibilidade);
		$template->setVariable("comboClassificacaoOpcoes", $classificacao);
		$template->setVariable("comboCategoriaOpcoes", $categoria);
		$template->setVariable("comboFabricanteOpcoes", $fabricantes);
		
	/* BB Code */
		$template->setVariable("onClickNegrito1",    "wrapSelection(form_produto.descricao,'[b]','[/b]')");
		$template->setVariable("onClickItalico1",    "wrapSelection(form_produto.descricao,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado1", "wrapSelection(form_produto.descricao,'[u]','[/u]')");
		
		$template->setVariable("onClickNegrito2",    "wrapSelection(form_produto.especificacao,'[b]','[/b]')");
		$template->setVariable("onClickItalico2",    "wrapSelection(form_produto.especificacao,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado2", "wrapSelection(form_produto.especificacao,'[u]','[/u]')");

		$template->setVariable("onClickNegrito3",    "wrapSelection(form_produto.dados_tecnicos,'[b]','[/b]')");
		$template->setVariable("onClickItalico3",    "wrapSelection(form_produto.dados_tecnicos,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado3", "wrapSelection(form_produto.dados_tecnicos,'[u]','[/u]')");
		
		$template->setVariable("onClickNegrito4",    "wrapSelection(form_produto.itens_inclusos,'[b]','[/b]')");
		$template->setVariable("onClickItalico4",    "wrapSelection(form_produto.itens_inclusos,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado4", "wrapSelection(form_produto.itens_inclusos,'[u]','[/u]')");
		
		$template->setVariable("onClickNegrito5",    "wrapSelection(form_produto.garantia,'[b]','[/b]')");
		$template->setVariable("onClickItalico5",    "wrapSelection(form_produto.garantia,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado5", "wrapSelection(form_produto.garantia,'[u]','[/u]')");
		
	/* Gerando imagens para exclusão, caso update */
		if($acao == "atualizar"){
			$sql = "SELECT f.fot_url, f.fot_cod FROM {$tabela['fotos']} f, {$tabela['produtos_fotos']} fp WHERE f.fot_cod = fp.fot_cod AND fp.pro_cod = {$produto['cod']} ORDER BY fot_cod ASC";
			$resultado = $dataBase->query($sql);
			$i=0;
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$replace .= "<div id=\"atu_{$dados['fot_cod']}\"><img src=\"img.php?loc={$dados['fot_url']}&l=60&a=60&s=nao\" align=\"absmiddle\"> <b>{$dados['fot_url']}</b> - <a href = \"#ancFotos\" onClick=\"removeImagem({$produto['cod']}, {$dados['fot_cod']})\" class=\"link_claro\">Remover imagem</a></div><br>";
				$i++;
			}
		}
		$template->setVariable("atuImgs", $replace);
		
	/* Fotos */
		$template->setVariable("preVisualizacao", "preV");
		$template->setVariable("imgPre", "imgP");
		$template->setVariable("mostaEsconde1", "mE1");
		$template->setVariable("mostaEsconde2", "mE2");
		$template->setVariable("mostaEsconde3", "mE3");
		$template->setVariable("existeHTML", "eHTML");
		$template->setVariable("atuImagens", "atuImg");
		$template->setVariable("idFotos", "fotos");
		$template->setVariable("preVisualizacaoMostra", "preVM");
		$remover = '<span class=tahoma10>Remover foto</span>';
		$template->setVariable("onClickFoto", "addInputFile('fotos', 'foto', '$remover', 'arquivos[]', '#ancFotos')");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "kValProduto(document.form_produto.nome, document.form_produto.peso, document.form_produto.preco, document.form_produto.qtd, document.form_produto.descricao, document.form_produto)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_produtos");

$show = $template->get();

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
	if($acao == "atualizar" && $i > 0){
		$template->setVariable("onLoad", "document.all.mE3.style.display='';");
	}	
	$template->setVariable("admin",  "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
	$template->setVariable("logoff", "<a href=\"logout.php\"><img src=\"../images/botLogoff.gif\" border = \"0\"></a>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $show);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>