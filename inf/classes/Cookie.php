<?
/**
* A seguir sуo colocados os arquivos incluidos e suas respectivas descriчѕes.
*/

/**
* Incluindo arquivo de configuraчуo com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo impressуo de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe щ responsavel por manipular as cookies da pсgina.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright Љ 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Cookie
	 */

class Cookie{

	  /** 
	  * Mщtodo CONSTRUTOR que adiciona as cookies passadas em forma de array no parтmetro.
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
	  * Mщtodo que salva uma cookie a partir de seu эndice, valor e as constantes definidas no arquivo de configuraчуo.
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
	  * Mщtodo CONSTRUTOR que inicializa a session e caso o parтmetro passado nуo seja vazio adiciona as sessions.
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