<?
$user = "root"; // usuario
$pass = "";//senha
$dbname="targetsolutions"; // Banco de Dados
$hostname="localhost";
//1º passo - Conecta ao servidor MySQL
if(!($_id = mysql_connect($hostname,$user,$pass))) {
   echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}
//2º passo - Seleciona o Banco de Dados
if(!($con=mysql_select_db($dbname,$_id))) {
   echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
   exit;
}
?>