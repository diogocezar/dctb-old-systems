<?php

class Conhecimento extends Body{

	/**
	* Atributos
	*/		
	protected
		$idconhecimento,
		$idmanifesto,
		$numero,
		$dataemissao,
		$idstatusconhecimento,
		$idclienteremetente,
		$idclientedestinatario,
		$peso,
		$volumes,
		$valornotafiscal,
		$valorfrete,
		$datacadastro,
		$databaixa,
		$situacao;
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Par�metro true (no m�todo set) faz com que o m�todo __toFillGeneric n�o seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* M�todo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	
	/** 
	* M�todo que conta quantos conhecimentos pertencem a um manifesto
	* @parm Integer $idManifesto
	* @access public
	*/
	public function getCountCtrcWithMan($idManifesto){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT count(*) as total_ctrc FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " AND ".$this->campos[1]." = ".$idManifesto;
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['total_ctrc'];
		}
	}
	
	/** 
	* M�todo que soma os pesos dos conhecimentos que pertencem a um manifesto
	* @parm Integer $idManifesto
	* @access public
	*/
	public function getSumPesoWithMan($idManifesto){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT sum(peso) as total_peso FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " AND ".$this->campos[1]." = ".$idManifesto;
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['total_peso'];
		}
	}
	
	/** 
	* M�todo que soma os volumes dos conhecimentos que pertencem a um manifesto
	* @parm Integer $idManifesto
	* @access public
	*/
	public function getSumVolWithMan($idManifesto){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT sum(volumes) as total_vol FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " AND ".$this->campos[1]." = ".$idManifesto;
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['total_vol'];
		}
	}
	
	/** 
	* M�todo que soma as notas fiscais dos conhecimentos que pertencem a um manifesto
	* @parm Integer $idManifesto
	* @access public
	*/
	public function getSumNfWithMan($idManifesto){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT sum(valornotafiscal) as total_nf FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " AND ".$this->campos[1]." = ".$idManifesto;
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['total_nf'];
		}
	}
	
	/** 
	* M�todo que soma os fretes dos conhecimentos que pertencem a um manifesto
	* @parm Integer $idManifesto
	* @access public
	*/
	public function getSumFreteWithMan($idManifesto){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT sum(valorfrete) as total_frete FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " AND ".$this->campos[1]." = ".$idManifesto;
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['total_frete'];
		}
	}
	
	/** 
	* M�todo retorna os conhecimentos para a lista de sa�da de manifesto
	* @access public
	*/
	public function getListOutMan($arraySelecionados){
		global $tabelaMap;
		global $camposMap;
		
		$inArray = "";
		
		if(!empty($arraySelecionados)){
			if(is_array($arraySelecionados)){
				$i = 0;
				foreach($arraySelecionados as $item){
					$inArray .= $item;
					$i++;
					if($i != count($arraySelecionados)){
						$inArray .= ", ";
					}
				}
			}
		}

		$sql = "SELECT c.numero as numconhecimento,
		        c.idconhecimento,
				f.razaosocial, 
				k.nome, 
				p.rua, p.numero, p.complemento, p.cidade, p.bairro, p.estado,
				c.volumes, c.peso, c.valornotafiscal, c.valorfrete 
				FROM conhecimento c, manifesto m, fornecedor f, cliente k, pessoa p
				WHERE c.idmanifesto = m.idmanifesto
				AND m.idfornecedor = f.idfornecedor
				AND k.idcliente = c.idclientedestinatario
				AND k.idpessoa = p.idpessoa
				AND c.idstatusconhecimento = 1"; // s� mostra conhecimentos em aberto
		
		if(!empty($inArray)){
		$sql .=	" UNION ";
		$sql .= "SELECT c.numero as numconhecimento,
		        c.idconhecimento,
				f.razaosocial, 
				k.nome, 
				p.rua, p.numero, p.complemento, p.cidade, p.bairro, p.estado,
				c.volumes, c.peso, c.valornotafiscal, c.valorfrete 
				FROM conhecimento c, manifesto m, fornecedor f, cliente k, pessoa p
				WHERE c.idmanifesto = m.idmanifesto
				AND m.idfornecedor = f.idfornecedor
				AND k.idcliente = c.idclientedestinatario
				AND k.idpessoa = p.idpessoa
				AND c.idconhecimento IN ($inArray)
				AND c.idstatusconhecimento = 1";  // s� mostra conhecimentos em aberto
		}
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}
	}
	
	/** 
	* M�todo retorna os conhecimentos que est�o no array passado como par�metro para gera��o de relat�rio.
	* @access public
	*/
	public function getListRelOutMan($arraySelecionados){
		global $tabelaMap;
		global $camposMap;
		
		$inArray = "";
		
		if(!empty($arraySelecionados)){
			if(is_array($arraySelecionados)){
				$i = 0;
				foreach($arraySelecionados as $item){
					$inArray .= $item;
					$i++;
					if($i != count($arraySelecionados)){
						$inArray .= ", ";
					}
				}
			}
		}
		
		$sql .= "SELECT c.numero as numconhecimento,
		        c.idconhecimento,
				f.razaosocial, 
				k.nome, 
				p.rua, p.numero, p.complemento, p.cidade, p.bairro, p.estado,
				c.volumes, c.peso, c.valornotafiscal, c.valorfrete 
				FROM conhecimento c, manifesto m, fornecedor f, cliente k, pessoa p
				WHERE c.idmanifesto = m.idmanifesto
				AND m.idfornecedor = f.idfornecedor
				AND k.idcliente = c.idclientedestinatario
				AND k.idpessoa = p.idpessoa
				AND c.idconhecimento IN ($inArray)";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}
	}
	
	/** 
	* M�todo que altera o status de um conhecimento
	* @access public
	*/
	public function chanceStatusCon($id, $status){
		$sql .= "UPDATE ".$this->getTabela();
		$sql .= " SET idstatusconhecimento = ".$status;
		$sql .= " WHERE idconhecimento = ".$id;
		$db = Generic::dataBase();
		$db->query($sql);
	}
	
	/** 
	* M�todo retorna uma lista de conhecimento e a indexa��o de seu id
	* @access public
	*/  	
	function _list(){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[0].", ".$this->campos[2]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[13]." = 'TRUE'";
		$sql .= " ORDER BY ".$this->campos[2]." ASC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//list	
	
	/** 
	* M�todo que altera os status de todos os conhecimentos de um array
	* @access public
	public function chanceStatusArrayCon($arrayConhecimentos, $status){
		foreach($arrayConhecimentos as $item){
			$this->chanceStatusCon($item, $status);
		}	
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
}
?>