<?php

class Empresa extends Generic{

	/**
	* Atributos
	*/
	protected
		$id,
		$nome,
		$descricao,
		$logo,
		$foto1,
		$foto2,
		$foto3,
		$foto4,
		$foto5,
		$foto6;
		
	/**
	* Construtor
	* __construct_Empresa()
	*/
	public function __construct_Empresa(){}	
	
	/** 
	* Método que será implementado nas classes herdeiras, esse método deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId();
		
		/* Parâmetro true, faz com que o método __toFillGeneric não seja chamado novamente */
		
		$condicao = $camposMap['empresa'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getNome(),
				         $this->getDescricao(),
						 $this->getLogo(),
						 $this->getFoto1(),
						 $this->getFoto2(),
						 $this->getFoto3(),
						 $this->getFoto4(),
						 $this->getFoto5(),
						 $this->getFoto6()
						 );
					 		
		$this->setTabela($tabelaMap['empresa'], true);
		$this->setCampos($camposMap['empresa'], true);        
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
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId              ($dados[$this->campos[0]]);
			$this->setNome            ($dados[$this->campos[1]]);
			$this->setDescricao       ($dados[$this->campos[2]]);
			$this->setLogo            ($dados[$this->campos[3]]);
			$this->setFoto1           ($dados[$this->campos[4]]);
			$this->setFoto2           ($dados[$this->campos[5]]);
			$this->setFoto3           ($dados[$this->campos[6]]);
			$this->setFoto4           ($dados[$this->campos[7]]);
			$this->setFoto5           ($dados[$this->campos[8]]);
			$this->setFoto6           ($dados[$this->campos[9]]);
		}
	}//__get

	/** 
	* Método que exclue todas as fotos do objeto
	* @access public
	*/  
	function deletePictures(){
		for($i=0; $i<6; $i++) $this->deletePicture($i);
	}

	/** 
	* Método que exclue uma foto do objeto
	* @parm Integer $indice
	* @access public
	*/  
	function deletePicture($indice){
		$delete[0] = $this->logo;
		$delete[1] = $this->foto1;
		$delete[2] = $this->foto2;
		$delete[3] = $this->foto3;
		$delete[4] = $this->foto4;
		$delete[5] = $this->foto5;
		$delete[6] = $this->foto6;
		
		if(file_exists($delete[$indice])){
			unlink($delete[$indice]);
		}
	}
	
	/** 
	* Método que retorna o resultado de uma query
	* @parm String $sql
	* @access public
	*/
	function query($sql){
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;		
		}
	}
	
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
}//Artigo
?>