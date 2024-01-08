<?php
// bw-to-do-list.php
/*
Plugin Name: BW To-Do List
Description: Simple To-Do List plugin for WordPress.
Version: 0.1
Author: Kris
*/


defined('ABSPATH') or die('Hey, What are you doing here? You Silly Man!');

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
	require_once dirname(__FILE__).'/vendor/autoload.php';
}

//activate plugin
function activate_bwtodolist(){
	\Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_bwtodolist' );
//deactivate plugin
function deactivate_bwtodolist(){
	\Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_bwtodolist' );
//instantiate classes
if( class_exists( 'Inc\\Init' ) ){
	\Inc\Init::register_services();
}

function shortcode_bwtodolist(){
	return \Inc\Base\Model::bwtodolist_shortcode_template();
}
add_shortcode('show-todolist', 'shortcode_bwtodolist');