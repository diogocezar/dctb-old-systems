<?php
/** 
* SpeceBrain
*
* Esta classe é responsavel por criar uma imagem de título dinamicamente
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package session
*/

class Imggen{

	private $fonte;
	
	private $tamanhofote;
	
	private $texto;
	
	private $type = "gif";
	
	private $corTexto;
	
	private $corFundo;
	
	private $transparente;
	
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
	public function __go_Imggen($fonte, $tamanho, $texto, $corTexto, $corFundo, $transparente){
	
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
			$this->setTamanhofote($tamanho);
		}
		else{
			$this->setTamanhofote(9);
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
		$this->imgGenerator();
	}//__go_Imggen
	
	public function geraArrayCor($cor){
		$array = explode(",", $cor);
		return $array;
	}
	
	public function imgGenerator(){
	
		header("Content-type: image/".$this->type);

		// Create the image
		$tamanho  = imagettfbbox($this->tamanhofote, 0, $this->fonte, $this->texto);
		$width    = $tamanho[2] + $tamanho[0];
		$height   = abs($tamanho[1]) + abs($tamanho[7]);		
		$image    = imagecreate($width, $height);
		
		$imgCorFundo = imagecolorallocate($image, $this->corFundo[0], $this->corFundo[1], $this->corFundo[2]);
		
		if($this->transparente == "sim"){		
			imagecolortransparent($image, $imgCorFundo);
		}

		$imgCorLetra = imagecolorallocate($image, $this->corTexto[0], $this->corTexto[1], $this->corTexto[2]);
		
		// Add the text
		imagefttext($image, $this->tamanhofote, 0, 0, abs($tamanho[5]), $imgCorLetra, $this->fonte, $this->texto);
		
		// Using imagepng() results in clearer text compared with
		if($this->type == "gif"){
			imagegif($image);
		}
		if($this->type == "png"){
			imagepng($image);
		}
		imagedestroy($image);
	}//imgGenerator
	
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