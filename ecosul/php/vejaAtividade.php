<?php
/* Identificador do tipo */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Você deve selecionar uma atividade para ver seus detalhes!');location.href='index.php'</script>";
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
	
$templateHtmlName = 'mostraAtividade.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$sql = "SELECT a.nomeAtividade, a.descricaoAtividade, a.localizacaoAtividade, a.acessoAtividade, a.fotosAtividade, t.idTipoAtividade, t.nomeTipoAtividade 
        FROM {$tabela['tipoatividade']} t, {$tabela['atividades']} a
		WHERE t.idTipoAtividade = a.idTipoAtividade AND
		a.idAtividades = $id";	
		
$resultado = $dataBase->query($sql);
if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
}

$template->setCurrentBlock("blk_mostra_atividades");

	$dirFotos = $diretorio['atividades'];
	$fotosPP  = 50;
	$colunas  = 4;
	
	$pikture = new Pikture($dirFotos, FOTOSPP, COLUNAS);
	if($pikture->countPhotos($diretorio['atividades'].'/'.$dados['fotosAtividade'])){
		$fotos   = $pikture->showPhotos($dados['fotosAtividade'], 0, "não", "não", "não");
	}
	else{
		$fotos   = "Sem fotos";
	}
	
	$template->setVariable("fotos", $fotos);

	$template->setVariable("nome", $dados['nomeAtividade']);
	$template->setVariable("descricao", $dados['descricaoAtividade']);
	$template->setVariable("localizacao", $dados['localizacaoAtividade']);
	$template->setVariable("acesso", $dados['acessoAtividade']);
	$tipo = "<img src=\"../images/setaLaranja.gif\" width=\"5\" height=\"5\" />&nbsp;<a href =\"atividades.php?id={$dados['idTipoAtividade']}\">{$dados['nomeTipoAtividade']}</a>";
	$template->setVariable("tipoAtividade", $tipo);
	
	/* Cidade */
	
	$sql = "SELECT c.nomeCidade, c.idCidade 
			FROM {$tabela['cidades']} c, {$tabela['atividadescidades']} ac, {$tabela['atividades']} a
			WHERE c.idCidade = ac.idCidade AND
			ac.idAtividades = a.idAtividades AND
			a.idAtividades = $id
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

$template->parseCurrentBlock("blk_mostra_atividades");

$conteudo = $template->get();

include("includeInterna.php");
?>