
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
	require_once '../include/DiagnosisTreatmentMapping_' . $lang . '.php';

	$map;
	if($lang == "es") {
		$map = new DiagnosisTreatmentMapping_es();
	} else {
		$map = new DiagnosisTreatmentMapping_en();
	}

	$db = new DbOperation();

	$patient_id = "";
	$illness_id = -1;
	$illness = "";

	if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];

		if(isset($_GET['save'])) {
			$illness_id = $_GET['illness_id'];
			if(!$illness_id) {
				$illness_id = -1;
			}
			$is_chronic = $_GET['is_chronic'];
			if(!$is_chronic) {
				$is_chronic = NULL;
			}
			$type = $_GET['type'];
			if(!$type) {
				$type = NULL;
			}
			$other = $_GET['other'];
			if(!$other) {
				$other = NULL;
			}
			$start_date = $_GET['start_date'];
			if(!$start_date) {
				$start_date = NULL;
			}
			$end_date = $_GET['end_date'];
			if(!$end_date) {
				$end_date = NULL;
			}
			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}
			$datetime = Utilities::getCurrentDateTime();

			$val = $db->createNewHistoryIllness($patient_id, $illness_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['delete'])) {
			$illness_id = $_GET['illness_id'];

			$val = $db->deleteHistoryIllness($illness_id);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['illness_id'])) {
			$illness_id = $_GET['illness_id'];
			if($illness_id) {
				$illness = $db->getHistoryIllness($illness_id);
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
			<p class="content_p consult_section"><?php echo ILLNESSES_CONDITIONS; ?></p>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ": "; ?></p>
<?php
			if($illness) {
				$consult_id = $illness['consult_id'];
				$category = $illness['category'];
				$type = $illness["type"];
				$other = $illness["other"];

				echo "<select id='illness_select' class='input_field'>";
				
				if($other || $consult_id) {
					$index = 0;
					foreach(ILLNESS_ARRAY as $default_illness) {
						if($default_illness == OTHER) {
							echo '<option value="other" selected>' . $default_illness .'</option>';
						} else {
							echo '<option value="' . $index . '">' . $default_illness .'</option>';
						}
						$index++;
					}
					echo "</select>";
				} else  {
					$index = 0;
					foreach(ILLNESS_ARRAY as $default_illness) {
						if($default_illness == OTHER) {
							echo '<option value="other">' . $default_illness .'</option>';
						} else {
							if ($index === intval($type)) {
								echo '<option value="' . $index . '" selected>' . $default_illness .'</option>';
							} else {
								echo '<option value="' . $index . '">' . $default_illness .'</option>';
							}
						}
						$index++;
					}
					echo "</select>";
				} 
			} else {
				echo "<select id='illness_select' class='input_field'>";
				$index = 0;
				foreach(ILLNESS_ARRAY as $default_illness) {
					if($default_illness == OTHER) {
						echo '<option value="other">' . $default_illness .'</option>';
					} else {
						echo '<option value="' . $index . '">' . $default_illness .'</option>';
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
<?php
			if($illness) {
				$consult_id = $illness['consult_id'];
				$category = $illness['category'];
				$type = $illness['type'];
				$other = $illness["other"];
				if($other || $consult_id) {
					if($consult_id) {
						$other = $map->getDiagnosisOptions($category)[$type];
					}  
					echo "<input id='custom_name_input' class='input_field' type='text' value='$other'>";
				}
			} else {
				echo "<input id='custom_name_input' class='input_field' type='text'>";
			}
?>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo TYPE . ": "; ?></p>
			<form id="type_radiogroup" class="input_field">
<?php
				if($illness) {
					$is_chronic = $illness['is_chronic'];
					if($is_chronic == BOOLEAN_TRUE) {
						echo "<input type='radio' name='type' id='type_chronic' value='chronic' checked='checked'><label for='type_chronic'>" . CHRONIC . "</label>";
						echo "<input type='radio' name='type' id='type_acute' value='acute'><label for='type_acute'>" . ACUTE . "</label>";
					} else if ($is_chronic == BOOLEAN_FALSE) {
						echo "<input type='radio' name='type' id='type_chronic' value='chronic'><label for='type_chronic'>" . CHRONIC . "</label>";
						echo "<input type='radio' name='type' id='type_acute' value='acute' checked='checked'><label for='type_acute'>" . ACUTE . "</label>";
					}
				} else {
					echo "<input type='radio' name='type' id='type_chronic' value='chronic'><label for='type_chronic'>" . CHRONIC . "</label>";
					echo "<input type='radio' name='type' id='type_acute' value='acute'><label for='type_acute'>" . ACUTE . "</label>";
				}
?>
			</form>
		</div>
	</div>

	<div id="chronic_section">
		<div class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo START_DATE . ": "; ?></p>
<?php
				if($illness && $illness["start_date"]) {
					$start_date = $illness['start_date'];
					echo "<input id='ongoing_start_date_input' class='input_field' type='date' value='$start_date'>";
				} else {
					echo "<input id='ongoing_start_date_input' class='input_field' type='date'>";
				}
?>
			</div>
		</div>
		<div class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo END_DATE . ": "; ?><span class="normal_span"><?php echo "(" . LEAVE_BLANK_IF_CURRENT . ")"; ?><span></p>
<?php
				if($illness && isset($illness["end_date"])) {
					$end_date = $illness['end_date'];
					echo "<input id='ongoing_end_date_input' class='input_field' type='date' value='$end_date'>";
				} else {
					echo "<input id='ongoing_end_date_input' class='input_field' type='date'>";
				}
?>
			</div>
		</div>
	</div>

	<div id="acute_section">
		<div class="row input_row">
			<div class="col-xs-12">
				<p class="input_label"><?php echo DATE . ": "; ?></p>
<?php
				if($illness && $illness["start_date"]) {
					$date = $illness['start_date']; //Should be same as end_date 
					echo "<input id='once_date_input' class='input_field' type='date' value='$date'>";
				} else {
					echo "<input id='once_date_input' class='input_field' type='date'>";
				}
?>
			</div>
		</div>
	</div>

	<div id="illness_notes_row" class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NOTES . ": "; ?></p>
<?php
			if($illness && isset($illness['notes'])) {
				$notes = $illness['notes'];
				echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
			} else {
				echo "<textarea id='notes_input' class='input_field'></textarea>";
			}
?>	
		</div>
	</div>

<?php
	if($illness == NULL || ($illness && !$illness["consult_id"])) {
?>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick(<?php echo $patient_id . ", " . $illness_id; ?>);"><?php echo SAVE_RECORD; ?></button>
		</div>
	</div>

	<div id="button_row" class='row input_row <?php if($illness_id == -1) { echo "no_display"; } ?>'>
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="deleteClick(<?php echo $patient_id . ", " . $illness_id; ?>);"><?php echo DELETE_RECORD; ?></button>
		</div>
	</div>
<?php
	} else if ($illness) {
		$consult_id = $illness['consult_id'];
?>
	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo CANNOT_EDIT_DELETE; ?></p>
			<a onclick='consultClick(<?php echo $patient_id . "," . $consult_id; ?>);'><?php echo GO_TO_CONSULT; ?></a>
		</div>
	</div>

<?php
	} 
?>

<script type="text/javascript">

var value = $("#illness_select").find(":selected").val();
if(value == "other") {
	$("#name_custom_row").show();
}

var type = $("input[name=type]:checked").val();
if (type == "chronic") {
	$('#illness_notes_row').show();
	$('#chronic_section').show();
	$('#acute_section').hide();
} else if (type == "acute") {
	$('#illness_notes_row').show();
	$('#chronic_section').hide();
	$('#acute_section').show();
} else {
	$('#illness_notes_row').hide();
	$('#chronic_section').hide();
	$('#acute_section').hide();
}


$("#illness_select").change(function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if(value == "other") {
		$('#name_custom_row').show();
	} else {
		$('#name_custom_row').hide();	
	}
});

function consultClick(patient_id, consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_complete.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
}

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

function saveClick(patient_id, illness_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!illness_id) {
		illness_id = "";
	}
	var type_value = $("#illness_select").find(":selected").val();
	var is_chronic = $("input[name=type]:checked").val();
	var start_date = "";
	var end_date = "";
	if(is_chronic) {
		if(is_chronic == "chronic") {
			is_chronic = 2;
			start_date =  $("#ongoing_start_date_input").val();
			end_date = $("#ongoing_end_date_input").val();
		} else if (is_chronic == "acute") {
			is_chronic = 1;
			start_date =  $("#once_date_input").val();
		} else {
			is_chronic = "";
		}
	} else {
		is_chronic = "";
	} 
	var other = "";
	if(type_value == "0") {
		var alert_text = "Must select an illness name.";
		if(lang == "es") {
			alert_text = "Necesita escoger un nombre de enfermedad.";
		}
		alert(alert_text);
		return;
	} else {
		if(type_value == "other") {
			other = $("#custom_name_input").val();
			if(!other) {
				var alert_text = "Must enter a custom illness name.";
				if(lang == "es") {
					alert_text = "Necesita ingresar un nombre de enfermedad.";
				}
				alert(alert_text);
				return;
			}
		} 
	}
	
	if(!start_date) {
		start_date = "";
	} 
	if(!end_date) {
		end_date = "";
	} 

	var notes = document.getElementById("notes_input").value;

	window.location.href = "history_illness.php?patient_id=" + patient_id + "&illness_id=" + illness_id + "&type=" + type_value + "&other=" + other + "&is_chronic=" + is_chronic + "&start_date=" + start_date + "&end_date=" + end_date + "&notes=" + notes + "&save=2" + extra_text;
}

function deleteClick(patient_id, illness_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_illness.php?patient_id=" + patient_id + "&illness_id=" + illness_id + "&delete=2" + extra_text;
}


$("input[name=type]").change(function() {
	var value = $("input[name=type]:checked").val();
	if (value == "chronic") {
		$('#illness_notes_row').show();
		$('#chronic_section').show();
		$('#acute_section').hide();
	} else if (value == "acute") {
		$('#illness_notes_row').show();
		$('#chronic_section').hide();
		$('#acute_section').show();
	} else {
		$('#notes_row').hide();
		$('#chronic_section').hide();
		$('#acute_section').hide();
	}
});

</script>

