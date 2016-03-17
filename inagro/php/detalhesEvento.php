<?php
/* id da notícia */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Uma identificação é necessária para consultar os detalhes de uma notícia.');location.href='noticias.php'</script>";
	exit();
}

$evento = $controlador['evento'];
$evento->__toFillGeneric();
$evento->__get_db($id);

$foto[1]   = $evento->getFoto1();
$foto[2]   = $evento->getFoto2();
$foto[3]   = $evento->getFoto3();
$foto[4]   = $evento->getFoto4();
$foto[5]   = $evento->getFoto5();
$foto[6]   = $evento->getFoto6();
$foto[7]   = $evento->getFoto7();
$foto[8]   = $evento->getFoto8();
$data      = $evento->getData();
$titulo    = $evento->getTitulo();
$descricao = converteQuebra($evento->getDescricao());

$pikture = $controlador['pikture'];

for($i=1; $i<9; $i++){
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

$info['data']      = desconverteData($data);
$info['titulo']    = $titulo;
$info['descricao'] = $descricao;
?>