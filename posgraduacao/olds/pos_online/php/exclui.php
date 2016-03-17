<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$op = $_GET['tipo'];

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
	$id = $_GET['id'];
	
	switch($op){
		case 'curso' :
			$prefix = "O";
			$titulo = "Curso";
			$volta  = "administrar.php";

			$existeInscricao     = $dataBase->getOne("SELECT count(*) FROM {$tabela['inscricoes']} WHERE cur_cod = $id");
			$existeContato       = $dataBase->getOne("SELECT count(*) FROM {$tabela['contato']} WHERE cur_cod = $id");
			$existeNoticia       = $dataBase->getOne("SELECT count(*) FROM {$tabela['noticias']} WHERE cur_cod = $id");
			$existeDisciplina    = $dataBase->getOne("SELECT count(*) FROM {$tabela['disciplinas']} WHERE cur_cod = $id");
			$existeAdministrador = $dataBase->getOne("SELECT count(*) FROM {$tabela['administradores']} WHERE cur_cod = $id");
			
			if(empty($existeInscricao) && empty($existeContato) && empty($existeNoticia) && empty($existeDisciplina) && empty($existeAdministrador)){
						
				$excluir = new DataBase();
				
				$excluir->Delete($tabela['cursos'], "cur_cod = $id");
			
			}
			else{
				$trava_exclusao = true;
			}
	
			break;
		
		case 'administrador' :
			$prefix = "O";
			$titulo = "Administrador";
			$volta = "administrar.php";
			
			$existeNoticia = $dataBase->getOne("SELECT count(*) FROM {$tabela['noticias']} WHERE adm_cod = $id");
			
			if(empty($existeNoticia)){
				
				$excluir = new DataBase();
				
				$excluir->Delete($tabela['administradores'], "adm_cod = $id");
				
			}
			else{
				$trava_exclusao = true;
			}
			
			break;
		
		case 'noticia' :
			$prefix = "A";
			$titulo = "Notcícia";
			$volta = "administrar.php";
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['noticias'], "not_cod = $id");
			
			break;
		
		case 'inscricao' :
			$prefix = "A";
			$titulo = "Inscrição";
			$volta = "administrar.php";
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['inscricoes'], "ins_cod = $id");
			
			break;
		
		case 'professor' :
			$prefix = "O";
			$titulo = "Professor";
			$volta = "administrar.php";
			
			$existeDisciplina = $dataBase->getOne("SELECT count(*) FROM {$tabela['disciplinas']} WHERE pro_cod = $id");
			
			if(empty($existeDisciplina)){
				
				$excluir = new DataBase();
				
				$excluir->Delete($tabela['professores'], "pro_cod = $id");
				
			}
			else{
				$trava_exclusao = true;
			}
	
			break;
		
		case 'disciplina' :
			$prefix = "A";
			$titulo = "Disciplina";
			$volta = "administrar.php";
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['disciplinas'], "dic_cod = $id");
			
			break;
		
		case 'contato' :
			$prefix = "O";
			$titulo = "Contato";
			$volta = "index.php";
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['contato'], "con_cod = $id");
			
			break;	
	}
	
	if($trava_exclusao != true){
	
		$msg = "<div align=\"center\">";
		$msg .= "<br><br>";
		$msg .= "<img src=\"../icones/button_cancel.jpg\"><br><br>";
		$titulo = strtolower($titulo);
		$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."<b> com sucesso.<br><br>";
		$msg .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:location.href='$volta'\">";
		$msg .= "</div>";
		
	}
	else{
	
		$msg = "<div align=\"center\">";
		$msg .= "<br><br>";
		$msg .= "<img src=\"../icones/button_cancel.jpg\"><br><br>";
		$titulo = strtolower($titulo);
		$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
		$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
		$msg .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:location.href='$volta'\">";
		$msg .= "</div>";
		
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
		$template->setVariable("titulo", "Atualizando $titulo");
	$template->parseCurrentBlock("bloco_titulo");
	
	/* Bloco do conteúdo da página interna */
	$template->setCurrentBlock("bloco_conteudo");
		$template->setVariable("conteudo", $msg);
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