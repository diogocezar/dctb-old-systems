<?php
/** 
 * SpeceBraid
 *
 * Esta classe � responsavel por instanciar e controlar todos neur�nios
 * This class is responsible to instantiate and control all neurons
 *
 * @author xg0rd0 <xgordo@gmail.com> 
 * @version 2.0.1
 * @copyright Copyright � 2007-2009
 * @package brain
 */

/**
 * Framework PEAR
 */
require_once("../core/components/Pear/PEAR.php");

/**
 * Framework PEAR::DB
 */
require_once("../core/components/DB/DB.php");

/**
 * Framework PEAR::HTML_Template_IT
 */
require_once("../core/components/HTML_Template_IT/IT.php");

/**
 * Framework XML Util
 */
require_once("../core/components/XML_Util/Util.php");

/**
 * Framework XML Parser
 */
require_once("../core/components/XML_Parser/Parser.php");

/**
 * Framework XML Serializer
 */
require_once("../core/components/XML_Serializer/Serializer.php");

/**
 * Framework XML Unserializer
 */
require_once("../core/components/XML_Serializer/Unserializer.php");

/**
 * Framework sAjax
 */
require_once("../core/components/sAjax/Sajax.php");

/**
 * Classe gen�rica DAO dos objetos
 * Generic DAO objects class
 */
require_once("../model/dao-generic/DAOGeneric.php");

/**
 * Classe corpo dos objetos
 * Class body of objects
 */
require_once("../model/dao-generic/Body.php");


class Brain{
	
	/** 
	 * Atributo que ir� armazenar o objeto de manipula��o do banco de dados
	 * @name $data_base
	 * @var Object
	 */
	public static $data_base;

	/** 
	 * Atributo que ir� armazenar o ultimo objeto criado, que extende todos os anteriores.
	 * @name $objeto
	 * @var Object
	 */		
	public $objectArray;
	
	/**
	 * Construtor
	 * ___construct()
	 */
	public function __construct(){
		flush();
	}//__construct
	
	/** 
	 * M�todo que retorna o objeto com todas as classes extendidas.
	 * @access public 
	 * @return void
	 */  
	public function getFrameWork(){
		if(empty($this->objectArray)){
			return;
		}
		else{
			return $this->objectArray;
		}
	}//getFrameWork
	
	/** 
	 * M�todo que extrai a classe a ser extendida do documento php.
	 * @access public
	 * @param String[] $linhas
	 * @return String[]
	 */  
	private function clearClass($lines){
		$countLines = count($lines);
		for($i=0; $i<$countLines; $i++){
			if($i == 0 || $i == ($countLines-1) || $i == ($countLines-2)){
				unset($lines[$i]);
			}
		}
		return $lines;
	}//clearClass
	
	/** 
	 * M�todo adiciona uma nova classe ao objeto $objeto do c�rebro.
	 * @access public
	 * @param String $directory
	 * @param String $class
	 * @return void
	 */
	public function neuron($directory, $class){
		$content       = file($directory.$class.".php");
		$content       = $this->clearClass($content);
		$content       = implode("",$content);
		$errorFunction = $this->errorFunction($class);
		$content      .= $errorFunction;

		eval($content);
		
		$this->objectArray[strtolower($class)] = new $class();
		$construct = "__construct_".$class;
		$newObject = $this->objectArray[strtolower($class)];
		$newObject->$construct();
	}//neuron
	
	/** 
	 * M�todo que retorna a fun��o de erro que dever� ser agregada por todas as classes do sistema.
	 * @access public
	 * @return String
	 */	
	function errorFunction($className){
		$function .= 'private function erro($mensagem){';
			$function .= 'echo "<script language = javascript>';
			$function .= 'alert(\'".$mensagem."\');';
			$function .= 'history.go(-1);';
			$function .= '</script>";';
		$function .= '}';
		$function .= '}//'.$className;
		
		return $function;
	}//errorFunction
}//Cerebro
?>