<?php
/**
* @package bwtodolist
*/
namespace Inc\Base;

use \Inc\Base\BaseController;
use \Inc\Pages\Admin;

class Model extends BaseController
{
	private static $wpdb;

	public function __construct(){
		global $wpdb;
		self::$wpdb = $wpdb;
	}

    // Create tables
	public static function bwtodolist_install() {
		// db structure
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
        $bwtodolist_structure = "CREATE TABLE $bwtodolist_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY ( `id` )
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

		// Sending to DB
		self::$wpdb->query($bwtodolist_structure);
		$today_date = gmdate('Y-m-d');

	}
}