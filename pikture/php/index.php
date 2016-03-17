<link href="../css/cssGallery.css" rel="stylesheet" type="text/css">
<script src="../jscripts/library.js"></script>

<?
/* Incluindo classes */
include('../classes/Pikture.php');
include('../classes/IniFile.php');

/* Incluindo funções das bibliotecas */
include('../lib/util.php');

$getOp  = $_GET['folder'];
$getPag = $_GET['page'];

if(empty($getPag)){
	$getPag = 0;
}

$ini = new IniFile("../config/gerais.ini");
$gerais = $ini->getIni(false);

$diretorio     = $gerais['diretorio'];
$colunas       = $gerais['colunas'];
$fotosPP       = $gerais['fotosPorPagina'];
$iconePastinha = $gerais['iconePastinha'];
$iconePrimeiro = $gerais['iconePrimeiro'];
$iconeProximo  = $gerais['iconeProximo'];
$iconeAnterior = $gerais['iconeAnterior'];
$iconeUltimo   = $gerais['iconeUltimo'];
$iconeVoltar   = $gerais['iconeVoltar'];
$scalar        = $gerais['fotoEscalar'];
$imprimeNome   = $gerais['imprimirNome'];
$imprimeTam    = $gerais['imprimirTamanho'];
$colunasCapa   = $gerais['colunasCapa'];

$paginaAtual   = getPaginaAtual();	

if(empty($getOp)){
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	echo $pikture->setStyle('fonteGalerias');
	echo $pikture->printFolders($paginaAtual, 'folder', $iconePastinha, $colunasCapa);
	echo $pikture->setStyle('fecha');
	$pikture->countDir();
	echo "<br>";
	echo "<div align=\"center\">";
	echo $pikture->setStyle('fonteFotos');
	echo $pikture->printStats();
	echo $pikture->setStyle('fecha');
	echo "</div>";
}
else{
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	echo $pikture->showPhotos($getOp, $getPag, $scalar, $imprimeNome, $imprimeTam);
	$pikture->countDir();
	echo $pikture->setStyle('fonteGalerias');
	echo $pikture->printPaging($getPag, $paginaAtual, $iconePrimeiro, $iconeAnterior, $iconeProximo, $iconeUltimo); 
	echo $pikture->printVoltar($iconeVoltar, $paginaAtual, "Voltar para a galeria principal");
	echo $pikture->setStyle('fecha');
}

echo $pikture->setStyle('fonteGalerias');
echo "<br><div align=\"center\">Desenvolvido por: Diogo Cezar Teixeira Batista <br /> <b>xgordo@gmail.com</b></div>";
echo $pikture->setStyle('fecha');
?>