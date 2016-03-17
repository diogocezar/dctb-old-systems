<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por manipular as sessões do sistema
* This neuron is responsible to manipulate system sessions
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
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
				foreach($sessions as $index => $value){
					if(!empty($index) && !empty($value)){
						$this->saveSession($index, $value);
					}
				}
			}
			else{
				$this->error($error['SESSION_NOT_ARR']);
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
	* Método que salva uma session a partir de seu índice e value.
	* @access public 
	* @param String $index
	* @param String $value
	* @return void
	*/
	function saveSession($index, $value){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(empty($index) || empty($value)){
			$this->error($error['INDI_OR_VALUE_E']);
		}
		else{
			$_SESSION[$index] = $value;
		}
	}//saveSession
	
	/** 
	* Método que retorna um value a partir do índice passado com oparâmetro.
	* @access public 
	* @param String $index
	* @return String
	*/
	function returnSession($index, $returnError = false){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(!empty($index)){
			if(!empty($_SESSION[$index])){
				return $_SESSION[$index];
			}
			else{
				if($returnError)
				$this->error($error['SESSION_NOT_EXI']);
			}
		}
		else{
			if($returnError)
			$this->error($error['SE_index_EMPTY']);
		}
	}//returnSession
	
	/** 
	* Método que limpa todas as variáveis da sessão.
	* @access public 
	* @return void
	*/
	function clearSessions(){
		session_unset();
	}//limpaSessions
}//Session
?>