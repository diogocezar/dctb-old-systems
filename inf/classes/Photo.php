<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo impress�o de erros.
*/
include("Errors.php");

	  /** 
	  * Esta classe � responsavel por manipular fotos nos formatos : Jpeg, gif e png.
	  *
	  * @author xg0rd0 <xgordo@kakitus.com> 
	  * @version 1.0
	  * @copyright Copyright � 2005, Kakirus.com LTDA. 
	  * @access public
	  * @package Photo
	  */

class Photo{

	  /** 
      * Atributo que ir� armazenar a altura da foto.
      * @access private  
      * @name $altura
	  * @var integer
      */		
	var $altura;
	
	  /** 
      * Atributo que ir� armazenar a altura da foto.
      * @access private  
      * @name $largura
	  * @var integer
      */		
	var $largura;
	
	  /** 
      * Atributo que ir� armazenar a localiza��o da foto.
      * @access private  
      * @name $localizacao
	  * @var String
      */		
	var $localizacao;
	
	  /** 
      * Atributo que ir� armazenar a mensagem de erro, caso ocorra.
      * @access private  
      * @name $msgErro
	  * @var String
      */		
	var $msgErro;
	
	  /** 
      * Atributo que ir� armazenar a extens�o da foto.
      * @access private  
      * @name $extensao
	  * @var String
      */		
	var $extensao;
	
	  /** 
      * Atributo que ir� armazenar TEMPORARIAMENTE a imagem criada pelo PHP.
      * @access private  
      * @name $img
	  * @var Imagem
      */		
	var $img;
	
	  /** 
      * Atributo que ir� armazenar se a imagem deve ser ou n�o proporcional.
      * @access private  
      * @name $scalar
	  * @var boolean
      */		
	var $scalar;

	 /** 
	  * M�todo CONSTRUTOR que inicializa os atributos passados como par�metros.
	  * @access public 
	  * @param String $localizacao
	  * @param integer $largura
	  * @param integer $altura
	  * @param boolean $scalar
	  * @return void
	  */  
	function Photo($localizacao, $largura, $altura, $scalar){
		if(file_exists($localizacao)){
			if(!empty($largura) && !empty($altura)){
				$this->largura = $largura;
				$this->altura  = $altura;
				$this->scalar  = $scalar;
				
				$this->localizacao = $localizacao; 
				
				/* Completando a Extens�o */
				$expBarra = explode('/', $this->localizacao);
				$nomeComExt = $expBarra[count($expBarra)-1];
				$expPonto = explode('.', $nomeComExt);
				$this->extensao =  '.'.$expPonto[count($expPonto)-1];
				
				$this->msgErro = MSG_IMG_ERRO;
				
				$this->goPhoto();
			}
			else{
				$erroPhoto = new Errors($erro['ALTU_LARG_VAZIA']);
			}
		}
		else{
			$erroPhoto = new Errors($erro['LOCALIZA_INVALI']);
		}
	}
	
	 /** 
	  * M�todo que ir� gerar a imagem de acordo com as informa��es dos atributos preenchidos, tamb�m readequada a imagem nas propor��s para seu tamanho.
	  * @access public 
	  * @return void
	  */  
	function goPhoto(){
		switch($this->extensao){
			case '.jpeg':
			case '.jpg' :
				$this->img = imagecreatefromjpeg($this->localizacao);
				break;
				
			case '.gif':
				$this->img = imagecreatefromgif($this->localizacao);
				break;
				
			case '.png':
				$this->img = imagecreatefrompng($this->localizacao);
				break;
		}
		
		/* Se a imagem foi carregada com sucesso, testa-se o tamanho da mesma */
		if($this->img){
			$largura = imagesx($this->img); 
			$altura  = imagesy($this->img); 
			$escala  = min($this->largura/$largura, $this->altura/$altura); 
			
			/* Se a escala gerada n�o estiver dentro das propor��es, elas s�o geradas ! */
			if($escala < 1){
				/* Se a imagem deve ser escalar ou n�o */
				
				if($this->scalar == true){		
					$novaLargura = floor($escala*$largura); 
					$novaAltura  = floor($escala*$altura); 	
					/* Cria uma imagem tempor�ria */
					$imgTemp = imagecreatetruecolor($novaLargura, $novaAltura);
				}
				else{
					$novaLargura = $this->largura; 
					$novaAltura  = $this->altura; 	
					/* Cria uma imagem tempor�ria */
					$imgTemp = imagecreatetruecolor($this->largura, $this->altura);
				}
				
				/* Copia e altera as propor��es da imagem carregada anteriormente */
				imagecopyresampled($imgTemp, $this->img, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura); 
				/* Apaga a imagem anterior */
				imagedestroy($this->img); 
				/* Carrega a nova imagem */
				$this->img = $imgTemp; 
			}		
		}
		/* Cria imagem com mensagem de erro */
		else{
			$this->img = imagecreate($this->largura, $this->altura); 
			
			imagecolorallocate($this->img, 204, 204, 204); 
			
			$corLinha = imagecolorallocate($this->img, 153, 153, 153); 
			$corLetra = imagecolorallocate($this->img, 0, 0, 0); 
			
			imageline($this->img, 0, 0, $this->largura, $this->altura, $corLinha); 
			imageline($this->img, $this->largura, 0, 0, $this->altura, $corLinha); 
			imagestring($this->img, 2, 12, 55, $this->msgErro, $corLetra); 
		}
		
		/* Gerando a imagem final */
		switch($this->extensao){
			case '.jpeg':
			case '.jpg' :
				header("Content-type: image/jpeg");
				imagejpeg($this->img);
				break;
				
			case '.gif':
				header("Content-type: image/gif");
				imagegif($this->img);
				break;
				
			case '.png':
				header("Content-type: image/png");
				imagegif($this->img);
				break;
		}
	}
}
?>