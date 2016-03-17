<?php
/* $Id: db_import.php,v 2.1 2005/09/24 09:24:11 nijel Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:


/**
 * Gets tables informations and displays top links
 */
require('./db_details_common.php');
require('./db_details_db_info.php');

$import_type = 'database';
require('./libraries/display_import.lib.php');

/**
 * Displays the footer
 */
require('./footer.inc.php');
?>

