<?
/**
* A seguir são colocados os arquivos incluidos e suas respectivas descrições.
*/

/**
* Incluindo impressão de erros.
*/
#require_once("Errors.php");

	  /** 
	  * Esta classe é responsavel por listar arquivos e diretórios de um diretório padrão
	  *
	  * @author xg0rd0 <xgordo@gmail.com> 
	  * @access public
	  * @package Files
	  */

class Files{

	/** 
      * Atributo que irá armazenar o diretório das fotos da galeria.
      * @access private  
      * @name $diretorio
	  * @var String
      */
	var $diretorio;
	
	var $arrayArquivos;
	
	 /** 
	  * Método CONSTRUTOR que inicializa os atributos passados como parâmetros.
	  * @access public 
	  * @param String $diretorio
	  * @param integer $qtdFotosPP
	  * @return void
	  */  
	function Files($diretorio){
		$this->diretorio = $diretorio;
		$this->scanDire();
	}
	
	 /** 
	  * Método que conta quantos arquivos existem no diretório setado pelo método construtor.
	  * @access public 
	  * @return void
	  */  
	function countDir(){
		$countFiles = 0;
		$countFolders = 0;
		$dirFiles = $this->scanDire($this->diretorio);
        $quantos = count($dirFiles);
        for($i=0;$i<$quantos;$i++){
			$subDir = $this->diretorio."/$dirFiles[$i]";
			$subDirFiles = $this->scanDire($subDir);
			$subQuantos = count($subDirFiles);
			$countFolders++;
			for($j=0;$j<$subQuantos;$j++){
				$countFiles++;
			}
        }
		$this->qtdFotos   = $countFiles;
		$this->qtdSessoes = $countFolders;
	}
	
	 /** 
	  * Método gera um array com as pastas do diretório setado no método construtor.
	  * @access public 
	  * @return Array $arrayPastas
	  */  
	function arrayFolders(){
		$dirFiles = $this->scanDire($this->diretorio);
		$quantos = count($dirFiles);
		$count = 0;
		for($i=0;$i<$quantos;$i++){
			if(is_dir($this->diretorio.'/'.$dirFiles[$i])){
				$arrayPastas[$count] = $dirFiles[$i];
				$count++;
			}
		}
		return $arrayPastas;	
	}
	
	 /** 
	  * Método mostra as fotos de um subdiretório passado como parâmetro.
	  * @access public 
	  * @param String $subDir Subdiretório que irá ser mostrado.
	  * @param String $page Página que irá ser direcionado nas paginações.
	  * @param boolean $scalar Define se as imagens são escalares ou não
	  * @param boolean $printFileName Define se o nome do arquivo será exibido.
	  * @param boolean $printSize Define se o tamanho do arquivo será exibido.
	  * @return void
	  */  
	function showFiles(){
		$retorno = "";
		$retorno .= "<br>";
		$retorno .= "Materiais disponíveis : <br><br>";
		if(!empty($this->arrayArquivos)){
			foreach($this->arrayArquivos as $num => $arquivo){
				$ext = $this->getExtension($arquivo);
				$diretorioCompleto = $this->diretorio."/$arquivo";
				if(file_exists("../icones/$ext.jpg")){
					$icone = "../icones/$ext.jpg";
				}
				else{
					$icone = "../icones/empty.jpg";
				}
				$retorno .= "<img src=\"$icone\" border=\"0\" align=\"absmiddle\"/> ";
				if($ext == "dir"){ $link = getPaginaAtual()."?folder=".$diretorioCompleto; } else{ $link = $diretorioCompleto; } 
				$retorno .= "<a href =\"$link\" class=\"link_escuro\">";
				$retorno .= $arquivo;
				$retorno .= "</a>";
				$retorno .= "<br><br>";
			}
		}
		else{
			$retorno .= "Não existem arquivos disponíveis nesta pasta !";
		}
		$retorno .= $this->printVoltar();
		return $retorno;
	}
	
	 /** 
	  * Método retorna o tamanho do diretório passado como parâmetro.
	  * @access public 
	  * @param String $dir
	  * @return float
	  */  
	function dirSize($dir){
		$files = $this->scanDire($dir);
		$quanto = 0;
		for($i=0; $i<count($files); $i++){
			$quanto += filesize($dir.'/'.$files[$i]);
		}
		return (($quanto/1024)/1000);
	}
	
	 /** 
	  * Método retorna o tamanho do arquivo passado como parâmetro.
	  * @access public 
	  * @param String $dirFoto
	  * @return float
	  */  
	function fileSize($dirFoto){
		$quanto = filesize($dirFoto);
		return (($quanto/1024));
	}
	
	 /** 
	  * Método retorna a extensão do arquivo passado como parâmetro.
	  * @access public 
	  * @param String $file Arquivo que irá ser verificado.
	  * @return String
	  */  
	function getExtension($file){
		if(is_dir($this->diretorio.'/'.$file)){
			return "dir";	
		}
		else{
			$qtd = strlen($file);
			$ext = strtolower(substr($file, ($qtd-3), $qtd));
			return $ext;
		}
	}
	
	 /** 
	  * Método retorna um array com os arquivos de um diretório, limitados por 2 parâmetros, De e Até.
	  * @access public 
	  * @param String $diretorio Diretório que irá ser escaneado.
	  * @param integer $limiteDe Limite de.
	  * @param integer $limiteAte Limite até.
	  * @return Array
	  */  
	function scanDire(){
		$open = opendir($this->diretorio);
		$i=0;
		while(false !== ($file = readdir($open))){
			if($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.php"){
				$ext = $this->getExtension($file);
				if($ext == "zip" || $ext == "doc" || $ext == "txt" || $ext == "pdf" || $ext = "dir"){
					$dir[$i++] = $file;
				}
			}
		}
		$this->arrayArquivos = $dir;			  
	}
	 /** 
	  * Método retorna imprime/retorna o voltar
	  * @access public 
	  * @param String $iconeVoltar Icone voltar.
	  * @param String $linkPrincipal Link principal.
	  * @param String $msgVoltar Mensagem a ser exibida.
	  * @return void
	  */  
	function printVoltar(){
		$retorno .= "<br><br>";
		$retorno .= "<div align=\"center\">";
		$retorno .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\">";
		$retorno .= "</div><br>";		
		return $retorno;
	}
}
?>