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
	
	$templateHtmlName = 'formAlteraSenha.html';
	
	if(file_exists($templateHtmlDir.$templateHtmlName)){ echo "existe"; }
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Convers�o das vari�veis dos blocos */
	
	$template->setCurrentBlock("bloco_alterar_senha");
	
		/* Formulario */
			$template->setVariable("form_alterar_senha", "formAltera");
			$template->setVariable("action", "atualiza.php?tipo=alterar_senha");
		
		/* Titulos */
			$template->setVariable("troca_de_senha", "Alterar senha de administra��o");
	
		/* Titulos dos Campos */	
			$template->setVariable("senha_atual", "Senha atual");
			$template->setVariable("nova_senha", "Nova senha");
			$template->setVariable("nova_senha_confirma", "Confirme a nova senha");
		
		/* Nomes dos Campos */
			$template->setVariable("campoSenhaAtual", "senha_atual");
			$template->setVariable("campoNovaSenha", "senha_nova");
			$template->setVariable("campoNovaSenhaConfirma", "confirma_senha");
		
		/* Bot�o */
			$template->setVariable("nomeBotao", "btnAtualizar");
			$template->setVariable("enviar", "Atualizar Senha");
			$template->setVariable("nomeBotaoVoltar", "btnVoltar");
			$template->setVariable("voltar", "� Voltar");
			
		/* Java Script ao Enviar */
			$template->setVariable("onClickEnviar", "validaAlterar(formAltera.senha_atual, formAltera.senha_nova, formAltera.confirma_senha, formAltera)");
			$template->setVariable("onClickVoltar", "javascript:history.go(-1)");
			
	$template->parseCurrentBlock("bloco_alterar_senha");
	
	$alterarSenha .= "<br>";
	$alterarSenha .= $template->get();
	
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
		$template->setVariable("conteudo", $alterarSenha);
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