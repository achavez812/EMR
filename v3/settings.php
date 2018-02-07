<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';

	if(isset($_GET['save'])) {
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
	}



	$group_mapping = $db->getGroupMapping();
	$settings = $db->getSettings();
	$locations = $db->getExistingConsultLocations();
	$db->close();
	$default_consult_medical_group = $settings['default_consult_medical_group'];
	$default_consult_chief_physician = $settings['default_consult_chief_physician'];
	$default_consult_location = $settings['default_consult_location'];

	$json_group_mapping = json_encode($group_mapping, JSON_HEX_TAG);

	if($lang == "es") {
		echo '<script type="text/javascript" src="js/Constants_es.js"></script>';
	} else {
		echo '<script type="text/javascript" src="js/Constants_en.js"></script>';
	}
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

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo LOCATION_FIELD; ?></p>
			<select id="location_select" class="input_field">
				<?php
					$location_match_found = false;
					if($default_consult_location) {
						echo '<option value="-1">' . TOUCH_HERE . '</option>';
						foreach($locations as $location_obj) {
							$location = $location_obj['location'];
							if($default_consult_location == $location) {
								$location_match_found = true;
					    		echo '<option value="' . $location . '" selected>' . $location .'</option>';
					    	} else {
					    		echo '<option value="' . $location . '">' . $location .'</option>';
					    	}
					    }
					} else {
						echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
						foreach($locations as $location_obj) {
							$location = $location_obj['location'];
					    	echo '<option value="' . $location . '">' . $location .'</option>';
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
	</div>

	

	<div class="row input_row">
		<div class="col-xs-12">
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
				<option value="-2"><?php echo OTHER; ?></option>
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
	</div>

	

	<div id="chief_physician_row" class="row input_row hidden">
		<div class="col-xs-12">
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

	<div id="button_row" class="row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick();"><?php echo SAVE_CAPS; ?></button>
		</div>
	</div>
	

	


</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
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

function saveClick() {
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

	window.location.href = "settings.php?save=2&location=" + location + "&medical_group=" + medical_group + "&chief_physician=" + chief_physician + getLang(1);
}



</script>

</html>


