
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
	$allergy_id = -1;
	$allergy = "";

	if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];

		if(isset($_GET['save'])) {
			$allergy_id = $_GET['allergy_id'];
			if(!$allergy_id) {
				$allergy_id = -1;
			}
			$name = $_GET['name'];
			if(!$name) {
				$name = NULL;
			}

			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}
			$datetime = Utilities::getCurrentDateTime();

			$val = $db->createNewHistoryAllergy($patient_id, $allergy_id, $name, $notes, $datetime);

			//echo $val;
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}
		if(isset($_GET['delete'])) {
			$allergy_id = $_GET['allergy_id'];

			$val = $db->deleteHistoryAllergy($allergy_id);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		$has_existing_allergies = $db->hasExistingHistoryAllergies($patient_id);
		if(isset($_GET['allergy_id'])) {
			$allergy_id = $_GET['allergy_id'];
			if($allergy_id) {
				$allergy = $db->getHistoryAllergy($allergy_id);
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
			<p class="content_p consult_section"><?php echo ALLERGIES; ?></p>
		</div>
	</div>

	<?php
		if(!$has_existing_allergies) {
			echo '<div class="row input_row">';
			echo '<div class="col-xs-12">';
			echo '<p class="input_label">'. NKDA . '?</p>';
			echo '<form id="allergy_radiogroup" class="input_field">';
			echo '<input type="radio" id="radio_nkda_yes" name="nkda" value="yes"><label for="radio_nkda_yes">' . YES . '</label>';
			echo '<input type="radio" id="radio_nkda_no" name="nkda" value="no"><label for="radio_nkda_no">' . NO . '</label>';
			echo '</form>';
			echo '</div>';
			echo '</div>';
		}

	?>

	<div id="allergy_name_row" class='row input_row <?php if(!$has_existing_allergies) { echo "no_display"; } ?>'>
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ": "; ?></p>
<?php
			if($allergy && isset($allergy["name"])) {
				$name = $allergy["name"];
				echo "<input id='name_input' class='input_field' type='text' value='$name'>";
			} else {
				echo "<input id='name_input' class='input_field' type='text'>";
			}
?>
		</div>
	</div>

	<div id="allergy_notes_row" class='row input_row <?php if(!$has_existing_allergies) { echo "no_display"; } ?>'>
		<div class="col-xs-12">
			<p class="input_label"><?php echo NOTES . ": "; ?></p>
<?php
			if($allergy && isset($allergy['notes'])) {
				$notes = $allergy['notes'];
				echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
			} else {
				echo "<textarea id='notes_input' class='input_field'></textarea>";
			}
?>	
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick(<?php echo $patient_id . ", " . $allergy_id; ?>);"><?php echo SAVE_RECORD; ?></button>
		</div>
	</div>

	<div id="button_row" class='row input_row <?php if($allergy_id == -1) { echo "no_display"; } ?>'>
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="deleteClick(<?php echo $patient_id . ", " . $allergy_id; ?>);"><?php echo DELETE_RECORD; ?></button>
		</div>
	</div>


<script type="text/javascript">

$("input[name=nkda]").change(function() {
	var value = $("input[name=nkda]:checked").val();
	if (value == "no") {
		$('#allergy_notes_row').show();
		$('#allergy_name_row').show();
	} else {
		$('#allergy_notes_row').hide();
		$('#allergy_name_row').hide();
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

function saveClick(patient_id, allergy_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}

	if(!allergy_id) {
		allergy_id = "";
	}

	var nkda = $("input[name=nkda]:checked").val();
	var name = "";
	var notes = "";

	if(nkda !== "yes") {
		name = $("#name_input").val();
		if(!name){
			var alert_text = "Must enter an allergy name.";
			if(lang == "es") {
				alert_text = "Necesita ingresar un nombre de alergia.";
			}
			alert(alert_text);
			return;
		}
		notes = document.getElementById("notes_input").value;
	}

	window.location.href = "history_allergy.php?patient_id=" + patient_id + "&allergy_id=" + allergy_id + "&name=" + name + "&notes=" + notes + "&save=2" + extra_text;
}

function deleteClick(patient_id, allergy_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_allergy.php?patient_id=" + patient_id + "&allergy_id=" + allergy_id + "&delete=2" + extra_text;
}

</script>

