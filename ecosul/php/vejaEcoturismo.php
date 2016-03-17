<?php
/* Identificador do tipo */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Você deve selecionar um ecoturismo para ver seus detalhes!');location.href='index.php'</script>";
}

/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Pikture.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'mostraEcoturismo.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$sql = "SELECT e.nomeEcoturismo, e.descricaoEcoturismo, e.localizacaoEcoturismo, e.acessoEcoturismo, e.fotosEcoturismo, t.nomeTipoEcoturismo, t.idTipoEcoturismo
        FROM {$tabela['tipoecoturismo']} t, {$tabela['ecoturismo']} e
		WHERE t.idTipoEcoturismo = e.idTipoEcoturismo AND
		e.idEcoturismo = $id";	
		
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
}

$template->setCurrentBlock("blk_mostra_ecoturismo");

	$dirFotos = $diretorio['ecoturismo'];
	$fotosPP  = 50;
	$colunas  = 4;
	
	$pikture = new Pikture($dirFotos, FOTOSPP, COLUNAS);
	if($pikture->countPhotos($diretorio['ecoturismo'].'/'.$dados['fotosEcoturismo'])){
		$fotos   = $pikture->showPhotos($dados['fotosEcoturismo'], 0, "não", "não", "não");
	}
	else{
		$fotos   = "Sem fotos";
	}
	
	$template->setVariable("fotos", $fotos);

	$template->setVariable("nome", $dados['nomeEcoturismo']);
	$template->setVariable("descricao", $dados['descricaoEcoturismo']);
	$template->setVariable("localizacao", $dados['localizacaoEcoturismo']);
	$template->setVariable("acesso", $dados['acessoEcoturismo']);
	$tipo = "<a href =\"ecoturismos.php?id={$dados['idTipoEcoturismo']}\">{$dados['nomeTipoEcoturismo']}</a>";
	$template->setVariable("tipoEcoturismo", $tipo);
	
	/* Cidade */
	
	$sql = "SELECT c.nomeCidade, c.idCidade 
			FROM {$tabela['cidades']} c, {$tabela['cidadesecoturismo']} ac, {$tabela['ecoturismo']} e
			WHERE c.idCidade = ac.idCidade AND
			ac.idEcoturismo = e.idEcoturismo AND
			e.idEcoturismo = $id
			LIMIT 1";
		
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		if(!empty($dados['nomeCidade'])){
		$cidade = "<img src=\"../images/setaLaranja.gif\" width=\"5\" height=\"5\" />&nbsp;<a href = \"vejaCidade.php?id={$dados['idCidade']}\">{$dados['nomeCidade']}</a>";
		}
	}

	if(!empty($cidade)){
		$template->setVariable("cidade", $cidade);
	}
	

$template->parseCurrentBlock("blk_mostra_ecoturismo");

$conteudo = $template->get();

include("includeInterna.php");
?>