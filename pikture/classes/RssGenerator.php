<?php
/**
* A seguir são colocados os arquivos incluidos e suas respectivas descrições.
*/

/**
* Incluindo impressão de erros.
*/
include("Errors.php");

	  /** 
	  * Esta classe é responsavel por gerar um arquivo XML nos padrões RSS
	  *
	  * @author xg0rd0 <xgordo@kakitus.com> 
	  * @version 1.0
	  * @copyright Copyright © 2005, Kakirus.com LTDA. 
	  * @access public
	  * @package Rss
	  */

class xRssGenerator{
	  /** 
      * Atributo que irá armazenar os campos e os valores do canal do RSS.
      * @access private  
      * @name $canal
	  * @var array
      */
	var $canal      = array();
	
      /** 
      * Atributo que irá armazenar os campos e os valores da imagem do RSS.
      * @access private  
      * @name $imagem
	  * @var array
      **/ 
	var $imagem     = array();
	
      /** 
      * Atributo que irá armazenar os campos e os valores de cada ítem do RSS.
      * @access private  
      * @name $todosItens
	  * @var array
      **/
	var $todosItens = array();

      /**
	  * Atributos de configuração onde serão armazenados configurações do documento RSS.
	  **/
	 	 
	  /** 
      * Atributo que irá armazenar qual o ultimo ítem que foi inserido, ao inserir o proximo, funciona como um ponteiro para o último ítem inserido.
      * @access private  
      * @name $cont
	  * @var integer
      */	
	var $cont       = 0;
	
      /** 
      * Atributo que irá armazenar qual o ultimo erro que foi inserido, ao inserir o proximo, funciona como um ponteiro para o último erro inserido.
      * @access private  
      * @name $cont
	  * @var integer
      */	
	var $contErro   = 0;
	
	  /** 
      * Atributo responsável por "travar" um canal quando ele já tiver sido inserido.
      * @access private  
      * @name $travaCanal
	  * @var boolean
      */	 
	var $travaCanal = false;
	
	 /** 
      * Atributo responsável por "travar" uma imagem quando ela já tiver sido inserida.
      * @access private  
      * @name $tavaImagem
	  * @var boolean
      */	
	var $tavaImagem = false;
	
	 /** 
      * Atributo responsável por armazenar todos os erros eventuais que possam ocorrer.
      * @access private  
      * @name $erro
	  * @var array
      */  
	var $erro       = array();
	
	 /** 
      * Atributo responsável por armazenar a versão do XML no documento RSS.
      * @access private  
      * @name $versaoXML
	  * @var String
      */    
	var $versaoXML  = "1.0";
	
	 /** 
      * Atributo responsável por armazenar a versão do RSS.
      * @access private  
      * @name $versaoRSS
	  * @var String
      */   
	var $versaoRSS  = "2.0";
	
	 /** 
       * Atributo responsável por armazenar a versão do Encoding no documento RSS.
       * @access private  
       * @name $encoding
	   * @var String
	   * 
       **/   
	var $encoding   = "ISO-8859-1";
	
	 /** 
      * Atributo responsável por armazenar a localização que será gerado o arquivo RSS.
      * @access private  
      * @name $encoding
	  * @var String
      */   
	var $filePath   = "";
	
	 /**
	  * Construtor
	  */
	   
	 /** 
	  * Método CONSTRUTOR xRssGenerator para iniciar a variavel $file
	  * @access public 
	  * @return void
	  * @param String $filePath Localização do arquivo.
	  */  
	 function xRssGenerator($filePath){
	 	$this->setFile($filePath);  
	 }
	
	 /**
	  * Gets e Sets
	  */
	  
	 /** 
	  * Método seCont para manipular(inserir) o atributo $cont. 
	  * @access public 
	  * @param integer $cont Variável a ser inserida
	  * @return void
	  */   
	function setCont($cont){
		$this->cont = $cont;
	}
	 
	 /** 
	  * Método getCont para manipular(retornar) o atributo $cont. 
	  * @access public 
	  * @return integer
	  */  
	function getCont(){
		return $this->cont;
	}
	 
	 /** 
	  * Método setContErro para manipular(inserir) o atributo $contErro. 
	  * @access public 
	  * @param integer $cont Variável a ser inserida
	  * @return void
	  */   
	function setContErro($contErro){
		$this->contErro = $contErro;                  
	}
	 
	 /** 
	  * Método getCont para manipular(retornar) o atributo $cont. 
	  * @access public 
	  * @return integer
	  */  
	function getContErro(){
		return $this->contErro;
	}
	 
	 /** 
	  * Método setErro para manipular(inserir) o atributo $erro. 
	  * @access public 
	  * @param String $cont Variável a ser inserida
	  * @return void
	  */   	 
	function setErro($erro){
		$this->erro[$this->$contErro] = $erro;
		$this->setContErro($this->$contErro++);
	}
	 
	 /** 
	  * Método getErro para manipular(retornar) o atributo $erro. 
	  * @access public 
	  * @return String
	  */ 
	function getErro(){
		return $this->erro;
	}
	 
	 /** 
	  * Método setTravaCanal para manipular(inserir) o atributo $travaCanal. 
	  * @access public 
	  * @return void
	  */
	function setTravaCanal($travaCanal){
		$this->travaCanal = $travaCanal;
	}
	 
	 /** 
	  * Método getTravaCanal para manipular(retornar) o atributo $travaCanal. 
	  * @access public 
	  * @return boolean
	  */ 
	function getTravaCanal(){
		return $this->travaCanal;
	}
	 
	 /** 
	  * Método setTravaImagem para manipular(inserir) o atributo $tavaImagem. 
	  * @access public 
	  * @return void
	  */
	function setTravaImagem($tavaImagem){
		$this->travaImagem = $tavaImagem;
	}
	 
	 /** 
	  * Método getTravaImagem para manipular(retornar) o atributo $tavaImagem. 
	  * @access public 
	  * @return boolean
	  */ 
	function getTravaImagem(){
		return $this->travaImagem;
	}
	 
	 /** 
	  * Método setVersaoXML para manipular(inserir) o atributo $versaoXML. 
	  * @access public 
	  * @return void
	  */
	function setVersaoXML($versaoXML){
		$this->versaoXML = $versaoXML;
	}
	 
	 /** 
	  * Método getVersaoXML para manipular(retornar) o atributo $versaoXML. 
	  * @access public 
	  * @return String
	  */ 
	function getVersaoXML(){
		return $this->versaoXML;
	}
	 
	 /** 
	  * Método setVersaoRSS para manipular(inserir) o atributo $versaoRSS. 
	  * @access public 
	  * @return void
	  */	
	function setVersaoRSS($versaoRSS){
		$this->versaoRSS = $versaoRSS;
	}
	 
	 /** 
	  * Método getVersaoRSS para manipular(retornar) o atributo $versaoRSS. 
	  * @access public 
	  * @return String
	  */ 
	function getVersaoRSS(){
		return $this->versaoRSS;
	}
	 
	 /** 
	  * Método setEncoding para manipular(inserir) o atributo $encoding. 
	  * @access public 
	  * @return void
	  */
	function setEncoding($encoding){
		$this->encoding = $encoding;
	}
	 
	 /** 
	  * Método getEncoding para manipular(retornar) o atributo $encoding. 
	  * @access public 
	  * @return String
	  */ 
	function getEncoding(){
		return $this->encoding;
	}
	 
	 /** 
	  * Método setFile para manipular(inserir) o atributo $file. 
	  * @access public 
	  * @return void
	  */
	function setFile($filePath){
		$this->filePath = $filePath;
	}
	 
	 /** 
	  * Método getFile para manipular(retornar) o atributo $file. 
	  * @access public 
	  * @return String
	  */ 
	function getFile(){
		return $this->filePath;
	}
	 
	 /** 
	  * Método setCanal para manipular(inserir) o atributo $canal. 
	  * @access public 
	  * @return void
	  */
	function setCanal($canal){
		$this->canal = $canal;
	}
	 
	 /** 
	  * Método getCanal para manipular(retornar) o atributo $canal. 
	  * @access public 
	  * @return array
	  */ 
	function getCanal(){
		return $this->canal;
	}
	 
	 /** 
	  * Método setImagem para manipular(inserir) o atributo $imagem. 
	  * @access public 
	  * @return void
	  */
	function setImagem($imagem){
		$this->imagem = $imagem;
	}
	 
	 /** 
	  * Método getImagem para manipular(retornar) o atributo $imagem. 
	  * @access public 
	  * @return array
	  */ 
	function getImagem(){
		return $this->imagem;
	}
	 
	 /** 
	  * Método setTodosItens para manipular(inserir) o atributo $itens. 
	  * @access public 
	  * @return void
	  */
	function setTodosItens($itens){
		$this->todosItens[$this->cont] = $itens;
		$this->cont++;
	}
	 
	 /** 
	  * Método getTodosItens para manipular(retornar) o atributo $itens. 
	  * @access public 
	  * @return array of array
	  */ 
	function getTodosItens(){
		return $this->todosItens;
	}

	/**
	 * Métodos
	 */
	  
	 /** 
	  * Método insereCanal responsável por inserir um canal ao atributo $canal.
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
				$this->setErro("O canal inserido está vazio.");
			}
		}
		else{
			$this->setErro("Um canal já foi inserido.");
		}							
	}
	
	 /** 
	  * Método insereImagem responsável por inserir uma imagem ao atributo $imagem.
	  * @access public 
	  * @return void
	  */ 
	function insereImagem($imagem){
		if(!$this->getTravaImagem()){
			if(!empty($imagem)){
				$this->setImagem($imagem);	
			}
			else{
				$this->setErro("A imagem inserida está vazia.");
			}	
		}
		else{
			$this->setErro("Uma imagem já fopi inserida.");
		}
	}
	
	 /** 
	  * Método insereItem responsável por inserir um ítem no array de arrays $todosItens
	  * @access public 
	  * @return void
	  */ 
	function insereItem($item){
		if(!empty($item)){
			$this->setTodosItens($item);	
		}
		else{
			$this->setErro("O ítem inserido está com seus campos vazios.");
		}		
	}
	
	 /** 
	  * Método geraXML responsável por gerar todo o documento XML.
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
	  * Método geraRSS responsável por gerar todo o documento RSS e salvá-lo no $file definido.
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
			$Erro = new Errors("O caminho para gerar o arquivo RSS não está definido");
		} 
	}
};
?>