<?php
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
	 * Esta classe щ responsavel por enviar arquivos.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright Љ 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package SendFile
	 */

class SendFile{

	  /** 
      * Atributo que irс armazenar o nome original do arquivo no computador do usuсrio.
      * @access private  
      * @name $nome
	  * @var String
      */		
	var $nome;

	  /** 
      * Atributo que irс armazenar o tipo MIME do arquivo.
      * @access private  
      * @name $tipo
	  * @var String
      */		
	var $tipo;
	
	  /** 
      * Atributo que irс armazenar o tamanho em bytes do arquivo.
      * @access private  
      * @name $tamanho
	  * @var String
      */		
	var $tamanho;
	
	  /** 
      * Atributo que irс armazenar nome temporсrio que o servidor utilizou para armazenar o arquivo.
      * @access private  
      * @name $tmpName
	  * @var String
      */		
	var $tmpName;
	
	  /** 
      * Atributo que irс armazenar o cѓdigo do erro em caso de falha.
      * @access private  
      * @name $erro
	  * @var integer
      */		
	var $erro;
	
	  /** 
      * Atributo que irс armazenar o destino do arquivo, ou seja aonde ele serс salvo.
      * @access private  
      * @name $dirDestino
	  * @var String
      */		
	var $dirDestino;
	
	  /** 
      * Atributo que irс armazenar a extensуo do arquivo.
      * @access private  
      * @name $extensao
	  * @var String
      */		
	var $extensao;
	
	  /** 
      * Atributo que irс se o arquivo jс foi enviado ou nуo
      * @access private  
      * @name $concluido
	  * @var boolean
      */		
	var $concluido;
	
	 /** 
	  * Mщtodo CONSTRUTOR que inicializa os atributos a partir do arquivo e diretѓrio passados como parтmetros.
	  * @access public 
	  * @param File $arquivo
	  * @param String $diretorio
	  * @return void
	  */  
	function SendFile($arquivo, $diretorio){
		/* Setando tempo limite da pсgina para infinito (Caso o arquivo demore para ser enviado) */
		set_time_limit(0);
		
	 	global $erro; // Reconhecendo variavel global para os erros.
		
		$this->nome       = $arquivo['name'];
		$this->tamanho    = $arquivo['size'];
		$this->tmpName    = $arquivo['tmp_name'];
		$this->tipo       = $arquivo['type'];
		$this->erro       = $arquivo['error'];
		$this->dirDestino = $diretorio;
		
		if(!is_dir($diretorio)){
			$erroSendFile = new Errors($erro['DIRETORIO_INVAL']);
		}		
		else if(empty($this->nome) || empty($this->tamanho) || empty($this->tmpName) || empty($this->tipo)){
			$erroSendFile = new Errors($erro['ARQUI_INCOMPLET']);
		}
		else{
			$this->concluido = false;
			$this->goFile();
		}
	}
	
	  /** 
	  * Mщtodo que envia um arquivo caso nenhuma "restriчуo" seja encontrada.
	  * Apѓs o termino, seta concluido como true.
	  * @access public 
	  * @return void
	  */
	function goFile(){
	 	global $erro; // Reconhecendo variavel global para os erros.
		global $extValidas; // Array com as extensѕes vсlidas.
		global $mimeExt; // Array com as extensѕes e seus respectivos MIME types.
		
		$this->nome = str_replace(" ", "_", $this->nome);
		$this->nome = strtolower($this->nome);
		
		$this->nome = $this->dirDestino.'/'.$this->nome;
		
		$this->extensao = strrchr($this->nome, '.'); 
		
		if(LIMITAR_EXT == 'sim' && !in_array($this->extensao, $extValidas)){
			$erroSendFile = new Errors($erro['EXT_ARQUIV_INVA']);
		}
		
		if(LIMITAR_TAMANHO == 'sim' && $this->tamanho > TAMANHO_BYTES){
			$erroSendFile = new Errors($erro['TAMANHO_MAIOR_P']);
		}
		
		/* Pegando apenas nome do arquivos */
		
		$expBarra = explode('/', $this->nome);
		$nomeComExt = $expBarra[count($expBarra)-1];
		$expPonto = explode('.', $nomeComExt);
		$nomeArquivo =  $expPonto[0];
		
		/* Se jс existir um arquivo com o mesmo nome */		
		if(file_exists($this->nome)){
			$count = 1;
			$this->nome = $this->dirDestino.'/'.$nomeArquivo.'['.$count.']'.$this->extensao;
			while(file_exists($this->nome)){
				$count++;
				$this->nome = $this->dirDestino.'/'.$nomeArquivo.'['.$count.']'.$this->extensao;
			}
		}
		
		if(move_uploaded_file($this->tmpName, $this->nome)){
			
			foreach($mimeExt as $mime => $ext){
				if($this->tipo == $mime && $this->extensao != $ext){
					/* Caso a extensуo passada seja diferente do tipo, ele щ renomeado. */
					$this->extensao = $mimeExt[$mime];
					rename($this->nome, $this->dirDestino.'/'.$nomeArquivo.$this->extensao);
					$this->nome = $this->dirDestino.'/'.$nomeArquivo.$this->extensao;	
				}
			}
			if($this->extensao == '.jpeg' || $this->extensao == '.jpg' || $this->extensao == '.gif' || $this->extensao == '.png'){
				if(ALTERAR_QUALIDADE == 'sim'){
					switch($this->extensao){
						case '.jpeg':
						case '.jpg' :
							/* Criando a imagem JPG*/
							$img = imagecreatefromjpeg($this->nome);
							imagejpeg($img, $this->dirDestino.'/'.$this->nome, QUALIDADE);
							break;
							
						case '.gif':
							/* Criando a imagem GIP*/
							$img = imagecreatefromgif($this->nome);
							imagegif($img, $this->dirDestino.'/'.$this->nome, QUALIDADE);
							break;
							
						case '.png':
							/* Criando a imagem PNG*/
							$img = imagecreatefrompng($this->nome);
							imagepng($img, $this->dirDestino.'/'.$this->nome, QUALIDADE);
							break;
					}
				}
			}
		}
		$this->concluido = true;
	}
	
	  /** 
	  * Mщtodo que retorna a localizaчуo do arquivo enviado.
	  * Apѓs o termino, seta concluido como true.
	  * @access public 
	  * @return void
	  */
	function getNome(){
		if($this->concluido == true){
			return $this->nome;
		}
		else{
			return false;
		}
	}
}
?>