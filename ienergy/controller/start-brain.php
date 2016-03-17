<?php
/**
* Cerebro do sistema
* System brain
* @package brain
*/
require_once("../core/brain/Brain.php");

$brain = new Brain();

/*
* Extraindo/Gerando informaчѕes dos arquivos XML
* Extracting/Generating informations from XML archives
*/ 

	/* Incluindo o neurєnio para scaneamento de XML */
	/* Including neuron to XML scanning */
	$brain->neuron("../core/neurons/xml-scanner/", "XMLScanner");
	
	/* Atribuindo para a variсvel global brain_controller a classe intanciada */
	/* Assigning to global variable brain_controller the class instantiated */
	$brain_controller = $brain->getFrameWork();
	
	/* Incluindo classe de gerenciamento de importaчуo de XML's */
	/* Including class to XML import management */
	include("xml-imports/XMLImports.php");
	
	/* Incluindo classe de geraчуo de classes */
	/* Including class to class genetarion */
	include("class-exports/ClassExports.php");
	
	/* Importando os erros */
	/* Importing errors */
	$error = array();
	$error = XMLImports::erro();
	
	/* Importando as configuraчѕes */
	/* Importing configurations */
	$conf = array();
	$conf = XMLImports::conf();
	
	/* Importando os neurєnios ativos no sistema */
	/* Importing activetd neurons in system */
	$actived_neuron = array();
	$actived_neuron = XMLImports::actived_neuron();
	
	/*
	* Importando os neurєnios
	* Importing neurons
	*/
	if(is_array($actived_neuron)){
		foreach($actived_neuron as $package => $status){
			if($status == "true"){
				$arrayNeurons = scandir("../core/neurons/$package/");
				/* Removendo elementos "." e ".." */
				/* Removing elements "." and ".." */
				unset($arrayNeurons[0]);
				unset($arrayNeurons[1]);
				foreach($arrayNeurons as $neuron){
					if(is_file("../core/neurons/$package/".$neuron)){
						$neuron = substr($neuron, 0, strlen($neuron)-4);					
						$brain->neuron("../core/neurons/$package/", ucfirst($neuron));
					}
				}
			}
		}
	}
	
	/* Importando lista de tabelas ativas no sistema */
	/* Importing list of tables enabled in system */
	$actived_tables = array();
	$actived_tables = XMLImports::actived_tables();
	
	
	/* Importando mapeamento das tabelas */
	/* Importing table mapping */
	$table_mapping = array();
	$table_mapping = XMLImports::table_mapping();
	
	/* Importando rѓtulos das tabelas */
	/* Importing table labels */
	$label_mapping = array();
	$label_mapping = XMLImports::label_mapping();
	
	/*
	* Importando as classes do sistema
	* Importing system classes
	*/
	if(is_array($actived_tables)){
		foreach($actived_tables as $class => $status){
			if($status == "true"){
				$className     = ClassExports::renameFile($class);
				$pathName      = "../model/system-class/";
				$classNamePath = $pathName.$className;
				if(is_file($classNamePath)){
					$className = substr($className, 0, strlen($className)-4);					
					$brain->neuron($pathName, $className);
				}
			}
		}
	}
	
	/* Sobrescrevendo para a variсvel global brain_controller a classe intanciada */
	/* Overwriting to global variable brain_controller the class instantiated */
	$brain_controller = $brain->getFrameWork();
?>