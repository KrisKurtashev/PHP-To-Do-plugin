<div id="addForm" title="Add New Task" style="background-color: #F6F6F6;">
	<form action="" method="post">
		<input name="bwtodolist_addtask" id="bwtodolist_addtask" value="true" type="hidden" />
		<input name="bwtodolist_from" id="bwtodolist_from" value="<?php echo self::get_user_id(); ?>" type="hidden" />
		<table>
			<tr>
				<td><label for="bwtodolist_title">Title:</label></td>
				<td><input type="text" name="bwtodolist_title" id="bwtodolist_title" placeholder="Enter Title" required /></td>
			</tr>
			<tr>
				<td><label for="bwtodolist_description">Description:</label></td>
				<td><textarea name="bwtodolist_description" id="bwtodolist_description" placeholder="Enter Description" required></textarea></td>
			</tr>
			<!-- <tr>
				<td><button name="submit" type="submit" value="Add Task">Submit</button></td>
			</tr> -->
		</table>
	</form>
</div>
<script>
	jQuery(document).ready(function() {
		var dialog, form;

		form = jQuery("form");

		function formSubmit() {
			var errors;
			if (!jQuery("#bwtodolist_title").val()) {
				jQuery("#bwtodolist_title").addClass('ui-state-error');
				errors = 1;
			} else {
				jQuery("#bwtodolist_title").removeClass('ui-state-error');
				errors = 0;
			}

			if (!jQuery("#bwtodolist_description").val()) {
				jQuery("#bwtodolist_description").addClass('ui-state-error');
				errors = 1;
			} else {
				jQuery("#bwtodolist_description").removeClass('ui-state-error');
				errors = 0;
			}

			if (!errors) {
				form.submit();
				dialog.dialog("close");
			}
		}

		dialog = jQuery("#addForm").dialog({
			autoOpen: false,
			height: 400,
			width: 350,
			modal: true,
			buttons: {
				"Submit": formSubmit,
				Cancel: function() {
					form[0].reset();
					dialog.dialog("close");
				}
			},
			close: function() {
				form[0].reset();
				dialog.dialog("close");
			}
		});

		jQuery("#addTask-button").button().on("click", function() {
			dialog.dialog("open");
		});
	});
</script>