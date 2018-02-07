
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>


<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<style type="text/css">


#followup_content_div {
	display: none;
}

#custom_type_row {
	display: none;
}

#reason_select_row {
	display: none;
}

#custom_reason_row {
	display: none;
}

</style>


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

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		if(isset($_GET['is_needed'])) {
			$is_needed = $_GET['is_needed'];
			if(!$is_needed) {
				$is_needed = NULL;
			}
			$is_type_custom = $_GET['is_type_custom'];
			if(!$is_type_custom) {
				$is_type_custom = NULL;
			}
			$type = $_GET['type'];
			if(!$type) {
				$type = NULL;
			}
			$is_reason_custom = $_GET['is_reason_custom'];
			if(!$is_reason_custom) {
				$is_reason_custom = NULL;
			}
			$reason = $_GET['reason'];
			if(!$reason) {
				$reason = NULL;
			}
			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}

			$continue = $_GET['continue'];

			echo $db->createNewFollowup($consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes);
			if($continue == 2) {
				header("LOCATION: sign_complete.php?consult_id=" . $consult_id . "&lang=" . $lang);
			} else {
				header("LOCATION: followup.php?consult_id=" . $consult_id . "&lang=" . $lang);
			}
		}
	} else {
		header($index_link);
	}


	$editable = true;
	$consult = $db->getConsult($consult_id);
	$patient_id = $consult["patient_id"];

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

	$followup = null;
	if($db->hasExistingFollowup($consult_id)) {
		$followup = $db->getFollowup($consult_id);
	}

?>

<div class="container-fluid">

	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row consult_link_row">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<p class="content_p consult_section"><?php echo FOLLOWUP; ?></p>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo IS_A_FOLLOWUP_NEEDED; ?></p>
			<form id="followup_referral_radiogroup" class="input_field">
<?php
				if($followup && isset($followup['is_needed'])) {
					$is_needed = $followup['is_needed'];
					if($is_needed == BOOLEAN_FALSE) {
						echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes'><label for='is_needed_input_yes'>Yes</label>";
						echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no' checked='checked'><label for='is_needed_input_no'>No</label>";
					} else if ($is_needed == BOOLEAN_TRUE) {
						echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes' checked='checked'><label for='is_needed_input_yes'>Yes</label>";
						echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no'><label for='is_needed_input_no'>No</label>";
					}
				} else {
					echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes'><label for='is_needed_input_yes'>Yes</label>";
					echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no'><label for='is_needed_input_no'>No</label>";
				}
?>
			</form>
		</div>
	</div>

	<div id="followup_content_div">
		<div id="type_select_row" class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo FOLLOWUP_REFERRAL . ": "; ?></p>
				<select id="type_select" class="input_field">
<?php
				for($i = 0; $i < sizeof(TYPE_ARRAY); $i++) {
					$type = TYPE_ARRAY[$i];
					$default_set = false;
					if($followup && isset($followup['is_type_custom']) && isset($followup['type'])) {
						$is_type_custom = $followup['is_type_custom'];
						$selected_type = $followup['type'];
						if($i < sizeof(TYPE_ARRAY) - 1 && $is_type_custom == BOOLEAN_FALSE && $selected_type == $i) {
							$default_set = true;
							echo "<option value='$i' selected>$type</option>";
						} else if ($i == sizeof(TYPE_ARRAY) - 1 && $is_type_custom == BOOLEAN_TRUE) {
							$defaut_set = true;
							echo "<option value='other' selected>$type</option>";
						} 
					} 
					if(!$default_set) {
						if($i < sizeof(TYPE_ARRAY) - 1) {
							echo "<option value='$i'>$type</option>";
						} else {
							echo "<option value='other'>$type</option>";
						}
						
					}
				}
?>
				</select>

			</div>
		</div>

		<div id="custom_type_row" class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo FOLLOWUP_REFERRAL_CUSTOM . ": "; ?></p>
	<?php
					if($followup && isset($followup['is_type_custom']) && isset($followup['type'])) {
						$is_type_custom = $followup['is_type_custom'];
						$type = $followup['type'];
						if($is_type_custom == BOOLEAN_TRUE) {
							echo "<input id='type_custom' class='input_field' type='text' value='$type'>";
						} else {
							echo "<input id='type_custom' class='input_field' type='text'>";
						}
					} else {
						echo "<input id='type_custom' class='input_field' type='text'>";
					}
	?>
			</div>
		</div>

		<div id="reason_select_row" class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo REASON . ": "; ?></p>
				<select id="reason_select" class="input_field">
<?php
				foreach(REASON_MAP as $key => $reason_array) {
					for($i = 0; $i < sizeof($reason_array); $i++) {
						$reason = $reason_array[$i];

						$default_set = false;
						if($followup) {
							$is_type_custom = $followup['is_type_custom'];
							$type = $followup['type'];
							$is_reason_custom = $followup['is_reason_custom'];
							$selected_reason = $followup['reason'];
							if($is_type_custom == BOOLEAN_FALSE && $is_reason_custom == BOOLEAN_FALSE) {
								if($key == $type && $i == $selected_reason) {
									$default_set = true;
									echo "<option rel='$key' value='$i' selected>$reason</option>";
								} 
							} else if ($is_type_custom == BOOLEAN_FALSE && $is_reason_custom == BOOLEAN_TRUE) {
								if($key == $type && $i == sizeof($reason_array)-1) {
									$default_set = true;
									echo "<option rel='$key' value='other' selected>$reason</option>";
								}
							}
						}

						if(!$default_set) {
							if($i < sizeof($reason_array) - 1) {
								echo "<option rel='$key' value='$i'>$reason</option>";
							} else {
								echo "<option rel='$key' value='other'>$reason</option>";
							}
						}
					}
				}
?>
				</select>

			</div>
		</div>

		<div id="custom_reason_row" class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo REASON_CUSTOM . ": "; ?></p>
	<?php
					if($followup && isset($followup['is_reason_custom']) && isset($followup['reason'])) {
						$is_reason_custom = $followup['is_reason_custom'];
						$reason = $followup['reason'];
						if($is_reason_custom == BOOLEAN_TRUE) {
							echo "<input id='reason_custom' class='input_field' type='text' value='$reason'>";
						} else {
							echo "<input id='reason_custom' class='input_field' type='text'>";
						}
					} else {
						echo "<input id='reason_custom' class='input_field' type='text'>";
					}
	?>
			</div>
		</div>

			<div class="row input_row">
				<div class="col-xs-12">
					<p class="input_label"><?php echo NOTES . ": "; ?></p>
		<?php
						if($followup && isset($followup['notes'])) {
							$notes = $followup['notes'];
							echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
						} else {
							echo "<textarea id='notes_input' class='input_field'></textarea>";
						}
		?>	
				</div>
			</div>




	</div>

<?php
	if($editable) {
?>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveStayFunction(<?php echo $consult_id . ", " . $patient_id . ", 1"; ?>);"><?php echo SAVE_AND_STAY; ?></button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveStayFunction(<?php echo $consult_id . ", " . $patient_id . ", 2"; ?>);"><?php echo SAVE_AND_CONTINUE; ?></button>
		</div>
	</div>

<?php
	} else {
?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);"><?php echo CONTINUE_WORD; ?></button>
		</div>
	</div>

<?php
	}
?>

</div>

<script type="text/javascript">

var is_followup_needed = $("input[name=is_needed_input]:checked").val();
if (is_followup_needed == "yes") {
	$('#followup_content_div').show();
} else if (is_followup_needed == "no") {
	$('#followup_content_div').hide();
} else {
	$('#followup_content_div').hide();
}

var type_selected = $('#type_select').find(":selected").val();
if(type_selected == '0') {
	$("#custom_type_row").hide();
	$("#custom_reason_row").hide();
	$("#reason_select_row").hide();
} else if(type_selected == 'other') {
	$("#custom_type_row").show();
	$("#custom_reason_row").show();
	$("#reason_select_row").hide();
} else {
	$("#custom_type_row").hide();
	$("#custom_reason_row").hide();
	$("#reason_select_row").show();

	$("#reason_select option").hide();
	$("#reason_select").find("[rel=" + type_selected + "]").show();

	var reason_selected = $('#reason_select').find(":selected").val();
	if(reason_selected == '0') {
		$("#custom_reason_row").hide();
	} else if (reason_selected == 'other') {
		$("#custom_reason_row").show();
	} else {
		$("#custom_reason_row").hide();
	}
}





$("input[name=is_needed_input]").change(function() {
	var value = $("input[name=is_needed_input]:checked").val();
	if (value == "yes") {
		$('#followup_content_div').show();
	} else if (value == "no") {
		$('#followup_content_div').hide();
	} else {
		$('#followup_content_div').hide();
	}
});

$("#type_select").change(function() {
	var selected = $('#type_select').find(":selected").val();

	if (selected == "other")  {
		$("#custom_type_row").show();
		$("#custom_reason_row").show();
		$("#reason_select_row").hide();
	} else if (selected == '0') {
		$("#custom_type_row").hide();
		$("#custom_reason_row").hide();
		$("#reason_select_row").hide();
	} else {
		$("#custom_type_row").hide();
		$("#custom_reason_row").hide();
		$("#reason_select_row").show();

		$("#reason_select option").hide();
		$("#reason_select").find("[rel=" + selected + "]").show();
		
		$("#reason_select option[value='0'][rel=" + selected + "]").prop("selected", true);

	}
});

$("#reason_select").change(function() {
	var selected = $('#reason_select').find(":selected").val();

	if (selected == "other")  {
		$("#custom_reason_row").show();
	} else if (selected == '0') {
		$("#custom_reason_row").hide();
	} else {
		$("#custom_reason_row").hide();
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

function saveStayFunction(consult_id, patient_id, arg) {
	var valid_submission = true;

	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var is_followup_needed = $("input[name=is_needed_input]:checked").val();
	var type_selected = $('#type_select').find(":selected").val();
	var type_custom = $('#type_custom').val();
	var reason_selected = $('#reason_select').find(":selected").val();
	var reason_custom = $('#reason_custom').val();
	var notes = $('#notes_input').val();

	var is_needed = 0;
	var is_type_custom = 0;
	var type = "";
	var is_reason_custom = 0;
	var reason = "";

	if(is_followup_needed == 'yes') {
		is_needed = 2;
	} else if (is_followup_needed == 'no') {
		is_needed = 1;
		notes = "";
	} else {
		valid_submission = false;
	}
	if(is_needed == 2) {
		if(type_selected == '0') {
			valid_submission = false;
		} else if(type_selected == 'other') {
			is_type_custom = 2;
			if(type_custom) {
				type = type_custom;
				is_reason_custom = 2;
				if(reason_custom) {
					reason = reason_custom;
				} else {
					valid_submission = false;
				}
			} else {
				valid_submission = false;
			}
		} else {
			is_type_custom = 1;
			type = type_selected;
			if(reason_selected == 'other') {
				is_reason_custom = 2;
				if(reason_custom) {
					reason = reason_custom;
				} else {
					valid_submission = false;
				}
			} else {
				is_reason_custom = 1;
				reason = reason_selected;
			}
		}
	}

	if(!valid_submission) {
		var alert_text = "ERROR: MUST ANSWER ALL QUESTIONS.";
		if(lang == "es") {
			alert_text = "ERROR: NECESITA CONTESTAR TODAS LAS PREGUNTAS.";
		}
		alert(alert_text);
		return;
	}

	window.location.href = "followup.php?patient_id=" + patient_id + "&consult_id=" + consult_id + "&is_needed=" + is_needed + "&is_type_custom=" + is_type_custom + "&type=" + type + "&is_reason_custom=" + is_reason_custom + "&reason=" + reason + "&notes=" + notes + "&continue=" + arg + extra_text;

}

function saveMainMenuFunction(consult_id, patient_id) {

}

function goBackFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments.php?consult_id=" + consult_id + extra_text;
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "sign_complete.php?consult_id=" + consult_id + extra_text; 
}

function functionClick(consult_id, diagnosis_index) {
}


</script>

