<?
/** 
* SpeceBraid
*
* Esta classe é responsavel por criar uma galeria de fotos, colocadas separadas por pastas em uma pasta pre-determinada.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package pikture
*/

class Pikture{

	/** 
	* Atributo que irá armazenar quantas colunas a galeria terá.
	* @access private  
	* @name $colunas
	* @var integer
	*/
	private $colunas;
	
	/** 
	* Atributo que irá armazenar o diretório das fotos da galeria.
	* @access private  
	* @name $diretorio
	* @var String
	*/
	private $diretorio;
	
	/** 
	* Atributo que irá armazenar o a pasta de trabalho atual.
	* @access private  
	* @name $folder
	* @var String
	*/
	private $folder;
	
	/** 
	* Atributo que irá armazenar a quantidade de fotos da galeria.
	* @access private  
	* @name $qtdFotos
	* @var integer
	*/
	private $qtdFotos;
	
	/** 
	* Atributo que irá armazenar a quantidade de sessões da galeria.
	* @access private  
	* @name $qtdSessoes
	* @var integer
	*/
	private $qtdSessoes;
	
	/** 
	* Atributo que irá armazenar a quantidade de fotos por página.
	* @access private  
	* @name $qtdFotosPorPagina
	* @var integer
	*/
	private $qtdFotosPP;
	
	/**
	* Construtor
	* __construct_Photo()
	*/
	public function __construct_Photo(){}

	
	/** 
	* Método que inicializa os atributos passados como parâmetros.
	* @access public 
	* @param String $diretorio
	* @param integer $qtdFotosPP
	* @return void
	*/  
	function __go_Pikture($diretorio, $qtdFotosPP, $colunas){
		$this->diretorio  = $diretorio;
		$this->qtdFotosPP = $qtdFotosPP;
		$this->colunas    = $colunas;
	}//__go_Pikture
	
	/** 
	* Método que conta quantas imagens existem no diretório setado pelo método construtor.
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
	}//countDir
	
	/** 
	* Método que separa um titulo caso não tenha espaço por n caracteres
	* @access public 
	* @return Array $arrayPastas
	*/  
	function clearStr($str, $n){
		$str = str_replace(" ", "_", $str);
		$exp = explode(" ", $str);
		for($i=0; $i<count($exp); $i++){
			$qtdParte = strlen($exp[$i]);
			$parte = $exp[$i];
			if($qtdParte > $n){
				$count = 0;
				$inicio = 0;
				$strExp = "";
				for($j=0; $j<$qtdParte; $j++){
					$incrementa = true;
					if($parte[$j] == " "){
						$inicio = $i+1;
						$count = 0;
						$incrementa = false;
					}
					if($count == $n){
						$strExp .= substr($parte, $inicio, $count)."@";
						$inicio = $j;
						$count = 0;
						$incrementa = false;
					}
					if($incrementa){
						$count++;
					}
				}
				$strExp .= substr($parte, $inicio, strlen($parte));
				$exp[$i] = $strExp;
			}
		}
		$strFinal = implode(" ", $exp);
		$strFinal  = str_replace("@ - ", " @", $strFinal);
		$strFinal  = str_replace("@-", " @", $strFinal);
		$strFinal  = str_replace("@", "- ", $strFinal);
		$strFinal  = str_replace("-", "<br>", $strFinal);
		$strFinal  = str_replace("_", " ", $strFinal);
		$exp = explode(".", $strFinal);
		$strFinal = $exp[0];
		return $strFinal;
	}//clearStr
	
	/** 
	* Método gera um array com as pastas do diretório setado no método construtor.
	* @access public 
	* @return Array $arrayPastas
	*/  
	function arrayFolders($limiteDe=-1, $limiteAte=-1){
		if($limiteDe != -1 && $limiteAte != -1){
			$dirFiles = $this->scanDire($this->diretorio, $limiteDe, $limiteAte);
		}
		else{
			$dirFiles = $this->scanDire($this->diretorio);
		}
		$quantos = count($dirFiles);
		$count = 0;
		for($i=0;$i<$quantos;$i++){
			if(is_dir($this->diretorio.'/'.$dirFiles[$i])){
				$arrayPastas[$count] = $dirFiles[$i];
				$count++;
			}
		}
		return $arrayPastas;	
	}//arrayFolders
	
	/** 
	* Método imprime as pastas do diretório setado no método construtor.
	* @access public 
	* @return String
	*/  
	function printFolders($pagMostra, $varGet, $iconePastinha, $colunasCapa, $limiteDe=-1, $limiteAte=-1){
		$array = $this->arrayFolders($limiteDe, $limiteAte);
		$j=0;
		for($i=0; $i<count($array); $i++){
			$link = "<a href = \"$pagMostra?$varGet={$array[$i]}\" target=\"galeria\">";
			$fechaLink = "</a>";
			$retorno  .= "<span class=\"fonte10\"><img src=\"../images/seta.gif\" width=\"3\" height=\"5\" />&nbsp;".$link.$array[$i].$fechaLink."</span>";
			$retorno  .= "<br>";
		}
		return $retorno;
	}//printFolders
	
	/** 
	* Método retorna 4 fotos aleatórias de uma sessão aleatória
	* @access public 
	* @return Array[]
	*/
	function returnPictures(){
		$array = $this->arrayFolders();
		shuffle($array);
		$fotos = $this->scanDire($this->diretorio.'/'.$array[0], 0, 4);
		$retorno['fotos'] = $fotos;
		$retorno['folder'] = $array[0];
		return $retorno;
	}//returnPictures
	
	/** 
	* Método imprime as pastas do diretório setado no método construtor.
	* @access public 
	* @return String
	*/
	function firstPicture($dir){
		$dirScan = $this->scanDire($dir, 0, 1);
		return $dir.'/'.$dirScan[0];
	}//firstPicture
	
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
	function showPhotos($subDir, $page, $scalar, $printFileName, $printSize){
		$this->folder = $subDir;
		$dir          = $this->diretorio.'/'.$subDir;
		$mInicial     = $this->qtdFotosPP*$page;
		$mFinal       = ($mInicial+$this->qtdFotosPP)-1;
		$fotos        = $this->scanDire($dir, $mInicial, $mFinal);
		$quantos      = count($fotos);
		$colunas      = $this->colunas;
		$sobra        = $quantos % $colunas;
		$countFotos   = 0;
		$linhas       = ceil(($quantos/$colunas));
		$retorno .= "<table width=\"100%\" border=\"0\">";
		for($i=0; $i<$linhas; $i++){
			$retorno .= "<tr>";
			if($i+1 == $linhas){
				if($sobra > 0){
					$colunas = $sobra;
				}
			}
			for($j=0; $j<$colunas; $j++){
				$retorno .= "<td align=\"center\" valign=\"middle\">";
				$dirFoto = $dir.'/'.$fotos[$countFotos];
				$tamanho = $this->getSize($dirFoto);					
				$largura = $tamanho[0]; 
				$altura  = $tamanho[1];
				$nome    = $this->clearStr($fotos[$countFotos], 12);
				$retorno .= "<a href=\"#\" onClick=\"abrir('mostra.php?loc=".$dirFoto."&a=$altura&l=$largura&titulo=".$nome."', '".$largura."', '".$altura."', 'no');\" >";
				$retorno .= "<img src=\"img.php?loc=".$dirFoto."&t=2&s=$scalar\" border=\"0\">";
				$retorno .= "<br>";
				if($printFileName){
					$retorno .= $nome;
				}
				if($printSize){
					$retorno .= "<br>[".number_format($this->photoSize($dirFoto), 3, ',', '.')." Kb]";
				}
				$retorno .= "</a>";
				$countFotos++;
				$retorno .= "</td>";
			}
			$retorno .= "</tr>";
		}
		$retorno .= "</table>";
		
		return $retorno;
	}//showPhotos
	
	/** 
	* Método retorna o tamanho do diretório passado como parâmetro.
	* @access public 
	* @param String $dir Diretório que irá ser calculado.
	* @return float
	*/  
	function dirSize($dir){
		$files = $this->scanDire($dir);
		$quanto = 0;
		for($i=0; $i<count($files); $i++){
			$quanto += filesize($dir.'/'.$files[$i]);
		}
		return (($quanto/1024)/1000);
	}//dirSize
	
	/** 
	* Método retorna o tamanho da foto passada como parâmetro.
	* @access public 
	* @param String $dirFoto Foto que irá ser calculada.
	* @return float
	*/  
	function photoSize($dirFoto){
		$quanto = filesize($dirFoto);
		return (($quanto/1024));
	}//photoSize
	
	/** 
	* Método retorna se a extensão do arquivo passado como parâmetro é ou não valida.
	* @access public 
	* @param String $file Arquivo que irá ser verificado.
	* @return boolean
	*/  
	function getExtension($file){
		if(is_dir($this->diretorio.'/'.$file)){
			return true;	
		}
		else{
			$lock = false;
			$qtd = strlen($file);
			$ext = strtoupper(substr($file, ($qtd-3), $qtd));
			if($ext == 'GIF' || $ext == 'JPG' || $ext == 'JPEG' || $ext == 'PNG'){
				$lock = true;
			}
		}
		return $lock;
	}//getExtension
	
	/** 
	* Método retorna um array com os arquivos de um diretório, limitados por 2 parâmetros, De e Até.
	* @access public 
	* @param String $diretorio Diretório que irá ser escaneado.
	* @param integer $limiteDe Limite de.
	* @param integer $limiteAte Limite até.
	* @return Array
	*/  
	function scanDire($diretorio, $limiteDe=-1, $limiteAte=-1){
		$open = opendir($diretorio);
		$i=0;
		while(false !== ($file = readdir($open))){
			if($file != "." && $file != ".." && $file != "Thumbs.db"){
				if($this->getExtension($file)){
					$dir[$i] = $file;
					$i++; 
				}
			}
		}
		if($limiteDe != -1 && $limiteAte != -1){
			$i=0;
			foreach($dir as $indice => $valor){
				if($indice >= $limiteDe && $indice <= $limiteAte){
					$dirReturn[$i++] = $valor;
				}
			}
			$dir = $dirReturn;
		}
		return $dir;			  
	}//scanDire
	
	/** 
	* Método retorna o número de arquivos de um diretório.
	* @access public 
	* @param String $diretorio Diretório que irá ser escaneado.
	* @return Array
	*/  
	function countPhotos($diretorio){
		$dir = $this->scanDire($diretorio);
		return count($dir);
	}//countPhotos
	
	/** 
	* Método retorna o tamanho de um arquivo passado por parâmetro e retorna um array contendo :
	* 0 -> Largura
	* 1 -> Altura
	* @access public 
	* @param String $url Arquivo a ser examinado.
	* @return Array
	*/  
	function getSize($url){
		$quantos = strlen($url);
		$ext     = strtoupper(substr($url, ($quantos-3), $quantos));
	
		if($ext == 'GIF'){
			@$img = imagecreatefromgif($url);
			$cria = 'gif';
		}
		if($ext == 'JPG' || $ext == 'JPEG'){
			@$img = imagecreatefromjpeg($url); 
			$cria = 'jpg';
		}
		if($ext == 'PNG'){
			@$img = imagecreatefrompng($url); 
			$cria = 'png';
		}
	
		if($img){		
			define(MAX_WIDTH, 1000); 
			define(MAX_HEIGHT, 800); 
			
			$width = imagesx($img); 
			$height = imagesy($img);
						
			$array = array($width, $height);
			return $array;
		}
	}//getSize
	
	/** 
	* Método retorna imprime/retorna os estatus das galerias.
	* @access public
	* @return String
	*/  
	function printStats(){
		$retorno .= "Total de fotos : <b>".$this->qtdFotos."</b>";;
		$retorno .= "<br>";
		$retorno .= "Total de sessões : <b>".$this->qtdSessoes."</b>";
		return $retorno;
	}//printStats
	
	/** 
	* Método retorna imprime/retorna a paginação a partir dos parâmetros.
	* @access public 
	* @param integer $pag Número da página atual.
	* @param integer $pagina Página atual.
	* @param String $iconePrimeiro Icone Primeiro.
	* @param String $iconeAnterior Icone Anterior.
	* @param String $iconeProximo Icone Proximo.
	* @param String $iconeUltimo Icone Último.
	* @return String
	*/  
	function printPaging($pag, $paginaAtual, $iconePrimeiro, $iconeAnterior, $iconeProximo, $iconeUltimo){
	
		define(POR_PAGINA, $this->qtdFotosPP);
		define(PAGINA_ATUAL, $paginaAtual);
		define(QTD_PAGINAS_SHOW, 10);
		define(ATUAL, $pag);
		define(QTD, $this->countPhotos($this->diretorio.'/'.$this->folder));
		define(TOTAL, ceil((QTD)/POR_PAGINA));
		define(ASSUNTO, "imagens");
		define(SESSAO, $this->folder);

		$mostra_prox  = POR_PAGINA*(($pag+1)-1);
		$mostra_ante = POR_PAGINA*(($pag-1)-1);
		$mostra_essa = POR_PAGINA*(($pag)-1);		
		$pag_prox = $pag+1;		
		$pag_ante = $pag-1;		
		$pag_atua = $pag;
		
		$paginacao .= '<br>';
			
		$paginacao .= "<a href=\"".PAGINA_ATUAL."?folder=".SESSAO."\"><img src=\"$iconePrimeiro\" border=\"0\"><a>&nbsp;&nbsp;";
		if($pag > 0){
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?page=$pag_ante&folder=".SESSAO."\">";
		}		
		$paginacao .= "<img src=\"$iconeAnterior\" border=\"0\"></a>&nbsp;.<b>.</b>";		
		
		$inicioMostra = $pag_atua - (QTD_PAGINAS_SHOW/2);
		$fimMostra    = $pag_atua + (QTD_PAGINAS_SHOW/2);
	
		if($inicioMostra <= 0){
			$inicioMostra = 1;
		}
		
		if($fimMostra > TOTAL){
			$fimMostra = TOTAL;
		}
		
		for($i=$inicioMostra; $i<=$fimMostra ; $i++){
			if($i == ATUAL+1){	
				$paginacao .= "<b> $i</b>";
			}
			else{
				$aevi = POR_PAGINA*($i-1);
				$mI = $i-1;
				$paginacao .= " <a href=\"".PAGINA_ATUAL."?page=$mI&folder=".SESSAO."\">$i</a> ";
			}
		}
		
		$aevi = POR_PAGINA*(TOTAL-1);
		$i    = TOTAL-1;
		$link = PAGINA_ATUAL."?page=$i&folder=".SESSAO;
		
		$paginacao .= "&nbsp;<b>.</b>.&nbsp;";
		
		if($pag+1 < TOTAL){						
			$paginacao .= "<a href=\"".PAGINA_ATUAL."?page=$pag_prox&folder=".SESSAO."\">";
		}
		
		$paginacao .= "<img src=\"$iconeProximo\" border=\"0\"></a>&nbsp;";
		$paginacao .= "<a href=\"$link\"><img src=\"$iconeUltimo\" border=\"0\"></a>";									

		$agora = ATUAL+1;
		$todas = TOTAL;
		
		//$infos = '<br><br>';
		
		//$infos .= "Sessão : <b>".SESSAO."</b><br>";
		//$infos .= "Exibindo página : <b>$agora</b> de <b>$todas</b> páginas<br>";
		//$infos .= "Existem <b>".QTD."</b> ".ASSUNTO." na galeria atual.<br>";
		//$infos .= "Exibindo <b>".POR_PAGINA."</b> ".ASSUNTO." por página.<br><br>";
		
		$retorno .= "<div align=\"center\">";
		$retorno .= $paginacao;
		$retorno .= $infos;
		$retorno .= "</div>";
		
		return $retorno;
	}//printPaging
	
	/** 
	* Método retorna imprime/retorna o voltar
	* @access public 
	* @param String $iconeVoltar Icone voltar.
	* @param String $linkPrincipal Link principal.
	* @param String $msgVoltar Mensagem a ser exibida.
	* @return void
	*/  
	function printVoltar($iconeVoltar, $linkPrincipal){
		$retorno .= "<br><br>";
		$retorno .= "<a href = \"$linkPrincipal\"><div align=\"center\">";
		$retorno .= "<img src=\"$iconeVoltar\" border=\"0\"><br>";
		$retorno .= "</div>";
		
		return $retorno;
	}//printVoltar
	
	/** 
	* GETS e SETS
	* Método __call que é verificado a cada chamada de uma função da classe, o seguinte método implementa automaticamente as funções de GET e SET.
	* @access public 
	*/  	
	public function __call ($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Pikture
?>