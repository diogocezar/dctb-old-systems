<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por gerenciar a manipulação de arquivos XML no sistema
* This neuron is responsible to manage the XML archives manipulation of system
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class XMLScanner{
	
	/** 
	* Atributo que armazena um nome para o arquivos XML manipulado
	* @access private
	*/
	private $file_name;
	
	/** 
	* Atributo que armazena as opções para salvar XML
	* @access private
	*/
	private $options_in;
	
	/** 
	* Atributo que armazena as opções para abrir XML
	* @access private
	*/
	private $options_out;
	
	/** 
	* Atributo que armazena o retorno do XML extraído
	* @access private
	*/
	private $array;
	
	/** 
	* Atributo que armazena uma variável booleana para imprimir ou não os debugs
	* @access private
	*/
	private $print_result;
	
	/**
	* Construtor
	* Constructor
	* __construct_Connection()
	*/	  
	public function __construct_XMLScanner(){
		$this->setPrintResult(false);
	}
	
	/** 
	* Método que salva um array como um arquivo XML
	* @access public
	* @return void
	*/
	public function saveArray(){
		if(!empty($this->options_in) && !empty($this->array)){
			$this->utf8_array_encode($this->array);
			$print_result = $this->getPrintResult();
			$serializer   = new XML_Serializer($this->options_in);
			$result       = $serializer->serialize($this->array);
			if(PEAR::isError($status)){
				$this->erro($status->getMessage());
			}
			else{
				$xml = $serializer->getSerializedData();
				if($print_result){
					echo '<pre>';
						echo htmlentities($xml);
					echo '</pre>';
				}
				$this->saveXMLInFile($serializer->getSerializedData($xml));
			}
		}
	}
	
	/** 
	* Método que extrai de um arquivos XML e atribui para um array
	* @access public
	* @return Array
	*/
	public function extractArray(){
		if(!empty($this->options_out) && !empty($this->file_name) && is_file($this->file_name)){
			$file_name = $this->getFileName();
			$print_result = $this->getPrintResult();
			$unserializer = new XML_Unserializer($this->options_out);
			$status = $unserializer->unserialize($file_name, true);
			if (PEAR::isError($status)){
				$this->erro($status->getMessage());
			}
			else{
				$data = $unserializer->getUnserializedData();
				$data = $this->utf8_array_decode($data);
				if($print_result){
					echo '<pre>';
						print_r($data);
					echo '</pre>';
				}
				return $data;
			}
		}
	}
	
	/** 
	* Método que salva um arquivos XML no file_name setado
	* @access private
	* @return void
	*/
	private function saveXMLInFile($xml){
		$file_name = $this->getFileName();
		file_put_contents($file_name, $xml);
	}
	
	/** 
	* Método que decodifica um array para utf8
	* @access private
	* @return Array
	*/
	private function utf8_array_decode($input)
	{
    	$return = array();
		foreach ($input as $key => $val)
		{
			if(is_array($val))
			{
				$return[$key] = $this->utf8_array_decode($val);
			}
			else
			{
				$return[$key] = utf8_decode($val);
			}
		}
    	return $return;          
	}
	
	/** 
	* Método que codifica um array para utf8
	* @access private
	* @return Array
	*/
	private function utf8_array_encode($input)
	{
    	$return = array();
		foreach ($input as $key => $val)
		{
			if(is_array($val))
			{
				$return[$key] = $this->utf8_array_encode($val);
			}
			else
			{
				$return[$key] = utf8_encode($val);
			}
		}
    	return $return;          
	} 

	
	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call ($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}
?>