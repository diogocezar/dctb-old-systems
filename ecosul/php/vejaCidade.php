<?php
/* Identificador do tipo */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Voc� deve selecionar uma cidade para ver seus detalhes!');location.href='index.php'</script>";
}

/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Pikture.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'mostraCidade.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$sql = "SELECT nomeCidade, descricaoCidade, localizacaoCidade, acessoCidade, fotosCidade
        FROM {$tabela['cidades']}
		WHERE idCidade = $id";
		
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
}

$template->setCurrentBlock("blk_mostra_atividades");

	$dirFotos = $diretorio['cidades'];
	$fotosPP  = 50;
	$colunas  = 4;
	
	$pikture = new Pikture($dirFotos, FOTOSPP, COLUNAS);
	if($pikture->countPhotos($diretorio['cidades'].'/'.$dados['fotosCidade'])){
		$fotos   = $pikture->showPhotos($dados['fotosCidade'], 0, "n�o", "n�o", "n�o");
	}
	else{
		$fotos   = "Sem fotos";
	}
	
	$template->setVariable("fotos", $fotos);

	$template->setVariable("nome", $dados['nomeCidade']);
	$template->setVariable("descricao", $dados['descricaoCidade']);
	$template->setVariable("localizacao", $dados['localizacaoCidade']);
	$template->setVariable("acesso", $dados['acessoCidade']);
	
	/* Atividades */
	
	$sql = "SELECT a.nomeAtividade, a.idAtividades
        FROM {$tabela['cidades']} c, {$tabela['atividades']} a, {$tabela['atividadescidades']} ac
		WHERE c.idCidade = ac.idCidade AND
		a.idAtividades = ac.idAtividades AND		
		c.idCidade = $id";	
		
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$atividades .= "<img src=\"../images/setaLaranja.gif\" width=\"5\" height=\"5\"><a href =\"vejaAtividade.php?id={$dados['idAtividades']}\">{$dados['nomeAtividade']}</a><br>";
		}
	}
	
	$template->setVariable("listaAtividades", $atividades);
	
	/* Ecoturismos */
	
	$sql = "SELECT e.nomeEcoturismo, e.idEcoturismo
        FROM {$tabela['cidades']} c, {$tabela['ecoturismo']} e, {$tabela['cidadesecoturismo']} ce
		WHERE c.idCidade = ce.idCidade AND
		e.idEcoturismo = ce.idEcoturismo AND		
		c.idCidade = $id";	
		
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$ecoturismos .= "<img src=\"../images/setaVerde.gif\" width=\"5\" height=\"5\"><a href =\"vejaEcoturismo.php?id={$dados['idEcoturismo']}\">{$dados['nomeEcoturismo']}</a><br>";
		}
	}
	
	$template->setVariable("listaEcoturismo", $ecoturismos);


$template->parseCurrentBlock("blk_mostra_atividades");

$conteudo = $template->get();

include("includeInterna.php");
?>