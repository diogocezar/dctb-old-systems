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

	/* Resgatando o ID de uma única locação */
	$id = $_GET['id'];
	
	/* Resgatando o filtro [Andamento/Fechadas] */
	$filtro = $_GET['filtro'];
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'detalhesLocacoesAdm.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Definindo constantes */	
	define(ASSUNTO, "locações");
	
	/* Restringindo a uma locação se id não estiver vazio */
	if(!empty($id)){
		$where = " AND l.loc_cod = $id";
		$whereQtd = " WHERE loc_cod = $id";
	}
	
	if(!empty($filtro) && empty($id)){
		switch($filtro){
			case 'andamento':
				$where = " AND l.loc_situacao = 'Locado'";
				$whereQtd = " WHERE loc_situacao = 'Locado'";
			break;
			case 'fechado':
				$where = " AND l.loc_situacao = 'Fechado'";
				$whereQtd = " WHERE loc_situacao = 'Fechado'";
			break;
			case 'aguardando':
				$where = " AND l.loc_situacao = 'Aguardando Confirmação'";
				$whereQtd = " WHERE loc_situacao = 'Aguardando Confirmação'";
			break;
		}
	}
	
	/* Contando registros */
	$qtd = $dataBase->getOne("SELECT count(loc_cod) FROM {$tabela['locacao']}".$whereQtd);
	
	/* Variáveis de Get para paginação */
	if(!isset($_GET['start']))$_GET['start']=0;
	$start = $_GET['start'];
	
	define(QTD, $qtd);
	define(PAGINA_ATUAL, getPaginaAtual());
	define(ORDEM, 'DESC');
	define(ORDENADO, 'loc_cod');
	define(ATUAL, $start);
	define(POR_PAGINA, PP_LISTA_LOCACOES);
	define(TOTAL, ceil((QTD)/POR_PAGINA));
	define(SQL, "SELECT l.loc_cod, l.loc_quando, l.loc_valor, l.loc_obs, l.loc_situacao, l.loc_data_entrega, l.loc_hora_entrega, l.loc_data_busca,
				        l. loc_hora_busca, u.usu_nome, u.usu_sobrenome, u.ema_id, c.cli_rua, c.cli_numero, c.cli_cpf, c.cli_bairro, c.cli_telefone, 
						t.txe_localizacao, t.txe_valor
                 FROM {$tabela['locacao']} l, {$tabela['cliente']} c, {$tabela['usuario']} u, {$tabela['taxa_entrega']} t
                 WHERE l.cli_cpf = c.cli_cpf
				 AND c.usu_cod = u.usu_cod
				 AND c.txe_cod = t.txe_cod ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
	$resultado = $dataBase->query(SQL);
	$contem_resultado = false;
	
	$template->setCurrentBlock("bloco_locacoes");
	
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
			$produtos = retornaProdsLoc($dados['loc_cod']);
			
			$filmes   = retornaFilmesLoc($dados['loc_cod']);
			
			if(!empty($produtos)){			
				for($i=0; $i<count($produtos); $i++){			
					$template->setCurrentBlock("bloco_locacoes_conv_linha");
					$template->setVariable("produtosComprados", $produtos[$i]['qtd']." ".$produtos[$i]['nom']);
					$template->parseCurrentBlock("bloco_locacoes_conv_linha");
				}
			}
			else{
				$template->setCurrentBlock("bloco_locacoes_conv_linha");
				$template->setVariable("produtosComprados", "Sem produtos.");
				$template->parseCurrentBlock("bloco_locacoes_conv_linha");
			}
			
			if(!empty($filmes)){			
				foreach($filmes as $indice => $valor){
					$template->setCurrentBlock("bloco_locacoes_filmes_linha");
						$linha = "<a href=\"mostraFilme.php?id=$indice\">".limitaStr($valor, LIMITE_LOC)."</a>";
						if(lancamento($indice)){
							$linha .= " - <b>Lançamento</b>";
						}
						$template->setVariable("filmesLocados", $linha);
					$template->parseCurrentBlock("bloco_locacoes_filmes_linha");
				}
			}
		
			$template->setCurrentBlock("bloco_locacoes_filmes");
				$template->setVariable("tituloFilmes", "Filmes");
			$template->parseCurrentBlock("bloco_locacoes_filmes");
			
			$template->setCurrentBlock("bloco_locacoes_conv");
				$template->setVariable("tituloConv", "Conveniência");
			$template->parseCurrentBlock("bloco_locacoes_conv");
		
			$template->setCurrentBlock("bloco_locacoes_header");
				$template->setVariable("qtdF", count($filmes));
				$template->setVariable("qtdP", count($produtos));
				$template->setVariable("valor", number_format($dados['loc_valor'], 2, ',','.'));
				$template->setVariable("tituloLocacao", "Locado em : ".extraiData($dados['loc_quando']).", ".extraiHora($dados['loc_quando']).".");
			$template->parseCurrentBlock("bloco_locacoes_header");
			
			$template->setCurrentBlock("bloco_locacoes_dados");
				$template->setVariable("tituloDados", "Dados do Cliente");
				$template->setVariable("nome", $dados['usu_nome']." ".$dados['usu_sobrenome']);
				$email = retornaEmail($dados['ema_id']);
				$link = "<a href=\"mailto:$email\">$email</a>";
				$template->setVariable("email", $link);
				$template->setVariable("rua", $dados['cli_rua']);
				$template->setVariable("numero", $dados['cli_numero']);
				$template->setVariable("bairro", $dados['cli_bairro']);
				$template->setVariable("telefone", $dados['cli_telefone']);
				$taxa = $dados['txe_localizacao']." (<b>".number_format($dados['txe_valor'], 2, ',','.')."</b>)";
				$template->setVariable("taxa", $taxa);
				if(empty($dados['loc_obs'])){
					$dados['loc_obs'] = "Sem observação.";
				}
				$template->setVariable("obs", $dados['loc_obs']);
				$template->setVariable("status", $dados['loc_situacao']);
				$template->setVariable("dLoc", converteData($dados['loc_data_entrega']));
				$template->setVariable("dBus", converteData($dados['loc_data_busca']));
				$template->setVariable("hLoc", $horarios[$dados['loc_hora_entrega']]);
				$template->setVariable("hBus", $horarios[$dados['loc_hora_busca']]);
				$template->setVariable("cod", $dados['loc_cod']);
				
				$template->setVariable("linkVejaMais", "javascript:abrir('mostraCliente.php?cliente={$dados['cli_cpf']}', '328', '443', 'no');");
				$template->setVariable("vejaMais", "Maiores informações sobre o cliente");
				
				$locar     = false;
				$fechar    = false;
				$concluido = false;
				
				if($dados['loc_situacao'] == $situacao[3]){
					$locar  = true;
					$fechar = true;
				}
				else if($dados['loc_situacao'] == $situacao[1]){
					$fechar = true;
				}
				else{
					$concluido = true;
				}
				
				if($locar){
					$template->setVariable("locar", "<a href=\"alteraLocacao.php?id={$dados['loc_cod']}&altera=locar\"><img src=\"../images/bot_locar3.jpg\" border=\"0\" alt = \"Confirmar Locação !\"></a>");
				}				
				
				if($fechar){
					$template->setVariable("fechar", "<a href=\"alteraLocacao.php?id={$dados['loc_cod']}&altera=fechar\"><img src=\"../images/bot_fechar.jpg\" border=\"0\" alt = \"Fechar Locação !\"></a>");
				}
				
				if($concluido){
					$template->setVariable("concluido", "<a href=\"alteraLocacao.php?id={$dados['loc_cod']}&altera=locar&trava=sim\"><img src=\"../images/bot_abrir.jpg\" border=\"0\" alt = \"Abrir Locação !\"></a>");
				}
				
			$template->parseCurrentBlock("bloco_locacoes_dados");
			
		$template->setCurrentBlock("bloco_locacoes_pag");
		$template->parseCurrentBlock("bloco_locacoes_pag");
		
		$contem_resultado = true;
	}
	
	/* Botão */	
		$template->setVariable("linkVoltar", "#");
		$template->setVariable("altVoltar", "Voltar !");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "location.href='administrar.php'");
		
	/* Titulo */	
	$template->setVariable("tituloLocacoes", "Listagem das locações");
	
	/* Caso não ache nenhum resultado escreve para o usuário */
	if($contem_resultado == false){
		$template->setCurrentBlock("bloco_detalhes_capa_erro");
				$template->setVariable("erro", "Não foi encontrado nenhum registro em '".ASSUNTO."'.");
		$template->parseCurrentBlock("bloco_detalhes_capa_erro");
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
	$infos .= "Existem <b>".QTD."</b> ".ASSUNTO." em nosso site.<br>";
	$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";
	
	if(!empty($paginacao)){
		$template->setCurrentBlock("bloco_detalhes_capa_paginacao_controle");
					$template->setVariable("paginacao", $paginacao);
		$template->parseCurrentBlock("bloco_detalhes_capa_paginacao_controle");
	}
	
	if($contem_resultado == true  && empty($id)){
		$template->setCurrentBlock("bloco_detalhes_capa_paginacao");
					$template->setVariable("infos", $infos);
		$template->parseCurrentBlock("bloco_detalhes_capa_paginacao");
	}
	
	$template->parseCurrentBlock("bloco_locacoes");
	
	$show  = $template->get();
	$show .= "<br>";
	
	/* Título da Página Interna */
	$tituloInterna = "Locações";
	
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