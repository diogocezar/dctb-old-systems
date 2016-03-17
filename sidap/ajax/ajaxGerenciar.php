<?php
/**
* Funções a serem executadas pelo ajax.
*/

/* Configurando o sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais");
sajax_handle_client_request();

/**
* G E R A L
*/

/* @@ DEBUG SERVER ONLINE @@ */
function uc_latin1_ajax($str){
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

/* @@ FUNÇÕES AUXILIARES PARA O AJAX @@ */
/*
* Função para converter data do formato do banco para o formato utilizado
* Converte de YYYY-MM-DD para DD/MM/YYYY
*/
function desconverteDataAjax($data){
	$exp = explode("-", $data);
	$ano = $exp[0];
	$mes = $exp[1];
	$dia = $exp[2];
	return $dia.'/'.$mes.'/'.$ano;	
}

function limitaStrAjax($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}
/* FIM */


/*
 * A J A X
 */
 
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
						$template->setVariable("cmp_detalhe_item", uc_latin1_ajax($aliasMap[$tabela][$i]).$arrayCheck[1].':');
						$campoAtual = $camposMap[$tabela][$i];
						switch($campoAtual){
							case 'datasolicitacao':
							case 'dataagenda':
							case 'datanascimento':
								$valor = uc_latin1_ajax(desconverteDataAjax($dados[$campoAtual]));
							break;
							
							case 'observacao':
							case 'descricao':
								$valor = uc_latin1_ajax(limitaStrAjax($dados[$campoAtual], 100));
							break;
							
							default:
								$valor = uc_latin1_ajax($dados[$campoAtual]);
							break;
						}
						$template->setVariable("cmp_detalhe_valor",$valor);
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
	$sql .= " SET situacao = '0', databaixa = now() WHERE ";
	$sql .= $campo;
	$sql .= " = ";
	$sql .= $key;
	
	$db = $controlador['database'];
	$db->query($sql);	
	
	return rawurlencode($key);
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
	$limite   = 20;
	
	$sql  = "";
	$sql .= "SELECT $campoPK, $campo";
	if($tabela == 'agenda'){
		$sql .= ", dataagenda, horaagenda";
	}
	$sql .= " FROM $tabela";
	
	$qtdDigitado = strlen($digitado);
	
	if(!empty($digitado) && $qtdDigitado > 2){
		if(!is_array($campos)){
			$sql .= " WHERE (sem_acentos($campo) iLIKE sem_acentos('%$digitado%')";
		}
		else{
			$i=0;
			foreach($campos as $campoAtual){
				$nomeCampo = $camposMap[$tabela][$campoAtual];
				if($i==0){
					$sql .= " WHERE (sem_acentos($nomeCampo) iLIKE sem_acentos('%$digitado%')";
					$i++;
				}
				else{
					$sql .= " OR sem_acentos($nomeCampo) iLIKE  sem_acentos('%$digitado%')";
				}
			}
		}
		$sql .= ") AND situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC";
	}
	else{
		$sql .= " WHERE situacao = 'TRUE'";
		$sql .= " ORDER BY $campoPK DESC LIMIT $limite";
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
				
				$item = "<span onmouseover=\"call_registerDetais('$pk')\" class=\"cursorLink\">".uc_latin1_ajax($dados[$campo])."</span>";
				
				if($tabela == 'agenda'){
					$item = "<span onmouseover=\"call_registerDetais('$pk')\" class=\"cursorLink\">".desconverteDataAjax($dados['dataagenda']). ' - '. $dados['horaagenda'].' - '.limitaStrAjax(uc_latin1_ajax($dados[$campo]),150)."</span>";
				}

				
				$template->setVariable("cmp_id", $pk);
				$template->setVariable("cmp_titulo_item", $item);
				$template->setVariable("cmp_excluir", "<a href=\"javascript:;\" onclick=\"call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_alterar", "<a href=\"frm".ucfirst($tabela).".php?acao=atualizar&id=$pk\" class=\"link_gen\">Atualizar</a>");
				
				$template->parseCurrentBlock("bloco_item");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}