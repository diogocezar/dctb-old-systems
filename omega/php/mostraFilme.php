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

/* Capturando Pedido */
$templateHtmlName = 'detalhesFilme.html';

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

/* Verificando se o filme tem alguma mídia cadastrada */

if(!filmeComMidia($id)){
	echo "<script language=javascript>alert('Este filme não possui nenhuma mídia cadastrada.');location.href='index.php'</script>";
	exit();
}

$sql = "SELECT fil.fil_cod, fil.cat_cod, fil.cla_cod, fil.fil_titulo, fil.fil_titulo_original, fil.fil_ano, fil.fil_duracao, fil.fil_sinopse, fil.fil_foto, fil.fil_distribuidora, fil.fil_destaque,
			   midi.mid_tipo, midi.mid_audio, midi.mid_legenda, midi.mid_regiao, midi.mid_formato, midi.mid_status
		FROM {$tabela['filme']} fil, {$tabela['midia']} midi
		WHERE fil.fil_cod = midi.fil_cod AND fil.fil_cod = $id
		LIMIT 1";
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	$template->setCurrentBlock("bloco_detalhe_filme");
	
		/* Gerando a avaliação */
	
		$avaliacao = retornaAvaliacao($dados['fil_cod']);

		$imprime = $avaliacao;
		
		for($i=0; $i<$imprime; $i++){
			$estrelas .= "<img src=\"../images/star.jpg\" />";
		}
		
		for($i=0; $i<5-$imprime; $i++){
			$estrelas .= "<img src=\"../images/star_null.jpg\" />";
		}
		
		/* Gerando lista de atores */
		
		$atores = retornaAtores($dados['fil_cod']);
		$i=1;
		if(!empty($atores)){
			foreach($atores as $id => $nome){
				if($i == count($atores)){
					$separador = "";
				}
				else{
					$separador = ", ";
				}
				//$exibirAtores .= "<a href = \"busca.php?genero=-1&por=2&nome=".toGet($nome)."\">$nome</a>".$separador;
				$exibirAtores .= "<a href = \"mostraAtor.php?id=$id\">$nome</a>".$separador;
				$i++;
			}
		}
		
		/* Gerando Lista de Diretores */
		
		$diretores = retornaDiretores($dados['fil_cod']);
		$i=1;
		if(!empty($diretores)){
			foreach($diretores as $id => $nome){
				if($i == count($diretores)){
					$separador = "";
				}
				else{
					$separador = ", ";
				}
				$exibirDiretores .= "<a href = \"busca.php?genero=-1&por=3&nome=".toGet($nome)."\">$nome</a>".$separador;
				$i++;
			}
		}
		
		/* Gerando a lista de Gêneros */
		
		$generos = retornaGeneros($dados['fil_cod']);
		$i=1;
		if(!empty($generos)){
			foreach($generos as $id => $nome){
				if($i == count($generos)){
					$separador = "";
				}
				else{
					$separador = ", ";
				}
				$exibirGeneros .= "<a href = \"busca.php?genero=$id\">$nome</a>".$separador;
				$i++;
			}
		}
		
		/* Linkando categoria e classificação */
		
		$categoria = "<a href = \"busca.php?genero=-1&categoria={$dados['cat_cod']}\">".retornaNomeCategoria($dados['cat_cod'])."</a>";
		
		$classificacao = "<a href = \"busca.php?genero=-1&classificacao={$dados['cla_cod']}\">".retornaNomeClassificacao($dados['cla_cod'])."</a>";
		
		/* Subistituindo as Variáveis */
		
		$template->setVariable("tituloMostaFilme", "Ficha Técnica :");
		$template->setVariable("tituloSinopse", "Sinopse :");
		$template->setVariable("tituloCaracteristicas", "Características :");
		$template->setVariable("titulo", $dados['fil_titulo']);
		$template->setVariable("tituloOriginal", $dados['fil_titulo_original']);
		$template->setVariable("ano", $dados['fil_ano']);
		$template->setVariable("duracao", $dados['fil_duracao']);
		$template->setVariable("categoria", $categoria);
		$template->setVariable("classificacao", $classificacao);
		$template->setVariable("elenco", $exibirAtores);
		$template->setVariable("diretor", $exibirDiretores);
		$template->setVariable("generos", $exibirGeneros);
		$template->setVariable("tipo", $dados['mid_tipo']);
		$template->setVariable("destaque", $dados['fil_destaque']);
		$template->setVariable("avaliacao", $estrelas);
		$template->setVariable("sinopse", bbcode(converteQuebra($dados['fil_sinopse'])));
		$template->setVariable("audio", $dados['mid_audio']);
		$template->setVariable("legenda", $dados['mid_legenda']);
		$template->setVariable("foto", "<img src=\"img.php?l=125&a=177&s=n&loc={$dados['fil_foto']}\" border = \"0\">");
		$template->setVariable("distribuidora", $dados['fil_distribuidora']);
		$template->setVariable("regiao", $dados['mid_regiao']);
		$template->setVariable("formato", $dados['mid_formato']);
		
		$link = "";
		if($_SESSION['usuarioSession'] != 'sim'){
			$link    = "javascript:alert('Você prescisa estar logado no site para locar um filme.')";
			$linkAva = "javascript:alert('Você prescisa estar logado no site para avaliar um filme.')";
			$linkFav = "javascript:alert('Você prescisa estar logado no site para adicionar um filme como favorito.')";
		}
		else{
			$cod = $session->retornaSession('codSession');
			
			$link = "carrinho.php?id={$dados['fil_cod']}&tipo=filme";
			if(!avaliado($cod, $dados['fil_cod'])){
				$linkAva = "javascript:abrir('avaliar.php?id={$dados['fil_cod']}', '330', '265', 'no');";
			}
			if(!favorito($cod, $dados['fil_cod'])){
				$linkFav = "adiciona.php?tipo=favorito&id={$dados['fil_cod']}";
			}
		}
				
		/* Gerando o botão de locado/locar */
			if(locado($dados['fil_cod'])){
				$btn = "<img src=\"../images/bot_locado.jpg\" border=\"0\"/>";
				$template->setVariable("locar_locado", $btn);
			}
			else{
				$btn = "<img src=\"../images/bot_locar.jpg\" border=\"0\"/>";
				$template->setVariable("locar_locado", "<a href = \"$link\">".$btn."</a>");
			}
			
		/* Gerando o botão avaliar */
			if(!empty($linkAva)){
				$template->setVariable("avaliar",   "<a href = \"$linkAva\"><img src=\"../images/bot_avaliar.jpg\"  border=\"0\"/></a>");
			}
			if(!empty($linkFav)){
				$template->setVariable("favoritos", "<a href = \"$linkFav\"><img src=\"../images/bot_favoritos.jpg\"  border=\"0\"/></a>");
			}
			else{
				$template->setVariable("favoritos", "<img src=\"../images/bot_favoritos_add.jpg\"  border=\"0\"/>");
			}
		
	$template->parseCurrentBlock("bloco_detalhe_filme");
}

$show = $template->get();
$show .= "<br>";
$show .= "<div align = \"center\"><a href = \"#\"><img src=\"../images/bot_voltar.jpg\" alt=\"Voltar !\" onClick=\"javascript:history.go(-1);\" border=\"0\"/></a></div>";
$show .= "<br>";

/* Título da Página Interna */
$tituloInterna = "Detalhes do Filme";

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