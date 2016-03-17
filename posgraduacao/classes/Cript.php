<?php
/**
* A seguir s„o colocados os arquivos incluidos e suas respectivas descriÁıes.
*/

/**
* Incluindo impress„o de erros.
*/
include("Errors.php");

	 /** 
	 * Esta classe È responsavel por fazer criptografia de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright © 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Cript
	 */


class Cript{

	 /** 
     * Atributo que ir· armazenar a palavra, que pode estar criptografada ou n„o.
	 *
     * @access private  
     * @name $str
	 * @var String
     */
	var $str;
	
     /** 
     * Atributo que ir· armazenar se a palavra est· criptografada ou n„o.
	 *
     * @access private  
     * @name $str
	 * @var boolean
     */	
	var $crip;
	
	 /** 
     * Atributo que ir· armazenar a chave alfa da criptografia.
	 *
     * @access private  
     * @name $str
	 * @var String
     */	
	var $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  Ä Å Ç É Ñ Ö Ü á à â ä ã å ç é è ê ë í ì î ï ñ ó ò ô ö õ ú ù û ü   ° ¢ £ § • ¶ ß ® © ™ ´ ¨ ≠ Æ Ø ∞ ± ≤ ≥ ¥ µ ∂ ∑ ∏ π ∫ ª º Ω æ ø ¿ ¡ ¬ √ ƒ ≈ ∆ « » …   À Ã Õ Œ œ – — “ ” ‘ ’ ÷ ◊ ÿ Ÿ ⁄ € ‹ › ﬁ ﬂ ‡ · ‚ „ ‰ Â Ê Á Ë È Í Î Ï Ì Ó Ô  Ò Ú Û Ù ı ˆ ˜ ¯ ˘ ˙ ˚ ¸ ˝ ˛ ˇ ';
	
     /** 
     * Atributo que ir· armazenar a chave beta da criptografia.
	 *
     * @access private  
     * @name $str
	 * @var String
     */	
    var $beta = 'ö « g ˛ Í o ´ ` N ≤  … x î Ì  ª # 1 ñ W ∆ Ø  R J  ˙ Ó ç | + a Ÿ œ ˇ { 4 $ Ù Ü  w Ê » Ú E · ø ˚  ’ ‚ ) v ÷ V Z  & Æ  B F r P  y ß  : , è § C b ≥ t ± c ( º Œ ¢ 0 Ô > ë m ¯ é — õ n  ≠ ƒ › å ò ﬂ ¡ q ¶ @ Á ] G ˆ p ‡ ¥ ¬ " ™ ﬁ  } k  f M ∏ O á 2 ‘ • L ì 9 ∫ * l π  Ë  ã _ ^ K ? = z Ò ˝ ‰ Ñ Å ” Ç È j „ æ ∞ ° . ¨    ô - ï ∂ €  É ®   ! Ã ú Q ≈ X 6 D √ 7 µ  ¿    Ä Ω  © H í 5 ◊ A ê T s  3 ı Û d % ‹ Â ˘ Î à £ i ∑ e [ À â <  I – h Ö Õ u ⁄ ó ¸ ü  ˜ ä / “ ÿ ~ Y û ù 8 Ï S  \ ; U   ';

	  /**
	  * Construtor
	  */
	   
	  /** 
	  * MÈtodo CONSTRUTOR que recebe como par‚metro a palavra a ser criptografada.
	  * @access public
	  * @param String $palavra
	  * @return void
	  */  

	function Cript($str){
		$this->str = $str;
		$crip = false;
	}//Cript
	
	  /** 
	  * MÈtodo que faz a criptografia da samblagem. Armazena o resultado no atributo str.
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
				$erroCript = new Errors($erro['CRIPT_STR_CRIPT']);
			}
			$this->crip = true;
			$this->str  = $strCript;
		}
		else{
				$erroCript = new Errors($erro['CRIPT_STR_VAZIA']);
		}
	}//criptStr
	
	  /** 
	  * MÈtodo que faz a descriptografia da samblagem. Armazena o resultado no atributo str.
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
				$erroCript = new Errors($erro['CRIPT_STR_DESCR']);
			}
			$this->crip    = false;
			$this->str = $palavraUnCript;
		}
		else{
				$erroCript = new Errors($erro['CRIPT_STR_VAZIA']);
		}
	}//unCriptStr
	
	  /** 
	  * MÈtodo que retorna a samblagem.
	  * @access public 
	  * @return String
	  */  
	
	function getStr(){
		if(!empty($this->str)){
			return $this->str;
		}
		else{
			$erroCript = new Errors($erro['CRIPT_STR_VAZIA']);
		}
	}
	
}//Cript
?>