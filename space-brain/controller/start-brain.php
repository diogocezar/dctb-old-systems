<?php
session_start ##@ iniciando sess�o / starting session
/**
* Cerebro do sistema
* System brain
* @package brain
*/
require_once("../core/brain/Brain.php");

$brain = new Brain();

/*
* Extraindo/Gerando informa��es dos arquivos XML
* Extracting/Generating informations from XML archives
*/ 

	/* Incluindo o neur�nio para scaneamento de XML */
	/* Including neuron to XML scanning */
	$brain->neuron("../core/neurons/xml-scanner/", "XMLScanner");
	
	/* Atribuindo para a vari�vel global brain_controller a classe intanciada */
	/* Assigning to global variable brain_controller the class instantiated */
	$brain_controller = $brain->getFrameWork();
	
	/* Incluindo classe de gerenciamento de importa��o de XML's */
	/* Including class to XML import management */
	include("xml-imports/XMLImports.php");
	
	/* Incluindo classe de gera��o de classes */
	/* Including class to class genetarion */
	include("class-exports/ClassExports.php");
	
	/* Importando os erros */
	/* Importing errors */
	$erro = array();
	$erro = XMLImports::erro();
	
	/* Importando as configura��es */
	/* Importing configurations */
	$conf = array();
	$conf = XMLImports::conf();
	
	/* Importando os neur�nios ativos no sistema */
	/* Importing activetd neurons in system */
	$actived_neuron = array();
	$actived_neuron = XMLImports::actived_neuron();
	
	/*
	* Importando os neur�nios
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
	
	/* Sobrescrevendo para a vari�vel global brain_controller a classe intanciada */
	/* Overwriting to global variable brain_controller the class instantiated */
	$brain_controller = $brain->getFrameWork();
?>