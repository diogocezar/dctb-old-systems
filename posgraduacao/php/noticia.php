<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Fazendo a verificação no banco de dados se o usuário e/ou senha são válidos */

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
	echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
}
else{
	
	$acao  = $_GET['acao'];
	$id    = $_GET['id'];
	
	switch($acao){
		case 'adicionar' :
			$noticia['action'] = "adiciona.php?tipo=noticia";
			$noticia['nome_botao'] = "btnInserir";
			$noticia['label_botao'] = "Adicionar Notícia";
			break;
		
		case 'atualizar' :
			$noticia['action'] = "atualiza.php?tipo=noticia&id=$id";
			$noticia['nome_botao'] = "btnAtualizar";
			$noticia['label_botao'] = "Atualizar Notícia";
			$sql = "SELECT cur_cod, not_titulo, not_conteudo
			FROM {$tabela['noticias']}
			WHERE not_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$noticia['titulo']       = $dados['not_titulo'];
			$noticia['conteudo']     = desconverteQuebra($dados['not_conteudo']);
			/* Recuperando curso do banco de dados */
			$cursoSeleciona = $dados['cur_cod'];
			break;
	}
	
	/* Gerando combo dos cursos */
	if($curso == 1){
		$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']}";	
	}
	else{
		$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']} WHERE cur_cod = $curso";	
	}
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		if($dados['cur_cod'] == 1){
			$dados['cur_nome'] .= " - Página Principal";
		}
			$cursos .= "<option value=\"{$dados['cur_cod']}\"";
			if($dados['cur_cod'] == $cursoSeleciona){
				$cursos .= "selected";
			}
			$cursos .= ">".limitaStr(str_replace("Curso de Especialização em ", "", $dados['cur_nome']), 38)."</option>";
	}
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'formNoticia.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_form_noticia");
	
		/* Formulario */
			$template->setVariable("form_noticia", "formNoticia");
			$template->setVariable("action", $noticia['action']);
		
		/* Titulos */
			$template->setVariable("noticia", "Notícia");
	
		/* Titulos dos Campos */	
			$template->setVariable("curso", "Curso");
			$template->setVariable("titulo", "Título");
			$template->setVariable("conteudo", "Conteúdo");
		
		/* Nomes dos Campos */
			$template->setVariable("comboCurso", "curso");
			$template->setVariable("campoTitulo", "titulo");
			$template->setVariable("campoConteudo", "conteudo");
		
		/* Valores dos Campos */
			$template->setVariable("valorTitulo", $noticia['titulo']);
			$template->setVariable("valorConteudo", $noticia['conteudo']);

		/* Preenchimento dos Combos */
			$template->setVariable("comboCursoOpcoes", $cursos);
			
		/* Botão */
			$template->setVariable("nomeBotao", $noticia['nome_botao']);
			$template->setVariable("enviar", $noticia['label_botao']);
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "« Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaNoticia(formNoticia.titulo, formNoticia.conteudo, formNoticia)");
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
			
	$template->parseCurrentBlock("bloco_form_noticia");
	
	$formulario .= "<br>";
	$formulario .= $template->get();
	
	/* Diretório dos Templates */
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
		$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
		$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");
	
	/* Bloco do Titulo da Página Interna */
	$template->setCurrentBlock("bloco_titulo_interna");
		$template->setVariable("titulo", "Área Restrita");
	$template->parseCurrentBlock("bloco_titulo");
	
	/* Bloco do conteúdo da página interna */
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
	
	/* Bloco do Título */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
	$template->show();
}//Else
?>