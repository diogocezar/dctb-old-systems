<?php
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

$templateHtmlName = 'index.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Menu */
foreach($menu['links'] as $menu => $link){
		$template->setVariable($menu, $link);
}

/* Bloco Título */
$template->setCurrentBlock("blk_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("blk_titulo");

/* Bloco Ecoturismo */
$template->setCurrentBlock("blk_ecoturismo");
	$opcoesEcoturismo .= "<option value=\"#\">Selecione...</option>";
	$opcoesEcoturismo .= "<option value=\"#\"></option>";
	$sql = "SELECT 	idTipoEcoturismo, nomeTipoEcoturismo FROM {$tabela['tipoecoturismo']} ORDER BY nomeTipoEcoturismo ASC";	
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$opcoesEcoturismo .= "<option value=\"{$dados['idTipoEcoturismo']}\">{$dados['nomeTipoEcoturismo']}</option>";
		}
	}
	$template->setVariable("comboEcoturismo", "combo_ecoturismo");
	$template->setVariable("comboOpcoesEcoturismo", $opcoesEcoturismo);
	$template->setVariable("onChanceEcoturismo", "goCombo('combo_ecoturismo', 'ecoturismos.php')");
$template->parseCurrentBlock("blk_ecoturismo");

/* Bloco Aventura */
$template->setCurrentBlock("blk_aventura");
	$opcoesAventura .= "<option value=\"#\">Selecione...</option>";
	$opcoesAventura .= "<option value=\"#\"></option>";
	$sql = "SELECT 	idTipoAtividade, nomeTipoAtividade FROM {$tabela['tipoatividade']} ORDER BY nomeTipoAtividade ASC";	
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$opcoesAventura .= "<option value=\"{$dados['idTipoAtividade']}\">{$dados['nomeTipoAtividade']}</option>";
		}
	}

	$template->setVariable("comboAventura", "combo_aventura");
	$template->setVariable("comboOpcoesAventura", $opcoesAventura);
	$template->setVariable("onChanceAventura", "goCombo('combo_aventura', 'atividades.php')");
$template->parseCurrentBlock("blk_aventura");

/* Bloco Cidades */
$template->setCurrentBlock("blk_cidades");
	$opcoesCidades .= "<option value=\"#\">Selecione...</option>";
	$opcoesCidades .= "<option value=\"#\"></option>";
	$sql = "SELECT 	idCidade, nomeCidade FROM {$tabela['cidades']} ORDER BY nomeCidade ASC";	
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$opcoesCidades .= "<option value=\"{$dados['idCidade']}\">{$dados['nomeCidade']}</option>";
		}
	}
	$template->setVariable("comboCidades", "combo_cidades");
	$template->setVariable("comboOpcoesCidades", $opcoesCidades);
	$template->setVariable("onChanceCidades", "goCombo('combo_cidades', 'vejaCidade.php')");
$template->parseCurrentBlock("blk_cidades");

/* Bloco Dicas */
$template->setCurrentBlock("blk_dicas");
	$sql = "SELECT 	idEcoturismo, nomeEcoturismo, fotosEcoturismo FROM {$tabela['ecoturismo']} ORDER BY idEcoturismo DESC LIMIT 3";	
	$resultado = $dataBase->query($sql);
	$i = 1;
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$dir = $diretorio['ecoturismo'].'/'.$dados['fotosEcoturismo'];
			@$pik = new Pikture($dir, 0, 0);
			$dirpik = $pik->firstPicture($dir);
			$alt = 77;
			$lar = 103;
			$sca = 'não';
			$fotos[$i] = "<a href=\"vejaEcoturismo.php?id={$dados['idEcoturismo']}\"><img src=\"img.php?loc=$dirpik&a=$alt&l=$lar&s=$sca\" border=\"0\"></a>";
			$ecoturismo[$i] = $dados['nomeEcoturismo'];
			$i++;
		}
	}
	$template->setVariable("foto1", $fotos[1]);
	$template->setVariable("foto2", $fotos[2]);
	$template->setVariable("foto3", $fotos[3]);
	$template->setVariable("ecoturismo1", $ecoturismo[1]);
	$template->setVariable("ecoturismo2", $ecoturismo[2]);
	$template->setVariable("ecoturismo3", $ecoturismo[3]);	
$template->parseCurrentBlock("blk_dicas");


/* Bloco Texto */
$template->setCurrentBlock("blk_texto");
	$template->setVariable("textoSobreEcoturismo", TEXTO_INICIAL);
$template->parseCurrentBlock("blk_texto");

$template->show();
?>