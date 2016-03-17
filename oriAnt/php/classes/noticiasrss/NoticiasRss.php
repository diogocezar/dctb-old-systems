<?php

class NoticiasRss extends Generic{

	/**
	* Atributos
	*/
	protected
		$id         = '',
		$id_pai     = '',
		$ordem      = '',
		$nome       = '',
		$link       = '',
		$xml        = '',
		$qtd        = '',
		$quando     = '';
	
	/**
	* Construtor
	* __construct_NoticiasRss()
	*/
	public function __construct_NoticiasRss(){
		$this->__toFillGeneric();
	}	
	
	/** 
	* Método que será implementado nas classes herdeiras, esse método deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$id = $this->getId();
		
		/* Parâmetro true, faz com que o método __toFillGeneric não seja chamado novamente */
		
		$condicao = $camposMap['noticiasrss'][0]." = ".$id;
		
		$valores = array($this->getId(),
						 $this->getId_pai(),
		                 $this->getOrdem(),
						 $this->getNome(),
						 $this->getLink(),
						 $this->getXml(),
						 $this->getQtd(),
						 $this->getQuando(),
						 );
						 		
		$this->setTabela($tabelaMap['noticiasrss'], true);
		$this->setCampos($camposMap['noticiasrss'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Método que extrai do banco de dados um registro com determinado índice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setId($key);
		
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId         ($dados[$this->campos[0]]);
			$this->setId_pai     ($dados[$this->campos[1]]);
			$this->setOrdem      ($dados[$this->campos[2]]);
			$this->setNome       ($dados[$this->campos[3]]);
			$this->setLink       ($dados[$this->campos[4]]);
			$this->setXml        ($dados[$this->campos[5]]);
			$this->setQtd        ($dados[$this->campos[6]]);
			$this->setQuando     ($dados[$this->campos[7]]);
		}
	}//__get

	/** 
	* Método que extrai do banco de dados o nome da notícia a partir de seu link
	* @parm String $link
	* @access public
	*/  
	public function getNameNew($link){
		$sql .= "SELECT ".$this->campos[3]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[4];
		$sql .= " = '";
		$sql .= $link;
		$sql .= "'";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[3]];
		}
	}
	
	/** 
	* Método que extrai do banco de dados um registro com determinado endereço.
	* @parm String $key
	* @access public
	*/  
	public function __get_db_endereco($endereco){
	
		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[4];
		$sql .= " = '";
		$sql .= $endereco;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId         ($dados[$this->campos[0]]);
			$this->setId_pai     ($dados[$this->campos[1]]);
			$this->setOrdem      ($dados[$this->campos[2]]);
			$this->setNome       ($dados[$this->campos[3]]);
			$this->setLink       ($dados[$this->campos[4]]);
			$this->setXml        ($dados[$this->campos[5]]);
			$this->setQtd        ($dados[$this->campos[6]]);
			$this->setQuando     ($dados[$this->campos[7]]);
		}
	}//__get_db_endereco

	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
			if(empty($parametros[1])){
				$this->__toFillGeneric();
			}
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Comentarios
?>