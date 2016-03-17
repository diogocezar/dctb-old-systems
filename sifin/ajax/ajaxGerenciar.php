<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais", "getFiltredRegistersPessoa", "deleteRegisterPessoa", "registerDetaisPessoa");
sajax_handle_client_request();

/**
* G E R A L
*/

/* @@ DEBUG SERVER ONLINE @@ */
function uc_latin1($str){
	$str = rawurldecode($str);
	$str = str_replace('à', 'À', $str);
	$str = str_replace('á', 'Á', $str);
	$str = str_replace('â', 'Â', $str);
	$str = str_replace('ã', 'Ã', $str);
	$str = str_replace('ç', 'Ç', $str);
	$str = str_replace('è', 'È', $str);
	$str = str_replace('é', 'É', $str);
	$str = str_replace('ê', 'Ê', $str);
	$str = str_replace('ì', 'Ì', $str);
	$str = str_replace('í', 'Í', $str);
	$str = str_replace('ò', 'Ò', $str);
	$str = str_replace('ó', 'Ó', $str);
	$str = str_replace('ô', 'Ô', $str);
	$str = str_replace('ú', 'Ú', $str);
    return strtoupper($str);
}
/* FIM */

function registerDetais($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
	
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
				if(!in_array($i, $hideMap[$tabela], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
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
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap[$tabela];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now() WHERE ";
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
	global $aliasMap;
	global $hideMap;	
	
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
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= ") AND situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC";
	}
	
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
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

/**
* P E S S O A
*/

function registerDetaisPessoa($key, $tabela){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela       = $tabelaMap[$tabela];
	$tabelaPessoa = $tabelaMap['pessoa'];
	$campoPK      = $camposMap['pessoa'][0];
	$campoPKF     = $camposMap[$tabela][0];
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $tabelaPessoa p, $tabela po";
	$sql .= " WHERE p.$campoPKF = po.$campoPKF AND p.$campoPK = ";
	
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
				if(!in_array($i, $hideMap[$tabela], true)){			
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1($aliasMap[$tabela][$i]).':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1($dados[$camposMap[$tabela][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}			
			}
			
			$qtdCampos = count($camposMap['pessoa']);
			
			for($i=0; $i<$qtdCampos; $i++){
				if(!in_array($i, $hideMap['pessoa'], true)){
					$template->setCurrentBlock("bloco_detalhe");
						$template->setVariable("cmp_detalhe_item", uc_latin1($aliasMap['pessoa'][$i]).':');
						$template->setVariable("cmp_detalhe_valor", uc_latin1($dados[$camposMap['pessoa'][$i]]));
					$template->parseCurrentBlock("bloco_detalhe");
				}
			}
		}
	}
	$retorno = $template->get();
	return rawurlencode($retorno);
}

function deleteRegisterPessoa($key){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	$tabela = $tabelaMap['pessoa'];
	$campo  = $camposMap[$tabela][0]; // Primeiro campo sempre é PK !
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $tabela;
	$sql .= " SET situacao = 'FALSE', databaixa = now() WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);
}

function getFiltredRegistersPessoa($digitado, $tabela, $campos){
	global $controlador;
	global $tabelaMap;
	global $camposMap;
	global $aliasMap;
	global $hideMap;
		
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$digitado = rawurldecode($digitado);
	
	$tabela       = $tabelaMap[$tabela];
	$tabelaPessoa = $tabelaMap['pessoa'];
	$campo        = $camposMap[$tabela][$campoIndex];
	$campoPK      = $camposMap['pessoa'][0];
	$campoPKT     = $camposMap[$tabela][0];
	$limite       = 30;
	
	$sql  = "";
	$sql .= "SELECT $campoPK, $campo";
	$sql .= " FROM $tabelaPessoa p, $tabela po";
			
	if(!empty($digitado)){
		if(!is_array($campos)){
			$sql .= " WHERE ($campo iLIKE '%$digitado%'";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE ($nomeCampo iLIKE '%$digitado%'";
					$i++;
				}
				else{
					$sql .= " OR $nomeCampo iLIKE  '%$digitado%'";
				}
			}
		}
		$sql .= ") AND p.$campoPKT = po.$campoPKT AND situacao = 'TRUE'"; 
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
	}
	else{
		$sql .= " WHERE p.$campoPKT = po.$campoPKT AND situacao = 'TRUE'"; 
		$sql .= " ORDER BY $campoPK DESC";
	}
	
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
				
				$item = "<span onmouseover=\"call_registerDetaisPessoa('$pk')\" class=\"cursorLink\">{$dados[$campo]}</span>";
				
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegisterPessoa('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}

?>