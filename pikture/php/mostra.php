<html>
<head>
<title><?= $_GET['titulo'] ?></title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
$onde    = $_GET['loc'];
$altura  = $_GET['a'];
$largura = $_GET['l'];
echo "<a href=\"javascript:window.close();\">";
echo "<img src=\"img.php?loc=".$onde."&a=$altura&l=$largura\" border=\"0\">";
echo "</a>";
?>
</body>
</html>