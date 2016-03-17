<?php
include("start-brain.php");

/* ajax control */
include("ajax/manage-ajax.php");

/* session control */
include("session-control.php");

/* definitions to manage system */
$table  = $_GET['table'];
$fields = $_GET['fields'];
$hided  = $_GET['hided'];
$name   = $table;

if(empty($table) || empty($fields)){
	echo "<script language=javascript>alert('Deve-se selecionar a tabela e seus campos para acionar o gerenciamento.');location.href='index.php'</script>";
	exit();
}

$new_label_mapping = $label_mapping[$table];

/* template directory */
$templateHtmlDir = '../view/html';

/* template file */
$templateHtmlName = 'manage.html';

/* setting template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instantiating the class */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("html_block");

	/* java script */
	$template->setVariable("js_sajax",  sajax_show_javascript());
	$template->setVariable("js_table",  $table);
	$template->setVariable("js_fields", $fields);
	$template->setVariable("js_hided",  $hided);
	
	$template->setVariable("cmp_search", "Procurar: ");
	$template->setVariable("cmp_form_search", "typed");
	$template->setVariable("cmp_title_detail", "DETALHES DO REGISTRO:");
	
	if(eregi(",", $fields)){
		$fields      = explode(",", $fields);
		$fieldIndex  = $fields[0];
	}
	else{
		$fieldIndex  = $fields;
	}	
	$table = $table_mapping[$table];
	
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
				$fields_items_select = $new_label_mapping[strtolower($element['name'])];
				break;
			}
		}
		$i++;
	}
	
	if(count($fields) > 1){
		foreach($fields as $item){
			$new_fields_item[] = $fields_items[$item];
		}
	}
	
	if(is_array($new_fields_item)){
		$fields_items_select = implode(', ', $new_fields_item);
	}
		
	$template->setVariable("cmp_search_fields", $fields_items_select);
	
$template->parseCurrentBlock("html_block");

$content = $template->get();

switch($name){
	case "inscricao":
		$title = "Gerenciar Cadastro";	
	break;
	
	case "curso":
		$title = "Gerenciar Cursos";	
	break;
	
	case "adminitrador":
		$title = "Gerenciar Adminsitradores";	
	break;
}

/* incluindo conteudo na página interna */
include('inside-include.php');
?>