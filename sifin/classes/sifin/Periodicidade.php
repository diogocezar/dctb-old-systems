<?php

class Periodicidade extends Generic{

	/**
	* Atributos
	*/
	protected
		$idperiodicidade,
		$descricao,
		$qtdnumerico,
		$tipoperiodo,
		$situacao,
		$databaixa;
		
	/**
	* Construtor
	* __construct_Periodicidade()
	*/
	public function __construct_Periodicidade(){}	
	
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
		
		$condicao = $camposMap['periodicidade'][0]." = ".$cod;
		
		$valores = array($this->getIdperiodicidade(),
				         $this->getDescricao(),
						 $this->getQtdnumerico(),
						 $this->getTipoperiodo(),
						 $this->getSituacao(),
						 $this->getDatabaixa()
						 );
					 		
		$this->setTabela($tabelaMap['periodicidade'], true);
		$this->setCampos($camposMap['periodicidade'], true);        
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
			
			$this->setId              ($dados[$this->campos[0]]);
			$this->setDescricao       ($dados[$this->campos[1]]);
			$this->setQtdnumerico     ($dados[$this->campos[2]]);
			$this->setTipoperido      ($dados[$this->campos[3]]);
			$this->setSituacao        ($dados[$this->campos[4]]);
			$this->setDatabaixa       ($dados[$this->campos[5]]);
		}
	}//__get
	
	/** 
	* Mщtodo que retorna a quantidade de dias a partir do id informado
	* @parm Integer $id
	* @access public
	*/  	
	public function getQtdNumericoAndTipoPeriodo($id){
		$this->__get_db($id);
		$retorno['qtdnumerico'] = $this->getQtdnumerico();
		$retorno['tipoperiodo'] = $this->getTipoperido();
		return $retorno;
	}//getQtdDias
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdperiodicidade();
	}
	
	function setId($id){
		$this->setIdperiodicidade($id);
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