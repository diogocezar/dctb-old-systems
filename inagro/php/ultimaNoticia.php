<?
$noticia = $controlador['noticia'];
$noticia->__toFillGeneric();
$resultado = $noticia->lastNotices(1);
$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

$foto = $dados[$noticia->campos[4]];
$id    = $dados[$noticia->campos[0]];
$link  = "vejaNoticia.php?id=$id";
if(empty($foto)){
	$foto = '../images/sem_foto_noticias.jpg';
}
echo "<a href=\"$link\"><img src=\"img.php?l=126&a=96&s=no&loc=".$foto."\" border=\"0\"></a>";
?>