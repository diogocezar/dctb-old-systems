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

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateIndex.html';

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

/* Bloco Mais Locados */
$template->setCurrentBlock("bloco_mais_locados");

	$mes      = date("m");
	$diaNum   = date("d");
	$ano      = date("Y");
	
	$hora     = date("H");
	$minuto   = date("i");
	$segundo  = date("s");
	
	$dias = 30;
	
	$hojeTs = mktime($hora, $minuto, $segundo, $mes, $diaNum, $ano);
	
	$antesTs = strtotime("-$dias days", $hojeTs);
	
	$hoje = date("U", $hojeTs);
	
	$antes = date("U", $antesTs);
	
	$sql = "SELECT DISTINCT fil.fil_cod, fil.fil_titulo, fil.fil_foto, count(mid_loc.mid_cod) as qtd
		    FROM {$tabela['filme']} fil, {$tabela['midia']} midi, {$tabela['midia_locacao']} mid_loc, {$tabela['locacao']} loc, {$tabela['categoria']} cat, {$tabela['genero']} gen, {$tabela['genero_filme']} genf
			WHERE fil.fil_cod = midi.fil_cod
			AND midi.mid_cod = mid_loc.mid_cod
			AND loc.loc_cod = mid_loc.loc_cod
			AND fil.cat_cod = cat.cat_cod
			AND genf.gen_cod = gen.gen_cod
			AND fil.fil_cod = genf.fil_cod
			AND gen.gen_nome <> 'Pornô'
			AND  UNIX_TIMESTAMP(loc.loc_quando) < '$hoje' AND UNIX_TIMESTAMP(loc.loc_quando) > '$antes'
			GROUP BY fil.fil_cod
			ORDER BY qtd DESC
			LIMIT 10";

	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		$i = 1;
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			if(filmeComMidia($dados['fil_cod'])){
				$template->setVariable("ML$i", "<a href = \"mostraFilme.php?id={$dados['fil_cod']}\"><img src=\"img.php?l=61&a=94&s=n&loc={$dados['fil_foto']}\" border = \"0\"></a>");
				$titulo = quebraStr($dados['fil_titulo'], LIMITE_LINHA);
				$template->setVariable("MLT$i", limitaStr($titulo, LIMITE_TITULO));
				$i++;
			}
		}
	}
	$template->setVariable("linkMaisLocados", "maisLocados.php");
$template->parseCurrentBlock("bloco_mais_locados");

/* Bloco Carrinho */
$template->setCurrentBlock("bloco_carrinho");
	$template->setVariable("qtdF", number_format($_SESSION['qtd_filmes'], 0));
	$template->setVariable("qtdC", number_format($_SESSION['qtd_conveniencia'], 0));
	$template->setVariable("valorTotal", "R$ ".number_format($_SESSION['val_total'], 2, ',','.'));
	$template->setVariable("linkFim", "#");
	$template->setVariable("onClickFim", "javascript:location.href='finalizar.php'");
	$template->setVariable("altFim", "Finalizar Pedido !");
$template->parseCurrentBlock("bloco_carrinho");

/* Bloco Lançamentos */
$template->setCurrentBlock("bloco_lancamentos");
	/* CAPTURAR DINÂMICAMENTE */
	$sql = "SELECT DISTINCT fil.fil_cod, fil.fil_titulo, fil.fil_foto
			FROM {$tabela['filme']} fil, {$tabela['categoria']} cat, {$tabela['genero']} gen, {$tabela['genero_filme']} genf
			WHERE fil.cat_cod = cat.cat_cod 
			AND cat.cat_nome = 'Lançamento' 
			AND genf.gen_cod = gen.gen_cod 
			AND fil.fil_cod = genf.fil_cod
			AND gen.gen_nome <> 'Pornô'
			ORDER BY fil.fil_cod DESC
			LIMIT 20";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		$i = 1;
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			if(filmeComMidia($dados['fil_cod'])){
				$template->setVariable("L$i", "<a href = \"mostraFilme.php?id={$dados['fil_cod']}\"><img src=\"img.php?l=61&a=94&s=n&loc={$dados['fil_foto']}\" border = \"0\"></a>");
				$titulo = quebraStr($dados['fil_titulo'], LIMITE_LINHA);
				$template->setVariable("LT$i", limitaStr($titulo, LIMITE_TITULO));
				$i++;
			}
		}
	}
	$template->setVariable("linkLancamentos", "lancamentos.php");
$template->parseCurrentBlock("bloco_lancamentos");

/* Bloco Newsletter */
$template->setCurrentBlock("bloco_news");
	$template->setVariable("actionNews", "news.php");
	$template->setVariable("formNews", "form_news");
	$template->setVariable("campoEmail", "email");
	$template->setVariable("valorEmail", "");
	$template->setVariable("cadastrar", "cadastrar");
	$template->setVariable("remover", "remover");
	$template->setVariable("opNews", "opnews");
	$template->setVariable("altNews", "Enviar Cadastro !");
	$template->setVariable("linkNews", "#");
	$template->setVariable("clickNews", "news(form_news.email, form_news)");
$template->parseCurrentBlock("bloco_news");

/* Bloco Parceiros */
$template->setCurrentBlock("bloco_parceiros");
	foreach($parceiros as $indice => $valor){
		$parc .= "<a href =\"{$valor[1]}\"><img src=\"{$valor[0]}\" width=\"213\" height=\"52\" alt=\"$indice\" border=\"0\"></a><br>";
	}
	$template->setVariable("parceiros", $parc);
$template->parseCurrentBlock("bloco_parceiros");

/* Bloco Enquete */
$template->setCurrentBlock("bloco_enquete");
	$template->setVariable("actionEnquete", "votaEnquete.php");
	$template->setVariable("formEnquete", "form_enquete");
	
	$sql = "SELECT enq_id, enq_pergunta FROM {$tabela['enquete']} WHERE enq_exibir = 'Sim' LIMIT 1";	
	$resultado = $dataBase->getRow($sql);
	
	$idEnquete = $resultado[0];
	$perguntaEnquete = $resultado[1];
	
	$template->setVariable("pergunta", $perguntaEnquete);
	
	$sql = "SELECT res_id, res_resposta FROM {$tabela['respostas']} WHERE enq_id = $idEnquete ORDER BY res_resposta";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		$i = 1;
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$template->setVariable("resposta$i", $dados['res_resposta']);
			$template->setVariable("r$i", $dados['res_id']);
			$i++;
		}
	}
	$template->setVariable("opEnquete", "op_enquete");
	$template->setVariable("linkResultadoParcial", "javascript:abrir('resultado.php?enquete=$idEnquete', '330', '319', 'no');");
	$template->setVariable("linkVotar", "#");
	$template->setVariable("clickVotar", "enviaForm(form_enquete)");
	$template->setVariable("altVotar", "Votar !");
	
$template->parseCurrentBlock("bloco_enquete");

/* Bloco Novidades */
$template->setCurrentBlock("bloco_novidades");
	$sql = "SELECT nov_id, nov_titulo FROM {$tabela['novidade']} ORDER BY nov_id DESC LIMIT 4";
	$resultado = $dataBase->query($sql);
	$i = 1;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){	
		$template->setVariable("novidade$i", limitaStr($dados['nov_titulo'], LIMITE_TITULO_NOTICIA_INDEX));
		$template->setVariable("linkN$i", "mostraNovidade.php?id={$dados['nov_id']}");
		$i++;
	}
	$template->setVariable("linkVerTodas", "mostraTodas.php");
$template->parseCurrentBlock("bloco_novidades");

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