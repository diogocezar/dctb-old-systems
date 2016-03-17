<?php

class Noticia extends Generic{

	/**
	* Atributos
	*/
	protected
		$id,
		$titulo,
		$autor,
		$descricao,
		$data;
	/**
	* Construtor
	* __construct_Noticia()
	*/
	public function __construct_Noticia(){}	
	
	/** 
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId();
		
		/* Parтmetro true, faz com que o mщtodo __toFillGeneric nуo seja chamado novamente */
		
		$condicao = $camposMap['noticia'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getTitulo(),
						 $this->getAutor(),
				         $this->getDescricao(),
						 $this->getData()
						 );
					 		
		$this->setTabela($tabelaMap['noticia'], true);
		$this->setCampos($camposMap['noticia'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setId($key);
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId             ($dados[$this->campos[0]]);
			$this->setTitulo         ($dados[$this->campos[1]]);
			$this->setAutor          ($dados[$this->campos[2]]);
			$this->setDescricao      ($dados[$this->campos[3]]);
			$this->setData           ($dados[$this->campos[4]]);
		}
	}//__get

	/** 
	* Mщtodo que extrai do banco de dados os ultimos n registros
	* @parm Integer $limite
	* @access public
	*/  	
	function lastNotices($limite){
		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " ORDER BY ";
		$sql .= $this->campos[0];
		$sql .= " DESC";
		$sql .= " LIMIT $limite";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;		
		}
	}
	
	public function queryNotices($sql){
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;		
		}
	}

	/** 
	* GETS e SETS
	* Mщtodo __call que щ verificado a cada chamada de uma funчуo da classe, o seguinte mщtodo implementa automaticamente as funчѕes de GET e SET.
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
}//Artigo
?>