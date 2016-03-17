<?
/** 
* SpeceBraid
*
* Esta classe é responsavel por gerar um menu em árvore.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package tree
*/
 
$nivel = 1;
	  
class Tree{

	/** 
	* Atributo que irá armazenar o nome do campo do id do menu
	* @access private  
	* @name $idMenu
	* @var String
	*/
	var $idMenu;
	
	/** 
	* Atributo que irá armazenar o nome do campo do id do menu pai
	* @access private  
	* @name $idPai
	* @var String
	*/
	var $idPai;
	
	/** 
	* Atributo que irá armazenar o nome do campo da ordem à que esse menu pertence
	* @access private  
	* @name $ordemMenu
	* @var String
	*/
	var $ordemMenu;
	
	/** 
	* Atributo que irá armazenar o nome do campo do nome do menu
	* @access private  
	* @name $nomeMenu
	* @var String
	*/
	var $nomeMenu;
	
	/** 
	* Atributo que irá armazenar o nome do campo do link do menu
	* @access private  
	* @name $linkMenu
	* @var String
	*/
	var $linkMenu;
	
	/** 
	* Atributo que irá armazenar o nome da tabela
	* @access private  
	* @name $table
	* @var String
	*/
	var $table;
	
	/** 
	* Atributo que irá armazenar se os menus com filhoes terão link
	* @access private  
	* @name $linkSubMenu
	* @var boolean
	*/	
	var $linkSubMenu;
	  
	/** 
	* Atributo que irá armazenar o nome da árvore em javascript
	* @access private  
	* @name $nomeArvore
	* @var String
	*/		  
	var $nomeArvore = 'menu';
	
	/** 
	* Atributo que irá armazenar o objeto de manipulação do banco de dados.
	* @access private static
	* @name $db
	* @var DataBase
	*/	    	
	private $db;
	
	private $dirPageAlias;
	  
	/**
	* Construtor
	* __construct_Tree()
	*/
	public function __construct_Tree(){}
	
	/** 
	* Método que retorna o objeto de manipulação de dados.
	* @access public
	* @return DataBase
	*/    
	public function dataBase(){
		global $controlador;
		if(empty($this->db)){
			$this->db = $controlador['database'];
			return $this->db;
		}
		else{
			return $this->db;
		}
	}
		  
	/** 
	* Método CONSTRUTOR que inicializa os atributos passados como parâmetros.
	* @access public 
	* @param boolean $linkSubMenu
	* @return void
	*/  
	public function __go_Tree($linkSubMenu){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;		

		$this->idMenu    = $camposMap['noticiasrss'][0];	
		$this->idPai     = $camposMap['noticiasrss'][1];	
		$this->ordemMenu = $camposMap['noticiasrss'][2];
		$this->nomeMenu  = $camposMap['noticiasrss'][3];		
		$this->linkMenu  = $camposMap['noticiasrss'][4];		
		$this->table     = $tabelaMap['noticiasrss'];
		
		$this->dirPageAlias = "../pages";
		
		$this->linkSubMenu  = $linkSubMenu;	
	}
	
	function converteNome($nome){
  		$nome = ereg_replace("[^a-zA-Z0-9 _]", "", strtr($nome, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ'´`", "aaaaeeiooouucAAAAEEIOOOUUC"));
		$nome = str_replace(" ", "_", $nome);
		$nomeConvertido = strtolower($nome.".php");
		return $nomeConvertido;
	}

	/** 
	* Método que gera um link
	* @access public 
	* @param String $nome Nome do link a ser mostrado
	* @param String $link Link a ser gerado
	* @return String
	*/  
	function geraLink($nome, $link){
		$nomeLink = $this->converteNome($nome);
		$link = $this->dirPageAlias.'/'.$nomeLink;
		return "<a href = \"$link\">".$nome."</a>";
	}
	
	/** 
	* Método que retorna a lista com a árvore
	* @access public 
	* @return String
	*/  	
	function makeTree(){
		$sql   = "SELECT * FROM ".$this->table." ORDER BY ".$this->ordemMenu;
		$db    = $this->dataBase();
		$query = $db->query($sql);
		return $this->geraArvore($query, '');
	}
	
	/** 
	* Método que retorna a lista com a árvore modo administração
	* @access public 
	* @return String
	*/  	
	function makeTreeAdmin(){
		$sql   = "SELECT * FROM ".$this->table." ORDER BY ".$this->ordemMenu;
		$db    = $this->dataBase();
		$query = $db->query($sql);
		return $this->geraArvore($query, 'admin');
	}
		
	/** 
	* Método que gera a arvore
	* @access public 
	* @param query $query
	* @param String $tipo
	* @return String
	*/	
	function geraArvore($query, $tipo){
		global $nivel;
		
		$db = $this->dataBase();
		
		while($dados = $query->fetchRow(DB_FETCHMODE_ASSOC)){
			$idMenuLk    = $dados[$this->idMenu];
			$idPaiLk     = $dados[$this->idPai];
			$ordemMenuLk = $dados[$this->ordemMenu];
			$nomeMenuLk  = $dados[$this->nomeMenu];
			$linkMenuLk  = rawurlencode($dados[$this->linkMenu]);
			
			$sqlFilho   = "SELECT count(".$this->idMenu.") as total FROM ".$this->table." WHERE ".$this->idPai." = ".$idMenuLk;
			$queryFilho = $db->query($sqlFilho);
			$dadosFilho = $queryFilho->fetchRow(DB_FETCHMODE_ASSOC);
			
			if($tipo == 'admin'){
				$remover = " <a href=\"#\"><img src=\"../images/tree/remove.gif\" onClick=\"call_rmvCategoria($idMenuLk)\" border=\"0\" align=\"absmiddle\" alt=\"Remover Ítem\"/></a>";
				$ordem   = $ordemMenuLk." - ";  
			}
			
			if($dadosFilho['total'] > 0){
				if($idPaiLk == 0){ 
					$nivel = 1; 
				}
				
				if(!$this->linkSubMenu){
					if($tipo == 'admin'){						
						$lista .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$ordem.$nomeMenuLk.$remover."');";
					}
					else{
						$lista .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$nomeMenuLk."');";
					}
				}
				else{
					if($tipo == 'admin'){
						$lista .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$ordem.$this->geraLink($nomeMenuLk, $linkMenuLk).$remover."');";
					}
					else{
						$lista .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$this->geraLink($nomeMenuLk, $linkMenuLk)."');";
					}
				}
				
				$sqlNovo   = "SELECT * FROM ".$this->table." WHERE ".$this->idPai." = ".$this->idMenu;
				$queryNovo = $db->query($sqlNovo);			
				$nivel++;
				if($tipo == 'admin'){
					$this->geraArvore($queryNovo, 'admin');
				}
				else{
					$this->geraArvore($queryNovo, '');
				}
			}
			else{			
				$pontos  = explode(".", $ordemMenuLk);
				$nivel   = count($pontos);
				if($tipo == 'admin'){
					$lista  .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$ordem.$this->geraLink($nomeMenuLk, $linkMenuLk).$remover."');";	
				}
				else{
					$lista  .= $this->nomeArvore.".inserir_itens(".$nivel.",'".$this->geraLink($nomeMenuLk, $linkMenuLk)."');";
				}
			}
		}
		return $lista;
	}
	
	/** 
	* Método que gera cria uma página de "alias" para chamr o link com o rss
	* @access public 
	* @param String $name
	* @param String $link
	*/	
	function createPage($name, $link){
		$name = $this->converteNome($name);
		$link = rawurlencode($link);
		$conteudo .= '<?php';
		$conteudo .= "\n";
		$conteudo .= '$filtro = $_GET[\'filtro\'];';
		$conteudo .= "\n";
		$conteudo .= '$_GET[\'rss\'] = "'.$link.'";';
		$conteudo .= "\n";
		$conteudo .= 'if(!empty($filtro)){';
		$conteudo .= "\n";
		$conteudo .= '$_GET[\'filtro\'] = $filtro;';
		$conteudo .= "\n";
		$conteudo .= '}';
		$conteudo .= "\n";
		$conteudo .= 'include("../php/index.php");';
		$conteudo .= "\n";
		$conteudo .= '?>';
		$fp = fopen($this->dirPageAlias.'/'.$name, 'w+');
		fputs($fp, $conteudo);
		fclose($fp);
	}

	/** 
	* Método que gera adiciona um novo nodo
	* @access public 
	* @param String $nome Nome do nodo a ser inserido
	* @param String $feed Link do nodo a ser inserido
	* @param String $ordem Ordem do nodo a ser inserido
	*/	
	function addMenu($nome, $feed, $ordem){
	
		$db = $this->dataBase();
		
		if($ordem < 10){
			$ordem = "0".$ordem;
		}
	
		$lengthOrdem      = strlen($ordem);
		$ordemPai         = substr($ordem, 0, $lengthOrdem-2);
		$sqlConsultaPai   = "SELECT ".$this->idMenu." FROM ".$this->table." WHERE ".$this->ordemMenu." = '".$ordemPai."'";
		$queryConsultaPai = $db->query($sqlConsultaPai);
		$idPaiFetch       = $queryConsultaPai->fetchRow(DB_FETCHMODE_ASSOC);
		$idPai            = $idPaiFetch[$this->idMenu];
		
		if(empty($idPai) && !ereg('.', $ordem)){
			return false;
		}
		else{	
			$sql = "INSERT INTO ".$this->table." (".$this->idPai.", ".$this->ordemMenu.", ".$this->nomeMenu.", ".$this->linkMenu.") VALUES ('$idPai', '$ordem', '$nome', '$feed')";
			if($db->query($sql)){
				/* Criando as páginas */
				$this->createPage($nome, $feed);
				return true;
			}
		}	
	}
	
	/** 
	* Método que gera remove um nodo
	* @access public 
	* @param Integer $id id do nodo a ser removido
	*/	
	function rmvMenu($id){
	
		$db = $this->dataBase();
		
		/* Apagando a pagina criada */
		
		$sqlPage = "SELECT ".$this->nomeMenu." FROM ".$this->table." WHERE ".$this->idMenu." = $id";
		$queryPage = $db->query($sqlPage);
		$dadosPage = $queryPage->fetchRow(DB_FETCHMODE_ASSOC);
		$name      = $this->converteNome($dadosPage[$this->nomeMenu]);
		$file      = $this->dirPageAlias.'/'.$name;
		
		if(is_file($file)){
			unlink($file);
		}	
	
		$sqlCheck = "SELECT count(".$this->idMenu.") as total FROM ".$this->table." WHERE ".$this->idPai." = $id";
		$query = $db->query($sqlCheck);
		$dados = $query->fetchRow(DB_FETCHMODE_ASSOC);
		if($dados['total'] > 0){
			return false;
		}
		else{
			$db->query("DELETE FROM ".$this->table." WHERE ".$this->idMenu." = $id");
			return true;
		}
	}
	
	/** 
	* Método que gera limpa a lista de nodos
	* @access public 
	*/		
	function limparMenu(){
	
		$db = $this->dataBase();
	
		if($db->query("TRUNCATE TABLE ".$this->table)){
			return true;
		}
	}
}
?>