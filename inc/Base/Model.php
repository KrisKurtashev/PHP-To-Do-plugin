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

    //Create base DB
	public static function bwtodolist_install() {
		// where and what we will store - db structure
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
        $bwtodolist_structure = "CREATE TABLE $bwtodolist_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            description text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY ( `id` )
		) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

		// Sending all this to mysql queries
		self::$wpdb->query($bwtodolist_structure);
		$today_date = gmdate('Y-m-d');

	}

	//Add to DB
	public static function bwtodolist_addtask(array $newdata) {
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		$today_date = gmdate('Y-m-d');
		$bwtodolist_query = "INSERT INTO `".$bwtodolist_table."` (`id`, `title`, `description`)VALUES (NULL, '".$newdata['bwtodolist_title']."','".$newdata['bwtodolist_description']."')";
		self::$wpdb->query($bwtodolist_query);
	}

	//Update task
	public static function bwtodolist_updatetask(array $newdata) {
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		$bwtodolist_query = "UPDATE `".$bwtodolist_table."` SET `title`='".$newdata['bwtodolist_title']."', `description`='".$newdata['bwtodolist_description']."' WHERE `id`='".$newdata['bwtodolist_taskid']."'";
		self::$wpdb->query($bwtodolist_query);

        //UX logic to redirect to the table (need to ask Didi)
		//echo '<script>window.location.href="?page=wp-todo"</script>';
	}

	// Delete task
	public static function bwtodolist_deletetask(int $id) {
		if(isset($id)){
			$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
			$bwtodolist_comments_table = self::$wpdb->prefix . "bwtodolist_comments";
			$q = self::$wpdb->query("DELETE FROM `".$bwtodolist_table."` WHERE `id`=$id");
			self::$wpdb->query("DELETE FROM `".$bwtodolist_comments_table."` WHERE `task`=$id");
			echo '<script>window.location.href="?page=wp-todo"</script>';
		}
	}

	// Edit task
	public static function bwtodolist_edit(int $id) {
		if(isset($id) && !empty($id)){
			$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
			$bwtodolist_edit_item = self::$wpdb->get_results("SELECT * FROM `$bwtodolist_table` WHERE `id`=$id");
			if(!$bwtodolist_edit_item) {
				echo'<div class="wrap"><h2>There is no such task to edit. Please add one first.</h2></div>';
			}
			else {
				require_once(parent::$plugin_path . 'templates/edit_task.php');
		 	}
		}
	}

	// Admin page
	public static function bwtodolist_manage_main(/*$bwtodolist_filter_status*/) {
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		require_once(parent::$plugin_path . 'templates/admin.php');
	}

	// Admin CP manage page
	public static function bwtodolist_manage() {
		
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		if(isset($_POST['bwtodolist_addtask']) && isset($_POST['bwtodolist_title'])) self::bwtodolist_addtask($_POST); //Add
		if(isset($_POST['bwtodolist_updatetask'])) self::bwtodolist_updatetask($_POST); //Update
		if(isset($_POST['bwtodolist_deletetask'])) self::bwtodolist_deletetask($_POST['bwtodolist_taskid']); //Delete
		else if(isset($_GET['edit'])) self::bwtodolist_edit($_GET['edit']);
		else self::bwtodolist_manage_main();
	}

	// shortcode template
	public static function bwtodolist_shortcode_template() {
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		require_once(parent::$plugin_path . 'templates/show_todolist.php');
	}


	public static function bwtodolist_shortcode(){
		ob_start();
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		if(isset($_POST['bwtodolist_addtask']) && isset($_POST['bwtodolist_title'])) self::bwtodolist_addtask($_POST); //Add
		if(isset($_POST['bwtodolist_updatetask'])) self::bwtodolist_updatetask($_POST); //Update 
		if(isset($_POST['bwtodolist_deletetask'])) self::bwtodolist_deletetask($_POST['bwtodolist_taskid']); //DELETE
		else if(isset($_GET['edit'])) self::bwtodolist_edit($_GET['edit']);
		else self::bwtodolist_manage_main();

		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	// redirect to tasks
	public static function bwtodolist_edit_task(int $id){
		$edit = '';
		$role = Admin::get_role();
		if($role == 'administrator'){
			$edit = '<a href="?page=bw-todolist&edit='.$id.'" >Edit</a>';
		}
		return $edit;
	}

	public static function bwtodolist_tasks($level){
		$bwtodolist_table = self::$wpdb->prefix . "bwtodolist";
		$bwtodolist_manage_items = self::$wpdb->get_results("SELECT * FROM $bwtodolist_table ORDER BY `id` DESC");
		$bwtodolist_counted = count($bwtodolist_manage_items);
		$num = 0;
			while($num != $bwtodolist_counted) {
				echo "<li>";
				echo "<div data-name='id'>".$bwtodolist_manage_items[$num]->id."</div>";
				echo "<div data-name='title'>".$bwtodolist_manage_items[$num]->title."</div>";
				echo "<div data-name='desc'>".$bwtodolist_manage_items[$num]->description."</div>";
				echo "<div data-name='created at'>".$bwtodolist_manage_items[$num]->created_at."</div>";
				echo "<div data-name='last update'>".$bwtodolist_manage_items[$num]->updated_at."</div>";

				if ($level === 'admin'){
					echo "<div data-name='actions'><span>".self::bwtodolist_edit_task($bwtodolist_manage_items[$num]->id). "</span></div>"; 
				}
				echo "</li>";
				echo "";
				$num++;
			}
	}	
}