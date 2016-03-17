<?php
/* $Id: server_sql.php,v 2.2 2005/09/27 13:53:48 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:


/**
 * Does the common work
 */
require_once './server_common.inc.php';
require_once './libraries/sql_query_form.lib.php';


/**
 * Displays the links
 */
require './server_links.inc.php';


/**
 * Query box, bookmark, insert data from textfile
 */
PMA_sqlQueryForm();

/**
 * Displays the footer
 */
require_once './footer.inc.php';
?>
