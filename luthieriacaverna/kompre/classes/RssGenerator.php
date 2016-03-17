<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo impress�o de erros.
*/
include("Errors.php");

	  /** 
	  * Esta classe � responsavel por gerar um arquivo XML nos padr�es RSS
	  *
	  * @author xg0rd0 <xgordo@kakitus.com> 
	  * @version 1.0
	  * @copyright Copyright � 2005, Kakirus.com LTDA. 
	  * @access public
	  * @package Rss
	  */

class xRssGenerator{
	  /** 
      * Atributo que ir� armazenar os campos e os valores do canal do RSS.
      * @access private  
      * @name $canal
	  * @var array
      */
	var $canal      = array();
	
      /** 
      * Atributo que ir� armazenar os campos e os valores da imagem do RSS.
      * @access private  
      * @name $imagem
	  * @var array
      **/ 
	var $imagem     = array();
	
      /** 
      * Atributo que ir� armazenar os campos e os valores de cada �tem do RSS.
      * @access private  
      * @name $todosItens
	  * @var array
      **/
	var $todosItens = array();

      /**
	  * Atributos de configura��o onde ser�o armazenados configura��es do documento RSS.
	  **/
	 	 
	  /** 
      * Atributo que ir� armazenar qual o ultimo �tem que foi inserido, ao inserir o proximo, funciona como um ponteiro para o �ltimo �tem inserido.
      * @access private  
      * @name $cont
	  * @var integer
      */	
	var $cont       = 0;
	
      /** 
      * Atributo que ir� armazenar qual o ultimo erro que foi inserido, ao inserir o proximo, funciona como um ponteiro para o �ltimo erro inserido.
      * @access private  
      * @name $cont
	  * @var integer
      */	
	var $contErro   = 0;
	
	  /** 
      * Atributo respons�vel por "travar" um canal quando ele j� tiver sido inserido.
      * @access private  
      * @name $travaCanal
	  * @var boolean
      */	 
	var $travaCanal = false;
	
	 /** 
      * Atributo respons�vel por "travar" uma imagem quando ela j� tiver sido inserida.
      * @access private  
      * @name $tavaImagem
	  * @var boolean
      */	
	var $tavaImagem = false;
	
	 /** 
      * Atributo respons�vel por armazenar todos os erros eventuais que possam ocorrer.
      * @access private  
      * @name $erro
	  * @var array
      */  
	var $erro       = array();
	
	 /** 
      * Atributo respons�vel por armazenar a vers�o do XML no documento RSS.
      * @access private  
      * @name $versaoXML
	  * @var String
      */    
	var $versaoXML  = "1.0";
	
	 /** 
      * Atributo respons�vel por armazenar a vers�o do RSS.
      * @access private  
      * @name $versaoRSS
	  * @var String
      */   
	var $versaoRSS  = "2.0";
	
	 /** 
       * Atributo respons�vel por armazenar a vers�o do Encoding no documento RSS.
       * @access private  
       * @name $encoding
	   * @var String
	   * 
       **/   
	var $encoding   = "ISO-8859-1";
	
	 /** 
      * Atributo respons�vel por armazenar a localiza��o que ser� gerado o arquivo RSS.
      * @access private  
      * @name $encoding
	  * @var String
      */   
	var $filePath   = "";
	
	 /**
	  * Construtor
	  */
	   
	 /** 
	  * M�todo CONSTRUTOR xRssGenerator para iniciar a variavel $file
	  * @access public 
	  * @return void
	  * @param String $filePath Localiza��o do arquivo.
	  */  
	 function xRssGenerator($filePath){
	 	$this->setFile($filePath);  
	 }
	
	 /**
	  * Gets e Sets
	  */
	  
	 /** 
	  * M�todo seCont para manipular(inserir) o atributo $cont. 
	  * @access public 
	  * @param integer $cont Vari�vel a ser inserida
	  * @return void
	  */   
	function setCont($cont){
		$this->cont = $cont;
	}
	 
	 /** 
	  * M�todo getCont para manipular(retornar) o atributo $cont. 
	  * @access public 
	  * @return integer
	  */  
	function getCont(){
		return $this->cont;
	}
	 
	 /** 
	  * M�todo setContErro para manipular(inserir) o atributo $contErro. 
	  * @access public 
	  * @param integer $cont Vari�vel a ser inserida
	  * @return void
	  */   
	function setContErro($contErro){
		$this->contErro = $contErro;                  
	}
	 
	 /** 
	  * M�todo getCont para manipular(retornar) o atributo $cont. 
	  * @access public 
	  * @return integer
	  */  
	function getContErro(){
		return $this->contErro;
	}
	 
	 /** 
	  * M�todo setErro para manipular(inserir) o atributo $erro. 
	  * @access public 
	  * @param String $cont Vari�vel a ser inserida
	  * @return void
	  */   	 
	function setErro($erro){
		$this->erro[$this->$contErro] = $erro;
		$this->setContErro($this->$contErro++);
	}
	 
	 /** 
	  * M�todo getErro para manipular(retornar) o atributo $erro. 
	  * @access public 
	  * @return String
	  */ 
	function getErro(){
		return $this->erro;
	}
	 
	 /** 
	  * M�todo setTravaCanal para manipular(inserir) o atributo $travaCanal. 
	  * @access public 
	  * @return void
	  */
	function setTravaCanal($travaCanal){
		$this->travaCanal = $travaCanal;
	}
	 
	 /** 
	  * M�todo getTravaCanal para manipular(retornar) o atributo $travaCanal. 
	  * @access public 
	  * @return boolean
	  */ 
	function getTravaCanal(){
		return $this->travaCanal;
	}
	 
	 /** 
	  * M�todo setTravaImagem para manipular(inserir) o atributo $tavaImagem. 
	  * @access public 
	  * @return void
	  */
	function setTravaImagem($tavaImagem){
		$this->travaImagem = $tavaImagem;
	}
	 
	 /** 
	  * M�todo getTravaImagem para manipular(retornar) o atributo $tavaImagem. 
	  * @access public 
	  * @return boolean
	  */ 
	function getTravaImagem(){
		return $this->travaImagem;
	}
	 
	 /** 
	  * M�todo setVersaoXML para manipular(inserir) o atributo $versaoXML. 
	  * @access public 
	  * @return void
	  */
	function setVersaoXML($versaoXML){
		$this->versaoXML = $versaoXML;
	}
	 
	 /** 
	  * M�todo getVersaoXML para manipular(retornar) o atributo $versaoXML. 
	  * @access public 
	  * @return String
	  */ 
	function getVersaoXML(){
		return $this->versaoXML;
	}
	 
	 /** 
	  * M�todo setVersaoRSS para manipular(inserir) o atributo $versaoRSS. 
	  * @access public 
	  * @return void
	  */	
	function setVersaoRSS($versaoRSS){
		$this->versaoRSS = $versaoRSS;
	}
	 
	 /** 
	  * M�todo getVersaoRSS para manipular(retornar) o atributo $versaoRSS. 
	  * @access public 
	  * @return String
	  */ 
	function getVersaoRSS(){
		return $this->versaoRSS;
	}
	 
	 /** 
	  * M�todo setEncoding para manipular(inserir) o atributo $encoding. 
	  * @access public 
	  * @return void
	  */
	function setEncoding($encoding){
		$this->encoding = $encoding;
	}
	 
	 /** 
	  * M�todo getEncoding para manipular(retornar) o atributo $encoding. 
	  * @access public 
	  * @return String
	  */ 
	function getEncoding(){
		return $this->encoding;
	}
	 
	 /** 
	  * M�todo setFile para manipular(inserir) o atributo $file. 
	  * @access public 
	  * @return void
	  */
	function setFile($filePath){
		$this->filePath = $filePath;
	}
	 
	 /** 
	  * M�todo getFile para manipular(retornar) o atributo $file. 
	  * @access public 
	  * @return String
	  */ 
	function getFile(){
		return $this->filePath;
	}
	 
	 /** 
	  * M�todo setCanal para manipular(inserir) o atributo $canal. 
	  * @access public 
	  * @return void
	  */
	function setCanal($canal){
		$this->canal = $canal;
	}
	 
	 /** 
	  * M�todo getCanal para manipular(retornar) o atributo $canal. 
	  * @access public 
	  * @return array
	  */ 
	function getCanal(){
		return $this->canal;
	}
	 
	 /** 
	  * M�todo setImagem para manipular(inserir) o atributo $imagem. 
	  * @access public 
	  * @return void
	  */
	function setImagem($imagem){
		$this->imagem = $imagem;
	}
	 
	 /** 
	  * M�todo getImagem para manipular(retornar) o atributo $imagem. 
	  * @access public 
	  * @return array
	  */ 
	function getImagem(){
		return $this->imagem;
	}
	 
	 /** 
	  * M�todo setTodosItens para manipular(inserir) o atributo $itens. 
	  * @access public 
	  * @return void
	  */
	function setTodosItens($itens){
		$this->todosItens[$this->cont] = $itens;
		$this->cont++;
	}
	 
	 /** 
	  * M�todo getTodosItens para manipular(retornar) o atributo $itens. 
	  * @access public 
	  * @return array of array
	  */ 
	function getTodosItens(){
		return $this->todosItens;
	}

	/**
	 * M�todos
	 */
	  
	 /** 
	  * M�todo insereCanal respons�vel por inserir um canal ao atributo $canal.
	  * @access public 
	  * @return void
	  */ 
	function insereCanal($canal){
		if(!$this->getTravaCanal()){
			if(!empty($canal)){
				$this->setCanal($canal);
				$this->setTravaCanal(true);	
			}
			else{
				$this->setErro("O canal inserido est� vazio.");
			}
		}
		else{
			$this->setErro("Um canal j� foi inserido.");
		}							
	}
	
	 /** 
	  * M�todo insereImagem respons�vel por inserir uma imagem ao atributo $imagem.
	  * @access public 
	  * @return void
	  */ 
	function insereImagem($imagem){
		if(!$this->getTravaImagem()){
			if(!empty($imagem)){
				$this->setImagem($imagem);	
			}
			else{
				$this->setErro("A imagem inserida est� vazia.");
			}	
		}
		else{
			$this->setErro("Uma imagem j� fopi inserida.");
		}
	}
	
	 /** 
	  * M�todo insereItem respons�vel por inserir um �tem no array de arrays $todosItens
	  * @access public 
	  * @return void
	  */ 
	function insereItem($item){
		if(!empty($item)){
			$this->setTodosItens($item);	
		}
		else{
			$this->setErro("O �tem inserido est� com seus campos vazios.");
		}		
	}
	
	 /** 
	  * M�todo geraXML respons�vel por gerar todo o documento XML.
	  * @access public 
	  * @return String
	  */ 
	function geraXML(){
		if(empty($this->$erro)){
		
			$xml  = "";
			$xml .= "<?xml version=\"".$this->getVersaoXML()."\" encoding=\"".$this->getEncoding()."\" ?>";
			$xml .= "<rss version=\"".$this->getVersaoRSS()."\">";
			$xml .= "<channel>";
				foreach($this->canal as $indice => $valor){
					$xml .= "<".$indice.">".$valor."</".$indice.">";			
				}
				$xml .= "<webMaster>kakitus@kakitus.com</webMaster>";
				$xml .= "<image>";
				foreach($this->imagem as $indice => $valor){
					$xml .= "<".$indice.">".$valor."</".$indice.">";			
				}
				$xml .= "</image>";
				foreach($this->todosItens as $indice => $valor){
					$xml .= "<item>";
					foreach($this->todosItens[$indice] as $indiceInterno => $valorInterno){
						$xml .= "<".$indiceInterno.">".$valorInterno."</".$indiceInterno.">";
					}
					$xml .= "</item>";	
				}
			$xml .= "</channel>";
			$xml .= "</rss>";
			
		}
		else{
			$qtdErros = count($this->erro);
			for($i=0; $i<$qtdErros; $i++){
				$Erro = new Errors($this->erro[$i], $qtdErros);
			}
		}
		
		return $xml;
	}
	
	 /** 
	  * M�todo geraRSS respons�vel por gerar todo o documento RSS e salv�-lo no $file definido.
	  * @access public 
	  * @return void
	  */
	 function geraRSS(){
	 	$file = $this->getFile();
	 	if(!empty($file)){
			$xml = $this->geraXML();
			$fp  = fopen($file, "w");
			fputs($fp, $xml);
			fclose($fp);
	    }
		else{
			$Erro = new Errors("O caminho para gerar o arquivo RSS n�o est� definido");
		} 
	}
};
?>