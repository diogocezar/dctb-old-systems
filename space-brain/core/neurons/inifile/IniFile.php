<?php
/** 
* SpeceBrain
*
* Esse neurєnio щ responsavel por inserir e extrair variaveis de um arquivo ini
* This neuron is responsible to insert and extract variables from ini file
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright Љ 2007-2009
* @access public
* @package neuron
*/
	  
class IniFile{

	/** 
	* Atributo que irс armazenar a localizaчуo do arquivo.
	* @access private  
	* @name $urlIni
	* @var String
	*/
	private $urlIni;
	
	/**
	* Construtor
	* __construct_IniFile()
	*/
	public function __construct_IniFile(){}
	
	/** 
	* Mщtodo que seta a localizaчуo do arquivo ini.
	* @access public 
	* @param String $urlIni
	* @return void
	*/
	function __go_IniFile($urlIni){
		$this->urlIni = $urlIni;
	}//__go_IniFile
	
	  /** 
	  * Mщtodo que salva um arquivo ini.
	  * @access public 
	  * @param Array $assoc_array
	  * @return boolean
	  */ 
	function setIni($assoc_array){
		$content = '';
		$sections = '';
		$path = $this->urlIni;
				
		foreach ($assoc_array as $key => $item){
			if (is_array($item)){
				$sections .= "\n[{$key}]\n";
				foreach ($item as $key2 => $item2){
					if (is_numeric($item2) || is_bool($item2)){
						$sections .= "{$key2} = {$item2}\n";
					}
					else{
						$sections .= "{$key2} = \"{$item2}\"\n";
					}
				}      
			} 
			else{
				if(is_numeric($item) || is_bool($item)){
					$content .= "{$key} = {$item}\n";
				}
				else{
					$content .= "{$key} = \"{$item}\"\n";
				}
			}
		}
			  
		$content .= $sections;
		
		if(!$handle = fopen($path, 'w')){
			return false;
		}
		   
		if(!fwrite($handle, $content)){
			return false;
		}
		
		fclose($handle);
		return true;
	}//setIni
	
	/** 
	* Mщtodo que retorna um array a partir de um arquivo ini
	* @access public 
	* @return Array
	*/ 
	function getIni($comSessao = true){
		global $erro; // Reconhecendo variavel global para os erros.
		if($comSessao){
			$retorno = parse_ini_file($this->urlIni, true);
		}
		else{
			$retorno = parse_ini_file($this->urlIni, false);
		}
		if($retorno != false){
			return $retorno;
		}
		else{
			$this->erro($erro['INI_FILE_NOT_FI']);
		}		
	}//getIni
	
	/** 
	* GETS e SETS
	* Mщtodo __call que щ verificado a cada chamada de uma funчуo da classe, o seguinte mщtodo implementa automaticamente as funчѕes de GET e SET.
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