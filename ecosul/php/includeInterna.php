<?php
/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'interna.html';

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

/* Bloco Conteúdo */
$template->setCurrentBlock("blk_conteudo");
	$template->setVariable("conteudo", $conteudo);
$template->parseCurrentBlock("blk_conteudo");

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

$template->show();
?>