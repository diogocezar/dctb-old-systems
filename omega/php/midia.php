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
			$midia['action'] = "adiciona.php?tipo=midia";
			$midia['titulo'] = "Inserir mídia";
			break;
		
		case 'atualizar' :
			$midia['action'] = "atualiza.php?tipo=midia&id=$id";
			$midia['titulo'] = "Atualizar mídia";
			$sql = "SELECT fil_cod, mid_cod_controle, mid_tipo, mid_audio, mid_legenda, mid_regiao, mid_formato, mid_status
			FROM {$tabela['midia']}
			WHERE mid_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$midia['filme']        = $dados['fil_cod'];
			$midia['cod_controle'] = $dados['mid_cod_controle'];
			$midia['tipo']         = $dados['mid_tipo'];
			$midia['audio']        = $dados['mid_audio'];
			$midia['legenda']      = $dados['mid_legenda'];
			$midia['regiao']       = $dados['mid_regiao'];
			$midia['formato']      = $dados['mid_formato'];
			$midia['status']       = $dados['mid_status'];
			break;
	}
	
	
	/* Gerando combo dos filmes */
	$sql = "SELECT fil_cod, fil_titulo FROM {$tabela['filme']} ORDER BY fil_titulo ASC";
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$filmes .= "<option value=\"{$dados['fil_cod']}\"";
		if($midia['filme'] == $dados['fil_cod'] || $dados['fil_cod'] == $_GET['idFilme']){
			$filmes .= "selected";
		}
		$filmes .= ">{$dados['fil_titulo']}</option>";
	}
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formMidia.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_midia");
	
		/* Botões */
			$template->setVariable("linkEnviar",  "#");
			$template->setVariable("altEnviar", "Enviar !");
			$template->setVariable("linkVoltar", "#");
			$template->setVariable("altVoltar", "Voltar !");
	
		/* Formulario */
			$template->setVariable("formMidia", "form_midia");
			$template->setVariable("actionMidia", $midia['action']);
		
		/* Titulos */
			$template->setVariable("tituloMidia", $midia['titulo']);
	
		/* Nomes dos Campos */
			$template->setVariable("campoCodigo", "codigo");
			$template->setVariable("comboFilme", "filme");
			$template->setVariable("comboTipo", "tipo");
			$template->setVariable("campoAudio", "audio");
			$template->setVariable("campoLegenda", "legenda");
			$template->setVariable("campoRegiao", "regiao");
			$template->setVariable("campoFormato", "formato");
			$template->setVariable("comboStatus", "status");

		/* Valores dos Campos */
			$template->setVariable("valorCodigo", $midia['cod_controle']);
			$template->setVariable("valorAudio", $midia['audio']);
			$template->setVariable("valorLegenda", $midia['legenda']);
			$template->setVariable("valorRegiao", $midia['regiao']);
			$template->setVariable("valorFormato", $midia['formato']);
			
		/* Preenchimento dos Combos */
			$template->setVariable("comboFilmeOpcoes", $filmes);
			
		/* Marcando o tipo escolhido */
		if(!empty($midia['tipo'])){
			if($midia['tipo'] == "DVD"){
				$template->setVariable("selDVD", "selected");
			}
			else{
				$template->setVariable("selVHS", "selected");
			}
		}
			
		/* Marcando se está ou não locado */
			if($midia['status'] == "Sim"){
				$template->setVariable("selSim", "selected");
			}
			else{
				$template->setVariable("selNao", "selected");
			}

		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaMidia(form_midia.codigo, form_midia.audio, form_midia.legenda, form_midia.regiao, form_midia.formato, form_midia)");
			$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
			
	$template->parseCurrentBlock("bloco_midia");

	$show = $template->get();
	
	/* Título da Página Interna */
	$tituloInterna = "Mídias";
	
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