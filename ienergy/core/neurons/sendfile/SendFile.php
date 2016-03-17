<?php
/** 
* SpeceBrain
*
* Esse neurєnio щ responsavel por enviar arquivos
* This neuron is responsible to send files
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright Љ 2007-2009
* @access public
* @package neuron
*/

class SendFile{

	/** 
	* Atributo que irс armazenar o nome original do arquivo no computador do usuсrio.
	* @access private  
	* @name $nome
	* @var String
	*/
	private $nome;

	/** 
	* Atributo que irс armazenar o tipo MIME do arquivo.
	* @access private  
	* @name $tipo
	* @var String
	*/
	private $tipo;
	
	/** 
	* Atributo que irс armazenar o tamanho em bytes do arquivo.
	* @access private  
	* @name $tamanho
	* @var String
	*/
	private $tamanho;
	
	/** 
	* Atributo que irс armazenar nome temporсrio que o servidor utilizou para armazenar o arquivo.
	* @access private  
	* @name $tmpName
	* @var String
	*/	
	private $tmpName;
	
	/** 
	* Atributo que irс armazenar o cѓdigo do erro em caso de falha.
	* @access private  
	* @name $erro
	* @var integer
	*/		
	private $erro;
	
	/** 
	* Atributo que irс armazenar o destino do arquivo, ou seja aonde ele serс salvo.
	* @access private  
	* @name $dirDestino
	* @var String
	*/		
	private $dirDestino;
	
	/** 
	* Atributo que irс armazenar a extensуo do arquivo.
	* @access private  
	* @name $extensao
	* @var String
	*/		
	private $extensao;
	
	/** 
	* Atributo que irс se o arquivo jс foi enviado ou nуo
	* @access private  
	* @name $concluido
	* @var boolean
	*/		
	private $concluido;
	
	/**
	* Construtor
	* __construct_SendFile()
	*/
	public function __construct_SendFile(){}

	
	/** 
	* Mщtodo que inicializa os atributos a partir do arquivo e diretѓrio passados como parтmetros.
	* @access public 
	* @param File $arquivo
	* @param String $diretorio
	* @return void
	*/  
	function __go_SendFile($arquivo, $diretorio){
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
			$this->error($error['DIRETORIO_INVAL']);
		}		
		else if(empty($this->nome) || empty($this->tamanho) || empty($this->tmpName) || empty($this->tipo)){
			$this->error($error['ARQUI_INCOMPLET']);
		}
		else{
			$this->concluido = false;
			$this->goFile();
		}
	}//__go_SendFile
	
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
			$this->erro($erro['EXT_ARQUIV_INVA']);
		}
		
		if(LIMITAR_TAMANHO == 'sim' && $this->tamanho > TAMANHO_BYTES){
			$this->erro($erro['TAMANHO_MAIOR_P']);
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
							imagejpeg($img, $this->nome, QUALIDADE);
							break;
							
						case '.gif':
							/* Criando a imagem GIP*/
							$img = imagecreatefromgif($this->nome);
							imagegif($img, $this->nome, QUALIDADE);
							break;
							
						case '.png':
							/* Criando a imagem PNG*/
							$img = imagecreatefrompng($this->nome);
							imagepng($img, $this->nome, QUALIDADE);
							break;
					}
				}
			}
		}
		$this->concluido = true;
	}//goFile
	
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
	}//getNome
	
	/** 
	* GETS e SETS
	* Mщtodo __call que щ verificado a cada chamada de uma funчуo da classe, o seguinte mщtodo implementa automaticamente as funчѕes de GET e SET.
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
}//SendFile
?>