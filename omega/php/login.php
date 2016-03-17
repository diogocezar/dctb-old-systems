<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

@$session = new Session();

$acao = $_GET['acao'];
if($acao == "logout"){
	$nome = $session->retornaSession('nomeSession');
	$session->limpaSessions();
	$msgSair = "<div align=\"center\">";
	$msgSair .= "Obrigado <b>$nome</b>, voc� saio de nosso sistema com seguran�a.<br><br>";
	$msgSair .= "<a href=\"#\"><img src=\"../images/bot_login.jpg\" onclick=\"javascript:location.href='login.php'\" border=\"0\" alt=\"Logar-se !\"><br><br></a>";
	$msgSair .= "<a href=\"#\"><img src=\"../images/bot_voltar.jpg\" onclick=\"javascript:location.href='index.php'\" border=\"0\" alt=\"Voltar !\"></a>";
	$msgSair .= "</div>";
	$saio = true;
}

if($_SESSION['permitidoSession'] == 'sim'){
	echo "<script language=javascript>location.href='administrar.php'</script>";
	break;
}

$session->limpaSessions();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'login.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco do Login */
$template->setCurrentBlock("bloco_login");
	/* Formulario */
		$template->setVariable("formLogin", "form_login_adm");
		$template->setVariable("actionLogin", "administrar.php");

	/* Titulos dos Campos */	
		$template->setVariable("login", "Login");
		$template->setVariable("senha", "Senha");
		
	/* Nomes dos Campos */
		$template->setVariable("campoLogin", "usuario");
		$template->setVariable("campoSenha", "senha");
		
	/* Bot�o */
		$template->setVariable("linkEntrar", "#");
		$template->setVariable("altEntrar", "Entrar !");
	/* Java Script ao Enviar */
		$template->setVariable("onClickEntrar", "validaLogin(form_login_adm.usuario, form_login_adm.senha, form_login_adm)");
	
$template->parseCurrentBlock("bloco_login");

if($saio){
	$show = $msgSair;
}
else{
	$show  = "Essa �rea � restrita para propriet�rios e gerentes, para acessar a �rea restrita digite abaixo seu login e sua senha.<br>";
	$show .= "<br>";
	$show .= $template->get();
}

/* T�tulo da P�gina Interna */
$tituloInterna = "�rea de Administra��o";

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Login */
$template->setCurrentBlock("bloco_login");
	if($_SESSION['usuarioSession'] != 'sim'){
		/* Bloco Login Deslogado */
			$template->setVariable("abreForm", "<form action=\"loginUser.php\" method=\"post\" name=\"form_login\" id=\"form_login\">");
			$template->setVariable("conteudo", "Usu�rio <input name=\"usuario\" type=\"text\" class=\"form\" size=\"10\" onkeypress=\"pulaCampoNoEnter(senha)\"> Senha <input name=\"senha\" type=\"password\" class=\"form\" value=\"\" size=\"10\" onkeypress=\"enviaFormNoEnter(form_login)\">
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
	
	/* Recupera os g�neros cadastrados */
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
	
	/* On Load da Pagina */
	$template->setVariable("onLoad", "setaFoco(form_login_adm.usuario)");

$template->parseCurrentBlock("bloco_principal");

$template->show();
?>