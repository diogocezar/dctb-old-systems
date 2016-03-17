<?php
/* Ao ser incluida, a classe já inicializa a sessão. */
session_start();

/**
* A seguir são colocados os arquivos incluidos e suas respectivas descrições.
*/

/**
* Incluindo impressão de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe é responsavel por manipular as sessões da página.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright © 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Session
	 */


class Session{

	  /** 
	  * Método CONSTRUTOR que adiciona as sessions passadas em forma de array no parâmetro.
	  * @access public 
	  * @param Array $sessions
	  * @return void
	  */
	function Session($sessions){
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
				$erroSession = new Errors($erro['SESSION_NOT_ARR']);
			}
		}
	}

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
			$erroSession = new Errors($erro['INDI_OR_VALUE_E']);
		}
		else{
			$_SESSION[$indice] = $valor;
		}
	}
	
	  /** 
	  * Método que retorna um valor a partir do índice passado com oparâmetro.
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
				$erroSession = new Errors($erro['SESSION_NOT_EXI']);
			}
		}
		else{
			$erroSession = new Errors($erro['SE_INDICE_EMPTY']);
		}
	}
	
	  /** 
	  * Método que limpa todas as variáveis da sessão.
	  * @access public 
	  * @return void
	  */
	function limpaSessions(){
		session_unset();
	}
}
?>