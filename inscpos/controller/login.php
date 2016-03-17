<?php
include("start-brain.php");

$session = $brain_controller['session'];

/* template directory */
$templateHtmlDir = '../view/html';

/* template file */
$templateHtmlName = 'frm-login.html';

/* setting template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instantiating the class */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("form_block");
	$form = "form_login";
	$template->setVariable("formLogin",     $form);
	$template->setVariable("actionLogin",   "index.php");
	$template->setVariable("fieldLogin",    "login");
	$template->setVariable("fieldPassword", "password");
$template->parseCurrentBlock("form_block");

$content = $template->get();
$title   = 'Informe seu login e senha:';

include('inside-include.php');
?>