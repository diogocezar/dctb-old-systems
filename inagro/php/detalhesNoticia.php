<?php
/* id da notícia */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Uma identificação é necessária para consultar os detalhes de uma notícia.');location.href='noticias.php'</script>";
	exit();
}

$noticia = $controlador['noticia'];
$noticia->__toFillGeneric();
$noticia->__get_db($id);



$foto      = $noticia->getFoto();
$data      = $noticia->getData();
$titulo    = $noticia->getTitulo();
$descricao = converteQuebra($noticia->getDescricao());

$pikture = $controlador['pikture'];
$tamanho = $pikture->getSize($foto);
$largura = $tamanho[0]; 
$altura  = $tamanho[1];

$link    = "<a href=\"javascript:;\" onClick=\"abrir('mostra.php?loc=".$foto."&a=$altura&l=$largura&titulo=".$titulo."', '".$largura."', '".$altura."', 'no');\" >";

if(empty($foto)){
	$foto = '../images/sem_foto.jpg';
	$link = '';
}

$info['foto']      = "$link<img src=\"img.php?l=119&a=93&s=no&loc=".$foto."\" border=\"0\"></a>";
$info['data']      = desconverteData($data);
$info['titulo']    = $titulo;
$info['descricao'] = $descricao;
?>