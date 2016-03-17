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

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

$permitido = false;

@$session = new Session();

if($_SESSION['permitidoSession'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('codSession'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nomeSession');
	$login = $session->retornaSession('loginSession');
	$tipo = sessionNum($session->retornaSession('tipoSession'));
	$tipo = (int)$tipo;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
}
else{

	switch($acao){
		case 'adicionar' :
			$filme['action'] = "adiciona.php?tipo=filme";
			$filme['titulo_form'] = "Inserir filme";
			break;
		
		case 'atualizar' :
			$filme['action'] = "atualiza.php?tipo=filme&id=$id";
			$filme['titulo_form'] = "Atualizar filme";
			$sql = "SELECT cat_cod, cla_cod, fil_titulo, fil_titulo_original, fil_ano, fil_duracao, fil_sinopse, fil_foto, fil_distribuidora, fil_destaque
			FROM {$tabela['filme']}
			WHERE fil_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$filme['categoria']       = $dados['cat_cod'];
			$filme['classificacao']   = $dados['cla_cod'];
			$filme['titulo']          = $dados['fil_titulo'];
			$filme['titulo_original'] = $dados['fil_titulo_original'];			
			$filme['ano']             = $dados['fil_ano'];
			$filme['duracao']         = $dados['fil_duracao'];			
			$filme['sinopse']         = desconverteQuebra($dados['fil_sinopse']);
			$filme['foto']            = $dados['fil_foto'];
			$filme['dist']            = $dados['fil_distribuidora'];			
			$filme['destaque']        = $dados['fil_destaque'];
			
			/* Resgatando os ítens da lista de atores */
			$sql = "SELECT ato_cod FROM {$tabela['ator_filme']} WHERE fil_cod = $id";
			$resultado = $dataBase->query($sql);
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaAto .= "<option value=\"{$dados['ato_cod']}\"";
				$listaAto .= ">".retornaNomeAtor($dados['ato_cod'])."</option>";
			}
			
			/* Resgatando os ítens da lista de diretores */
			$sql = "SELECT dir_cod FROM {$tabela['diretor_filme']} WHERE fil_cod = $id";
			$resultado = $dataBase->query($sql);
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaDir .= "<option value=\"{$dados['dir_cod']}\"";
				$listaDir .= ">".retornaNomeDiretor($dados['dir_cod'])."</option>";
			}
			
			/* Resgatando os ítens da lista de gêneros */
			$sql = "SELECT gen_cod FROM {$tabela['genero_filme']} WHERE fil_cod = $id";
			$resultado = $dataBase->query($sql);
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$listaGen .= "<option value=\"{$dados['gen_cod']}\"";
				$listaGen .= ">".retornaNomeGenero($dados['gen_cod'])."</option>";
			}
			
			break;
	}
	
	/* Gerando combo das categorias */
	$sql = "SELECT cat_cod, cat_nome FROM {$tabela['categoria']} ORDER BY cat_nome ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$categorias .= "<option value=\"{$dados['cat_cod']}\"";
		if($filme['categoria'] == $dados['cat_cod']){
			$categorias .= "selected";
		}
		$categorias .= ">{$dados['cat_nome']}</option>";
	}
	
	/* Gerando combo das classificações */
	$sql = "SELECT cla_cod, cla_classificacao FROM {$tabela['classificacao']} ORDER BY cla_classificacao ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$classificacao .= "<option value=\"{$dados['cla_cod']}\"";
		if($filme['classificacao'] == $dados['cla_cod']){
			$classificacao .= "selected";
		}
		$classificacao .= ">{$dados['cla_classificacao']}</option>";
	}
	
	/* Gerando combo dos atores */
	$sql = "SELECT ato_cod, ato_nome FROM {$tabela['ator']} ORDER BY ato_nome ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$atores .= "<option value=\"{$dados['ato_cod']}\"";
		$atores .= ">{$dados['ato_nome']}</option>";
	}
	
	/* Gerando combo dos diretores */
	$sql = "SELECT dir_cod, dir_nome FROM {$tabela['diretor']} ORDER BY dir_nome ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$diretores .= "<option value=\"{$dados['dir_cod']}\"";
		$diretores .= ">{$dados['dir_nome']}</option>";
	}
	
	/* Gerando combo dos gêneros */
	$sql = "SELECT gen_cod, gen_nome FROM {$tabela['genero']} ORDER BY gen_nome ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$generos .= "<option value=\"{$dados['gen_cod']}\"";
		$generos .= ">{$dados['gen_nome']}</option>";
	}
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formFilme.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_filme_foto");
	
		$template->setVariable("fotoAnexada", $filme['foto']);	
		
	$template->parseCurrentBlock("bloco_filme_foto");
	
	$template->setCurrentBlock("bloco_filme");
	
		/* Botões */
			$template->setVariable("linkEnviar",  "#");
			$template->setVariable("altEnviar", "Enviar !");
			$template->setVariable("linkVoltar", "#");
			$template->setVariable("altVoltar", "Voltar !");
	
		/* Formulario */
			$template->setVariable("formFilme", "form_filme");
			$template->setVariable("actionFilme", $filme['action']);
		
		/* Titulos */
			$template->setVariable("tituloFilme", $filme['titulo_form']);
	
		/* Nomes dos Campos */
			$template->setVariable("campoTitulo", "titulo");
			$template->setVariable("campoTituloOri", "titulo_ori");
			$template->setVariable("campoAno", "ano");
			$template->setVariable("campoDuracao", "duracao");
			$template->setVariable("comboCategoria", "categoria");
			$template->setVariable("comboClassificacao", "classificacao");
			$template->setVariable("comboAtores", "atores");
			$template->setVariable("listAtores", "list_atores[]");
			$template->setVariable("listAtoresID", "list_atores");
			$template->setVariable("comboDiretores", "diretores");
			$template->setVariable("listDiretores", "list_diretores[]");
			$template->setVariable("listDiretoresID", "list_diretores");
			$template->setVariable("comboGeneros", "generos");
			$template->setVariable("listGeneros", "list_generos[]");
			$template->setVariable("listGenerosID", "list_generos");
			$template->setVariable("campoSinopse", "sinopse");
			$template->setVariable("campoFoto", "foto");
			$template->setVariable("campoDistribuidora", "dist");
			$template->setVariable("comboDestaque", "destaque");
		
		/* Valores dos Campos */
			$template->setVariable("valorTitulo", $filme['titulo']);
			$template->setVariable("valorTituloOri", $filme['titulo_original']);
			$template->setVariable("valorAno", $filme['ano']);
			$template->setVariable("valorDuracao", $filme['duracao']);
			$template->setVariable("valorSinopse", $filme['sinopse']);
			$template->setVariable("valorDistribuidora", $filme['dist']);
			
		/* BB Code */
			$template->setVariable("onClickNegrito", "wrapSelection(form_filme.sinopse,'[B]','[/B]')");
			$template->setVariable("onClickItalico", "wrapSelection(form_filme.sinopse,'[I]','[/I]')");
			$template->setVariable("onClickSublinhado", "wrapSelection(form_filme.sinopse,'[U]','[/U]')");
			
		/* Preenchimento dos Combos */
			$template->setVariable("comboCategoriaOpcoes", $categorias);
			$template->setVariable("comboClassificacaoOpcoes", $classificacao);
			$template->setVariable("comboAtoresOpcoes", $atores);
			$template->setVariable("comboDiretoresOpcoes", $diretores);
			$template->setVariable("comboGenerosOpcoes", $generos);
			
		/* Preenchendo as Listas */
			$template->setVariable("listAtoresOpcoes", $listaAto);
			$template->setVariable("listDiretoresOpcoes", $listaDir);
			$template->setVariable("listGenereosOpcoes", $listaGen);
			
		/* Java Script Add and Rmv */
			$template->setVariable("addAtor", "adicionaLista('atores', 'list_atores')");
			$template->setVariable("rmvAtor", "retiraLista('list_atores')");
			$template->setVariable("addDiretor", "adicionaLista('diretores', 'list_diretores')");
			$template->setVariable("rmvDiretor", "retiraLista('list_diretores')");
			$template->setVariable("addGenero", "adicionaLista('generos', 'list_generos')");
			$template->setVariable("rmvGenero", "retiraLista('list_generos')");
			
		/* Marcando é ou não um destaque */
			if($filme['destaque'] == "Sim"){
				$template->setVariable("selSim", "selected");
			}
			else{
				$template->setVariable("selNao", "selected");
			}
		
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaFilme(form_filme.titulo, form_filme.titulo_ori, form_filme.ano, form_filme.duracao, form_filme.sinopse, form_filme.dist, 'list_atores', 'list_diretores', 'list_generos', form_filme)");
			$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
			
	$template->parseCurrentBlock("bloco_filme");

	$show = $template->get();
	$show .= "<br>";
	
	/* Título da Página Interna */
	$tituloInterna = "Enquetes";
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'templateInterna.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Conversão das variáveis dos blocos */
	
	/* Bloco do Título */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
	/* Bloco Login */
	$template->setCurrentBlock("bloco_login");
		if($_SESSION['usuarioSession'] != 'sim'){
			/* Bloco Login Deslogado */
				$template->setVariable("abreForm", "<form action=\"loginUser.php\" method=\"post\" name=\"form_login\" id=\"form_login\">");
				$template->setVariable("conteudo", "Usuário <input name=\"usuario\" type=\"text\" class=\"form\" size=\"10\" onkeypress=\"pulaCampoNoEnter(senha)\"> Senha <input name=\"senha\" type=\"password\" class=\"form\" value=\"\" size=\"10\" onkeypress=\"enviaFormNoEnter(form_login)\">
													<a href=\"#\"><img src=\"../images/seta_go.jpg\" alt=\"Logar\" width=\"34\" height=\"24\" border=\"0\" align=\"absmiddle\" onClick=\"entrar(form_login.usuario, form_login.senha, form_login)\"></a>&nbsp;");
				$template->setVariable("fechaForm", "</form>");
		}
		else{
			/* Bloco Login Logado */
				$template->setVariable("conteudo", "Bem vindo(a), <span class=\"texto4\">".$_SESSION['nomeSession']."</span>&nbsp;&nbsp;&nbsp;<br><b><a href = \"minhaConta.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_minha','','../images/bot_minhaconta_rol.gif',1)\"><img src=\"../images/bot_minhaconta.gif\" name=\"img_minha\" border=\"0\" alt=\"Minha conta !\"/></a>
																																			  <a href = \"logout.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_sair_login','','../images/bot_logout_rol.gif',1)\"><img src=\"../images/bot_logout.gif\" name=\"img_sair_login\" border=\"0\"  alt=\"Sair !\"/></a>&nbsp;&nbsp;&nbsp;");
		}
	$template->parseCurrentBlock("bloco_login");
	
	/* Bloco Busca */
	$template->setCurrentBlock("bloco_busca");
		$template->setVariable("actionBusca", "busca.php");
		$template->setVariable("formBusca", "form_busca");
		$template->setVariable("comboGenero", "genero");
		
		/* Recupera os gêneros cadastrados */
		$sql = "SELECT gen_cod, gen_nome FROM {$tabela['genero']} ORDER BY gen_nome";
		$resultado = $dataBase->query($sql);
		$generos = "<option value=\"-1\">Todos</option>";
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$generos .= "<option value=\"{$dados['gen_cod']}\"";
			$generos .= ">{$dados['gen_nome']}</option>";
		}
		
		$template->setVariable("comboGeneroOpcoes", $generos);
		
		/* Pega do array o buscar por... */
	
		foreach($buscarPor as $indice => $valor){
			$por .= "<option value=\"$indice\"";
			$por .= ">$valor</option>";
		}
		
		$template->setVariable("comboPor", "por");
		$template->setVariable("comboPorOpcoes", $por);
		
		$template->setVariable("campoNome", "nome");
		$template->setVariable("altBusca", "Buscar !");
		$template->setVariable("linkVejaTodos", "listarTodos.php");
		$template->setVariable("onClickBusca", "buscar(form_busca.nome, form_busca)");
		$template->setVariable("linkBuscar", "#");
	$template->parseCurrentBlock("bloco_busca");
	
	/* Bloco Carrinho */
	$template->setCurrentBlock("bloco_carrinho");
		$template->setVariable("qtdF", number_format($_SESSION['qtd_filmes'], 0));
		$template->setVariable("qtdC", number_format($_SESSION['qtd_conveniencia'], 0));
		$template->setVariable("valorTotal", "R$ ".number_format($_SESSION['val_total'], 2, ',','.'));
		$template->setVariable("linkFim", "#");
		$template->setVariable("onClickFim", "javascript:location.href='finalizar.php'");
		$template->setVariable("altFim", "Finalizar Pedido !");
	$template->parseCurrentBlock("bloco_carrinho");
	
	/* Bloco Parceiros */
	$template->setCurrentBlock("bloco_parceiros");
		foreach($parceiros as $indice => $valor){
			$parc .= "<a href =\"{$valor[1]}\"><img src=\"{$valor[0]}\" width=\"213\" height=\"52\" alt=\"$indice\" border=\"0\"></a><br>";
		}
		$template->setVariable("parceiros", $parc);
	$template->parseCurrentBlock("bloco_parceiros");
	
	/* Bloco Interno */
	$template->setCurrentBlock("bloco_interno");
		$template->setVariable("titulo_interno", $tituloInterna);
		$template->setVariable("conteudo_interno", $show);
	$template->parseCurrentBlock("bloco_interno");
	
	/* Bloco Principal */
	$template->setCurrentBlock("bloco_principal");
		/* Menu */
		foreach($menu['principal'] as $menu => $cont){
			foreach($cont as $titulo => $link){
				$template->setVariable($menu, $titulo);
				$lnk = strtoupper($menu[0]).substr($menu, 1, strlen($menu));
				$template->setVariable("link".$lnk, $link);
			}
		}
		
		/* Login */
		$template->setVariable("linkCadastreSe", "cadastrese.php");
		$template->setVariable("linkEsqueci", "esqueci.php");
		$template->setVariable("altCadastreSe", "Cadastre-se !");
		$template->setVariable("altEsqueci", "Esqueceu a senha ?");
		
		/* Kreea */
		$template->setVariable("linkKreea", "http://www.kreea.com.br");
		
	$template->parseCurrentBlock("bloco_principal");
	
	$template->show();
}//Else
?>