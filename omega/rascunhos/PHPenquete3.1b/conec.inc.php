<?
$user = "root"; // usuario
$pass = "";//senha
$dbname="targetsolutions"; // Banco de Dados
$hostname="localhost";
//1� passo - Conecta ao servidor MySQL
if(!($_id = mysql_connect($hostname,$user,$pass))) {
   echo "N�o foi poss�vel estabelecer uma conex�o com o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}
//2� passo - Seleciona o Banco de Dados
if(!($con=mysql_select_db($dbname,$_id))) {
   echo "N�o foi poss�vel estabelecer uma conex�o com o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}
?>