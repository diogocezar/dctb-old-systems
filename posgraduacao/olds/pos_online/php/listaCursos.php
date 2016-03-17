<link href="../css/estilo.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-color: #C5C6C8;
	margin-left: 5px;
	margin-top: 5px;
	margin-right: 5px;
	margin-bottom: 5px;
}
</style>
<?
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$sql = "SELECT cur_cod, cur_nome FROM {$tabela['cursos']}";
$resultado = $dataBase->query($sql);

$cursos  = "<span class=\"letra_padrao\">";

$cursos  .= '<b>Cursos :</b><br><br>';

$id = $_GET['id'];

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	if($dados['cur_cod'] != 1){
		if(file_exists("../images/seta_{$dados['cur_cod']}.gif")){
			$cursos .= "<img src=\"../images/seta_{$dados['cur_cod']}.gif\">&nbsp;";
		}
		$cursos .= "<a href = \"pagina.php?id={$dados['cur_cod']}\" class=\"link_curso_{$dados['cur_cod']}\" target=\"_parent\">";
		if($id == $dados['cur_cod']){ $cursos .= "<b>"; $passou = true; }
		$cursos .= str_replace("Curso de Especialização em ", "", $dados['cur_nome']);
		if($passou == true){ $cursos .= "</b>"; }
		$cursos .= "</a><br><br>";
	}
}

$cursos  .= "</span>";

echo $cursos;

?>