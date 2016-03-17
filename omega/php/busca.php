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

/* Definindo constantes */	
define(ASSUNTO, "filmes");
define(TABELA_FILME, $tabela['filme']);
define(TABELA_GENERO_FILME, $tabela['genero_filme']);
define(TABELA_GENERO, $tabela['genero']);
define(TABELA_ATOR, $tabela['ator']);
define(TABELA_ATOR_FILME, $tabela['ator_filme']);
define(TABELA_DIRETOR, $tabela['diretor']);
define(TABELA_DIRETOR_FILME, $tabela['diretor_filme']);

/* Variáveis de Get para paginação */
if(!isset($_GET['start']))$_GET['start']=0;
$start = $_GET['start'];

/* Resgatando a opção para ordenação */
$ordem = $_GET['ordem'];

if(empty($ordem)){
	$ordem = 'fil_titulo';
}

$tipo = $_GET['tipo'];

if(empty($tipo)){
	$tipo = 'ASC';
}

define(PAGINA_ATUAL, getPaginaAtual());
define(ORDEM, $tipo);
define(ORDENADO, $ordem);
define(ATUAL, $start);
define(POR_PAGINA, PP_MOSTRA_FILMES);

/* Resgatando informacões para Gerar o SQL */
$genero        = $_GET['genero'];
$por           = $_GET['por'];
$nome          = noToGet($_GET['nome']);
$classificacao = $_GET['classificacao'];
$categoria     = $_GET['categoria'];

if(empty($genero)){
	echo "<script language=javascript>location.href='index.php'</script>";
}

$travaMaior = false;

if(empty($_SESSION['maiorSession'])){
	$travaMaior = true;
}

if(retornaNomeGenero($genero) == "Pornô"){
	if($travaMaior == true){
		echo "<script language=javascript>location.href='termos.php?genero=$genero'</script>";
	}
}

if(empty($genero)){
	$where = "gf.gen_cod = g.gen_cod AND f.fil_cod = gf.fil_cod AND g.gen_cod = $genero";
}
else{
	$where = "gf.gen_cod = g.gen_cod AND f.fil_cod = gf.fil_cod";
}

if(!empty($nome)){
	switch($por){
		case 1:
			if($travaMaior){
				$where .= " AND (f.fil_titulo LIKE '%$nome%' OR f.fil_titulo_original LIKE '%$nome%') AND g.gen_nome <> 'Pornô'";
			}
			else{
				$where .= " AND f.fil_titulo LIKE '%$nome%' OR f.fil_titulo_original LIKE '%$nome%'";
			}
			define(SQL, "SELECT DISTINCT f.fil_cod, f.fil_titulo, f.fil_foto
			             FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
						 WHERE ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
						 
			define(SQL_COUNT, "SELECT count(distinct( f.fil_titulo)) as qtd
			                   FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
						       WHERE ".$where);
			break;
		case 2:
			if($travaMaior){
				$where .= " AND (a.ato_cod = af.ato_cod AND f.fil_cod = af.fil_cod AND a.ato_nome LIKE '%$nome%') AND g.gen_nome <> 'Pornô'";
			}
			else{
				$where .= " AND a.ato_cod = af.ato_cod AND f.fil_cod = af.fil_cod AND a.ato_nome LIKE '%$nome%'";
			}
			define(SQL, "SELECT DISTINCT f.fil_cod, f.fil_titulo, f.fil_foto
			             FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g, ".TABELA_ATOR." a, ".TABELA_ATOR_FILME." af
						 WHERE ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
						 
			define(SQL_COUNT, "SELECT count(distinct( f.fil_titulo)) as qtd
			                   FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g, ".TABELA_ATOR." a, ".TABELA_ATOR_FILME." af
						       WHERE ".$where);
			break;
		case 3:
			if($travaMaior){
				$where .= " AND (d.dir_cod = df.dir_cod AND f.fil_cod = df.fil_cod AND d.dir_nome LIKE '%$nome%') AND g.gen_nome <> 'Pornô'";
			}
			else{
				$where .= " AND d.dir_cod = df.dir_cod AND f.fil_cod = df.fil_cod AND d.dir_nome LIKE '%$nome%'";
			}
			define(SQL, "SELECT DISTINCT f.fil_cod, f.fil_titulo, f.fil_foto
			             FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g, ".TABELA_DIRETOR." d, ".TABELA_DIRETOR_FILME." df
						 WHERE ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
						 
			define(SQL_COUNT, "SELECT count(distinct( f.fil_titulo)) as qtd
			                   FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g, ".TABELA_DIRETOR." d, ".TABELA_DIRETOR_FILME." df
						       WHERE ".$where);
			break;
	}
}
else{
	if($genero != -1){
		$passouPar = false;;
		if(!empty($classificacao)){
			$where .= " AND (f.cla_cod = $classificacao";
			$passouPar = true;
		}
		if(!empty($categoria)){
			$where .= " AND (f.cat_cod = $categoria";
			$passouPar = true;
		}
		if($passouPar){
			$where .= " AND g.gen_cod = $genero)";
		}
		else{
			$where .= " AND g.gen_cod = $genero";
		}
		if($travaMaior){
			$where .= " AND g.gen_nome <> 'Pornô'";
		}
		define(SQL, "SELECT DISTINCT f.fil_cod, f.fil_titulo, f.fil_foto
		             FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
					 WHERE ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
					 
		define(SQL_COUNT, "SELECT count(distinct( f.fil_titulo)) as qtd
		                   FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
					       WHERE ".$where);
	}
	else{
		if(!empty($classificacao)){
			$where .= " AND f.cla_cod = $classificacao";
		}
		if(!empty($categoria)){
			$where .= " AND f.cat_cod = $categoria";
		}
		if($travaMaior){
			$where .= " AND g.gen_nome <> 'Pornô'";
		}
		define(SQL, "SELECT DISTINCT f.fil_cod, f.fil_titulo, f.fil_foto
		             FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
					 WHERE ".$where." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
					 
		define(SQL_COUNT, "SELECT count(distinct( f.fil_titulo)) as qtd
		                   FROM ".TABELA_FILME." f, ".TABELA_GENERO_FILME." gf, ".TABELA_GENERO." g 
					       WHERE ".$where);
	}
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'listaFilmes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$resultado = $dataBase->query(SQL_COUNT);
$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
$qtd = $dados['qtd'];

define(QTD, $qtd);
define(TOTAL, ceil((QTD)/POR_PAGINA));

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
				$link    = "javascript:alert('Você prescisa estar logado no site para locar um filme.')";
			}
			else{
				$link = "carrinho.php?id={$dados['fil_cod']}&tipo=filme";
			}
				
			/* Gerando o botão de locado/locar */
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
/* Caso não ache nenhum resultado escreve para o usuário */
if($contem_resultado == false){
	$template->setCurrentBlock("bloco_gerenciar_erro");
	
			$template->setVariable("erro", "Não foi encontrado nenhum registro para sua busca.");
			
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
	
	/* Transformando o nome */
	$nome = toGet($nome);
		
	$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0&genero=$genero&por=$por&nome=$nome&categoria=$categoria&classificacao=$classificacao&ordem=$ordem&tipo=$tipo\"><img src=\"../images/bot_primeiro.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
	if($pag > 1){
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante&genero=$genero&por=$por&nome=$nome&categoria=$categoria&classificacao=$classificacao&ordem=$ordem&tipo=$tipo\">";
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
			$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i&genero=$genero&por=$por&nome=$nome&categoria=$categoria&classificacao=$classificacao&ordem=$ordem&tipo=$tipo\">$i</a> ";
		}
	}
	
	$aevi = POR_PAGINA*(TOTAL-1);
	$i    = TOTAL;
	$link = PAGINA_ATUAL."?start=$aevi&pag=$i&genero=$genero&por=$por&nome=$nome&categoria=$categoria&classificacao=$classificacao&ordem=$ordem&tipo=$tipo";
	
	$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
	
	if($pag < TOTAL){						
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox&genero=$genero&por=$por&nome=$nome&categoria=$categoria&classificacao=$classificacao&ordem=$ordem&tipo=$tipo\">";
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
		
	/* Botão */
		$template->setVariable("linkVoltar", "#");
		$template->setVariable("altVoltar", "Voltar !");
		$template->setVariable("linkOrdena", "#");
		$template->setVariable("altOrdena", "Ordenar !");
		
	/* Formulario */
		$template->setVariable("formBuscaOpcoes", "form_busca_op");
		$template->setVariable("actionBuscaOpcoes", "busca.php");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "location.href='index.php';");
		$template->setVariable("onClickOrdena", "enviaForm(form_busca_op)");
		
	/* Campos */
		$template->setVariable("campoGenero", "genero");
		$template->setVariable("campoPor", "por");
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoClassificacao", "classificacao");
		$template->setVariable("campoCategoria", "categoria");
		$template->setVariable("ordenadoPor", "ordem");
		$template->setVariable("tipoOrdem", "tipo");
		$template->setVariable("ordensOpcionais", "");
		
	/* Valores */
		$template->setVariable("valorGenero", $genero);
		$template->setVariable("valorPor", $por);
		$template->setVariable("valorNome", $nome);
		$template->setVariable("valorClassificacao", $classificacao);
		$template->setVariable("valorCategoria", $categoria);
		
	/* Marcando ordenações escolhidas */
	
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

/* Título da Página Interna */
$tituloInterna = "Exibindo os filmes encontrados na <b>Busca</b>.";

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
		if($genero == $dados['gen_cod']){
			$generos .= "selected";
		}
		$generos .= ">{$dados['gen_nome']}</option>";
	}
	
	$template->setVariable("comboGeneroOpcoes", $generos);
	
	/* Pega do array o buscar por... */

	foreach($buscarPor as $indice => $valor){
		$porOp .= "<option value=\"$indice\"";
		if($por == $indice){
			$porOp .= "selected";
		}
		$porOp .= ">$valor</option>";
	}
	
	$template->setVariable("comboPor", "por");
	$template->setVariable("comboPorOpcoes", $porOp);
	$template->setVariable("campoNome", "nome");
	$template->setVariable("valorNome", $nome);
	$template->setVariable("altBusca", "Buscar !");
	$template->setVariable("linkVejaTodos", "listarTodos.php");
	$template->setVariable("onClickBusca", "enviaForm(form_busca)");
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