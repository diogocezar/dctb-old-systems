<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Fazendo a verifica��o no banco de dados se o usu�rio e/ou senha s�o v�lidos */

$permitido = false;

@$session = new Session();

if($_SESSION['permitido'] == 'sim'){
	$permitido = true;
	$cod   = sessionNum($session->retornaSession('cod'));
	$cod   = (int)$cod;
	$nome  = $session->retornaSession('nome');
	$login = $session->retornaSession('login');
	$curso = sessionNum($session->retornaSession('curso_adm'));
	$curso = (int)$curso;
}

if($permitido != true){
	echo "<script language=javascript>alert('Desculpe mas voc� n�o pode ser identificado !');location.href='login.php'</script>";
}
else{
	
	/* Diret�rio dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'gerenciar.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Definindo constantes */	
	define(ASSUNTO, "not�cias");
	define(TABELA, $tabela['noticias']);
	
	/* Contando registros */
	if($curso == 1){ // se for o administrador
		$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA);
	}
	else{
		$qtd = $dataBase->getOne("SELECT count(*) FROM ".TABELA." WHERE cur_cod = $curso");
	}
	
	/* Vari�veis de Get para pagina��o */
	if(!isset($_GET['start']))$_GET['start']=0;
	$start = $_GET['start'];
	
	define(QTD, $qtd);
	define(PAGINA_ATUAL, getPaginaAtual());
	define(ORDEM, 'ASC');
	define(ORDENADO, 'not_titulo');
	define(ATUAL, $start);
	define(POR_PAGINA, PP_NOTICIAS);
	define(TOTAL, ceil((QTD)/POR_PAGINA));
	if($curso == 1){ // se for o administrador
		define(SQL, "SELECT not_cod, not_titulo FROM ".TABELA." ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
	}
	else{
		define(SQL, "SELECT not_cod, not_titulo FROM ".TABELA." WHERE cur_cod = $curso ORDER BY ".ORDENADO." ".ORDEM." LIMIT ".ATUAL.", ".POR_PAGINA);
	}
	$resultado = $dataBase->query(SQL);
	$contem_resultado = false;
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	
		$template->setCurrentBlock("bloco_gerenciar_interno");
		
			/* Nomes das Imagens */	
				$template->setVariable("editar", "Editar");
				$template->setVariable("excluir", "Excluir");
			
			/* Links da imagens dos Campos */
				$template->setVariable("linkEditar", "noticia.php?acao=atualizar&id={$dados['not_cod']}");
				$template->setVariable("linkExcluir", "exclui.php?tipo=noticia&id={$dados['not_cod']}");
			
			/* Linha a ser impressa */
				$template->setVariable("linha", "<a href = \"mostranoticia.php?id={$dados['not_cod']}\" class=\"link_escuro\">".limitaStr($dados['not_titulo'], 55)."</a>");
				
		$template->parseCurrentBlock("bloco_gerenciar_interno");
		$contem_resultado = true;

	}
	
	/* Caso n�o ache nenhum resultado escreve para o usu�rio */
	if($contem_resultado == false){
		$template->setCurrentBlock("bloco_gerenciar_erro");
				$template->setVariable("erro", "N�o foi encontrado nenhum registro em '".ASSUNTO."'.");
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
			
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=0\"><img src=\"../icones/2leftarrow.jpg\" border=\"0\"><a>&nbsp;&nbsp;";
		if($pag > 1){
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_ante&pag=$pag_ante\">";
		}		
		$paginacao .= "<img src=\"../icones/1leftarrow.jpg\" border=\"0\"></a>&nbsp;.<b>.</b>&nbsp;";		
		for($i=1; $i<=TOTAL ; $i++){
			if(POR_PAGINA*($i-1) == ATUAL){	
				$paginacao .= "<b> $i</b>";
			}
			else{
				$aevi = POR_PAGINA*($i-1);
				$paginacao .= " <a href=\"".PAGINA_ATUAL."?start=$aevi&pag=$i\" class=\"link_escuro\">$i</a> ";
			}
			/* Guardando o Link para a Ultima P�gina */
			if($i == TOTAL){
				$link = PAGINA_ATUAL."?start=$aevi&pag=$i";
			}
		}
		
		$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
		
		if($pag < TOTAL){						
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?start=$mostra_prox&pag=$pag_prox\">";
		}
		
		$paginacao .= "<img src=\"../icones/1rightarrow.jpg\" border=\"0\"></a>&nbsp;";
		$paginacao .= "<a href=\"$link\"><img src=\"../icones/2rightarrow.jpg\" border=\"0\"></a>";									
	}
	$agora = ($start/POR_PAGINA)+1;
	$todas = TOTAL;
	
	$infos = '<br>';
										
	$infos .= "Exibindo p�gina : <b>$agora</b> de <b>$todas</b> p�ginas<br>";
	$infos .= "Existem <b>".QTD."</b> de ".ASSUNTO." em nosso site.<br>";
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
			$template->setVariable("titulo", "Gerenciar Not�cias");
	
		/* Bot�o */
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "� Voltar");
			
		/* Java Script ao Voltar */
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
	
	$template->parseCurrentBlock("bloco_gerenciar");
	
	$formulario .= "<br>";
	$formulario .= $template->get();
	
	/* Diret�rio dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'templateInterna.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco de Contatos */
	$template->setCurrentBlock("bloco_contatos");
		$template->setVariable('contatos', $contato[1]);
	$template->parseCurrentBlock("bloco_contatos");
	
	/* Bloco Saiba Mais */
	$template->setCurrentBlock("bloco_saiba_mais");
		$template->setVariable("saibaMaisTitulo", "Maiores infroma��es ?");
		$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");
	
	/* Bloco do Titulo da P�gina Interna */
	$template->setCurrentBlock("bloco_titulo_interna");
		$template->setVariable("titulo", "�rea Restrita");
	$template->parseCurrentBlock("bloco_titulo");
	
	/* Bloco do conte�do da p�gina interna */
	$template->setCurrentBlock("bloco_conteudo");
		$template->setVariable("conteudo", $formulario);
	$template->parseCurrentBlock("bloco_conteudo");
	
	/* Bloco da Data */
	$template->setCurrentBlock("bloco_data");
		$template->setVariable("data", getData(0));
	$template->parseCurrentBlock("bloco_data");
	
	/* Bloco Geral */
	$template->setCurrentBlock("bloco_geral");
		/* Links Superiores */
		$template->setVariable("linkUtf", UTFPR);
		$template->setVariable("linkDepog", DEPOG);
		/* Menu */
		foreach($menu['principal'] as $menu => $cont){
			foreach($cont as $link => $titulo){
				$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
			}
		}
	$template->parseCurrentBlock("bloco_geral");
	
	/* Bloco do T�tulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
	$template->show();
}//Else
?>