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
			$admistrador['action'] = "adiciona.php?tipo=administrador";
			$admistrador['nome_botao'] = "btnInserir";
			$admistrador['label_botao'] = "Adicionar Administrador";
			break;
		
		case 'atualizar' :
			$admistrador['action'] = "atualiza.php?tipo=administrador&id=$id";
			$admistrador['nome_botao'] = "btnAtualizar";
			$admistrador['label_botao'] = "Atualizar Administrador";
			$sql = "SELECT cur_cod, adm_nome, adm_login, adm_senha, adm_email
			FROM {$tabela['administradores']}
			WHERE adm_cod = $id";	
			$resultado = $dataBase->query($sql);
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$admistrador['nome']          = $dados['adm_nome'];
			$admistrador['login']         = $dados['adm_login'];
			$admistrador['senha']         = $dados['adm_senha'];
			$admistrador['email']         = $dados['adm_email'];
			/* Recuperando curso do banco de dados */
			$curso = $dados['cur_cod'];
			break;
	}
	/* Gerando combo dos cursos */
	$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']}";	
	$resultado = $dataBase->query($sql);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		if($dados['cur_cod'] != 1){ // 1 : é o curso Administração geral
			$cursos .= "<option value=\"{$dados['cur_cod']}\"";
			if($dados['cur_cod'] == $curso){
				$cursos .= "selected";
			}
			$cursos .= ">".limitaStr(str_replace("Curso de Especialização em ", "", $dados['cur_nome']), 38)."</option>";
		}
	}
	
	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'formAdministrador.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	
	/* Conversão das variáveis dos blocos */
	
	$template->setCurrentBlock("bloco_form_administrador");
	
		/* Formulario */
			$template->setVariable("form_administrador", "formAdmin");
			$template->setVariable("action", $admistrador['action']);
		
		/* Titulos */
			$template->setVariable("administrador", "Administrador");
	
		/* Titulos dos Campos */	
			$template->setVariable("curso", "Curso");
			$template->setVariable("nome", "Nome");
			$template->setVariable("login", "Login");
			$template->setVariable("senha", "Senha");
			$template->setVariable("email", "E-mail");
		
		/* Nomes dos Campos */
			$template->setVariable("comboCurso", "curso");
			$template->setVariable("campoNome", "nome");
			$template->setVariable("campoLogin", "login");
			$template->setVariable("campoSenha", "senha");
			$template->setVariable("campoEmail", "email");
		
		/* Valores dos Campos */
			$template->setVariable("valorNome", $admistrador['nome']);
			$template->setVariable("valorLogin", $admistrador['login']);
			$template->setVariable("valorSenha", $admistrador['senha']);
			$template->setVariable("valorEmail", $admistrador['email']);	
		
		/* Preenchimento dos Combos */
			$template->setVariable("comboCursoOpcoes", $cursos);
			
		/* Botão */
			$template->setVariable("nomeBotao", $admistrador['nome_botao']);
			$template->setVariable("enviar", $admistrador['label_botao']);
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "« Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaAdm(formAdmin.nome, formAdmin.login, formAdmin.senha, formAdmin.email, formAdmin)");
			$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
			
	$template->parseCurrentBlock("bloco_form_administrador");
	
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