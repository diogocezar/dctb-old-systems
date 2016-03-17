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

$permitido = false;

@$session = new Session();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'listaFilmes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Definindo constantes */	
define(ASSUNTO, "filmes");

$sqlCount = "SELECT count(distinct(fil.fil_titulo)) as qtd
			 FROM {$tabela['filme']} fil, {$tabela['categoria']} cat, {$tabela['genero']} gen, {$tabela['genero_filme']} genf
			 WHERE fil.cat_cod = cat.cat_cod AND cat.cat_nome = 'Lan�amento' AND genf.gen_cod = gen.gen_cod AND fil.fil_cod = genf.fil_cod AND gen.gen_nome <> 'Porn�'
			 ORDER BY fil.fil_cod DESC";

/* Contando registros */
$resultado = $dataBase->query($sqlCount);
$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
$qtd = $dados['qtd'];

/* Vari�veis de Get para pagina��o */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

/* Resgatando a op��o para ordena��o */
$ordem = $_GET['ordem'];

if(empty($ordem)){
	$ordem = 'fil_cod';
}

$tipo = $_GET['tipo'];

if(empty($tipo)){
	$tipo = 'DESC';
}

define(QTD, $qtd);
define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, $tipo);
define(ORDENADO, $ordem);
define(ATUAL, $start);
define(POR_PAGINA, PP_LANCAMENTOS);
define(TOTAL, ceil((QTD)/POR_PAGINA));
$sql = "SELECT DISTINCT fil.fil_cod, fil.fil_titulo, fil.fil_foto
	    FROM {$tabela['filme']} fil, {$tabela['categoria']} cat, {$tabela['genero']} gen, {$tabela['genero_filme']} genf
	    WHERE fil.cat_cod = cat.cat_cod AND cat.cat_nome = 'Lan�amento' AND genf.gen_cod = gen.gen_cod AND fil.fil_cod = genf.fil_cod AND gen.gen_nome <> 'Porn�'
		ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA;
define(SQL, $sql);
$resultado = $dataBase->query(SQL);
$contem_resultado = false;
$i = 0;
$template->setCurrentBlock("bloco_lista_filmes_loc");
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if(filmeComMidia($dados['fil_cod'])){
		if($i < 5){	
			$i++;
		}
		else{
			$template->setCurrentBlock("bloco_lista_filmes_linha");
			$template->parseCurrentBlock("bloco_lista_filmes_linha");
			$i = 1;
		}
		
		$template->setCurrentBlock("bloco_lista_filmes_loc");
			$link = "";
			if($_SESSION['usuarioSession'] != 'sim'){
				$link    = "javascript:alert('Voc� prescisa estar logado no site para locar um filme.')";
			}
			else{
				$link = "carrinho.php?id={$dados['fil_cod']}&tipo=filme";
			}
				
			/* Gerando o bot�o de locado/locar */
			if(locado($dados['fil_cod'])){
				$btn = "<img src=\"../images/bot_locado2.jpg\" border=\"0\"/>";
				$template->setVariable("loc", $btn);
			}
			else{
				$btn = "<img src=\"../images/bot_locar2.jpg\" border=\"0\"/>";
				$template->setVariable("loc", "<a href = \"$link\">".$btn."</a>");
			}
		$template->parseCurrentBlock("bloco_lista_filmes_loc");
		
		$template->setCurrentBlock("bloco_lista_filmes_foto");
				$template->setVariable("foto", "<a href = \"mostraFilme.php?id={$dados['fil_cod']}\"><img src=\"img.php?l=61&a=94&s=n&loc={$dados['fil_foto']}\" border = \"0\"></a>");
		$template->parseCurrentBlock("bloco_lista_filmes_foto");
	
		$template->setCurrentBlock("bloco_lista_filmes_titulo");
				$titulo = quebraStr($dados['fil_titulo'], LIMITE_LINHA);
				$template->setVariable("titulo", limitaStr($titulo, LIMITE_TITULO));
		$template->parseCurrentBlock("bloco_lista_filmes_titulo");
		
		$contem_resultado = true;
	}
}
/* Caso n�o ache nenhum resultado escreve para o usu�rio */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_gerenciar_erro");
			$template->setVariable("erro", "N�o foi encontrado nenhum filme em '<b>Lan�amentos</b>'.");
			
			$template->setCurrentBlock("bloco_lista_filmes_loc");
					$template->setVariable("loc", "<b>Desculpe</b>");
			$template->parseCurrentBlock("bloco_lista_filmes_loc");
			
			$template->setCurrentBlock("bloco_lista_filmes_foto");
					$template->setVariable("foto", "<img src=\"img.php?l=61&a=94&s=n&loc=../images/loc_n_achou.jpg\" border = \"0\">");
			$template->parseCurrentBlock("bloco_lista_filmes_foto");
			
			$template->setCurrentBlock("bloco_lista_filmes_titulo");
					$template->setVariable("titulo", "Nenhum filme encontrado.");
			$template->parseCurrentBlock("bloco_lista_filmes_titulo");
	$template->parseCurrentBlock("bloco_gerenciar_erro");
}

/* Controle da Pagina��o */
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
									
$infos .= "Exibindo p�gina : <b>$agora</b> de <b>$todas</b> p�ginas<br>";
$infos .= "Existem <b>".QTD."</b> ".ASSUNTO." em nosso site.<br>";
$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por p�gina.<br><br>";

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
		$template->setVariable("tituloListaFilmes", "Lista dos Filmes");
		$template->setVariable("ordenado", "Ordenar por :");
		$template->setVariable("tipo", "Tipo :");
		
	/* Bot�o */
		$template->setVariable("linkVoltar", "#");
		$template->setVariable("altVoltar", "Voltar !");
		$template->setVariable("linkOrdena", "#");
		$template->setVariable("altOrdena", "Ordenar !");
		
	/* Formulario */
		$template->setVariable("formBuscaOpcoes", "form_busca_op");
		$template->setVariable("actionBuscaOpcoes", "lancamentos.php");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickOrdena", "enviaForm(form_busca_op)");
		
	/* Campos */
		$template->setVariable("ordenadoPor", "ordem");
		$template->setVariable("tipoOrdem", "tipo");
		
	/* Marcando ordena��es escolhidas */
	
	switch($ordem){
		case 'fil_titulo':
			$template->setVariable("selTitulo", "selected");
			break;
			
		case 'fil_titulo_original':
			$template->setVariable("selTituloOri", "selected");
			break;
			
		case 'fil_cod':
			$template->setVariable("selCodigo", "selected");
			break;
			
		case 'fil_ano':
			$template->setVariable("selAno", "selected");
			break;
			
		case 'fil_duracao':
			$template->setVariable("selDuracao", "selected");
			break;
			
		case 'fil_distribuidora':
			$template->setVariable("selDistribuidora", "selected");
			break;
			
		case 'cat_cod':
			$template->setVariable("selCategoria", "selected");
			break;
			
		case 'cla_cod':
			$template->setVariable("selClassificacao", "selected");
			break;
	}
	
	switch($tipo){
		case 'ASC':
			$template->setVariable("selAsc", "selected");
			break;
			
		case 'DESC':
			$template->setVariable("selDesc", "selected");
			break;
	}

$template->parseCurrentBlock("bloco_gerenciar");

$show  = $template->get();
$show .= "<br>";

/* T�tulo da P�gina Interna */
$tituloInterna = "Exibindo Todos os Filmes '<b>Lan�amentos</b>'";

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

?>