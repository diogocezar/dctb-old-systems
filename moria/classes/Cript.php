<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo impress�o de erros.
*/
include("Errors.php");

	 /** 
	 * Esta classe � responsavel por fazer criptografia de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Cript
	 */


class Cript{

	 /** 
     * Atributo que ir� armazenar a palavra, que pode estar criptografada ou n�o.
	 *
     * @access private  
     * @name $str
	 * @var String
     */
	var $str;
	
     /** 
     * Atributo que ir� armazenar se a palavra est� criptografada ou n�o.
	 *
     * @access private  
     * @name $str
	 * @var boolean
     */	
	var $crip;
	
	 /** 
     * Atributo que ir� armazenar a chave alfa da criptografia.
	 *
     * @access private  
     * @name $str
	 * @var String
     */	
	var $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � �   � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � ';
	
     /** 
     * Atributo que ir� armazenar a chave beta da criptografia.
	 *
     * @access private  
     * @name $str
	 * @var String
     */	
    var $beta = '� � g � � o � ` N �  � x � �  � # 1 � W � �  R J  � � � | + a � � � { 4 $ � �  w � � � E � � � � � � ) v � V Z  & �  B F r P  y �  : , � � C b � t � c ( � � � 0 � > � m � � � � n  � � � � � � � q � @ � ] G � p � � � " � �  } k  f M � O � 2 � � L � 9 � * l �  �  � _ ^ K ? = z � � � � � � � � j � � � � . �    � - � � �  � �   ! � � Q � X 6 D � 7 �  �  � � �  � H � 5 � A � T s  3 � � d % � � � � � � i � e [ � � <  I � h � � u � � � �  � � / � � ~ Y � � 8 � S  \ ; U   ';

	  /**
	  * Construtor
	  */
	   
	  /** 
	  * M�todo CONSTRUTOR que recebe como par�metro a palavra a ser criptografada.
	  * @access public
	  * @param String $palavra
	  * @return void
	  */  

	function Cript($str){
		$this->str = $str;
		$crip = false;
	}//Cript
	
	  /** 
	  * M�todo que faz a criptografia da samblagem. Armazena o resultado no atributo str.
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
	  * M�todo que faz a descriptografia da samblagem. Armazena o resultado no atributo str.
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
	  * M�todo que retorna a samblagem.
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