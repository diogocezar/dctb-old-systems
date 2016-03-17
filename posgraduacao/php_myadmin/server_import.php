<?php
/* $Id: server_import.php,v 2.1 2005/09/24 09:24:11 nijel Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:


/**
 * Does the common work
 */
require('./server_common.inc.php');


/**
 * Displays the links
 */
require('./server_links.inc.php');

$import_type = 'server';
require('./libraries/display_import.lib.php');
/**
 * Displays the footer
 */
require('./footer.inc.php');
?>

