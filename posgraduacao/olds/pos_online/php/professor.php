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
	
	$curso = sessionNum($_SESSION['curso']);
	
	switch($acao){
		case 'adicionar' :
			$professor['action'] = "adiciona.php?tipo=professor";
			$professor['nome_botao'] = "btnInserir";
			$professor['label_botao'] = "Adicionar Professor";
			break;
		
		case 'atualizar' :
			$professor['action'] = "atualiza.php?tipo=professor&id=$id";
			$professor['nome_botao'] = "btnAtualizar";
			$professor['label_botao'] = "Atualizar Professor";
			$sql = "SELECT pro_nome, pro_atuacao, pro_titulacao, pro_formacao, pro_email, pro_pag_pessoal 
			FROM {$tabela['professores']}
			WHERE pro_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$professor['nome']          = $dados['pro_nome'];
			$professor['atuacao']       = desconverteQuebra($dados['pro_atuacao']);
			$professor['titulacao']     = desconverteQuebra($dados['pro_titulacao']);
			$professor['formacao']      = desconverteQuebra($dados['pro_formacao']);
			$professor['email']         = $dados['pro_email'];
			$professor['pag_pessoal']   = $dados['pro_pag_pessoal'];
			break;
	}
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'formProfessor.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_form_professor");
	
		/* Formulario */
			$template->setVariable("form_professor", "formProf");
			$template->setVariable("action", $professor['action']);
		
		/* Titulos */
			$template->setVariable("professor", "Professor");
	
		/* Titulos dos Campos */	
			$template->setVariable("nome", "Nome");
			$template->setVariable("email", "E-mail");
			$template->setVariable("paginaPessoal", "Página pessoal");
			$template->setVariable("atuacao", "Atuação");
			$template->setVariable("titulacao", "Titulação");
			$template->setVariable("formacao", "Formação");
		
		/* Nomes dos Campos */
			$template->setVariable("campoNome", "nome");
			$template->setVariable("campoEmail", "email");
			$template->setVariable("campoPaginaPessoall", "pagina_pessoal");
			$template->setVariable("campoAtuacao", "atuacao");
			$template->setVariable("campoTitulacao", "titulacao");
			$template->setVariable("campoFormacao", "formacao");
		
		/* Valores dos Campos */
			$template->setVariable("valorNome", $professor["nome"]);
			$template->setVariable("valorEmail", $professor["email"]);
			$template->setVariable("valorPaginaPessoall", $professor['pag_pessoal']);
			$template->setVariable("valorAtuacao", $professor["atuacao"]);
			$template->setVariable("valorTitulacao", $professor["titulacao"]);
			$template->setVariable("valorFormacao", $professor["formacao"]);	
		/* Botão */
			$template->setVariable("nomeBotao", $professor['nome_botao']);
			$template->setVariable("enviar", $professor['label_botao']);
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "« Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaProfessor(formProf.nome, formProf.email, formProf)");
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
			
	$template->parseCurrentBlock("bloco_form_professor");
	
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