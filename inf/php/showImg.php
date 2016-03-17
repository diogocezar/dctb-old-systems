<?php
include('../lib/library.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo anti_sql_injection($_GET['tit']) ?></title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<?php
$tamanho = anti_sql_injection($_GET['t']);

$largura = anti_sql_injection($_GET['l']);
$altura  = anti_sql_injection($_GET['a']);

$scalar  = anti_sql_injection($_GET['s']);

$localizacao = anti_sql_injection($_GET['loc']);

echo "<a href=\"javascript:window.close();\">";
echo "<img src=\"img.php?loc=".$localizacao."&t=".$tamanho."&a=".$altura."&l=".$largura."&s=".$scalar."\" border = \"0\">";
echo "</a>";
?>
</center>
</body>
</html>
