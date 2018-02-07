
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

	$patient_id = "";
	$surgery_id = -1;
	$surgery = "";

	if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];

		if(isset($_GET['save'])) {
			$surgery_id = $_GET['surgery_id'];
			if(!$surgery_id) {
				$surgery_id = -1;
			}
			$is_name_custom = $_GET['is_name_custom'];
			$name = $_GET['name'];
			$date = $_GET['date'];
			if(!$date) {
				$date = NULL;
			}
			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}
			$datetime = Utilities::getCurrentDateTime();

			$val = $db->createNewHistorySurgery($patient_id, $surgery_id, $is_name_custom, $name, $date, $notes, $datetime);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['delete'])) {
			$surgery_id = $_GET['surgery_id'];

			$val = $db->deleteHistorySurgery($surgery_id);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['surgery_id'])) {
			$surgery_id = $_GET['surgery_id'];
			if($surgery_id) {
				$surgery = $db->getHistorySurgery($surgery_id);
			}

		}
	} else {
		header($index_link);
	}

	$patient = $db->getPatientById($patient_id);	

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (" . APPROXIMATE_ABBREVIATION . ")";
	}

	$sex_text = "";
	if ($patient_sex == SEX_FEMALE) {
		$sex_text = FEMALE;
	} else if ($patient_sex == SEX_MALE) {
		$sex_text = MALE;
	} else {
		$sex_text = DESCONOCIDO;
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
			<p class="content_p consult_section"><a onclick="medicalHistoryClick(<?php echo $patient_id; ?>);"><?php echo GO_TO_MEDICAL_HISTORY; ?></a></p>
		</div>
	</div>
	<div class="row row3">
		<div class="col-xs-12">
			<p class="content_p consult_section"><?php echo SURGERIES; ?></p>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ": "; ?></p>
<?php
			if($surgery && isset($surgery["is_name_custom"]) && isset($surgery["name"])) {
				$is_name_custom = $surgery["is_name_custom"];
				$name = $surgery["name"];

				echo "<select id='surgery_select' class='input_field'>";
				
				if($is_name_custom == BOOLEAN_TRUE) {
					$index = 0;
					foreach(SURGERY_ARRAY as $default_surgery) {
						if($default_surgery == "Other") {
							echo '<option value="other" selected>' . $default_surgery .'</option>';
						} else {
							echo '<option value="' . $index . '">' . $default_surgery .'</option>';
						}
						$index++;
					}
					echo "</select>";
				} else {
					$index = 0;
					foreach(SURGERY_ARRAY as $default_surgery) {
						if($default_surgery == OTHER) {
							echo '<option value="other">' . $default_surgery .'</option>';
						} else {
							if ($index == intval($name)) {
								echo '<option value="' . $index . '" selected>' . $default_surgery .'</option>';
							} else {
								echo '<option value="' . $index . '">' . $default_surgery .'</option>';
							}
						}
						$index++;
					}
					echo "</select>";
				}
			} else {
				echo "<select id='surgery_select' class='input_field'>";
				$index = 0;
				foreach(SURGERY_ARRAY as $default_surgery) {
					if($default_surgery == OTHER) {
						echo '<option value="other">' . $default_surgery .'</option>';
					} else {
						echo '<option value="' . $index . '">' . $default_surgery .'</option>';
					}
					$index++;
				}
				echo "</select>";
			}
?>
		</div>
	</div>

	<div id="name_custom_row" class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ": "; ?></p>
<?php
			if($surgery && isset($surgery["is_name_custom"]) && isset($surgery["name"])) {
				$is_name_custom = $surgery["is_name_custom"];
				$name = $surgery["name"];
				if($is_name_custom == BOOLEAN_TRUE) {
					echo "<input id='custom_name_input' class='input_field' type='text' value='$name'>";
				}
			} else {
				echo "<input id='custom_name_input' class='input_field' type='text'>";
			}
?>
		</div>
	</div>


	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo DATE . ": "; ?></p>
<?php
			if($surgery && isset($surgery["date"])) {
				$date = substr($surgery['date'], 0, -3);
				echo "<input id='date_input' class='input_field' type='month' value='$date'>";
			} else {
				echo "<input id='date_input' class='input_field' type='month'>";
			}
?>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NOTES . ": "; ?></p>
<?php
			if($surgery && isset($surgery['notes'])) {
				$notes = $surgery['notes'];
				echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
			} else {
				echo "<textarea id='notes_input' class='input_field'></textarea>";
			}
?>	
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick(<?php echo $patient_id . ", " . $surgery_id; ?>);"><?php echo SAVE_RECORD; ?></button>
		</div>
	</div>

	<div id="button_row" class='row input_row <?php if($surgery_id == -1) { echo "no_display"; } ?>'>
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="deleteClick(<?php echo $patient_id . ", " . $surgery_id; ?>);"><?php echo DELETE_RECORD; ?></button>
		</div>
	</div>



<script type="text/javascript">

var value = $("#surgery_select").find(":selected").val();
if(value == "other") {
	$("#name_custom_row").show();
}

$("#surgery_select").change(function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if(value == "other") {
		$('#name_custom_row').show();
	} else {
		$('#name_custom_row').hide();	
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

function medicalHistoryClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "medical_history.php?patient_id=" + patient_id + extra_text;
}

function saveClick(patient_id, surgery_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!surgery_id) {
		surgery_id = "";
	}

	var name_value = $("#surgery_select").find(":selected").val();
	var is_name_custom = 0;
	var name = "";
	if(name_value == "0") {
		var alert_text = "Must select a surgery name.";
		if(lang == "es") {
			alert_text = "Necesita escoger un nombre de cirugia.";
		}
		alert(alert_text);
		return;
	} else {
		if(name_value == "other") {
			is_name_custom = 2;
			name = $("#custom_name_input").val();
			if(!name) {
				var alert_text = "Must enter a custom illness name.";
				if(lang == "es") {
					alert_text = "Necesita ingresar un nombre de cirugia.";
				}
				alert(alert_text);
				return;
			}
		} else {
			is_name_custom = 1;
			name = name_value;
		}
	}

	var date = $("#date_input").val();
	if(!date) {
		date = "";
	} else {
		date += "-01";
	}

	var notes = document.getElementById("notes_input").value;

	window.location.href = "history_surgery.php?patient_id=" + patient_id + "&surgery_id=" + surgery_id + "&is_name_custom=" + is_name_custom + "&name=" + name + "&date=" + date + "&notes=" + notes + "&save=2" + extra_text;
}

function deleteClick(patient_id, surgery_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_surgery.php?patient_id=" + patient_id + "&surgery_id=" + surgery_id + "&delete=2" + extra_text;
}





</script>

