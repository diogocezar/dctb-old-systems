<?
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo impress�o de erros.
*/
#require_once("Errors.php");

	  /** 
	  * Esta classe � responsavel por listar arquivos e diret�rios de um diret�rio padr�o
	  *
	  * @author xg0rd0 <xgordo@gmail.com> 
	  * @access public
	  * @package Files
	  */

class Files{

	/** 
      * Atributo que ir� armazenar o diret�rio das fotos da galeria.
      * @access private  
      * @name $diretorio
	  * @var String
      */
	var $diretorio;
	
	var $arrayArquivos;
	
	 /** 
	  * M�todo CONSTRUTOR que inicializa os atributos passados como par�metros.
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
	  * M�todo que conta quantos arquivos existem no diret�rio setado pelo m�todo construtor.
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
	  * M�todo gera um array com as pastas do diret�rio setado no m�todo construtor.
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
	  * M�todo mostra as fotos de um subdiret�rio passado como par�metro.
	  * @access public 
	  * @param String $subDir Subdiret�rio que ir� ser mostrado.
	  * @param String $page P�gina que ir� ser direcionado nas pagina��es.
	  * @param boolean $scalar Define se as imagens s�o escalares ou n�o
	  * @param boolean $printFileName Define se o nome do arquivo ser� exibido.
	  * @param boolean $printSize Define se o tamanho do arquivo ser� exibido.
	  * @return void
	  */  
	function showFiles(){
		$retorno = "";
		$retorno .= "<br>";
		$retorno .= "Materiais dispon�veis : <br><br>";
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
			$retorno .= "N�o existem arquivos dispon�veis nesta pasta !";
		}
		$retorno .= $this->printVoltar();
		return $retorno;
	}
	
	 /** 
	  * M�todo retorna o tamanho do diret�rio passado como par�metro.
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
	  * M�todo retorna o tamanho do arquivo passado como par�metro.
	  * @access public 
	  * @param String $dirFoto
	  * @return float
	  */  
	function fileSize($dirFoto){
		$quanto = filesize($dirFoto);
		return (($quanto/1024));
	}
	
	 /** 
	  * M�todo retorna a extens�o do arquivo passado como par�metro.
	  * @access public 
	  * @param String $file Arquivo que ir� ser verificado.
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
	  * M�todo retorna um array com os arquivos de um diret�rio, limitados por 2 par�metros, De e At�.
	  * @access public 
	  * @param String $diretorio Diret�rio que ir� ser escaneado.
	  * @param integer $limiteDe Limite de.
	  * @param integer $limiteAte Limite at�.
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
	  * M�todo retorna imprime/retorna o voltar
	  * @access public 
	  * @param String $iconeVoltar Icone voltar.
	  * @param String $linkPrincipal Link principal.
	  * @param String $msgVoltar Mensagem a ser exibida.
	  * @return void
	  */  
	function printVoltar(){
		$retorno .= "<br><br>";
		$retorno .= "<div align=\"center\">";
		$retorno .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"� Voltar\" onclick=\"javascript:history.go(-1)\">";
		$retorno .= "</div><br>";		
		return $retorno;
	}
}
?>