<?php
/** 
* SpeceBrain
*
* Esse neurфnio й responsavel gerenciar os cookies do sistema
* This neuron is responsible to manage the system cookies
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class Cookie{
	/**
	* Construtor
	* __construct_Cookie()
	*/
	public function __construct_Cookie(){}
	
	/** 
	* Mйtodo que adiciona as cookies passadas em forma de array no parвmetro.
	* @access public 
	* @param Array $cookies
	* @return void
	*/
	function __go_Cookie($cookies){
		global $erro; // Reconhecendo variavel global para os erros.
		if(!empty($cookies)){
			if(is_array($cookies)){
				foreach($cookies as $indice => $valor){
					if(!empty($indice) && !empty($valor)){
						$this->salvaCookie($indice, $valor);
					}
				}
			}
			else{
				$this->error($error['COOKIE_NOT_ARRA']);
			}
		}
	}//__go_Cookie

	/** 
	* Mйtodo que salva uma cookie a partir de seu нndice, valor e as constantes definidas no arquivo de configuraзгo.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function salvaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$this->error($error['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = EXPIRE + time();
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}//salvaCookie
	
	/** 
	* Mйtodo deleta uma cookie a partir de seu нndice.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function deletaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$this->error($error['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = 0;
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}//deletaCookie
}//Cookie
?>