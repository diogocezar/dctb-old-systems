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
	echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='login.php'</script>";
}
else{

	switch($acao){
		case 'adicionar' :
			$enquete['action'] = "adiciona.php?tipo=enquete";
			$enquete['titulo'] = "Inserir enquete";
			break;
		
		case 'atualizar' :
			$enquete['action'] = "atualiza.php?tipo=enquete&id=$id";
			$enquete['titulo'] = "Atualizar enquete";
			/* Pergunta */
			$sql = "SELECT enq_id, enq_pergunta, enq_exibir
			FROM {$tabela['enquete']}
			WHERE enq_id = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$enquete['pergunta'] = $dados['enq_pergunta'];
			$enquete['exibir']   = $dados['enq_exibir'];
			
			/* Respostas */
			$sql = "SELECT res_resposta
			FROM {$tabela['respostas']}
			WHERE enq_id = $id ORDER BY res_id ASC LIMIT 4";	
			$resultado = $dataBase->query($sql);
			$i = 1;
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$enquete["resposta$i"] = $dados['res_resposta'];
				$i++;
			}
			break;
	}
	
	/* Diret�rio dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formEnquete.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Convers�o das vari�veis dos blocos */
	
	$template->setCurrentBlock("bloco_enquete");
	
		/* Bot�es */
			$template->setVariable("linkEnviar",  "#");
			$template->setVariable("altEnviar", "Enviar !");
			$template->setVariable("linkVoltar", "#");
			$template->setVariable("altVoltar", "Voltar !");
	
		/* Formulario */
			$template->setVariable("formEnquete", "form_enquete");
			$template->setVariable("actionEnquete", $enquete['action']);
		
		/* Titulos */
			$template->setVariable("tituloEnquete", $enquete['titulo']);
	
		/* Nomes dos Campos */
			$template->setVariable("campoPergunta", "pergunta");
			$template->setVariable("campoResposta1", "resposta1");
			$template->setVariable("campoResposta2", "resposta2");
			$template->setVariable("campoResposta3", "resposta3");
			$template->setVariable("campoResposta4", "resposta4");
			$template->setVariable("comboExibir", "comboExibir");
		
		/* Valores dos Campos */
			$template->setVariable("valorPergunta", $enquete['pergunta']);
			$template->setVariable("valorResposta1", $enquete["resposta1"]);
			$template->setVariable("valorResposta2", $enquete["resposta2"]);
			$template->setVariable("valorResposta3", $enquete["resposta3"]);
			$template->setVariable("valorResposta4", $enquete["resposta4"]);
			
		/* Marcando se est� ou n�o sendo exibida */
			if($enquete['exibir'] == "Sim"){
				$template->setVariable("selSim", "selected");
			}
			else{
				$template->setVariable("selNao", "selected");
			}
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaEnquete(form_enquete.pergunta, form_enquete.resposta1, form_enquete.resposta2, form_enquete.resposta3, form_enquete.resposta4, form_enquete)");
			$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
			
	$template->parseCurrentBlock("bloco_enquete");

	$show = $template->get();
	
	/* T�tulo da P�gina Interna */
	$tituloInterna = "Enquetes";
	
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
		
	$template->parseCurrentBlock("bloco_principal");
	
	$template->show();
}//Else
?>