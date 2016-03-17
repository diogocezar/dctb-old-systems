<?php
/**
* this file write ajax functions used on manager system.
*/

/* configuring sAjax */
sajax_init();
$sajax_debug_mode = 0;
sajax_export("getFiltredRegisters", "deleteRegister", "registerDetais", "desactiveRegister", "activeRegister");
sajax_handle_client_request();

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
function desconverteDataAjax($data, $dataSimples = false){
	if(!$dataSimples){
		$dataSub = substr($data, 0, 10);
		$horaSub = substr($data, 10, strlen($data));
		$exp = explode("-", $dataSub);
		$ano = $exp[0];
		$mes = $exp[1];
		$dia = $exp[2];
		$exp = explode(":", $horaSub);
		$hor = $exp[0];
		$min = $exp[1];
		$seg = substr($exp[2], 0, 2);
		return $dia.'/'.$mes.'/'.$ano.' -'.$hor.':'.$min.':'.$seg;
	}
	else{
		$exp = explode("-", $data);
		$ano = $exp[0];
		$mes = $exp[1];
		$dia = $exp[2];
		return $dia.'/'.$mes.'/'.$ano;	
	}
}

function limitaStrAjax($str, $qtd){
	if(strlen($str) > $qtd){
		$str  = substr($str, 0, $qtd);
		$str .= "...";
	}
	return $str;
}

function converteDataAjax($data){
	if(eregi('/',$data)){
		$exp = explode("/", $data);
		$ano = $exp[2];
		$mes = $exp[1];
		$dia = $exp[0];
		return $ano.'-'.$mes.'-'.$dia;
	}
	else{
		return $data;
	}
}
/* FIM */


/*
 * A J A X
 */
function registerDetais($key, $table){
	global $brain_controller;
	global $table_mapping;
	global $label_mapping;
	
	$table_name = $table;
	$label      = $label_mapping[$table];
	$table      = $table_mapping[$table];
						 
	$i = 0;
	
	foreach($table as $element){
		if($i == 0){
			$fieldPK = $element['name'];
			break;
		}
	}
	
	$sql .= "";
	$sql .= "SELECT * ";
	$sql .= " FROM $table_name ";
	$sql .= " WHERE $fieldPK = ";
	
	if(is_numeric($key)){
		$sql .= $key;
	}
	else{
		$sql .= "'".$key."'";
	}
	
	$db = $brain_controller['database'];
	$result = $db->query($sql);
	
	if(!DB::isError($result)){
	
		/* Diretório dos Templates */
		$templateHtmlDir = '../view/html';
		
		/* Capturando Pedido */
		$templateHtmlName = 'manage-detail.html';
		
		/* Setando template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* Instanciando a classe */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
		while($data = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			
			$qtdCampos = count($table);
			
			$i = 0;
			foreach($table as $item){
				$array_field[$i++] = $item;	
			}
			
			for($i=0; $i<$qtdCampos; $i++){
					$label_mapping_item = strtolower($array_field[$i]['name']);
					if(!empty($label[$label_mapping_item])){
						$template->setCurrentBlock("detail_block");
							$template->setVariable("cmp_detail_item", uc_latin1_ajax($label[$label_mapping_item].":"));
							$value = $data[$array_field[$i]['name']];
							if($label[$label_mapping_item] == "data de nascimento"){
								$value = desconverteDataAjax($value, true);
							}
							if($label[$label_mapping_item] == "data de cadastro"){
								$value = desconverteDataAjax($value, false);
							}
							$template->setVariable("cmp_detail_value", uc_latin1_ajax($value));
						$template->parseCurrentBlock("detail_block");
					}
			}
		}
	}
	$return = $template->get();
	return rawurlencode($return);
}

function deleteRegister($table, $key){
	global $brain_controller;
	global $table_mapping;
	global $label_mapping;
	
	if($table == 'curso' && $key == 1){
		// impede de deletar o curso default
		return;	
	}
		
	$table_array  = $table_mapping[$table];
	foreach($table_array as $valor){
		$field = $valor;
		break;
	}
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $table;
	$sql .= " SET situacao = 'FALSE', data_baixa = now() WHERE ";
	$sql .= $field['name'];
	$sql .= " = ";
	$sql .= $key;
	
	$db = $brain_controller['database'];
	$db->query($sql);	
}

function desactiveRegister($key){
	global $brain_controller;
	global $table_mapping;
	global $label_mapping;
	$table = "curso";
	
	if($key == 1){
		// impede de deletar o curso default
		return;	
	}
		
	$table_array  = $table_mapping[$table];
	foreach($table_array as $valor){
		$field = $valor;
		break;
	}
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $table;
	$sql .= " SET ativo = 0 WHERE ";
	$sql .= $field['name'];
	$sql .= " = ";
	$sql .= $key;
	
	$db = $brain_controller['database'];
	$db->query($sql);	
}

function activeRegister($key){
	global $brain_controller;
	global $table_mapping;
	global $label_mapping;
	$table = "curso";
	
	if($key == 1){
		// impede de deletar o curso default
		return;	
	}
		
	$table_array  = $table_mapping[$table];
	foreach($table_array as $valor){
		$field = $valor;
		break;
	}
	
	$sql  = "";
	$sql .= "UPDATE ";
	$sql .= $table;
	$sql .= " SET ativo = 1 WHERE ";
	$sql .= $field['name'];
	$sql .= " = ";
	$sql .= $key;
	
	$db = $brain_controller['database'];
	$db->query($sql);	
}

function getFiltredRegisters($typed, $table, $fields, $hided){
	global $brain_controller;
	global $table_mapping;
	global $label_mapping;
	
	/* secure verifications */
	
	if(empty($table) || empty($fields) || empty($table_mapping[$table]) || !is_array($table_mapping[$table])){
		return;	
	}	
	
	if(eregi(",", $fields)){
		$fields      = explode(",", $fields);
		$fieldIndex  = $fields[0];
	}
	else{
		$fieldIndex  = $fields;
	}
	
	$typed = rawurldecode($typed);
	
	$table_name = $table;
	$table      = $table_mapping[$table];
	$limit      = 10;
	
	$i = 0;
	foreach($table as $element){
		if($i == 0){
			$fieldPK = $element['name'];
			$i++;
			continue;
		}
		if(is_array($fields)){
			if(in_array($i, $fields)){
				$fields_items[$i] = $element['name'];
			}
		}
		else{
			if($i == $fieldIndex){
				$fields_items_select = $element['name'];
				break;
			}
		}
		$i++;
	}
	
	if(count($fields) > 1){
		foreach($fields as $item){
			$new_fields_item[] = $fields_items[$item];
		}
		$fields_items_select = implode(', ', $new_fields_item);
	}
	
	$sql  = "";
	$sql .= "SELECT $fieldPK, $fields_items_select";
	$sql .= " FROM $table_name";
	
	$countTyped = strlen($typed);
	
	if(!empty($typed) && $countTyped > 1){
		if(!is_array($fields_items)){
			$sql .= " WHERE ($fields_items LIKE '%$typed%'";
		}
		else{
			$i=0;
			foreach($fields_items as $used_field){
				if($i==0){
					$sql .= " WHERE ($used_field LIKE '%$typed%'";
					$i++;
				}
				else{
					$sql .= " OR $used_field LIKE '%$typed%'";
				}
			}
		}
		$sql .= " AND situacao = TRUE ";
		if($table_name == "inscricao"  && $_SESSION['sessCurCod'] != 1){
			$sql .= " AND idcurso = ".$_SESSION['sessCurCod'];
		}
		$sql .= ") ORDER BY $fieldPK DESC LIMIT $limit";
	}
	else{
		$sql .= " WHERE situacao = TRUE ";
		if($table_name == "inscricao" && $_SESSION['sessCurCod'] != 1){
			$sql .= " AND idcurso = ".$_SESSION['sessCurCod'];
		}
		$sql .= " ORDER BY $fieldPK DESC";
	}
	
	$db = $brain_controller['database'];
	$result = $db->query($sql);
	
	if(!DB::isError($resultado)){
	
		/* template directory */
		$templateHtmlDir = '../view/html';
		
		/* template file */
		$templateHtmlName = 'manage-items.html';
		
		/* setting template */
		$template = new HTML_Template_IT($templateHtmlDir);
		
		/* instantiating the class */
		$template->loadTemplatefile($templateHtmlName, true, true);
		
			while($data = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$template->setCurrentBlock("item_block");
				
				$pk = $data[$fieldPK];
				
				if(eregi(',',$fields_items_select)){
					$field = explode(', ',$fields_items_select);
					$field = $field[0];
				}
				else{
					$field = $fields_items_select;	
				}
				
				$item = "<span onclick=\"Manage.call_registerDetais('$pk')\" class=\"cursorLink\">{$data[$field]}</span>";
				
				$template->setVariable("cmp_item_title", $item);
				$template->setVariable("cmp_delete", "<a href=\"javascript:;\" onclick=\"Manage.call_deleteRegister('$pk');\" class=\"link_gen\">Excluir</a>");
				$template->setVariable("cmp_change", "<a href=\"frm-".$table_name.".php?action=update&id=$pk\" class=\"link_gen\">Atualizar</a>");
				if($_GET['table'] == 'curso'){
					$curso = $brain_controller['curso'];
					$curso->__toFillGeneric();
					$curso->__get_db($pk);
					if($curso->activatedCourse() == 1){
						$template->setVariable("cmp_inativate", "<a href=\"javascript:;\" onclick=\"Manage.call_desactiveRegister('$pk');\" class=\"link_gen\">Desativar</a>");
					}
					else{
						$template->setVariable("cmp_inativate", "<a href=\"javascript:;\" onclick=\"Manage.call_activeRegister('$pk');\" class=\"link_gen\">Ativar</a>");
					}
				}
				
				$template->parseCurrentBlock("item_block");
			}
		
		$retorno = $template->get();
	}
	return rawurlencode($retorno);
}