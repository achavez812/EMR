
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>


<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


<?php
	$lang = "en";
	$index_link = "LOCATION: index.php";
	$constants_file = '../include/Constants_en.php';
	if(isset($_GET['lang'])) {
		$lang = $_GET['lang'];
		$index_link .= "?lang=" . $lang;
		if($lang == "es") {
			$constants_file = '../include/Constants_es.php';
		}
	}
	require_once $constants_file;

	require_once '../include/DbOperation.php';
	require_once '../include/Constants.php';
	require_once '../include/Utilities.php';


	$db = new DbOperation();

	$consult_id = 0;

	$consult;
	$patient_id;
	$medical_group = NULL;
	$chief_physician = NULL;
	$signing_physician = NULL;
	$location = NULL;
	$notes = NULL;
	$datetime_completed = NULL;

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		$patient_id = $consult["patient_id"];
		$medical_group = $consult["medical_group"];
		$chief_physician = $consult["chief_physician"];
		$signing_physician = $consult["signing_physician"];
		$location = $consult["location"];
		$notes = $consult["notes"];
		$datetime_completed = $consult["datetime_completed"];

		if(isset($_GET['medical_group'])) {
			$medical_group = $_GET['medical_group'];
			if(isset($_GET['chief_physician'])) {
				$chief_physician = $_GET['chief_physician'];
				$signing_physician = $_GET['signing_physician'];
				$location = $_GET['location'];
				$notes = $_GET['notes'];
				$is_complete = $_GET['is_complete'];
				$datetime_completed = NULL;

				if(!$medical_group) {
					$medical_group = NULL;
				}
				if(!$chief_physician) {
					$chief_physician = NULL;
				}
				if(!$signing_physician) {
					$signing_physician = NULL;
				}
				if(!$location) {
					$location = NULL;
				}
				if($is_complete == 'yes') {
					$datetime_completed = Utilities::getCurrentDateTime();
				}
				if(!$notes) {
					$notes = NULL;
				}

				if(isset($_GET['new'])) {
					$new = $_GET['new'];
					if($new == 2) {
						$location = $db->createCommunity($location);
					}
				}

				$db->updateConsult($consult_id, $medical_group, $chief_physician, $signing_physician, $location, $notes, $datetime_completed);

				$continue = $_GET['continue'];
				if($continue == 2) {
					if($is_complete == "yes" && $consult['status'] != CONSULT_STATUS_EDIT) {
						header("LOCATION: consult_complete.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
					} else {
						header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
					}
				} else {
					header("LOCATION: sign_complete.php?consult_id=" . $consult_id . "&lang=" . $lang);
				}
			}
		}	
	} else {
		header($index_link);
	}

	$editable = true;
	$patient = $db->getPatientById($patient_id);	

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (" . APPROXIMATE_ABBREVIATION . ")";
	}

	$datetime_started = $consult["datetime_started"];
	$in_progress = true;
	if(isset($consult["datetime_completed"])) {
		$in_progress = false;

		$status = $consult['status'];
		if($status != CONSULT_STATUS_EDIT) {
			$editable = false;
		}
	}

	$formatted_datetime_started = Utilities::reformatDateForDisplay2($datetime_started);

	$display_text = CONSULT . " " . $formatted_datetime_started;
	if($in_progress) {
		$display_text .= " (" . IN_PROGRESS . ")";
	} else {
		$display_text .= " (" . COMPLETED . ")";
	}

	$medical_groups = $db->getExistingMedicalGroups();
	$chief_physicians = array();
	$signing_physicians = array();
	$locations = $db->getAllCommunities();
	if($medical_group) {
		$chief_physicians = $db->getExistingChiefPhysicians($medical_group);
		$signing_physicians = $db->getExistingSigningPhysicians($medical_group);
	}
	

?>

<div class="container-fluid">
	<span class="no_display" id="hidden_consult_id"><?php echo $consult_id; ?></span>
	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row consult_link_row">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<p class="content_p consult_section"><?php echo SIGN_AND_COMPLETE; ?></p>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo MEDICAL_GROUP; ?></p>
			<select id="medical_group_select" class="input_field">
				<option value="default"><?php echo TOUCH_HERE; ?></option>
			<?php
				foreach($medical_groups as $group) {
					$name = $group['medical_group'];
					if($medical_group == $name) {
						echo "<option value='$name' selected>$name</option>";
					} else {
						echo "<option value='$name'>$name</option>";
					}
				}
				echo "<option value='other'>Unlisted</option>";

			?>
			</select>

			<div id="other_medical_group_div" class="no_display input_field other_field">
				<input id="other_medical_group_input" type="text" placeholder="Unlisted">
			</div>
		</div>
	</div>
	<div id="chief_physician_row" class="row input_row no_display">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo CHIEF_PHYSICIAN; ?></p>
			<select id="chief_physician_select" class="input_field">
				<option value="default"><?php echo TOUCH_HERE; ?></option>
			<?php
				foreach($chief_physicians as $physician) {
					$name = $physician['chief_physician'];
					if($chief_physician == $name) {
						echo "<option value='$name' selected>$name</option>";
					} else {
						echo "<option value='$name'>$name</option>";
					}
				}
				echo "<option value='other'>" . UNLISTED ."</option>";

			?>
			</select>
			<div id="other_chief_physician_div" class="no_display input_field other_field">
				<input id="other_chief_physician_input" type="text" placeholder="<?php echo UNLISTED;?>">
			</div>
		</div>
	</div>
	<div id="signing_physician_row" class="row input_row no_display">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo SIGNING_PHYSICIAN; ?></p>
			<select id="signing_physician_select" class="input_field">
				<option value="default"><?php echo TOUCH_HERE; ?></option>
			<?php
				foreach($signing_physicians as $physician) {
					$name = $physician['signing_physician'];
					if($signing_physician == $name) {
						echo "<option value='$name' selected>$name</option>";
					} else {
						echo "<option value='$name'>$name</option>";
					}
				}
				echo "<option value='other'>" . UNLISTED ."</option>";

			?>
			</select>
			<div id="other_signing_physician_div" class="no_display input_field other_field">
				<input id="other_signing_physician_input" type="text" placeholder="<?php echo UNLISTED;?>">
			</div>
		</div>
	</div>
	<div id="location_row" class="row input_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo LOCATION; ?></p>
			<select id="location_select" class="input_field">
				<option value="default"><?php echo TOUCH_HERE; ?></option>
			<?php
				foreach($locations as $community) {
					$community_id = $community["id"];
					$community_name = $community["name"];
					if($location == $community_id) {
						echo "<option value='$community_id' selected>$community_name</option>";
					} else {
						echo "<option value='$community_id'>$community_name</option>";
					}
				}
				echo "<option value='other'>" . UNLISTED ."</option>";

			?>
			</select>
			<div id="other_location_div" class="no_display input_field other_field">
				<input id="other_location_input" type="text" placeholder="<?php echo UNLISTED;?>">
			</div>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo NOTES; ?></p>
<?php
				if($notes) {
					$notes = $consult['notes'];
					echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
				} else {
					echo "<textarea id='notes_input' class='input_field'></textarea>";
				}
?>	
		</div>
	</div>
	<div class="row input_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo LOG_CONSULT_AS_COMPLETE; ?></p>
		<?php
			if($datetime_completed) {
				echo "<input id='consult_complete_yes' type='radio' name='consult_complete' value='yes' checked><label for='consult_complete_yes'>" . YES . "</label>";
				echo "<input id='consult_complete_no' type='radio' name='consult_complete' value='no'><label for='consult_complete_no'>" . NO . "</label>";
			} else {
				echo "<input id='consult_complete_yes' type='radio' name='consult_complete' value='yes'><label for='consult_complete_yes'>" . YES . "</label>";
				echo "<input id='consult_complete_no' type='radio' name='consult_complete' value='no' checked><label for='consult_complete_no'>" . NO . "</label>";
			}
		?>
		</div>
	</div>

<?php
	if($editable) {
?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveFunction(<?php echo $consult_id . ", " . $patient_id . ", 2"; ?>);"><?php echo SAVE_AND_CONTINUE; ?></button>
		</div>
	</div>
<?php
	} else {
?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id . ", " . $patient_id; ?>);"><?php echo CONTINUE_WORD; ?></button>
		</div>
	</div>

<?php
	}
?>
</div>

<script type="text/javascript">

var medical_group_selected = $("#medical_group_select").val();
if (medical_group_selected != "default") {
	$("#chief_physician_row").show();
	$("#signing_physician_row").show();
}

$("#medical_group_select").change(function() {
	var value = $(this).val();
	if(value == "other") {
		$("#other_medical_group_div").show();

		$("#chief_physician_row").show();
		$("#chief_physician_select").hide();
		$("#other_chief_physician_div").show();

		$("#signing_physician_row").show();
		$("#signing_physician_select").hide();
		$("#other_signing_physician_div").show();
	} else {
		if(value != "default") {
			var url_string = window.location.href;
			var url = new URL(url_string);
			var lang = url.searchParams.get("lang");
			var extra_text = "";
			if(lang) {
				extra_text = "&lang=" + lang;
			}
			var consult_id = $("#hidden_consult_id").html();
			window.location.href = "sign_complete.php?consult_id=" + consult_id + "&medical_group=" + value + extra_text;
		} else {
			$("#other_medical_group_div").hide();
			$("#chief_physician_row").hide();
			$("#signing_physician_row").hide();
		}
	}
});

$("#chief_physician_select").change(function() {
	var value = $(this).val();
	if(value == "other") {
		$("#other_chief_physician_div").show();
	} else {
		$("#other_chief_physician_div").hide();
	}
});

$("#signing_physician_select").change(function() {
	var value = $(this).val();
	if(value == "other") {
		$("#other_signing_physician_div").show();
	} else {
		$("#other_signing_physician_div").hide();
	}
});

$("#location_select").change(function() {
	var value = $(this).val();
	if(value == "other") {
		$("#other_location_div").show();
	} else {
		$("#other_location_div").hide();
	}
});

function nameClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "profile.php?id=" + patient_id + extra_text;
}

function consultClick(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
}

function saveFunction(consult_id, patient_id, arg) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var new_community = false;

	var medical_group = "";
	var chief_physician = "";
	var signing_physician = "";
	var location = "";
	var notes = "";
	var is_complete = "";

	medical_group = $("#medical_group_select").val();
	if (medical_group == "other") {
		medical_group = $("#other_medical_group_input").val();
		chief_physician = $("#other_chief_physician_input").val();
		signing_physician = $("#other_signing_physician_input").val();
	} else {
		chief_physician = $("#chief_physician_select").val();
		if(chief_physician == "other") {
			chief_physician = $("#other_chief_physician_input").val();
		}
		signing_physician = $("#signing_physician_select").val();
		if(signing_physician == "other") {
			signing_physician = $("#other_signing_physician_input").val();
		}
	}


	location = $("#location_select").val();
	if(location == "other") {
		new_community = true;
		location = $("#other_location_input").val();
	}

	notes = $("#notes_input").val();

	is_complete = $("input[name=consult_complete]:checked").val();
	if(!is_complete) {
		is_complete = "";
	}

	if(is_complete == "yes" && (medical_group == "default" || chief_physician == "default" || signing_physician == "default" || location == "default" || !medical_group || !chief_physician || !signing_physician || !location || !is_complete)) {
		var alert_text = "ERROR: MUST ENTER ALL FIELDS TO COMPLETE CONSULT";
		if(lang == "es") {
			alert_text = "ERROR: NECESITA LLENAR TODOS LOS CAMPOS PARA COMPLETAR LA CONSULTA."
		}
		alert(alert_text);
	} else {
		if(new_community) {
			window.location.href = "sign_complete.php?consult_id=" + consult_id + "&medical_group=" + medical_group + "&chief_physician=" + chief_physician + "&signing_physician=" + signing_physician + "&notes=" + notes + "&is_complete=" + is_complete + "&location=" + location + "&new=2" + "&continue=" + arg + extra_text; 
		} else {
			window.location.href = "sign_complete.php?consult_id=" + consult_id + "&medical_group=" + medical_group + "&chief_physician=" + chief_physician + "&signing_physician=" + signing_physician + "&notes=" + notes + "&is_complete=" + is_complete + "&location=" + location + "&continue=" + arg + extra_text;
		}	
	}
}

function continueFunction(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?consult_id=" + consult_id + "&patient_id=" + patient_id + extra_text;
}

</script>

