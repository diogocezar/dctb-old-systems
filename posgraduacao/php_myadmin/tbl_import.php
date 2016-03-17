<?php
/* $Id: tbl_import.php,v 2.2 2005/10/08 18:14:09 nijel Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:


/**
 * Gets tables informations and displays top links
 */
require_once('./tbl_properties_common.php');
require_once('./tbl_properties_table_info.php');
/**
 * Displays top menu links
 */
require_once('./tbl_properties_links.php');

$import_type = 'table';
require_once('./libraries/display_import.lib.php');

/**
 * Displays the footer
 */
require_once('./footer.inc.php');
?>

