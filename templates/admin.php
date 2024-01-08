<?php 
global $shortcode_tags;
?>
<div class="bw-todo wrap">
		<br>
		<h2 style="text-align: center"><?php _e("To Do Management", 'bwtodolist'); ?></h2>
		<br>
		<?php
		\Inc\Pages\Admin::bwtodolist_add_button();
		?>
		<ul class="todo-list admin">
			<li>
				<div>ID</div>
				<div>Title</div>
				<div>Description</div>
				<div>Created At</div>
				<div>Last Update</div>
				<div>Actions</div>
			</li>

			<?php
				self::bwtodolist_tasks($level="admin");
			?>
		</ul>
	</div>
	<?php
	\Inc\Pages\Admin::bwtodolist_add_form();
	?>