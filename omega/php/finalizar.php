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

/* Adicionando ítens na $_SESSION */

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Você prescisa estar logado para ter acesso à suas compras.');location.href='index.php'</script>";
	exit();
}
else{
	$cod = $session->retornaSession('codSession');
}

/*
########################################################################################
E X I B I N D O   Í T E N S   C O M P R A D O S   E   A   T A X A   D E   E N T R E G A 
*/

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'pedidoFinalizar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$trava_finaliza = false;

/* Bloco dos Produtos */
$total = 0;
if(!empty($_SESSION['produtos'])){
	foreach($_SESSION['produtos'] as $indice => $valor){
		$template->setCurrentBlock("bloco_pedido_prod");
			$preco = $valor['preco'];
			$qtd   = $valor['qtd'];
			$nome  = $valor['nome'];
			$subtotal = $qtd*$preco;
			$total += $subtotal;
			$template->setVariable("qtd", $qtd);
			$template->setVariable("prod", $nome);
			$template->setVariable("valor", number_format($preco,2,',','.'));
			$template->setVariable("subtotal", number_format($subtotal,2,',','.'));
		$template->parseCurrentBlock("bloco_pedido_prod");
	}
	$trava_finaliza = true;
}

$qtdLancamentos = 0;
$qtdOutros = 0;
$qtdFilmes = 0;

/* Bloco dos Filmes */
if(!empty($_SESSION['filmes'])){
	foreach($_SESSION['filmes'] as $indice => $valor){
		$template->setCurrentBlock("bloco_pedido_filme");
			$preco = $valor['preco'];
			$qtd   = $valor['qtd'];
			$nome  = "<a href = \"mostraFilme.php?id={$valor['cod_filme']}\">".$valor['nome']."</a>";
			$subtotal = $qtd*$preco;
			if(lancamento($valor['cod_filme'])){
				$qtdLancamentos++;
			}
			else{
				$qtdOutros++;
			}
			$qtdFilmes++;
			$total += $subtotal;
			$template->setVariable("qtd", $qtd);
			$template->setVariable("prod", $nome);
			$template->setVariable("valor", number_format($preco,2,',','.'));
			$template->setVariable("subtotal", number_format($subtotal,2,',','.'));
		$template->parseCurrentBlock("bloco_pedido_filme");
	}
	$trava_finaliza = true;
}

/* Enviando para Carrinho se Nào Houver Produtos */

if(!$trava_finaliza){
		echo "<script language=javascript>location.href='carrinho.php'</script>";
}

/* Adicionando Taxa de Entrega */
$template->setCurrentBlock("bloco_taxa_entrega");
		$taxa = retornaTx($cod);
		$template->setVariable("taxaEntrega", $taxa[0]);
		$template->setVariable("valorEnt", number_format($taxa[1],2,',','.'));
$template->parseCurrentBlock("bloco_taxa_entrega");

$total += $taxa[1];

/* Alterando valor da session */
$_SESSION['val_total'] = $total;

$template->setCurrentBlock("bloco_pedido_finalizar");
		$template->setVariable("total", number_format($total,2,',','.'));
$template->parseCurrentBlock("bloco_pedido_finalizar");

$show = $template->get();
$show .= "<br>";


/*
########################################################################################
F O R M U L Á R I O   D E   C O N C L U S Ã O   D A   C O M P R A 
*/

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formLocacao.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco da Obs */
$template->setCurrentBlock("bloco_locacao_obs");

		$msgLancamento = "Atenção você locou <b>$qtdLancamentos</b> lançamento(s), esse(s) filme(s) poderá(ão) ser buscado(s) em 24 horas (1 dia) após a locação.";
		$msgConfira    = "Confira atentamente todas as informações antes de confirmar seu pedido.";
		if($qtdLancamentos > 0){
			$template->setVariable("obs", $msgLancamento);
		}
		else{
			$template->setVariable("obs", $msgConfira);
		}
		
$template->parseCurrentBlock("bloco_locacao_obs");

$template->setCurrentBlock("bloco_locacao");
		$template->setVariable("actionLocacao", "adiciona.php?tipo=locacao");
		$template->setVariable("formLocacao", "form_locacao");
		$template->setVariable("onClickComprar", "enviaForm(form_locacao)");
		$template->setVariable("tituloLocacao", "Informações sobre Entrega");
		$template->setVariable("onClickVoltar", "location.href='carrinho.php'");
		$template->setVariable("comboHoraEntrega", "hora_entrega");
		$template->setVariable("comboHoraDevolucao", "hora_devolucao");
		$template->setVariable("campoObs", "obs");
		$template->setVariable("dataLocacao", "data_locacao");
		$template->setVariable("dataDevolucao", "data_devolucao");
		$template->setVariable("valor", "valor");
		$template->setVariable("valorEnvia", $total);
		$template->setVariable("linkComprar", "#");
		$template->setVariable("altComprar", "Finalizar Compra !");
		$template->setVariable("linkVoltar", "#");
		$template->setVariable("altVoltar", "Voltar !");
		$template->setVariable("valorEnvia", $total);
		
		/* Regra para Calcular tempo para Devolução */
		
		if(empty($qtdFilmes)){
			echo "<script language=javascript>alert('Você deve locar algum filme para concluir sua compra.');location.href='index.php'</script>";
			exit();
		}
		else if($qtdFilmes == 1){
			if($qtdOutros == 0){
				$horas = 24;
			}
			else{
				$horas = 48;
			}
		}
		else if($qtdFilmes == 2){
			$horas = 48;
		}
		else if($qtdFilmes == 3 || $qtdFilmes == 4){
			$horas = 72;
		}
		else{
			$horas = 96;
		}
		
		$mes        = date("m");
		$diaNum     = date("d");
		$ano        = date("Y");
		
		$hora     = date("H");
		$minuto   = date("i");
		$segundo  = date("s");
		
		$locacao = mktime($hora, $minuto, $segundo, $mes, $diaNum, $ano);
		
		$devolucao = strtotime("+$horas hours", $locacao);
		
		$semana  = date("w", $devolucao);
		
		if($semana == 0){
			$devolucao = strtotime("+24 hours", $devolucao);
		}
		
		/* Enquanto for feriado soma mais 24 horas */		
		while(feriado(date("Y-m-d", $devolucao))){
			$devolucao = strtotime("+24 hours", $devolucao);
		}
		
		/* Somar dias caso feriado FAZER */
		
		$template->setVariable("dataLoc", date("d/m/Y", $locacao));
		
		$template->setVariable("dataDev", date("d/m/Y", $devolucao));
		
		/* Inserindo as opções nos combos */
		
		$horarioLoc = eliminaHorarios($horarios);
		
		$horarioDev = $horarios;
		
		$diaSemanaLoc  = date("w", $locacao);
		
		$diaSemanaDev  = date("w", $devolucao); 
		
		/* Gerando os horários disponíveis para o dia de locação */		
		if(feriado(date("Y-m-d", $locacao))){
			$disponiveisLoc = $regHorarios['sabado'];
		}		
		else if($diaSemanaLoc > 0 && $diaSemanaLoc < 6){
			$disponiveisLoc = $regHorarios['semana'];
		}
		else if($diaSemanaLoc == 0){
			$disponiveisLoc = $regHorarios['domingo'];
		}
		else{
			$disponiveisLoc = $regHorarios['sabado'];
		}
		
		/* Gerando os horários disponíveis para o dia da devolução */
		if(feriado(date("Y-m-d", $devolucao))){
			$disponiveisDev = $regHorarios['sabado'];
		}		
		else if($diaSemanaDev > 0 && $diaSemanaDev < 6){
			$disponiveisDev = $regHorarios['semana'];
		}
		else if($diaSemanaDev == 0){
			$disponiveisDev = $regHorarios['domingo'];
		}
		else{
			$disponiveisDev = $regHorarios['sabado'];
		}
		
		/* Retirando Horários Indisponiveis da locação */
		for($i=1; $i<=count($horarios); $i++){
			if($disponiveisLoc[$i] == '#'){
				unset($horarioLoc[$i]);
			}
		}
		
		/* Retirando Horários Indisponiveis da locação */
		for($i=1; $i<=count($horarios); $i++){
			if($disponiveisDev[$i] == '#'){
				unset($horarioDev[$i]);
			}
		}
		
		/* Excluindo dias reservados no banco 
	
		$sql = "SELECT loc_hora_entrega, loc_hora_busca FROM {$tabela['locacao']} WHERE loc_data_entrega = '".date("Y-m-d", $locacao)."' or loc_data_busca = '".date("Y-m-d", $locacao)."'";	
		$resultado = $dataBase->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				unset($horarioLoc[$dados['loc_hora_entrega']]);
				unset($horarioLoc[$dados['loc_hora_busca']]);
			}
		}
		
		$sql = "SELECT loc_hora_entrega, loc_hora_busca FROM {$tabela['locacao']} WHERE loc_data_entrega = '".date("Y-m-d", $devolucao)."' or loc_data_busca = '".date("Y-m-d", $devolucao)."'";		
		$resultado = $dataBase->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				unset($horarioDev[$dados['loc_hora_entrega']]);
				unset($horarioDev[$dados['loc_hora_busca']]);
			}
		}
		
		*/
		
		foreach($horarioLoc as $indice => $valor){
			if(!empty($valor)){
				$horDispLoc .= "<option value=\"$indice\"";
				$horDispLoc .= ">".$valor."</option>";
			}
		}
		
		foreach($horarioDev as $indice => $valor){
			if(!empty($valor)){
				$horDispDev .= "<option value=\"$indice\"";
				$horDispDev .= ">".$valor."</option>";
			}
		}
		
		if(empty($horDispLoc) || empty($horDispDev)){
			unset($_SESSION['produtos']);
			unset($_SESSION['filmes']);
			unset($_SESSION['qtd_filmes']);
			unset($_SESSION['qtd_conveniencia']);
			unset($_SESSION['val_total']);
			echo "<script language=javascript>alert('Desculpe mas os horários para locação/devolução estão oculpados.');location.href='index.php'</script>";
		}
		
		$template->setVariable("comboOpcoesHoraEntrega", $horDispLoc);
		$template->setVariable("comboOpcoesHoraDevolucao", $horDispDev);
		
$template->parseCurrentBlock("bloco_locacao");

$show .= $template->get();
$show .= "<br>";

/* Título da Página Interna */
$tituloInterna = "Finalizando a Compra";

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