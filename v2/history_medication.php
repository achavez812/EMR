
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
	$medication_id = -1;
	$medication = "";

	if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];

		if(isset($_GET['save'])) {
			$medication_id = $_GET['medication_id'];
			if(!$medication_id) {
				$medication_id = -1;
			}
			$name = $_GET['name'];
			if(!$name) {
				$name = NULL;
			}

			$quantity = $_GET['quantity'];
			if(!$quantity) {
				$quantity = NULL;
			}
			$start_date = $_GET['start_date'];
			if(!$start_date) {
				$start_date = NULL;
			}
			$end_date = $_GET['end_date'];
			if(!$end_date) {
				$end_date = NULL;
			}
			$is_self_reported = BOOLEAN_TRUE;

			$is_recommended = BOOLEAN_FALSE;

			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}
			$datetime = Utilities::getCurrentDateTime();

			$val = $db->createNewHistoryMedication($patient_id, $medication_id, $name, $quantity, $start_date, $end_date, $is_self_reported, $is_recommended, $notes, $datetime);

			//echo $val;
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}
		if(isset($_GET['delete'])) {
			$medication_id = $_GET['medication_id'];

			$val = $db->deleteHistoryMedication($medication_id);
			header("LOCATION: medical_history.php?patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['medication_id'])) {
			$medication_id = $_GET['medication_id'];
			if($medication_id) {
				$medication = $db->getHistoryMedication($medication_id);
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
			<p class="content_p consult_section"><?php echo MEDICATIONS; ?></p>
		</div>
	</div>



	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ": "; ?></p>
<?php
			if($medication && isset($medication["name"])) {
				$name = $medication["name"];
				echo "<input id='name_input' class='input_field' type='text' value='$name'>";
			} else {
				echo "<input id='name_input' class='input_field' type='text'>";
			}
?>
		</div>
	</div>


	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo QUANTITY . ": "; ?></p>
<?php
			if($medication && isset($medication["quantity"])) {
				$quantity = $medication["quantity"];
				echo "<input id='quantity_input' class='input_field' type='text' value='$quantity'>";
			} else {
				echo "<input id='quantity_input' class='input_field' type='text'>";
			}
?>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo START_DATE . ": "; ?></p>
<?php
			if($medication && isset($medication["start_date"])) {
				$start_date = $medication['start_date'];
				echo "<input id='start_date_input' class='input_field' type='date' value='$start_date'>";
			} else {
				echo "<input id='start_date_input' class='input_field' type='date'>";
			}
?>
		</div>
	</div>
	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo END_DATE . ": "; ?> <span class="normal_span"><?php echo "(" . LEAVE_BLANK_IF_CURRENT . ")"; ?><span></p>
<?php
			if($medication && isset($medication["end_date"])) {
				$end_date = $medication['end_date'];
				echo "<input id='end_date_input' class='input_field' type='date' value='$end_date'>";
			} else {
				echo "<input id='end_date_input' class='input_field' type='date'>";
			}
?>
		</div>
	</div>


	<div id="medication_notes_row" class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NOTES . ": "; ?></p>
<?php
			if($medication && isset($medication['notes'])) {
				$notes = $medication['notes'];
				echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
			} else {
				echo "<textarea id='notes_input' class='input_field'></textarea>";
			}
?>	
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick(<?php echo $patient_id . ", " . $medication_id; ?>);"><?php echo SAVE_RECORD; ?></button>
		</div>
	</div>

	<div id="button_row" class='row input_row <?php if($medication_id == -1) { echo "no_display"; } ?>'>
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="deleteClick(<?php echo $patient_id . ", " . $medication_id; ?>);"><?php echo DELETE_RECORD; ?></button>
		</div>
	</div>


<script type="text/javascript">


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

function saveClick(patient_id, medication_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!medication_id) {
		medication_id = "";
	}
	var name = $("#name_input").val();
	if(!name){
		var alert_text = "Must enter a medication name.";
		if(lang == "es") {
			alert_text = "Necesita ingresar un nombre de medicamento.";
		}
		alert(alert_text);
		return;
	}

	quantity = $("#quantity_input").val();
	start_date =  $("#start_date_input").val();
	end_date = $("#end_date_input").val();

	var notes = document.getElementById("notes_input").value;

	window.location.href = "history_medication.php?patient_id=" + patient_id + "&medication_id=" + medication_id + "&name=" + name + "&quantity=" + quantity + "&start_date=" + start_date + "&end_date=" + end_date + "&notes=" + notes + "&save=2" + extra_text;
}

function deleteClick(patient_id, medication_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_medication.php?patient_id=" + patient_id + "&medication_id=" + medication_id + "&delete=2" + extra_text;
}




</script>

