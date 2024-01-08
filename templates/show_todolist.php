<div class="bw-todo wrap">
    <h2 style="text-align: center"><?php _e("To Do Management", 'bwtodolist'); ?></h2>
	<ul class="todo-list">
        <li>
            <div>ID</div>
            <div>Title</div>
            <div>Description</div>
            <div>Created At</div>
            <div>Last Update</div>
        </li>

        <?php
            self::bwtodolist_tasks($level="public");
        ?>
    </ul>
</div>
