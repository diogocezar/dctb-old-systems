<?php
/* id da notícia */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Uma identificação é necessária para consultar os detalhes de uma notícia.');location.href='noticias.php'</script>";
	exit();
}

$empresa = $controlador['empresa'];
$empresa->__toFillGeneric();
$empresa->__get_db($id);

$foto[1]   = $empresa->getFoto1();
$foto[2]   = $empresa->getFoto2();
$foto[3]   = $empresa->getFoto3();
$foto[4]   = $empresa->getFoto4();
$foto[5]   = $empresa->getFoto5();
$foto[6]   = $empresa->getFoto6();
$logo      = $empresa->getLogo();
$nome      = $empresa->getNome();
$descricao = converteQuebra($empresa->getDescricao());

$pikture = $controlador['pikture'];

for($i=1; $i<7; $i++){
	if(!empty($foto[$i])){
		$tamanho[$i] = $pikture->getSize($foto[$i]);
		$largura[$i] = $tamanho[$i][0]; 
		$altura [$i] = $tamanho[$i][1];
		$link   [$i] = "<a href=\"javascript:;\" onClick=\"abrir('mostra.php?loc=".$foto[$i]."&a=".$altura[$i]."&l=".$largura[$i]."&titulo=".$titulo."', '".$largura[$i]."', '".$altura[$i]."', 'no');\" >";
		$info[$i]    = "{$link[$i]}<img src=\"img.php?l=119&a=93&s=no&loc=".$foto[$i]."\" border=\"0\"></a>";
	}
	else{
		$foto[$i] = '../images/sem_foto.jpg';
		$link[$i] = '';
		$info[$i] = "{$link[$i]}<img src=\"img.php?l=119&a=93&s=no&loc=".$foto[$i]."\" border=\"0\"></a>";
	}
}

$tamanhoLogo = $pikture->getSize($logo);
$larguraLogo = $tamanhoLogo[0]; 
$alturaLogo  = $tamanhoLogo[1];
$linkLogo    = "<a href=\"javascript:;\" onClick=\"abrir('mostra.php?loc=".$logo."&a=$alturaLogo&l=$larguraLogo&titulo=".$titulo."', '".$larguraLogo."', '".$alturaLogo."', 'no');\" >";

if(empty($logo)){
	$logo = '../images/sem_foto.jpg';
	$linkLogo = '';
}

$info['logo']      = "$linkLogo<img src=\"img.php?l=119&a=93&s=no&loc=".$logo."\" border=\"0\"></a>";
$info['nome']      = $nome;
$info['descricao'] = $descricao;
?>