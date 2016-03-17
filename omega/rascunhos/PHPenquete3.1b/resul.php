<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
<?
include "conec.inc.php";
$cor = "#0000FF";
$resultado = mysql_query("SELECT * FROM perg WHERE id='".$id."'"); // Verifica a enquete a ser exibida
$obj = mysql_fetch_object($resultado);
$res = mysql_query("SELECT * FROM respostas WHERE idperg=".$id);
$num = mysql_num_rows($res);
$x = 0;
while($x<$num){
    $x++;
    $obj2 = mysql_fetch_object($res);
    $texto[$x] = $obj2->resp;
    $votos[$x] = $obj2->votos;
}
$tudo = array_sum($votos);
$x = 0;
while($x<$num){
    $x++;
    $votos[$x] = number_format(($votos[$x]/$tudo) *100 , 2, '.', ' ');
    $barra[$x] = 10 + $votos[$x];
}

echo "
<title>Resultado da enquetes</title>
</head>
<body>
<div id='titulo'><b>".$obj->perg."</b></div><br><br>
<table id='tabela'>
";
$x = 0;
while($x<$num){
    $x++;
    echo "<tr><td>". $texto[$x] ."</td>
       <td width=110px>
           <span style='{width:100px; border-width:0%}'>
                 <div style='{background:".$cor."; width:".$barra[$x]."px; height: 10px}'></span>
           </span>
       </td>
       <td> ".$votos[$x]."% </td></tr>";
}
?>
</table>
<br><br>
<a href='javascript:self.close()'> [fechar] </a>
</body>
</html>