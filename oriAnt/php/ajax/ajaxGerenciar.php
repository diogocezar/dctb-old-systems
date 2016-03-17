<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais");
sajax_handle_client_request();

function registerDetais($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	
	$tabela   = $tabelaMap[$tabela];
	$campoPK  = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabela ";
	$sql .= " WHERE $campoPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarDetalhes.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$qtdCampos = count($camposMap[$tabela]);
			
			for($i=0; $i<$qtdCampos; $i++){
			
				$template->setCurrentBlock("bloco_detalhe");
					$template->setVariable("cmp_detalhe_item", strtoupper($aliasMap[$tabela][$i]).':');
					$template->setVariable("cmp_detalhe_valor", strtoupper($dados[$camposMap[$tabela][$i]]));
				$template->parseCurrentBlock("bloco_detalhe");
			
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegister($tabela, $key){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "DELETE FROM ";
	$sql .= $tabela;
	$sql .= " WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);	
}

function getFiltredRegisters($digitado, $tabela, $campos){

	global $controlador;
	global $tabelaMap;
	global $camposMap;
	
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela   = $tabelaMap[$tabela];
	$campo    = $camposMap[$tabela][$campoIndex];
	$campoPK  = $camposMap[$tabela][0];
	$limite   = 30;
	
	$sql  = "";
	$sql .= "SELECT $campoPK, $campo";
	$sql .= " FROM $tabela";
	
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE $campo LIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE $nomeCampo LIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo LIKE  '%$digitado%'";
				}
			}
		}
		$sql .= " ORDER BY $campoPK DESC";
	}
	else{
		$sql .= " ORDER BY $campoPK DESC";
	}
	
	//return rawurlencode($sql);
	
	$db = $controlador['database'];
	$resultado = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'gerenciarItens.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("bloco_item");
				
				$pk   = $dados[$campoPK];
				
				$item = "<span onmouseover=\"call_registerDetais('$pk')\" class=\"cursorLink\">{$dados[$campo]}</span>";
				
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\">Alterar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}
?>