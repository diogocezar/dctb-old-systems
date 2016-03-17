<?php
/** 
* SpeceBrain
*
* Esse neurônio é responsavel criar uma imagem de título dinamicamente
* This neuron is responsible to dynamically a title image
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class Imggen{

	private $fonte;
	
	private $tamanhofonte;
	
	private $texto;
	
	private $type = "gif";
	
	private $corTexto;
	
	private $corFundo;
	
	private $transparente;
	
	private $maxLine;
	
	/**
	* Construtor
	* __construct_Photo()
	*/
	public function __construct_Imggen(){}

	/** 
	* Método que inicializa os atributos passados como parâmetros.
	* @access public 
	* @param String $localizacao
	* @param integer $largura
	* @param integer $altura
	* @param boolean $scalar
	* @return void
	*/  
	public function __go_Imggen($fonte, $tamanho, $texto, $corTexto, $corFundo, $transparente, $maxLine){
	
		if(!empty($fonte)){
			$patch = "./fontes/".$fonte.".TTF";
			if(file_exists($patch)){
				$this->setFonte($patch);
			}
			else{
				$patch = "./fontes/arial.ttf";
				$this->setFonte($patch);
			}
		}
		else{
			$patch = "./fontes/arial.ttf";
			$this->setFonte($patch);
		}
		if(!empty($tamanho)){
			$this->setTamanhofonte($tamanho);
		}
		else{
			$this->setTamanhofonte(9);
		}
		if(!empty($texto)){
			$this->setTexto($texto);
		}
		else{
			$this->setTexto(" { erro } ");
		}
		if(!empty($corTexto)){
			$this->corTexto = $this->geraArrayCor($corTexto);
		}
		else{
			$this->corTexto = $this->geraArrayCor("0,0,0");
		}
		if(!empty($corFundo)){
			$this->corFundo= $this->geraArrayCor($corFundo);
		}
		else{
			$this->corFundo = $this->geraArrayCor("255,255,255");
		}
		if(!empty($transparente)){
			$this->transparente = $transparente;
		}
		else{
			$this->transparente = 'não';
		}
		if(!empty($maxLine)){
			$this->maxLine = $maxLine;
		}
		else{
			$this->maxLine = 100;
		}		
		$this->imgGenerator();
	}//__go_Imggen
	
	public function geraArrayCor($cor){
		$array = explode(",", $cor);
		return $array;
	}
	
	public function imgGenerator(){
	
		header("Content-type: image/".$this->type);
		
		$len = strlen($this->texto);
		
		if($len > $this->maxLine){
					
			$this->splitWrite();	
		}
		else{
			// Create the image
			$tamanho  = imagettfbbox($this->tamanhofonte, 0, $this->fonte, $this->texto);
			$width    = $tamanho[2] + $tamanho[0];
			$height   = abs($tamanho[1]) + abs($tamanho[7]);		
			$image    = imagecreate($width, $height);
			
			$imgCorFundo = imagecolorallocate($image, $this->corFundo[0], $this->corFundo[1], $this->corFundo[2]);
			
			if($this->transparente == "sim"){		
				imagecolortransparent($image, $imgCorFundo);
			}
			
			$imgCorLetra = imagecolorallocate($image, $this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
							
			// Add the text
			imagefttext($image, $this->tamanhofonte, 0, 0, abs($tamanho[5]), $imgCorLetra, $this->fonte, $this->texto);
						
			// Using imagepng() results in clearer text compared with
			if($this->type == "gif"){
				imagegif($image);
			}
			if($this->type == "png"){
				imagepng($image);
			}
			imagedestroy($image);
		}
	}//imgGenerator
	
	public function splitWrite(){

		$word = '';
		$len = strlen($this->texto);
		for($i = 0 ; $i < $len ; $i++ ){
			$countLetras++;
			$word .= $this->texto{$i};
			if(
				$this->texto{$i} == " " ||
				$this->texto{$i} == "." ||
				$this->texto{$i} == "," ||
				$this->texto{$i} == "?" ||
				$this->texto{$i} == "!"
			  ){
					$toprint[(int)($i/$this->maxLine)] .= $word;
					$word = "";
			  }		
		}
		
		$textoCortado = substr($this->texto, 0, $this->maxLine);
		
		$multiplica = (count($toprint) > 0) ? (count($toprint)) : (1);

		$tamanho  = imagettfbbox($this->tamanhofonte, 0, $this->fonte, $textoCortado);
		$width    = $tamanho[2] + $tamanho[0] + 10;
		$height   = (abs($tamanho[1]) + abs($tamanho[7])) * $multiplica;

		$image    = imagecreate($width, $height);
		
		$imgCorFundo = imagecolorallocate($image, $this->corFundo[0], $this->corFundo[1], $this->corFundo[2]);
		
		if($this->transparente == "sim"){		
			imagecolortransparent($image, $imgCorFundo);
		}
		
		$imgCorLetra = imagecolorallocate($image, $this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
		
		$x = 0;
		$y = $this->tamanhofonte;
		
		foreach($toprint as $at => $current){
			
			imagefttext($image, $this->tamanhofonte, 0, $x, $y, $imgCorLetra, $this->fonte, $current);			

			$y += $this->tamanhofonte;
		}
		
		if($this->type == "gif"){
			imagegif($image);
		}
		if($this->type == "png"){
			imagepng($image);
		}
		imagedestroy($image);

	}
	
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
}
?>