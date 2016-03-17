<?php
@session_start();
/*
Plugin Name: Site Counts
Plugin URI: http://www.diogocezar.com/plugins/site-counts
Description: Show the number of times that your site has been visited
Version: 0.1
Author: Diogo Cezar Teixeira Batista
Author URI: http://www.diogocezar.com/
*/

$conn = false;

function openConnection(){
	global $conn;
	@$conn = mysql_connect('localhost', 'diogo_root', 'm3l3lus69');
	@mysql_select_db('diogo_blog');
}

function closeConnection(){
	global $conn;
	@mysql_close($conn);
}

function setCount(){
	openConnection();
	@mysql_query('UPDATE wp_counter SET counter=counter+1');
	closeConnection();
	$_SESSION['sessSiteCounts'] = "yes";
}

function getCount(){
	openConnection();
	@$query = mysql_query('SELECT counter FROM wp_counter');
	@$counter = mysql_fetch_array($query);
	closeConnection();
	return $counter['counter'];
}

function go_site_counts(){
	$counter = getCount();
	if($_SESSION['sessSiteCounts'] != "yes"){ setCount(); }
	echo getCount();
}
?>