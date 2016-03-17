<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Enquetes antigas!</title>
       <script language="javascript">
       function result(id){
           window.open("resul.php?id="+id, "clo3", "toolbar=no,location=no,directories=no,status=no,scrollbars=no,menubar=no,resizable=no,width=400,height=250");
       }
   </script>
</head>
<body>
<?
include "conec.inc.php";
$resultado = mysql_query("SELECT * FROM perg ORDER BY id"); // Executa a consulta
$obj = mysql_fetch_object($resultado);
$num = mysql_num_rows($resultado);
$x = 0;
echo "Escolha a enquete que deseja ver: <br><br>";
while($x<$num){
   echo "<a href='javascript:result(".$obj->id.")'>".$obj->perg."</a><br>";
   $x++;
}
?>
</body>
</html>