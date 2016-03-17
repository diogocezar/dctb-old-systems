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
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Parтmetro true (no mщtodo set) faz com que o mщtodo __toFillGeneric nуo seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* Mщtodo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	
	/** 
	* Mщtodo que conta quantos conhecimentos pertencem a um manifesto
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
	* Mщtodo que soma os pesos dos conhecimentos que pertencem a um manifesto
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
	* Mщtodo que soma os volumes dos conhecimentos que pertencem a um manifesto
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
	* Mщtodo que soma as notas fiscais dos conhecimentos que pertencem a um manifesto
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
	* Mщtodo que soma os fretes dos conhecimentos que pertencem a um manifesto
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
	* Mщtodo retorna os conhecimentos para a lista de saэda de manifesto
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
				AND c.idstatusconhecimento = 1"; // sѓ mostra conhecimentos em aberto
		
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
				AND c.idstatusconhecimento = 1";  // sѓ mostra conhecimentos em aberto
		}
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}
	}
	
	/** 
	* Mщtodo retorna os conhecimentos que estуo no array passado como parтmetro para geraчуo de relatѓrio.
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
	* Mщtodo que altera o status de um conhecimento
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
	* Mщtodo retorna uma lista de conhecimento e a indexaчуo de seu id
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
	* Mщtodo que altera os status de todos os conhecimentos de um array
	* @access public
	public function chanceStatusArrayCon($arrayConhecimentos, $status){
		foreach($arrayConhecimentos as $item){
			$this->chanceStatusCon($item, $status);
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
}
?>