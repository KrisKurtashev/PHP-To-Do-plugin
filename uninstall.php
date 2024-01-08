<?php
/**
*
* Trigger this file on Plugin uninstall
*
* @package bwtodolist
*/

if(! defined('WP_UNINSTALL_PLUGIN')){
	die;
}
global $wpdb;
$bwtodolist_table = $wpdb->prefix . "bwtodolist";
$tables = array($bwtodolist_table);
	foreach ($tables as $table) {
		$wpdb->query("DROP TABLE IF EXISTS `$table`");
	}