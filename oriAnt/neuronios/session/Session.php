<?php
/** 
* SpeceBrain
*
* Esta classe � responsavel por manipular as sess�es da p�gina.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright � 2007
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
	* M�todo que adiciona as sessions passadas em forma de array no par�metro.
	* @access public 
	* @param Array $sessions
	* @return void
	*/
	public function __go_Session($sessions){
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
	* M�todo que inicia as sess�es.
	* @access public 
	* @return void
	*/	
	public function startSession(){
		session_start();
	}//startSession

	/** 
	* M�todo que salva uma session a partir de seu �ndice e valor.
	* @access public 
	* @param String $indice
	* @param String $valor
	* @return void
	*/
	public function salvaSession($indice, $valor){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
			$this->erro($erro['INDI_OR_VALUE_E']);
		}
		else{
			$_SESSION[$indice] = $valor;
		}
	}//salvaSession
	
	/** 
	* M�todo que retorna um valor a partir do �ndice passado como par�metro.
	* @access public 
	* @param String $indice
	* @return String
	*/
	public function retornaSession($indice){
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
	* M�todo que limpa todas as vari�veis da sess�o.
	* @access public 
	* @return void
	*/
	public function limpaSessions(){
		session_unset();
	}//limpaSessions
}//Session
?>