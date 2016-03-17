<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel por criptografar ou descriptografar uma samblagem
* This neuron is responsible encrypt or decrypt a string 
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class Encrypt{

	/** 
	* Atributo que irá armazenar a palavra, que pode estar criptografada ou não.
	*
	* @access private  
	* @name $str
	* @var String
	*/
	private $str;
	
	/** 
	* Atributo que irá armazenar se a palavra está criptografada ou não.
	*
	* @access private  
	* @name $str
	* @var boolean
	*/	
	private $crip;
	
	/** 
	* Atributo que irá armazenar a chave alfa da criptografia.
	*
	* @access private  
	* @name $str
	* @var String
	*/	
	private $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  €  ‚ ƒ „ … † ‡ ˆ ‰ Š ‹ Œ     ‘ ’ “ ” • – — ˜ ™ š › œ   Ÿ   ¡ ¢ £ ¤ ¥ ¦ § ¨ © ª « ¬ ­ ® ¯ ° ± ² ³ ´ µ ¶ · ¸ ¹ º » ¼ ½ ¾ ¿ À Á Â Ã Ä Å Æ Ç È É Ê Ë Ì Í Î Ï Ğ Ñ Ò Ó Ô Õ Ö × Ø Ù Ú Û Ü İ Ş ß à á â ã ä å æ ç è é ê ë ì í î ï ğ ñ ò ó ô õ ö ÷ ø ù ú û ü ı ş ÿ ';
	
	/** 
	* Atributo que irá armazenar a chave beta da criptografia.
	*
	* @access private  
	* @name $str
	* @var String
	*/	
    private $beta = 'š Ç g ş ê o « ` N ²  É x ” í  » # 1 – W Æ ¯  R J  ú î  | + a Ù Ï ÿ { 4 $ ô †  w æ È ò E á ¿ û ğ Õ â ) v Ö V Z  & ®  B F r P  y §  : ,  ¤ C b ³ t ± c ( ¼ Î ¢ 0 ï > ‘ m ø  Ñ › n  ­ Ä İ Œ ˜ ß Á q ¦ @ ç ] G ö p à ´ Â " ª Ş  } k  f M ¸ O ‡ 2 Ô ¥ L “ 9 º * l ¹  è  ‹ _ ^ K ? = z ñ ı ä „  Ó ‚ é j ã ¾ ° ¡ . ¬    ™ - • ¶ Û  ƒ ¨   ! Ì œ Q Å X 6 D Ã 7 µ  À  Ê € ½  © H ’ 5 × A  T s  3 õ ó d % Ü å ù ë ˆ £ i · e [ Ë ‰ <  I Ğ h … Í u Ú — ü Ÿ  ÷ Š / Ò Ø ~ Y   8 ì S  \ ; U   ';

	/**
	* Construtor
	* __construct_Cript()
	*/
	public function __construct_Cript(){}

	   
	/** 
	* Método que recebe como parâmetro a palavra a ser criptografada.
	* @access public
	* @param String $palavra
	* @return void
	*/
	function __go_Cript($str){
		$this->str = $str;
		$crip = false;
	}//__go_Cript
	
	/** 
	* Método que faz a criptografia da samblagem. Armazena o resultado no atributo str.
	* @access public 
	* @return void
	*/  
	function criptStr(){
	 	global $erro; // Reconhecendo variavel global para os erros.
		if(!empty($this->str)){
			if($this->crip == false){
				$strCript = '';
				for($i=0; $i<strlen($this->str); $i++){
					$strCript .= $this->beta[strpos($this->alfa, $this->str[$i])];
				}
			}
			else{
				$this->erro($erro['CRIPT_STR_CRIPT']);
			}
			$this->crip = true;
			$this->str  = $strCript;
		}
		else{
			$this->erro($erro['CRIPT_STR_VAZIA']);
		}
	}//criptStr
	
	/** 
	* Método que faz a descriptografia da samblagem. Armazena o resultado no atributo str.
	* @access public 
	* @return void
	*/  
	function unCriptStr(){
		if(!empty($this->str)){
			if($this->crip == true){
				$strUnCript = '';
				for($i=0; $i<strlen($this->str); $i++){
					$strUnCript .= $this->alfa[strpos($this->beta, $this->str[$i])];
				}
			}
			else{
				$this->erro($erro['CRIPT_STR_DESCR']);
			}
			$this->crip    = false;
			$this->str = $palavraUnCript;
		}
		else{
			$this->erro($erro['CRIPT_STR_VAZIA']);
		}
	}//unCriptStr
	
	/** 
	* Método que retorna a samblagem.
	* @access public 
	* @return String
	*/  
	function getStr(){
		if(!empty($this->str)){
			return $this->str;
		}
		else{
			$this->erro($erro['CRIPT_STR_VAZIA']);
		}
	}//getStr
	
	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call ($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Cript
?>