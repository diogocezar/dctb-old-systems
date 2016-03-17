<?php
/** 
* SpeceBrain
*
* Esta classe é responsavel por gerar um arquivo XML nos padrões RSS.
* 
* @author xg0rd0 <xgordo@gmail.com> 
* @author WebÚnica Informática LTDA <contato@webunica.com.br> 
* @version 1.7
* @copyright Copyright © 2007
* @access public
* @package rss
*/

class RssGenerator{
	/** 
	* Atributo que irá armazenar os campos e os valores do canal do RSS.
	* @access private  
	* @name $canal
	* @var array
	*/
	private $canal = array();
	
	/** 
	* Atributo que irá armazenar os campos e os valores da imagem do RSS.
	* @access private  
	* @name $imagem
	* @var array
	*/ 
	private $imagem = array();
	
	/** 
	* Atributo que irá armazenar os campos e os valores de cada ítem do RSS.
	* @access private  
	* @name $todosItens
	* @var array
	*/
	private $todosItens = array();

	/**
	* Atributos de configuração onde serão armazenados configurações do documento RSS.
	**/
	 
	/** 
	* Atributo que irá armazenar qual o ultimo ítem que foi inserido, ao inserir o proximo, funciona como um ponteiro para o último ítem inserido.
	* @access private  
	* @name $cont
	* @var integer
	*/	
	private $cont = 0;
	
	/** 
	* Atributo que irá armazenar qual o ultimo erro que foi inserido, ao inserir o proximo, funciona como um ponteiro para o último erro inserido.
	* @access private  
	* @name $cont
	* @var integer
	*/	
	private $contErro = 0;
	
	/** 
	* Atributo responsável por "travar" um canal quando ele já tiver sido inserido.
	* @access private  
	* @name $travaCanal
	* @var boolean
	*/	 
	private $travaCanal = false;
	
	/** 
	* Atributo responsável por "travar" uma imagem quando ela já tiver sido inserida.
	* @access private  
	* @name $tavaImagem
	* @var boolean
	*/	
	private $tavaImagem = false;
	
	/** 
	* Atributo responsável por armazenar todos os erros eventuais que possam ocorrer.
	* @access private  
	* @name $erro
	* @var array
	*/  
	private $erroXml = array();
	
	/** 
	* Atributo responsável por armazenar a versão do XML no documento RSS.
	* @access private  
	* @name $versaoXML
	* @var String
	*/    
	private $versaoXML = "1.0";
	
	/** 
	* Atributo responsável por armazenar a versão do RSS.
	* @access private  
	* @name $versaoRSS
	* @var String
	*/   
	private $versaoRSS = "2.0";
	
	/** 
	* Atributo responsável por armazenar a versão do Encoding no documento RSS.
	* @access private  
	* @name $encoding
	* @var String
	* 
	*/   
	private $encoding = "ISO-8859-1";
	
	/** 
	* Atributo responsável por armazenar a localização que será gerado o arquivo RSS.
	* @access private  
	* @name $encoding
	* @var String
	*/   
	private $filePath = "";
	
	/**
	* Construtor
	* __construct_RssGenerator()
	*/
	public function __construct_RssGenerator(){}
	   
	/** 
	* Método para iniciar a variavel $filePath
	* @access public 
	* @return void
	* @param String $filePath Localização do arquivo.
	*/  
	public function __go_RssGenerator($filePath){
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
	public function setCont($cont){
		$this->cont = $cont;
	}//setCont
	 
	/** 
	* Método getCont para manipular(retornar) o atributo $cont. 
	* @access public 
	* @return integer
	*/  
	public function getCont(){
		return $this->cont;
	}//getCont
	 
	/** 
	* Método setContErro para manipular(inserir) o atributo $contErro. 
	* @access public 
	* @param integer $cont Variável a ser inserida
	* @return void
	*/   
	public function setContErro($contErro){
		$this->contErro = $contErro;                  
	}//setContErro
	 
	/** 
	* Método getCont para manipular(retornar) o atributo $cont. 
	* @access public 
	* @return integer
	*/  
	public function getContErro(){
		return $this->contErro;
	}//getContErro
	 
	/** 
	* Método setErro para manipular(inserir) o atributo $erro. 
	* @access public 
	* @param String $cont Variável a ser inserida
	* @return void
	*/   	 
	public function setErroXml($erro){
		$this->erroXml[$this->$contErro] = $erro;
		$this->setContErro($this->$contErro++);
	}//setErro
	 
	/** 
	* Método getErro para manipular(retornar) o atributo $erro. 
	* @access public 
	* @return String
	*/ 
	public function getErroXml(){
		return $this->erro;
	}//getErro
	 
	/** 
	* Método setTravaCanal para manipular(inserir) o atributo $travaCanal. 
	* @access public 
	* @return void
	*/
	public function setTravaCanal($travaCanal){
		$this->travaCanal = $travaCanal;
	}//setTravaCanal
	 
	/** 
	* Método getTravaCanal para manipular(retornar) o atributo $travaCanal. 
	* @access public 
	* @return boolean
	*/ 
	public function getTravaCanal(){
		return $this->travaCanal;
	}//getTravaCanal
	 
	/** 
	* Método setTravaImagem para manipular(inserir) o atributo $tavaImagem. 
	* @access public 
	* @return void
	*/
	public function setTravaImagem($tavaImagem){
		$this->travaImagem = $tavaImagem;
	}//setTravaImagem
	 
	/** 
	* Método getTravaImagem para manipular(retornar) o atributo $tavaImagem. 
	* @access public 
	* @return boolean
	*/ 
	public function getTravaImagem(){
		return $this->travaImagem;
	}//getTravaImagem
	 
	/** 
	* Método setVersaoXML para manipular(inserir) o atributo $versaoXML. 
	* @access public 
	* @return void
	*/
	public function setVersaoXML($versaoXML){
		$this->versaoXML = $versaoXML;
	}//setVersaoXML
	 
	/** 
	* Método getVersaoXML para manipular(retornar) o atributo $versaoXML. 
	* @access public 
	* @return String
	*/ 
	public function getVersaoXML(){
		return $this->versaoXML;
	}//getVersaoXML
	 
	/** 
	* Método setVersaoRSS para manipular(inserir) o atributo $versaoRSS. 
	* @access public 
	* @return void
	*/	
	public function setVersaoRSS($versaoRSS){
		$this->versaoRSS = $versaoRSS;
	}//setVersaoRSS
	 
	/** 
	* Método getVersaoRSS para manipular(retornar) o atributo $versaoRSS. 
	* @access public 
	* @return String
	*/ 
	public function getVersaoRSS(){
		return $this->versaoRSS;
	}//getVersaoRSS
	 
	/** 
	* Método setEncoding para manipular(inserir) o atributo $encoding. 
	* @access public 
	* @return void
	*/
	public function setEncoding($encoding){
		$this->encoding = $encoding;
	}//setEncoding
	 
	/** 
	* Método getEncoding para manipular(retornar) o atributo $encoding. 
	* @access public 
	* @return String
	*/ 
	public function getEncoding(){
		return $this->encoding;
	}//getEncoding
	 
	/** 
	* Método setFile para manipular(inserir) o atributo $file. 
	* @access public 
	* @return void
	*/
	public function setFile($filePath){
		$this->filePath = $filePath;
	}//setFile
	 
	/** 
	* Método getFile para manipular(retornar) o atributo $file. 
	* @access public 
	* @return String
	*/ 
	public function getFile(){
		return $this->filePath;
	}//getFile
	 
	/** 
	* Método setCanal para manipular(inserir) o atributo $canal. 
	* @access public 
	* @return void
	*/
	public function setCanal($canal){
		$this->canal = $canal;
	}//setCanal
	 
	/** 
	* Método getCanal para manipular(retornar) o atributo $canal. 
	* @access public 
	* @return array
	*/ 
	public function getCanal(){
		return $this->canal;
	}//getCanal
	 
	/** 
	* Método setImagem para manipular(inserir) o atributo $imagem. 
	* @access public 
	* @return void
	*/
	public function setImagem($imagem){
		$this->imagem = $imagem;
	}//setImagem
	 
	/** 
	* Método getImagem para manipular(retornar) o atributo $imagem. 
	* @access public 
	* @return array
	*/ 
	public function getImagem(){
		return $this->imagem;
	}//getImagem
	 
	/** 
	* Método setTodosItens para manipular(inserir) o atributo $itens. 
	* @access public 
	* @return void
	*/
	public function setTodosItens($itens){
		$this->todosItens[$this->cont] = $itens;
		$this->cont++;
	}//setTodosItens
	 
	/** 
	* Método getTodosItens para manipular(retornar) o atributo $itens. 
	* @access public 
	* @return array of array
	*/ 
	public function getTodosItens(){
		return $this->todosItens;
	}//getTodosItens

	/**
	 * Métodos
	 */
	  
	/** 
	* Método insereCanal responsável por inserir um canal ao atributo $canal.
	* @access public 
	* @return void
	*/ 
	public function insereCanal($canal){
		if(!$this->getTravaCanal()){
			if(!empty($canal)){
				$this->setCanal($canal);
				$this->setTravaCanal(true);	
			}
			else{
				$this->setErroXml($erro['CANAL_INSE_VAZI']);
			}
		}
		else{
			$this->setErroXml($erro['CANAL_JAH_INSER']);
		}							
	}//insereCanal
	
	/** 
	* Método insereImagem responsável por inserir uma imagem ao atributo $imagem.
	* @access public 
	* @return void
	*/ 
	public function insereImagem($imagem){
		if(!$this->getTravaImagem()){
			if(!empty($imagem)){
				$this->setImagem($imagem);	
			}
			else{
				$this->setErroXml($erro['IMAGEM_ES_VAZIA']);
			}	
		}
		else{
			$this->setErroXml($erro['IMAGEM_JAH_INSE']);
		}
	}//insereImagem
	
	/** 
	* Método insereItem responsável por inserir um ítem no array de arrays $todosItens
	* @access public 
	* @return void
	*/ 
	public function insereItem($item){
		if(!empty($item)){
			$this->setTodosItens($item);	
		}
		else{
			$this->setErroXml($erro['ITEM_CAMPOS_VAZ']);
		}		
	}//insereItem
	
	/** 
	* Método geraXML responsável por gerar todo o documento XML.
	* @access public 
	* @return String
	*/ 
	public function geraXML(){
		if(empty($this->$erroXml)){
		
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
			$qtdErros = count($this->erroXml);
			for($i=0; $i<$qtdErros; $i++){
				$erros .= $this->erroXml[$i].' | ';
			}
			$this->erro($erros);
		}
		
		return $xml;
	}//geraXML
	
	/** 
	* Método geraRSS responsável por gerar todo o documento RSS e salvá-lo no $file definido.
	* @access public 
	* @return void
	*/
	public function geraRSS(){
	 	$file = $this->getFile();
	 	if(!empty($file)){
			$xml = $this->geraXML();
			$fp  = fopen($file, "w");
			fputs($fp, $xml);
			fclose($fp);
	    }
		else{
			$this->erro($erro['CAMINHO_NOT_DEF']);
		} 
	}//geraRSS
	
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
}//RssGenerator
?>