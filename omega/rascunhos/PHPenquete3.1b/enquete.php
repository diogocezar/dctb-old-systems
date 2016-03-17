<?
include "conec.inc.php"; // Carrega as Configurações

// Trecho para Computar Votos
if(isset($oq) && isset($enq) && isset($id) && !isset($vota)){// Verifica se o visitante votou e se ele pode votar
   $resultado = mysql_query("SELECT * FROM respostas WHERE id='".$_POST['enq']."'");
   $obj = mysql_fetch_object($resultado);
   $refresh_votos=$obj->votos+1;
   $resultado = mysql_query("UPDATE respostas SET votos =".$refresh_votos." WHERE id='".$_POST['enq']."'"); // Executa a consulta
   setcookie("vota", "Votou"); // Define um cookie para verificar se o usuário já votou posteriormente
}
// FIM do Trecho para Computar Votos

if(isset($oq) && isset($enq)){ // Exibe o resultado
   echo "<script language='javascript'>
   window.open('resul.php?id=".$id."', 'clo3', 'toolbar=no,location=no,directories=no,status=no,scrollbars=no,menubar=no,resizable=no,width=400,height=250');
   </script>";// Exibe o resultado
}
?>
<!-- Sua Página -->
<b> Vote na minha enquete </b><br>
<form method="post">
<!-- Para votar na Enquete-->
<?
/* Exibe a enquete */
$res = mysql_query("SELECT * FROM perg WHERE exibir='S'");
$obj = mysql_fetch_object($res);
$resultado = mysql_query("SELECT * FROM respostas WHERE idperg='".$obj->id."'");
$num = mysql_num_rows($resultado);
$x = 0;
echo $obj->perg."<br>";
while($x<$num){
    $obj2 = mysql_fetch_object($resultado);
    echo "<input type='radio' name='enq' value='".$obj2->id."'> ".$obj2->resp."<br>";
    $x++;
}
echo "<input type='hidden' name='id' value='".$obj->id."'>";
echo "<input type='submit' name='oq' value='Votar'><input type='button' value='Resultados' onClick=".chr(34)."window.open('resul.php?id=".$obj->id."', 'clo4', 'toolbar=no,location=no,directories=no,status=no,scrollbars=no,menubar=no,resizable=no,width=450,height=250')".chr(34).">";
?></form>