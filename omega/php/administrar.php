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

/* Fazendo a verificação no banco de dados se o usuário e/ou senha são válidos */

$permitido = false;

$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

@$session = new Session();

$resultado = $dataBase->query("SELECT usu_cod, usu_nome, usu_sobrenome, usu_login, usu_senha, tip_id_user FROM {$tabela['usuario']}");

while($data = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($data['usu_login'] == $usuario && $data['usu_senha'] == $senha && $data['tip_id_user'] > 1){	
		$sessions = array('permitidoSession' => 'sim',
		                  'codSession'       => '#'.$data['usu_cod'],
						  'nomeSession'      => $data['usu_nome'],
		                  'loginSession'     => $data['usu_login'],
						  'tipoSession'      => '#'.$data['tip_id_user']
						 );
		$session = new Session($sessions);
		$permitido = true;
	}
}

$resultado->free();

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
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'admin.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco Administração Geral */
		$template->setCurrentBlock("bloco_titulo");
			$template->setVariable("bemVindo", "Bem vindo(a), <b>".$nome."</b>");
			$template->setVariable("infos", "Seu nivel : <b>".retornaNomeTipo($tipo)."</b>");
			$template->setVariable("linkSair", "login.php?acao=logout");
			$template->setVariable("altSair",  "Sair !");
		$template->parseCurrentBlock("bloco_titulo");
		
	/* Bloco da Busca */
		$template->setCurrentBlock("bloco_busca_adm");
			$template->setVariable("actionBuscaAdm", "buscaAdm.php");
			$template->setVariable("formBuscaAdm", "form_busca_adm");
			$template->setVariable("campoBuscaAdm", "busca");
			$template->setVariable("linkOk", "#");
			$template->setVariable("altOk", "Buscar !");
			$template->setVariable("selectOp",  "opcao");
			$template->setVariable("onClickOk", "enviaForm(form_busca_adm)");
			$template->setVariable("buscar", "Nome :");
			$template->setVariable("buscarPor", "Buscar por :");
		$template->parseCurrentBlock("bloco_busca_adm");
	
	
	/* Bloco Administração Ítens */
	foreach($menu['admin'] as $titulo => $link){
		$template->setCurrentBlock("bloco_admin_menu");
			$template->setVariable("menuOpcao", $titulo);
			$template->setVariable("linkGerenciar", $link[0]);
			$template->setVariable("linkInserir", $link[1]);
			$template->setVariable("altGerenciar", "Gerenciar $titulo");
			$template->setVariable("altInserir", "Inserir $titulo");
		$template->parseCurrentBlock("bloco_admin_menu");
	}
	
	/* Bloco Administração Gerenciar */
	foreach($menu['admin_gerenciar'] as $titulo => $link){
		$template->setCurrentBlock("bloco_admin_menu_gerenciar");
			$template->setVariable("menuGerenciar", $titulo);
			$template->setVariable("linkGerenciar", $link);
			$template->setVariable("altGerenciar", "Gerenciar $titulo");			
		$template->parseCurrentBlock("bloco_admin_menu_gerenciar");
	}
	
	$show  = $template->get();
	$show .= "<br>";
	
	/* Título da Página Interna */
	$tituloInterna = "Área de Administração";
	
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
}
?>