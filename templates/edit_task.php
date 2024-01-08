<div id="editForm">
	<br>
	<h2><?php _e("Task #$id", 'bwtodolist'); ?></h2>
	<br>
	<div class="clock" id="timer"></div>
	<br>

	<form id="edit_form" action="" method="post">
		<input name="bwtodolist_updatetask" id="bwtodolist_updatetask" value="true" type="hidden" />
		<input name="bwtodolist_taskid" id="bwtodolist_taskid" value="<?php echo $id; ?>" type="hidden" />
		<table>
			<tr>
				<td><label for="bwtodolist_title">Title:</label></td>
				<td><input name="bwtodolist_title" id="bwtodolist_title" value="<?php echo $bwtodolist_edit_item['0']->title; ?>" type="text" /></td>
			</tr>
			<tr>
				<td><label for="bwtodolist_description">Description:</label></td>
				<td><textarea name="bwtodolist_description" id="bwtodolist_description" rows="5" cols="40"><?php echo $bwtodolist_edit_item['0']->description; ?></textarea></td>
			</tr>
		</table>
		<!-- table starts -->
		<table>
			<tbody>
				<tr style="border: 0">
					<td style="border: 0">
						<input name="Submit" value="Update" type="submit" />
	</form>
	</td>
	<td style="border: 0">
		<form action="" method="post">
			<input name="bwtodolist_taskid" id="bwtodolist_taskid" value="<?php echo $id; ?>" type="hidden" />
			<?php
			$delete = '<input name="bwtodolist_deletetask" value="Delete" type="submit" />';
			\Inc\Pages\Admin::bwtodolist_delete_button($delete);
			\Inc\Pages\Admin::bwtodolist_cancel();
			?>
	</td>
	<td style="border: 0">
		<input name="cancel" value="Cancel" type="submit" />
		</form>
	</td>
	</tr>
	</tbody>
	</table>
	<!-- table ends -->
</div>
