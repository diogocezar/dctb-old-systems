<?php

class Conta extends Generic{

	/**
	* Atributos
	*/
	protected
		$idconta,
		$idusuario,
		$idusuariobaixa,
		$idtipodocumento,
		$idperiodicidade,
		$idbanco,
		$idpessoa,
		$documento,
		$datacadastro,
		$descricao,
		$numparcelas,
		$valortotal,
		$tipoconta,
		$situacao,
		$databaixa;
		
	/**
	* Construtor
	* __construct_Conta()
	*/
	public function __construct_Conta(){}	
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId();
		
		/* Par�metro true, faz com que o m�todo __toFillGeneric n�o seja chamado novamente */
		
		$condicao = $camposMap['conta'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getIdusuario(),
						 $this->getIdusuariobaixa(),
				         $this->getIdtipodocumento(),
						 $this->getIdperiodicidade(),
						 $this->getIdbanco(),
						 $this->getIdpessoa(),
						 $this->getDocumento(),
						 $this->getDatacadastro(),
						 $this->getDescricao(),
						 $this->getNumparcelas(),
						 $this->getValortotal(),
						 $this->getTipoconta(),
						 $this->getSituacao(),
						 $this->getDatabaixa(),
						 );
					 		
		$this->setTabela($tabelaMap['conta'], true);
		$this->setCampos($camposMap['conta'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
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
			$this->setIdusuario       ($dados[$this->campos[1]]);
			$this->setIdusuariobaixa  ($dados[$this->campos[2]]);
			$this->setIdtipodocumento ($dados[$this->campos[3]]);
			$this->setIdperiodicidade ($dados[$this->campos[4]]);
			$this->setIdbanco         ($dados[$this->campos[5]]);
			$this->setIdpessoa        ($dados[$this->campos[6]]);
			$this->setDocumento       ($dados[$this->campos[7]]);
			$this->setDatacadastro    ($dados[$this->campos[8]]);
			$this->setDescricao       ($dados[$this->campos[9]]);
			$this->setNumparcelas     ($dados[$this->campos[10]]);
			$this->setValortotal      ($dados[$this->campos[11]]);
			$this->setTipoconta       ($dados[$this->campos[12]]);
			$this->setSituacao        ($dados[$this->campos[13]]);
			$this->setDatabaixa       ($dados[$this->campos[14]]);

		}
	}//__get
	
	/** 
	* M�todo que retorna as parcelas de uma conta
	* @parm Integer $conta
	* @access public
	*/  	
	function getAllParcelas($conta){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT p.".$camposMap['parcela'][0].", p.".$camposMap['parcela'][1].", p.".$camposMap['parcela'][2].", to_char(p.".$camposMap['parcela'][3].", 'DD/MM/YYYY') as ".$camposMap['parcela'][3].", p.".$camposMap['parcela'][5]." FROM ";
		$sql .= $this->getTabela()." c, ".$tabelaMap['parcela']." p";
		$sql .= " WHERE p.".$camposMap['parcela'][1]." = c.".$this->campos[0];
		//$sql .= " AND p.".$camposMap['parcela'][5]." = 'TRUE'";
		$sql .= " AND p.".$camposMap['parcela'][1]." = ".$conta;
		$sql .= " ORDER BY date(".$camposMap['parcela'][3].") ASC";
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//getAllParcelas
	
	/** 
	* M�todo que retorna as parcelas de uma conta n�o pagas at� uma data
	* @parm Integer $conta
	* @parm Integer $data
	* @access public
	*/  	
	function getAllParcelasByDate($data){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT p.".$camposMap['parcela'][0].", p.".$camposMap['parcela'][1].", p.".$camposMap['parcela'][2].", to_char(p.".$camposMap['parcela'][3].", 'DD/MM/YYYY') as ".$camposMap['parcela'][3].", p.".$camposMap['parcela'][5].", c.".$this->campos[7]." FROM ";
		$sql .= $this->getTabela()." c, ".$tabelaMap['parcela']." p";
		$sql .= " WHERE p.".$camposMap['parcela'][1]." = c.".$this->campos[0];
		$sql .= " AND p.".$camposMap['parcela'][5]." = 'TRUE'";
		$sql .= " AND p.".$camposMap['parcela'][3]." <= '".$data."'";
		$sql .= " ORDER BY date(".$camposMap['parcela'][3].") ASC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//getAllParcelas
	
	/** 
	* Fun��es para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdconta();
	}
	
	function setId($id){
		$this->setIdconta($id);
	}
	
	/** 
	* GETS e SETS
	* M�todo __call que � verificado a cada chamada de uma fun��o da classe, o seguinte m�todo implementa automaticamente as fun��es de GET e SET.
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