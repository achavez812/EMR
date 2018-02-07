
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
	require_once '../include/Utilities.php';
	require_once '../include/Constants.php';
	

	$db = new DbOperation();

	$consult_id = 0;
	$primary_chief_complaints = array();
	$secondary_chief_complaints = array();

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];

		if(isset($_GET['primary']) && isset($_GET['secondary'])) {
			$primary = $_GET["primary"];
			$secondary = $_GET["secondary"];

			$primary_array = array();
			if($primary != "") {
				$primary_array = explode(",", $primary);
			}
			$secondary_array = array();
			if($secondary != "") {
				$secondary_array = explode(",", $secondary);
			}

			if($db->hasPrimaryChiefComplaint($consult_id)) {
				$existing_primary_chief_complaints = $db->getPrimaryChiefComplaints($consult_id);
				foreach($existing_primary_chief_complaints as $chief_complaint) {
					$id = $chief_complaint["id"];
					$type_is_custom = $chief_complaint["type_is_custom"];
					$type = $chief_complaint["type"];

					if($type_is_custom == BOOLEAN_TRUE) {
						if(!in_array($type, $primary_array)) {
							$db->deleteChiefComplaint($id);
							$db->deleteHPI($id);
						}
					} else {
						$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$type];
						if(!in_array($value, $primary_array)) {
							$db->deleteChiefComplaint($id);
							$is_pregnancy = BOOLEAN_FALSE;
							if($value == "pregnancy") {
								$is_pregnancy = BOOLEAN_TRUE;
							}
							$db->deleteHPI($id, $is_pregnancy);
						}
					}
				}
			}

			if($db->hasSecondaryChiefComplaint($consult_id)) {
				$existing_secondary_chief_complaints = $db->getSecondaryChiefComplaints($consult_id);
				foreach($existing_secondary_chief_complaints as $chief_complaint) {
					$id = $chief_complaint["id"];
					$type_is_custom = $chief_complaint["type_is_custom"];
					$type = $chief_complaint["type"];

					if($type_is_custom == BOOLEAN_TRUE) {
						if(!in_array($type, $secondary_array)) {
							$db->deleteChiefComplaint($id);
						}
					} else {
						$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$type];
						if(!in_array($value, $secondary_array)) {
							$db->deleteChiefComplaint($id);
							$is_pregnancy = BOOLEAN_FALSE;
							if($value == "pregnancy") {
								$is_pregnancy = BOOLEAN_TRUE;
							}
							$db->deleteHPI($id, $is_pregnancy);
						}
					}
				}
			}

			foreach($primary_array as $value) {
				$in_array = in_array($value, DEFAULT_CHIEF_COMPLAINT_VALUES);
				$index = array_search($value, DEFAULT_CHIEF_COMPLAINT_VALUES);
				if($in_array == FALSE) {
					$db->createChiefComplaint($consult_id, BOOLEAN_TRUE, $value, BOOLEAN_TRUE);
				} else {
					$db->createChiefComplaint($consult_id, BOOLEAN_FALSE, $index, BOOLEAN_TRUE);
				}
				
			}

			foreach($secondary_array as $value) {
				$in_array = in_array($value, DEFAULT_CHIEF_COMPLAINT_VALUES);
				$index = array_search($value, DEFAULT_CHIEF_COMPLAINT_VALUES);
				if($in_array == FALSE) {
					$db->createChiefComplaint($consult_id, BOOLEAN_TRUE, $value, BOOLEAN_FALSE);
				} else {
					$db->createChiefComplaint($consult_id, BOOLEAN_FALSE, $index, BOOLEAN_FALSE);
				}
			}

			
			if(isset($_GET['next'])) {
				//SEND TO THE RIGHT PAGE
				header("LOCATION: history_present_illness.php?consult_id=" . $consult_id . "&lang=" . $lang);
			} else {
				header("LOCATION: chief_complaints.php?consult_id=" . $consult_id . "&lang=" . $lang);
			}
		}


		if($db->hasPrimaryChiefComplaint($consult_id)) {
			$primary_chief_complaints = $db->getPrimaryChiefComplaints($consult_id);
		} 
		if($db->hasSecondaryChiefComplaint($consult_id)) {
			$secondary_chief_complaints = $db->getSecondaryChiefComplaints($consult_id);
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

	$primary_text = "";
	$primary_main_array = array();
	$primary_custom_array = array();
	$primary_is_other = FALSE;
	foreach($primary_chief_complaints as $primary_chief_complaint) {
		$type = $primary_chief_complaint['type'];
		if($primary_chief_complaint['type_is_custom'] == BOOLEAN_TRUE) {
			$primary_text .= $type . ", ";
			array_push($primary_custom_array, $type);
			$primary_is_other = TRUE;
		} else {
			$primary_text .= DEFAULT_CHIEF_COMPLAINT_LABELS[$type] . ", ";
			array_push($primary_main_array, $type);
		}
	}

	$secondary_text = "";
	$secondary_main_array = array();
	$secondary_custom_array = array();
	$secondary_is_other = FALSE;
	foreach($secondary_chief_complaints as $secondary_chief_complaint) {
		$type = $secondary_chief_complaint['type'];
		if($secondary_chief_complaint['type_is_custom'] == BOOLEAN_TRUE) {
			$secondary_text .= $type . ", ";
			array_push($secondary_custom_array, $type);
			$secondary_is_other = TRUE;
		} else {
			$secondary_text .= DEFAULT_CHIEF_COMPLAINT_LABELS[$type] . ", ";
			array_push($secondary_main_array, $type);
		}
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
			<p class="content_p consult_section"><?php echo CHIEF_COMPLAINT; ?></p>
		</div>
	</div>

	<div id="primary_chief_complaints_select_row" class="row chief_complaints_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo PRIMARY; ?></p>
			<?php
				if($primary_text) {
					$primary_text = substr($primary_text, 0, -2);
					echo "<p class='content_p3'>$primary_text</p>";
				}
			?>
			<select id="primary_chief_complaints_select" class="input_field" multiple>
			<?php
				$default_chief_complaint_length = sizeof(DEFAULT_CHIEF_COMPLAINT_VALUES);
				for($i = 0; $i < $default_chief_complaint_length; $i++) {
					$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$i];
					$label = DEFAULT_CHIEF_COMPLAINT_LABELS[$i];
					if(in_array((string)$i, $primary_main_array)) {
						echo "<option value='$value' selected>$label</option>";
					} else {
						echo "<option value='$value'>$label</option>";
					}
				}
				if($primary_is_other) {
					echo "<option value='other' selected>" . CUSTOM_OTHER . "</option>";
				} else {
					echo "<option value='other'>" . CUSTOM_OTHER . "</option>";
				}
			?>
			</select>
			<div id="primary_chief_complaint_custom_div" class="no_display">
				<?php
					if($primary_is_other) {
						$first_primary_custom = TRUE;
						foreach($primary_custom_array as $primary_type) {
							if($first_primary_custom) {
								echo "<input  class='input_field custom_chief_complaint_input custom_primary_chief_complaint' type='text' placeholder='" . CUSTOM_OTHER . "' value='$primary_type'>";
								$first_primary_custom = FALSE;
							} else {
								echo "<input class='input_field custom_chief_complaint_input custom_primary_chief_complaint custom_primary_extra' type='text' placeholder='" . CUSTOM_OTHER . "' value='$primary_type'>";
							}
						}
					} else {
						echo "<input  class='input_field custom_chief_complaint_input custom_primary_chief_complaint' type='text' placeholder='" . CUSTOM_OTHER . "'>";
					}
				?>
				<a id="add_custom_primary_chief_complaint" onclick="addCustomPrimaryChiefComplaint();">Add Another</a>
			</div>

		</div>
	</div>

	<div id="secondary_chief_complaints_select_row" class="row chief_complaints_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo SECONDARY; ?></p>
			<?php
				if($secondary_text) {
					$secondary_text = substr($secondary_text, 0, -2);
					echo "<p class='content_p3'>$secondary_text</p>";
				}
			?>
			<select id="secondary_chief_complaints_select" class="input_field" multiple>
			<?php
				$default_chief_complaint_length = sizeof(DEFAULT_CHIEF_COMPLAINT_VALUES);
				for($i = 0; $i < $default_chief_complaint_length; $i++) {
					$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$i];
					$label = DEFAULT_CHIEF_COMPLAINT_LABELS[$i];
					if(in_array((string)$i, $secondary_main_array)) {
						echo "<option value='$value' selected>$label</option>";
					} else {
						echo "<option value='$value'>$label</option>";
					}
				}
				if($secondary_is_other) {
					echo "<option value='other' selected>" . CUSTOM_OTHER . "</option>";
				} else {
					echo "<option value='other'>" . CUSTOM_OTHER . "</option>";
				}
			?>
			</select>
			<div id="secondary_chief_complaint_custom_div" class="no_display">
				<?php
					if($secondary_is_other) {
						$first_secondary_custom = TRUE;
						foreach($secondary_custom_array as $secondary_type) {
							if($first_secondary_custom) {
								echo "<input  class='input_field custom_chief_complaint_input custom_secondary_chief_complaint' type='text' placeholder='" . CUSTOM_OTHER . "' value='$secondary_type'>";
								$first_secondary_custom = FALSE;
							} else {
								echo "<input class='input_field custom_chief_complaint_input custom_secondary_chief_complaint custom_secondary_extra' type='text' placeholder='" . CUSTOM_OTHER . "' value='$secondary_type'>";
							}
						}
					} else {
						echo "<input  class='input_field custom_chief_complaint_input custom_secondary_chief_complaint' type='text' placeholder='" . CUSTOM_OTHER . "'>";
					}
				?>
				<a id="add_custom_secondary_chief_complaint" onclick="addCustomSecondaryChiefComplaint();"><?php echo ADD_ANOTHER; ?></a>
			</div>
		</div>
	</div>
	<p class="content_p3"><?php echo HPI_DETAILS; ?></p>
	<?php
		if($editable) {
	?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 0"; ?>);"><?php echo SAVE_AND_STAY; ?></button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 2"; ?>);"><?php echo SAVE_AND_CONTINUE; ?></button>
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

var primary_array = $("#primary_chief_complaints_select").val();
var primary_length = primary_array.length;
if(primary_array[primary_length - 1] == "other") {
	$("#primary_chief_complaint_custom_div").show();
}

var secondary_array = $("#secondary_chief_complaints_select").val();
var secondary_length = secondary_array.length;
if(secondary_array[secondary_length - 1] == "other") {
	$("#secondary_chief_complaint_custom_div").show();
}

$("#primary_chief_complaints_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#primary_chief_complaint_custom_div").show();
	} else {
		$("#primary_chief_complaint_custom_div").hide();
		$(".custom_primary_extra").remove();
		$(".custom_primary_chief_complaint").val("");
	}
});

$("#secondary_chief_complaints_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#secondary_chief_complaint_custom_div").show();
	} else {
		$("#secondary_chief_complaint_custom_div").hide();
		$(".custom_secondary_extra").remove();
		$(".custom_secondary_chief_complaint").val("");
	}
});

function addCustomPrimaryChiefComplaint() {
	$('<input class="input_field custom_chief_complaint_input custom_primary_chief_complaint custom_primary_extra" type="text" placeholder="Other/Custom">').insertBefore("#add_custom_primary_chief_complaint");
}

function addCustomSecondaryChiefComplaint() {
	$('<input class="input_field custom_chief_complaint_input custom_secondary_chief_complaint custom_secondary_extra" type="text" placeholder="Other/Custom">').insertBefore("#add_custom_secondary_chief_complaint");
}

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


//action == 0: stay
//action == 1: back
//action == 2: next
function save(consult_id, action) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var primary = "";
	var secondary = "";

	var primary_array = $("#primary_chief_complaints_select").val();
	var primary_length = primary_array.length;
	if(primary_length > 0 && primary_array[primary_length - 1] == "other") {
		primary_array.splice(primary_length - 1, 1);
		var custom_inputs = document.getElementsByClassName("custom_primary_chief_complaint");
		for(var i = 0; i < custom_inputs.length; i++) {
			var custom_input = custom_inputs[i].value;
			if(custom_input) {
				if(isInt(custom_input)) {
					var alert_text = "ERROR: INVALID CUSTOM CHIEF COMPLAINT";
					if(lang == "es") {
						alert_text = "ERROR: QUEJA PRINCIPAL INVALIDA";
					}
					alert(alert_text);
					return;
				}
				primary_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
	} 
	if(primary_array.length > 0) {
		primary = primary_array.toString();
	} 

	var secondary_array = $("#secondary_chief_complaints_select").val();
	var secondary_length = secondary_array.length;
	if(secondary_length > 0 && secondary_array[secondary_length - 1] == "other") {
		secondary_array.splice(secondary_length - 1, 1);
		var custom_inputs = document.getElementsByClassName("custom_secondary_chief_complaint");
		for(var i = 0; i < custom_inputs.length; i++) {
			var custom_input = custom_inputs[i].value;
			if(custom_input) {
				if(isInt(custom_input)) {
					var alert_text = "ERROR: INVALID CUSTOM CHIEF COMPLAINT";
					if(lang == "es") {
						alert_text = "ERROR: QUEJA PRINCIPAL INVALIDA";
					}
					alert(alert_text);
					return;
				}
				secondary_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
	} 
	if(secondary_array.length > 0) {
		secondary = secondary_array.toString();
	} 
	/*
	if(!primary && !secondary) {
		alert("ERROR: NO CHIEF COMPLAINT");
		return;
	}
	*/

	if(action == 2) {
		window.location.href = "chief_complaints.php?consult_id=" + consult_id + "&primary=" + primary + "&secondary=" + secondary + "&next=2" + extra_text;
	} else {
		window.location.href = "chief_complaints.php?consult_id=" + consult_id + "&primary=" + primary + "&secondary=" + secondary + extra_text;
	}
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location = "history_present_illness.php?consult_id=" + consult_id + extra_text;
}

function replaceAll(str, find, replace) {
	return str.replace(new RegExp(find, 'g'), replace);
}

function isInt(value) {
  var x;
  if (isNaN(value)) {
    return false;
  }
  x = parseFloat(value);
  return (x | 0) === x;
}




</script>

