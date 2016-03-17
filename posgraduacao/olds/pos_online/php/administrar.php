<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Fazendo a verificação no banco de dados se o usuário e/ou senha são válidos */

$permitido = false;

$login = $_POST['login'];
$senha = $_POST['senha'];

@$session = new Session();

$resultado = $dataBase->query("SELECT adm_cod, cur_cod, adm_nome, adm_login, adm_senha FROM {$tabela['administradores']}");

while($data = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($data['adm_login'] == $login && $data['adm_senha'] == $senha){	
		$sessions = array('permitido' => 'sim',
		                  'cod'       => '#'.$data['adm_cod'],
						  'nome'      => $data['adm_nome'],
		                  'login'     => $data['adm_login'],
						  'curso_adm' => '#'.$data['cur_cod']
						 );
		$session = new Session($sessions);
		$permitido = true;
	}
}

$resultado->free();

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
	/* Apresentação */
	$conteudo = "<br>";
	$conteudo .= "Bem vindo(a), <b>$nome.</b><br><br>";

	/* Construindo Menu da Administração */
	foreach($menu['admin'] as $titulo => $link){
		$titulo_especial = false;
		
		if($titulo == "Gerenciar Curso"){
			$titulo_especial = true;
			if($curso != 1){
				$link_replace = str_replace("#", $curso, $link);
				$imprime = "&nbsp;&nbsp;<img src=\"../images/seta_preta.gif\">&nbsp;&nbsp;<a href=\"$link_replace\" class=\"curso_$curso\"><b>$titulo</b></a><br><br>";
			}
			else{
				$imprime = "";
			}
		}
		if($titulo == "Adicionar Administrador" || $titulo == "Adicionar Curso" || $titulo == "Gerenciar Administradores" || $titulo == "Gerenciar Cursos" || $titulo == "Alterar Senha"){
			$titulo_especial = true;
			if($curso == 1){
				$imprime = "&nbsp;&nbsp;<img src=\"../images/seta_preta.gif\">&nbsp;&nbsp;<a href=\"$link\" class=\"link_escuro\">$titulo</a><br><br>";
			}
			else{
				$imprime = "";
			}
		}
		
		if($titulo_especial != true){
			$imprime = "&nbsp;&nbsp;<img src=\"../images/seta_preta.gif\">&nbsp;&nbsp;<a href=\"$link\" class=\"link_escuro\">$titulo</a><br><br>";
		}
		
		$conteudo .= $imprime;
	}
	
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
		$template->setVariable("conteudo", $conteudo);
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