<?
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo arquivo de configura��o com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo impress�o de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe � responsavel por manipular as cookies da p�gina.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Cookie
	 */

class Cookie{

	  /** 
	  * M�todo CONSTRUTOR que adiciona as cookies passadas em forma de array no par�metro.
	  * @access public 
	  * @param Array $cookies
	  * @return void
	  */
	function Cookie($cookies){
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
	}

	  /** 
	  * M�todo que salva uma cookie a partir de seu �ndice, valor e as constantes definidas no arquivo de configura��o.
	  * @access public 
	  * @param Array $cookies
	  * @return void
	  * @see Cookie.php
	  */
	function salvaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$erroSession = new Errors($erro['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = EXPIRE + time();
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}
	
	  /** 
	  * M�todo CONSTRUTOR que inicializa a session e caso o par�metro passado n�o seja vazio adiciona as sessions.
	  * @access public 
	  * @param Array $cookies
	  * @return void
	  */
	function deletaCookie($indice, $valor){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($indice) || empty($valor)){
				$erroSession = new Errors($erro['INDI_OR_VALUE_C']);
		}
		else{
			$tempoExpira = 0;
			setcookie($indice, $valor, $tempoExpira, PATH_COOKIE, DOMAIN);
		}
	}
}//Cookie

?>