<?php
/** 
* SpeceBraid
*
* Esta classe gerencia as cookies do sistema.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package cookie
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
				$erroSession = new Errors($erro['COOKIE_NOT_ARRA']);
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
				$this->erro($erro['INDI_OR_VALUE_C']);
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
				$this->erro($erro['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = 0;
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}//deletaCookie
}//Cookie
?>