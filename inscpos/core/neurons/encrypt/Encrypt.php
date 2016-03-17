<?php
/** 
* SpeceBrain
*
* Esse neur�nio � responsavel por criptografar ou descriptografar uma samblagem
* This neuron is responsible encrypt or decrypt a string 
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright � 2007-2009
* @access public
* @package neuron
*/

class Encrypt{

	/** 
	* Atributo que ir� armazenar a palavra, que pode estar criptografada ou n�o.
	*
	* @access private  
	* @name $str
	* @var String
	*/
	private $str;
	
	/** 
	* Atributo que ir� armazenar se a palavra est� criptografada ou n�o.
	*
	* @access private  
	* @name $str
	* @var boolean
	*/	
	private $crip;
	
	/** 
	* Atributo que ir� armazenar a chave alfa da criptografia.
	*
	* @access private  
	* @name $str
	* @var String
	*/	
	private $alfa = '                          ! " # $ % & ( ) * + , - . / 0 1 2 3 4 5 6 7 8 9 : ; < = > ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ \ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~  � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � �   � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � � ';
	
	/** 
	* Atributo que ir� armazenar a chave beta da criptografia.
	*
	* @access private  
	* @name $str
	* @var String
	*/	
    private $beta = '� � g � � o � ` N �  � x � �  � # 1 � W � �  R J  � � � | + a � � � { 4 $ � �  w � � � E � � � � � � ) v � V Z  & �  B F r P  y �  : , � � C b � t � c ( � � � 0 � > � m � � � � n  � � � � � � � q � @ � ] G � p � � � " � �  } k  f M � O � 2 � � L � 9 � * l �  �  � _ ^ K ? = z � � � � � � � � j � � � � . �    � - � � �  � �   ! � � Q � X 6 D � 7 �  �  � � �  � H � 5 � A � T s  3 � � d % � � � � � � i � e [ � � <  I � h � � u � � � �  � � / � � ~ Y � � 8 � S  \ ; U   ';

	/**
	* Construtor
	* __construct_Cript()
	*/
	public function __construct_Cript(){}

	   
	/** 
	* M�todo que recebe como par�metro a palavra a ser criptografada.
	* @access public
	* @param String $palavra
	* @return void
	*/
	function __go_Cript($str){
		$this->str = $str;
		$crip = false;
	}//__go_Cript
	
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
				$this->error($error['CRIPT_STR_CRIPT']);
			}
			$this->crip = true;
			$this->str  = $strCript;
		}
		else{
			$this->error($error['CRIPT_STR_VAZIA']);
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
				$this->error($error['CRIPT_STR_DESCR']);
			}
			$this->crip    = false;
			$this->str = $palavraUnCript;
		}
		else{
			$this->error($error['CRIPT_STR_VAZIA']);
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
			$this->error($error['CRIPT_STR_VAZIA']);
		}
	}//getStr
	
	/** 
	* GETS e SETS
	* M�todo __call que � verificado a cada chamada de uma fun��o da classe, o seguinte m�todo implementa automaticamente as fun��es de GET e SET.
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