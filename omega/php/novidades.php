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

	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'gerenciar.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Definindo constantes */	
	define(ASSUNTO, "novidades");
	define(TABELA, $tabela['novidade']);
	
	/* Contando registros */
	$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA);
	
	/* Variáveis de Get para paginação */
	if(!isset($_GET['start']))$_GET['start']=0;
	$start = $_GET['start'];
	
	define(QTD, $qtd);
	define(PAGINA_ATUAL, getPaginaAtual());
	define(ORDEM, 'DESC');
	define(ORDENADO, 'nov_id');
	define(ATUAL, $start);
	define(POR_PAGINA, PP_NOVIDADES);
	define(TOTAL, ceil((QTD)/POR_PAGINA));
	define(SQL, "SELECT nov_id, nov_titulo FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
	$resultado = $dataBase->query(SQL);
	$contem_resultado = false;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	
		$template->setCurrentBlock("bloco_gerenciar_interno");
		
			/* Nomes das Imagens */	
				$template->setVariable("editar", "Editar");
				$template->setVariable("excluir", "Excluir");
			
			/* Links da imagens dos Campos */
				$template->setVariable("linkEditar", "novidade.php?acao=atualizar&id={$dados['nov_id']}");
				$template->setVariable("linkExcluir", "exclui.php?tipo=novidade&id={$dados['nov_id']}");
			
			/* Linha a ser impressa */
				$linha  = "<a href = \"mostraNovidade.php?id={$dados['nov_id']}\" target=\"_blank\">";
				$linha .= limitaStr($dados['nov_titulo'], LIMITE_GENRENCIAR);
				$linha .= "</a>";
				$template->setVariable("linha", $linha);
				
		$template->parseCurrentBlock("bloco_gerenciar_interno");
		$contem_resultado = true;

	}
	/* Caso não ache nenhum resultado escreve para o usuário */
	if($contem_resultado == false){
		$template->setCurrentBlock("bloco_gerenciar_erro");
				$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
		$template->parseCurrentBlock("bloco_gerenciar_erro");
	}
	
	/* Controle da Paginação */
	$paginacao = '';
	if(TOTAL > 1){	
		$pag = $_GET['pag'];
		if(empty($pag)){
			$pag = 1;
		}										
		$mostra_prox = POR_PAGINA*(($pag+1)-1);
		$mostra_ante = POR_PAGINA*(($pag-1)-1);
		$mostra_essa = POR_PAGINA*(($pag)-1);		
		$pag_prox = $pag+1;		
		$pag_ante = $pag-1;		
		$pag_atua = $pag;
			
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0\"><img src=\"../images/bot_primeiro.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
		if($pag > 1){
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante\">";
		}		
		$paginacao .= "<img src=\"../images/bot_anteriror.jpg\" border=\"0\"></a>&nbsp;.<b>.</b>&nbsp;";		
		
		$inicioMostra = $pag_atua - (QTD_PAGINAS_SHOW/2);
		$fimMostra    = $pag_atua + (QTD_PAGINAS_SHOW/2);
	
		if($inicioMostra <= 0){
			$inicioMostra = 1;
		}
		
		if($fimMostra > TOTAL){
			$fimMostra = TOTAL;
		}
		
		for($i=$inicioMostra; $i<=$fimMostra ; $i++){

			if(POR_PAGINA*($i-1) == ATUAL){	
				$paginacao .= "<b> $i</b>";
			}
			else{
				$aevi = POR_PAGINA*($i-1);
				$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"link_escuro\">$i</a> ";
			}
		}
		
		$aevi = POR_PAGINA*(TOTAL-1);
		$i    = TOTAL;
		$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
		
		$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
		
		if($pag < TOTAL){						
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox\">";
		}
		
		$paginacao .= "<img src=\"../images/bot_proximo.jpg\" border=\"0\"></a>&nbsp;";
		$paginacao .= "<a href=\"$link\"><img src=\"../images/bot_ultimo.jpg\" border=\"0\"></a>";									
	}
	$agora = ($start/POR_PAGINA)+1;
	$todas = TOTAL;
	
	$infos = '<br>';
										
	$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
	$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
	$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";
	
	if(!empty($paginacao)){
		$template->setCurrentBlock("bloco_gerenciar_paginacao_controle");
					$template->setVariable("paginacao", $paginacao);
		$template->parseCurrentBlock("bloco_gerenciar_paginacao_controle");
	}
	
	if($contem_resultado == true){
		$template->setCurrentBlock("bloco_gerenciar_paginacao");
					$template->setVariable("infos", $infos);
		$template->parseCurrentBlock("bloco_gerenciar_paginacao");
	}
	
	$template->setCurrentBlock("bloco_gerenciar");
	
		/* Titulos */
			$template->setVariable("tituloGerenciar", "Gerenciar Novidades");
	
		/* Botão */	
			$template->setVariable("linkVoltar", "#");
			$template->setVariable("altVoltar", "Voltar !");
			
		/* Java Script ao Voltar */
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
	
	$template->parseCurrentBlock("bloco_gerenciar");
	
	$show  = $template->get();
	$show .= "<br>";
	
	/* Título da Página Interna */
	$tituloInterna = "Novidades";
	
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