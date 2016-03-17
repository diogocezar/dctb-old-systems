<?php
/** 
* SpeceBrain
*
* Esse neur�nio � responsavel por manipular as sess�es do sistema
* This neuron is responsible to manipulate system sessions
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright � 2007-2009
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
	* M�todo que adiciona as sessions passadas em forma de array no par�metro.
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
	* M�todo que inicia as sess�es.
	* @access public 
	* @return void
	*/	
	function startSession(){
		session_start();
	}//startSession

	/** 
	* M�todo que salva uma session a partir de seu �ndice e value.
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
	* M�todo que retorna um value a partir do �ndice passado com opar�metro.
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
	* M�todo que limpa todas as vari�veis da sess�o.
	* @access public 
	* @return void
	*/
	function clearSessions(){
		session_unset();
	}//limpaSessions
}//Session
?>