<?php

/**
 * @package bwtodolist
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Base\Model;
use \Inc\Api\SettingsApi;

class Admin extends BaseController
{
	public $settings;
	public $pages = array();
	public $subpages = array();

	public function __construct()
	{
		$this->settings = new SettingsApi();
		add_shortcode('wp-todo', array($this, 'bwtodolist_shortcode_main'));
	}

	public function register()
	{

		$this->pages = array(

			array(
				'page_title' => __('To Do List', 'bwtodolist'),
				'menu_title' => __('To Do List', 'bwtodolist'),
				'capability' => 'edit_posts',
				'menu_slug' => 'bw-todolist',
				'callback' =>  array($this, 'bwtodolist_manage')
			)

		);

		$this->settings->AddPage($this->pages)->register();
	}

	public function bwtodolist_manage()
	{
		Model::bwtodolist_manage();
	}

	public static function get_role()
	{
		$current_user = wp_get_current_user();
		foreach ($current_user->roles as $role) {
			if ($role = "administrator") { return $role; }
		}
		return $role;
	}

	public static function get_user_id()
	{
		$current_user = wp_get_current_user();
		return $current_user->ID;
	}

	public static function bwtodolist_add_form()
	{
		$role = self::get_role();
		if ($role == 'administrator') {
			require_once(parent::$plugin_path . 'templates/add_task.php');
		} else {
			echo '<div class="narrow"></div>';
		}
	}

	public static function bwtodolist_add_button()
	{
		$role = self::get_role();
		if ($role == 'administrator') {
			echo '<button class="addTask" type="button" id="addTask-button">Add Task</button><br><br>';
		}
	}

	public static function bwtodolist_delete_button($delete)
	{
		$role = self::get_role();
		if ($role == 'administrator') {
			echo $delete;
		}
	}

	public function bwtodolist_shortcode_main()
	{
		return Model::bwtodolist_shortcode();
	}

	// redirect to tasks
	public static function bwtodolist_cancel()
	{
		if (isset($_POST['cancel'])) {
			echo '<script>window.location.href="?page=bw-todolist"</script>';
		}
	}
}
