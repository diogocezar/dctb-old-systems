<?php

class Parcela extends Generic{

	/**
	* Atributos
	*/
	protected
		$idparcela,
		$idconta,
		$valor,
		$datavencimento,
		$datapagamento,
		$situacao,
		$databaixa;

	/**
	* Construtor
	* __construct_Parcela()
	*/
	public function __construct_Parcela(){}	
	
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
		
		$condicao = $camposMap['parcela'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getIdconta(),
						 $this->getValor(),
				         $this->getDatavencimento(),
						 $this->getDatapagamento(),
						 $this->getSituacao(),
						 $this->getDatabaixa(),
						 );
					 		
		$this->setTabela($tabelaMap['parcela'], true);
		$this->setCampos($camposMap['parcela'], true);        
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
			$this->setIdconta        ($dados[$this->campos[1]]);
			$this->setValor          ($dados[$this->campos[2]]);
			$this->setDatavencimento ($dados[$this->campos[3]]);
			$this->setDatapagamento  ($dados[$this->campos[4]]);
			$this->setSituacao       ($dados[$this->campos[5]]);
			$this->setDatabaixa      ($dados[$this->campos[6]]);
		}
	}//__get
	
	/** 
	* Mщtodo que exclui todas as parcelas de uma conta
	* @parm Integer $conta
	* @access public
	*/  	
	function deleteParcelas($conta){
		$sql .= "DELETE FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[1]." = $conta";
		
		$db = Generic::dataBase();
		$db->query($sql);
	}//deleteParcelas
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdparcela();
	}
	
	function setId($id){
		$this->setIdparcela($id);
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