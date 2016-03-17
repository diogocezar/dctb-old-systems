<?php
set_time_limit(0);
ob_start(); 
include('./config/config.php');
include('./class/EnglishDefinitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>English Definitions</title>
<link href="./css/ec.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$verbs       = $_POST['verbs'];
$vocabulary  = $_POST['vocabulary'];
$expressions = $_POST['expressions'];
$lesson      = $_POST['lesson'];
$book        = $_POST['book'];

$ed = new EnglishDefinitions($lesson, $book);

$ed->showVerbs      ($verbs);
$ed->showVocabulary ($vocabulary);
$ed->showExpressions($expressions);

$ed->saveHtml();
?>
</body>
</html>