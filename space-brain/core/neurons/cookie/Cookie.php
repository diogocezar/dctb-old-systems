<?php
/** 
* SpeceBrain
*
* Esse neur�nio � responsavel gerenciar os cookies do sistema
* This neuron is responsible to manage the system cookies
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright � 2007-2009
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
	* M�todo que adiciona as cookies passadas em forma de array no par�metro.
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
				$erroSession = new Errors($erro['COOKIE_NOT_ARRA']);
			}
		}
	}//__go_Cookie

	/** 
	* M�todo que salva uma cookie a partir de seu �ndice, valor e as constantes definidas no arquivo de configura��o.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function salvaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$this->erro($erro['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = EXPIRE + time();
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}//salvaCookie
	
	/** 
	* M�todo deleta uma cookie a partir de seu �ndice.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function deletaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$this->erro($erro['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = 0;
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}//deletaCookie
}//Cookie
?>