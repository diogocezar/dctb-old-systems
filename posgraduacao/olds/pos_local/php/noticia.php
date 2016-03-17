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
	
	$acao  = $_GET['acao'];
	$id    = $_GET['id'];
	
	switch($acao){
		case 'adicionar' :
			$noticia['action'] = "adiciona.php?tipo=noticia";
			$noticia['nome_botao'] = "btnInserir";
			$noticia['label_botao'] = "Adicionar Not�cia";
			break;
		
		case 'atualizar' :
			$noticia['action'] = "atualiza.php?tipo=noticia&id=$id";
			$noticia['nome_botao'] = "btnAtualizar";
			$noticia['label_botao'] = "Atualizar Not�cia";
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
			$dados['cur_nome'] .= " - P�gina Principal";
		}
			$cursos .= "<option value=\"{$dados['cur_cod']}\"";
			if($dados['cur_cod'] == $cursoSeleciona){
				$cursos .= "selected";
			}
			$cursos .= ">".limitaStr(str_replace("Curso de Especializa��o em ", "", $dados['cur_nome']), 38)."</option>";
	}
	
	/* Diret�rio dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'formNoticia.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	
	/* Convers�o das vari�veis dos blocos */
	
	$template->setCurrentBlock("bloco_form_noticia");
	
		/* Formulario */
			$template->setVariable("form_noticia", "formNoticia");
			$template->setVariable("action", $noticia['action']);
		
		/* Titulos */
			$template->setVariable("noticia", "Not�cia");
	
		/* Titulos dos Campos */	
			$template->setVariable("curso", "Curso");
			$template->setVariable("titulo", "T�tulo");
			$template->setVariable("conteudo", "Conte�do");
		
		/* Nomes dos Campos */
			$template->setVariable("comboCurso", "curso");
			$template->setVariable("campoTitulo", "titulo");
			$template->setVariable("campoConteudo", "conteudo");
		
		/* Valores dos Campos */
			$template->setVariable("valorTitulo", $noticia['titulo']);
			$template->setVariable("valorConteudo", $noticia['conteudo']);

		/* Preenchimento dos Combos */
			$template->setVariable("comboCursoOpcoes", $cursos);
			
		/* Bot�o */
			$template->setVariable("nomeBotao", $noticia['nome_botao']);
			$template->setVariable("enviar", $noticia['label_botao']);
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "� Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaNoticia(formNoticia.titulo, formNoticia.conteudo, formNoticia)");
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
			
	$template->parseCurrentBlock("bloco_form_noticia");
	
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