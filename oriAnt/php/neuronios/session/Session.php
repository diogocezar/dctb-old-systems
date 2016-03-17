<?php
/** 
* SpeceBraid
*
* Esta classe é responsavel por manipular as sessões da página.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package session
*/

class Session{

	/**
	* Construtor
	* __construct_Session()
	*/
	public function __construct_Session(){}


	/** 
	* Método que adiciona as sessions passadas em forma de array no parâmetro.
	* @access public 
	* @param Array $sessions
	* @return void
	*/
	function __go_Session($sessions){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(!empty($sessions)){
			if(is_array($sessions)){
				foreach($sessions as $indice => $valor){
					if(!empty($indice) && !empty($valor)){
						$this->salvaSession($indice, $valor);
					}
				}
			}
			else{
				$this->erro($erro['SESSION_NOT_ARR']);
			}
		}
	}//__go_Session
	
	/** 
	* Método que inicia as sessões.
	* @access public 
	* @return void
	*/	
	function startSession(){
		session_start();
	}//startSession

	/** 
	* Método que salva uma session a partir de seu índice e valor.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function salvaSession($indice, $valor){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
			$this->erro($erro['INDI_OR_VALUE_E']);
		}
		else{
			$_SESSION[$indice] = $valor;
		}
	}//salvaSession
	
	/** 
	* Método que remove uma session a partir de seu índice.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	function removeSession($indice){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice)){
			$this->erro($erro['INDI_OR_VALUE_E']);
		}
		else{
			unset($_SESSION[$indice]);
		}
	}//salvaSession	
	/** 
	* Método que retorna um valor a partir do índice passado como parâmetro.
	* @access public 
	* @param String $indice
	* @return String
	*/
	function retornaSession($indice){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(!empty($indice)){
			if(!empty($_SESSION[$indice])){
				return $_SESSION[$indice];
			}
			else{
				return NULL;
			}
		}
		else{
			$this->erro($erro['SE_INDICE_EMPTY']);
		}
	}//retornaSession
	
	/** 
	* Método que limpa todas as variáveis da sessão.
	* @access public 
	* @return void
	*/
	function limpaSessions(){
		session_unset();
	}//limpaSessions
}//Session
?>