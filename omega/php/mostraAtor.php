<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Criando variavel de session */
@$session = new Session();

/* Capturando template */
$templateHtmlName = 'detalhesAtor.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Resgatando o filme do banco de dados */
$id = $_GET['id'];

/* Manda para index caso nenhum id seja selecionado */
if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
	exit();
}

$sql = "SELECT ato_nome, ato_nome_nascimento, ato_profissao, ato_data_nascimento, ato_pais_natal, ato_cidade_natal, ato_biografia, ato_foto
		FROM {$tabela['ator']}
		WHERE ato_cod = $id
		LIMIT 1";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	$template->setCurrentBlock("bloco_detalhe_ator");
	
		/* Subistituindo as Variáveis */
		
		$template->setVariable("tituloFichaTecnica", "Ficha Técnica :");
		$template->setVariable("tituloBiografia", "Biografia :");
		$template->setVariable("tituloFilmografia", "Filmografia :");
		$template->setVariable("nomeArt", $dados['ato_nome']);
		$template->setVariable("nomeNas", $dados['ato_nome_nascimento']);
		$template->setVariable("profissao", $dados['ato_profissao']);
		$template->setVariable("data", converteData($dados['ato_data_nascimento']));
		$template->setVariable("pais", $dados['ato_pais_natal']);
		$template->setVariable("cidade", $dados['ato_cidade_natal']);
		if(!empty($dados['ato_foto'])){
			$template->setVariable("foto", "<img src=\"img.php?l=125&a=177&s=n&loc={$dados['ato_foto']}\" border = \"0\">");
		}
		else{
			$template->setVariable("foto", "<img src=\"../images/foto_nao_disponiovel.gif\" border = \"0\">");
		}
		$template->setVariable("biografia", $dados['ato_biografia']);
		
		$sql = "SELECT fil.fil_titulo, fil.fil_cod
				FROM {$tabela['filme']} fil, {$tabela['ator_filme']} af, {$tabela['ator']} a
				WHERE af.ato_cod = a.ato_cod AND af.fil_cod = fil.fil_cod AND a.ato_cod = $id";
				
		$resultado = $dataBase->query($sql);
		$filmografia = "";
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$filmografia .= "&nbsp;<img src=\"../images/seta_preta.gif\" width=\"2\" height=\"5\" /> <a href=\"mostraFilme.php?id={$dados['fil_cod']}\">{$dados['fil_titulo']}</a><br>";
		}
		
		$template->setVariable("filmografia", $filmografia);
		
	$template->parseCurrentBlock("bloco_detalhe_ator");
}

$show = $template->get();
$show .= "<br>";
$show .= "<div align = \"center\"><a href = \"javascript:history.go(-1);\"><img src=\"../images/bot_voltar.jpg\" border=\"0\"/></a></div>";
$show .= "<br>";

/* Título da Página Interna */
$tituloInterna = "Detalhes do Ator";

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
?>