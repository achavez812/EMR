<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';
	if(isset($_GET['show_alert'])) {
		echo '<script>';
		echo 'alert("' . NO_USERS_CREATE_ONE . '")';
		echo '</script>';
	}

	$user_id = INVALID_VALUE;
	if(isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
	}

	if(isset($_GET['delete'])) {
		$id = $_GET['id'];
		if($id == $user_id) {
			echo '<script>';
			echo 'alert("' . CANNOT_DELETE_YOURSELF . '")';
			echo '</script>';
		} else {
			$db->deleteUser($id);
		}
	}
	if(isset($_GET['medical_group'])) {
		$location = $_GET['location'];
		$medical_group = $_GET['medical_group'];
		$chief_physician = $_GET['chief_physician'];
		if(!$location) {
			$location = NULL;
		}
		if(!$medical_group) {
			$medical_group = NULL;
		}
		if(!$chief_physician) {
			$chief_physician = NULL;
		}
		$db->updateMainSettings($location, $medical_group, $chief_physician);
		header("LOCATION: settings.php?lang=" . $lang . "&user_id=" + $user_id);
	} else if(isset($_GET['username'])) {
		$name = $_GET['name'];
		$username = $_GET['username'];
		$password = $_GET['password'];

		if($db->usernameExists($username)) {
			echo '<script>';
			echo 'alert("' . ADD_NEW_USER_ERROR . '")';
			echo '</script>';
		} else {
			$db->createUser($name, $username, $password);
			header("LOCATION: settings.php?lang=" . $lang . "&user_id=" + $user_id);
		}
	} else if(isset($_GET['edit_code'])) {
		$edit_code = $_GET['edit_code'];
		$db->updateSettings('edit_code', $edit_code);
		if($user_id != INVALID_VALUE) {
			header("LOCATION: settings.php?lang=" . $lang . "&user_id=" + $user_id);
		} else {
			header("LOCATION: settings.php?lang=" . $lang);
		}
	}

	$existing_users = $db->getUsers();
	$settings = $db->getSettings();
	$group_mapping = $db->getGroupMapping();
	$json_group_mapping = json_encode($group_mapping, JSON_HEX_TAG);

	$locations = $db->getExistingConsultLocations();

	$db->close();

	$default_consult_medical_group = $settings['default_consult_medical_group'];
	$default_consult_chief_physician = $settings['default_consult_chief_physician'];
	$default_consult_location = $settings['default_consult_location'];

	$edit_code = $settings['edit_code'];

?>

<script type="text/javascript">
var php_group_mapping = <?php echo $json_group_mapping; ?>; 

</script>


<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo SETTINGS; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<a id="back_link" onclick="backClick();">Back to Main Page</a>
		</div>
	</div>

	<div class="row consult_row" >
		<div class="col-xs-12">
			<ul class="list-group">
				<li class="list-group-item" onclick="userManagementClick(<?php echo '\'' . $user_id . '\''; ?>);">
					<?php echo USER_MANAGAMENT; ?>
				</li>
				<li class="list-group-item" onclick="defaultConsultInformationClick(<?php echo '\'' .  $user_id . '\''; ?>);">
					<?php echo DEFAULT_CONSULT_INFORMATION; ?>
				</li>
				<li class="list-group-item" onclick="consultEditCodeClick(<?php echo '\'' .  $user_id . '\''; ?>);">
					<?php echo CONSULT_EDIT_CODE; ?>
				</li>
			</ul>
		</div>
	</div>
	
</div>

<div id="editCodeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo CONSULT_EDIT_CODE; ?></p>
      </div>
      <div class="modal-body">
      	<div class="input_row">
        	<p class="left_title4"><?php echo EDIT_CODE_FIELD; ?></p>
        	<input id='edit_code_input' class='modal_input_field' value="<?php echo $edit_code; ?>">
        </div>
      </div>
      <div class="modal-footer">
        <button id="edit_code_save_button" type="button" class="btn btn-default"><?php echo SUBMIT; ?></button>
      </div>
    </div>
  </div>
</div>

<div id="userManagementModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo USER_MANAGAMENT; ?></p>
      </div>
      <div class="modal-body">
      	<ul id="users_list" class="list-group">
      	<?php
      		foreach($existing_users as $user) {
      			$id = $user['id'];
      			$name = $user['name'];
      			$username = $user['username'];
      			echo '<li class="list-group-item" onclick="userClick(\'' . $id . '\', \'' . $user_id . '\', \'' . $name . '\', \'' . $username . '\');">' . $username . '</li>';
      		}
      	?>
      	</ul>
      	<div class="input_row">
    		<a class="left_title4" onclick="showAddUserFields();"><?php echo ADD_NEW_USER; ?></a>
    	</div>
      	<div id="add_user_fields" class="hidden">
	      	<div class="input_row">
	        	<p class="left_title4"><?php echo NAME_FIELD; ?></p>
	        	<input id='name_input' class='modal_input_field'>
	        </div>
	      	<div class="input_row">
	        	<p class="left_title4"><?php echo USERNAME_FIELD; ?></p>
	        	<input id='username_input' class='modal_input_field'>
	        </div>
	    	<div class="input_row">
	    		<p class="left_title4"><?php echo PASSWORD_FIELD; ?></p>
	    		<input id='password_input' class='modal_input_field' type='password'>
	    	</div>
	    </div>
      </div>
      <div class="modal-footer">
        <button id="user_management_save_button" type="button" class="btn btn-default hidden"><?php echo SUBMIT; ?></button>
      </div>
    </div>
  </div>
</div>

<div id="userManagementModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo USER_MANAGAMENT; ?></p>
      </div>
      <div class="modal-body">
      	<div class="input_row">
    		<a class="left_title4" onclick="userManagementClick();"><?php echo GO_BACK; ?></a>
    	</div>
      	<div class="input_row">
        	<p class="left_title4"><?php echo NAME_FIELD; ?></p>
        	<p id='name_field' class='modal_input_field'></p>
        </div>
      	<div class="input_row">
        	<p class="left_title4"><?php echo USERNAME_FIELD; ?></p>
        	<p id='username_field' class='modal_input_field'></p>
        </div>
      </div>
      <div class="modal-footer">
        <button id="user_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
      </div>
    </div>
  </div>
</div>

<div id="defaultConsultInformationModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo CONSULT_INFORMATION; ?></p>
      </div>
      <div class="modal-body">

		<div class="input_row">
			<p class="input_label"><?php echo LOCATION_FIELD; ?></p>
			<select id="location_select" class="input_field">
				<?php
					$location_match_found = false;
					if($default_consult_location) {
						echo '<option value="-1">' . TOUCH_HERE . '</option>';
						foreach($locations as $location_obj) {
							$location = $location_obj['location'];
							if($location) {
								if($default_consult_location == $location) {
									$location_match_found = true;
						    		echo '<option value="' . $location . '" selected>' . $location .'</option>';
						    	} else {
						    		echo '<option value="' . $location . '">' . $location .'</option>';
						    	}
						    }
					    }
					} else {
						echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
						foreach($locations as $location_obj) {
							$location = $location_obj['location'];
							if($location) {
						    	echo '<option value="' . $location . '">' . $location .'</option>';
						    }
					    }
					}
				?>
				<option value="-2"><?php echo OTHER; ?></option>
			</select>
			<div id="other_location_div" class="hidden input_field other_field">
				<?php
					if($location_match_found || !$default_consult_location) {
						echo '<input id="other_location_input" type="text" placeholder="' . OTHER . '">';
					} else {
						echo '<input id="other_location_input" type="text" value="' . $default_consult_location . '">';
					}
				?>
			</div>
		</div>

		<div class="input_row">
			<p class="input_label"><?php echo MEDICAL_GROUP_FIELD; ?></p>
			<select id="medical_group_select" class="input_field">
				<?php
					$medical_group_match_found = false;
					if($default_consult_medical_group) {
						echo '<option value="-1">' . TOUCH_HERE . '</option>';
						foreach($group_mapping as $medical_group => $chief_physicians) {
							if($default_consult_medical_group == $medical_group) {
								$medical_group_match_found = true;
					    		echo '<option value="' . $medical_group . '" selected>' . $medical_group .'</option>';
					    	} else {
					    		echo '<option value="' . $medical_group . '">' . $medical_group .'</option>';
					    	}
					    }
					} else {
						echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
						foreach($group_mapping as $medical_group => $chief_physicians) {
					    	echo '<option value="' . $medical_group . '">' . $medical_group .'</option>';
					    }
					}
				?>
				<?php
					if($medical_group_match_found || !$default_consult_medical_group) {
						echo '<option value="-2">' . OTHER . '</option>';
					} else {
						echo '<option value="-2" selected>' . OTHER . '</option>';
					}
				?>
			</select>
			<div id="other_medical_group_div" class="hidden input_field other_field">
				<?php
					if($medical_group_match_found || !$default_consult_medical_group) {
						echo '<input id="other_medical_group_input" type="text" placeholder="' . OTHER . '">';
					} else {
						echo '<input id="other_medical_group_input" type="text" value="' . $default_consult_medical_group . '">';
					}
				?>
			</div>
		</div>



		<div id="chief_physician_row" class="input_row hidden">
			<p class="input_label"><?php echo CHIEF_PHYSICIAN_FIELD; ?></p>
			<select id="chief_physician_select" class="input_field">
				<?php
					$chief_physician_match_found = false;
					if($default_consult_medical_group) {
						$chief_physicians = $group_mapping[$default_consult_medical_group];
						if ($default_consult_chief_physician) {
							echo '<option value="-1">' . TOUCH_HERE . '</option>';
							foreach($chief_physicians as $chief_physician) {
								if($default_consult_chief_physician == $chief_physician) {
									$chief_physician_match_found = true;
						    		echo '<option value="' . $chief_physician . '" selected>' . $chief_physician .'</option>';
						    	} else {
						    		echo '<option value="' . $chief_physician . '">' . $chief_physician .'</option>';
						    	}
						    }
						} else {
							echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
							foreach($chief_physicians as $chief_physician) {
						    	echo '<option value="' . $chief_physician . '">' . $chief_physician .'</option>';
						    }
						}
					}
				?>
				<option value="-2"><?php echo OTHER; ?></option>
			</select>
			<div id="other_chief_physician_div" class="hidden input_field other_field">
				<?php
					if(($medical_group_match_found && $chief_physician_match_found) || !$default_consult_chief_physician) {
						echo '<input id="other_chief_physician_input" type="text" placeholder="' . OTHER . '">';
					} else {
						echo '<input id="other_chief_physician_input" type="text" value="' . $default_consult_chief_physician . '">';
					}
				?>
			</div>
		</div>

      </div>
      <div class="modal-footer">
        <button id="consult_information_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
      </div>
    </div>
  </div>
</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
}

function userManagementClick(user_id) {
	$("#userManagementModal1").modal("show");
	$("#userManagementModal2").modal("hide");
	$("#add_user_fields").addClass("hidden");
	$("#user_management_save_button").addClass("hidden");
	$("#user_management_save_button").click(function() {
		submitNewUser(user_id);
	});
}

function submitNewUser(user_id) {
	var name_input = $("#name_input").val();
	var username_input = $("#username_input").val();
	var password_input = $("#password_input").val();

	if(name_input && username_input && password_input) {
		window.location.href = "settings.php?user_id=" + user_id + "&name=" + name_input + "&username=" + username_input + "&password=" + password_input + getLang(1);
	} else {
		alert(EMPTY_FIELDS_MUST_COMPLETE_MESSAGE);
	}


}

function userClick(id, user_id, name, username) {
	$("#userManagementModal2").modal("show");
	$("#userManagementModal1").modal("hide");

	$("#name_field").html(name);
	$("#username_field").html(username);

	$("#user_delete_button").click(function() {
		window.location.href = "settings.php?delete=2&id=" + id + "&user_id=" + user_id + getLang(1);
	});
}

function showAddUserFields() {
	$("#add_user_fields").removeClass("hidden");
	$("#user_management_save_button").removeClass("hidden");
}

function defaultConsultInformationClick(user_id) {
	$("#defaultConsultInformationModal").modal("show");
	$("#consult_information_save_button").click(function() {
		defaultConsultInformationSaveClick(user_id);
	});
}

function consultEditCodeClick(user_id) {
	$("#editCodeModal").modal("show");
	$("#edit_code_save_button").click(function() {
		submitEditCode(user_id);
	});
}

function submitEditCode(user_id) {
	var edit_code = $("#edit_code_input").val();
	if(!edit_code || edit_code.length < 6) {
		alert(ALERT_INVALID_EDIT_CODE);
	} else {
		var lang_text = getLang(1);
		window.location.href = "settings.php?user_id=" + user_id + "&edit_code=" + edit_code + lang_text;
	}
}

var medical_group_selected = $("#medical_group_select").val();
if (medical_group_selected != "-1") {
	$("#chief_physician_row").removeClass("hidden");
}
var other_location = $("#other_location_input").val();
if(other_location) {
	$("#location_select").val("-2");
	$("#other_location_div").removeClass("hidden");
}
var other_medical_group = $("#other_medical_group_input").val();
if(other_medical_group) {
	$("#other_medical_group_div").removeClass("hidden");
	$("#chief_physician_row").removeClass("hidden");
	$("#chief_physician_select").addClass("hidden");
	$("#other_chief_physician_div").removeClass("hidden");
}
var other_chief_physician = $("#other_chief_physician_input").val();
if(other_chief_physician) {
	$("#chief_physician_select").val("-2");
	$("#other_chief_physician_div").removeClass("hidden");
}
$("#location_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_location_div").removeClass("hidden");
	} else {
		$("#other_location_div").addClass("hidden");
	}
});
$("#medical_group_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_medical_group_div").removeClass("hidden");
		$("#chief_physician_row").removeClass("hidden");
		$("#chief_physician_select").addClass("hidden");
		$("#other_chief_physician_div").removeClass("hidden");
	} else {
		$("#other_medical_group_div").addClass("hidden");
		if (value == "-1") {
			$("#chief_physician_row").addClass("hidden");
		} else {
			$("#chief_physician_row").removeClass("hidden");
			$("#chief_physician_select").removeClass("hidden");
			$("#other_chief_physician_div").addClass("hidden");	
			var chief_physicians = php_group_mapping[value];
			$("#chief_physician_select").empty();
			var element = '<option value="-1" selected>' + TOUCH_HERE + '</option>';
			$("#chief_physician_select").append(element);
			for(var i = 0; i < chief_physicians.length; i++) {
				var chief_physician = chief_physicians[i];
				element = '<option value="' + chief_physician + '">' + chief_physician + '</option>';
				$("#chief_physician_select").append(element);
			}	
			 element = '<option value="-2">' + OTHER + '</option>';
			$("#chief_physician_select").append(element);
		}
	}
});
$("#chief_physician_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_chief_physician_div").removeClass("hidden");
	} else {
		$("#other_chief_physician_div").addClass("hidden");
	}
});

function defaultConsultInformationSaveClick(user_id) {
	var location = $("#location_select").val();
	if(location == "-1") {
		location = "";
	} else if (location == "-2") {
		location = $("#other_location_input").val();
	}
	var medical_group = $("#medical_group_select").val();
	if(medical_group == "-1") {
		medical_group = "";
	} else if (medical_group == "-2") {
		medical_group = $("#other_medical_group_input").val();
	}
	var chief_physician = $("#chief_physician_select").val();
	if(chief_physician == "-1") {
		chief_physician = "";
	} else if (chief_physician == "-2") {
		chief_physician = $("#other_chief_physician_input").val();
	}
	if(!medical_group) {
		chief_physician = "";
	}
	window.location.href = "settings.php?user_id=" + user_id + "&location=" + location + "&medical_group=" + medical_group + "&chief_physician=" + chief_physician + getLang(1);
}


</script>

</html>


