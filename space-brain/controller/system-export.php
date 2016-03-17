<?php
/**
 * Cerebro do sistema
 * System brain
 * @package system-export
 */
require_once("../core/brain/Brain.php");

$brain = new Brain(); 

	/* Incluindo o neurєnio para scaneamento de XML */
	/* Including neuron to XML scanning */
	$brain->neuron("../core/neurons/xml-scanner/", "XMLScanner");
	
	/* Atribuindo para a variсvel global brain_controller a classe intanciada */
	/* Assigning to global variable brain_controller the class instantiated */
	$brain_controller = $brain->getFrameWork();
	
	/* Incluindo classe de gerenciamento de importaчуo de XML's */
	/* Including class to XML import management */
	include("xml-imports/XMLImports.php");

	/* Incluindo classe de gerenciamento de exportaчуo de XML's */
	/* Including class to XML export management */
	include("xml-exports/XMLExports.php");
	
	/* Incluindo classe de gerenciamento de exportaчуo de Classes do sistema */
	/* Including class to system class export management */
	include("class-exports/ClassExports.php");
	
	/* Exportando os erros */
	/* Exporting errors */
	XMLExports::erro();

	/* Importando os erros */
	/* Importing errors */
	$erro = array();
	$erro = XMLImports::erro();
	
	/* Exportando as configuraчѕes */
	/* Exporting configurations */
	XMLExports::conf();
	
	/* Importando as configuraчѕes */
	/* Importing configurations */
	$conf = array();
	$conf = XMLImports::conf();
	
	/* Exportanto os neurєnios ativos no sistema */
	/* Exporting activetd neurons in system */
	XMLExports::actived_neuron();
	
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
	
	/* Exportando lista de tabelas ativas no sistema */
	/* Exporting list of tables enabled in system */
	XMLExports::actived_tables();
	
	/* Importando lista de tabelas ativas no sistema */
	/* Importing list of tables enabled in system */
	$actived_tables = array();
	$actived_tables = XMLImports::actived_tables();
	
	/* Exportando mapeamento das tabelas */
	/* Exporting table mapping */
	XMLExports::table_mapping();
	
	/* Importando mapeamento das tabelas */
	/* Importing table mapping */
	$table_mapping = array();
	$table_mapping = XMLImports::table_mapping();
	
	/* Criando as classes do sistema */
	/* Creating system classes */
	ClassExports::doExport();
?>