
<script type="text/javascript" src="../js/jquery-3.2.1.min" ></script>
<link rel="stylesheet" href="../css/bootstrap.min">
<script type="text/javascript" src="../js/bootstrap.min" ></script>

<link rel="stylesheet" href="../css/style">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


<?php
	require_once '../include/DbOperation.php';
	require_once '../include/Constants.php';
	require_once '../include/Utilities.php';
	require_once '../include/ExamDiagnosisTreatmentMapping.php';



	$db = new DbOperation();

	$consult_id = 0;
	$category_index = -1;
	$category = "";
	$custom_diagnoses;

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$category_index = $_GET['category_index'];

		if(isset($_GET['is_type_custom'])) {
			$is_type_custom = $_GET['is_type_custom'];
			$type = $_GET['type'];
			$notes = $_GET['notes'];
			$diagnosis_id = $_GET['diagnosis_id'];
			$db->createNewDiagnosis($consult_id, $diagnosis_id, $category_index, $is_type_custom, $type, $notes);
			if($type == '0') {
				header("LOCATION: diagnoses.php?consult_id=" . $consult_id);
			} else {
				header("LOCATION: diagnoses2.php?consult_id=" . $consult_id . "&category_index=" . $category_index);
			}
		}
		$category = DIAGNOSIS_CATEGORY_ARRAY[$category_index];
		$custom_diagnoses = $db->getCustomDiagnosesInCategory($consult_id, $category_index);

	} else {
		header("LOCATION: index.php");
	}


	$consult = $db->getConsult($consult_id);
	$patient_id = $consult["patient_id"];

	$patient = $db->getPatientById($patient_id);	

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (App.)";
	}

	$age_text = Utilities::getCurrentAgeString($patient_dob);

	$sex_text = "";
	if ($patient_sex == SEX_FEMALE) {
		$sex_text = "Female";
	} else if ($patient_sex == SEX_MALE) {
		$sex_text = "Male";
	} else {
		$sex_text = "Unknown";
	}

	$datetime_started = $consult["datetime_started"];
	$in_progress = true;
	if(isset($consult["datetime_completed"])) {
		$in_progress = false;
	}

	$formatted_datetime_started = Utilities::reformatDateForDisplay2($datetime_started);

	$display_text = "Consult " . $formatted_datetime_started;
	
	if($in_progress) {
		$display_text .= " (In Progress)";
	} else {
		$display_text .= " (Completed)";
	}

	$map = new ExamDiagnosisTreatmentMapping();
	$diagnosis_options = $map->getDiagnosisOptions($category_index);
	
?>

<div class="container-fluid">

	<div id="profile_row1" class="row row1">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p">Date of Birth: <?php echo $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row row2">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<p class="content_p consult_section"><a onclick="diagnosisClick(<?php echo $consult_id; ?>)">Diagnoses: <?php echo $category; ?></a></p>
		</div>
	</div>

<?php

	for($index = 0; $index < sizeof($diagnosis_options) - 1; $index++) {
		$diagnosis_option = $diagnosis_options[$index];
		$has_diagnosis_option = $db->hasExistingDiagnosisOptionByInformation($consult_id, $category_index, $index);
		$notes = "";
		$diagnosis_id = -1;
		if($has_diagnosis_option) {
			$the_diagnosis = $db->getDiagnosisByInformation($consult_id, $category_index, BOOLEAN_FALSE, $index);
			$notes = $the_diagnosis['notes'];
			$diagnosis_id = $the_diagnosis['id'];
		}
?>
		<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category_index . ", '" . $category . "', " . $index . ", '" . $diagnosis_option . "', 1, '" . $notes . "', " . $diagnosis_id; ?>);"> 
			<?php
			echo $diagnosis_option;
			if($has_diagnosis_option) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
		</li>
<?php
	}
	$cnt = -1;
	foreach($custom_diagnoses as $custom_diagnosis) {
		$diagnosis_id = $custom_diagnosis["id"];
		$type = $custom_diagnosis["type"];
		$notes = $custom_diagnosis["notes"];
?>

		<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category_index . ", '" . $category . "', " . (sizeof($diagnosis_options) + $cnt) . ", '" . $type . "', 2, '" . $notes . "', " . $diagnosis_id; ?>);"> 
			<?php
			echo $type;
			echo '<img class="consult_task_completed" src="../images/checkmark"/>';
			?>
		</li>


<?php
		$cnt++;
	}

?>

	<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category_index . ", '" . $category . "', " . "-1" . ", '" . "Other" . "',2 , '', -1"  ?>);"> Other
		</li>

	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modal_header" class="modal-title"></h4>
      </div>
      <div class="modal-body">
      		<div id="information_row" class="input_row">
	      		<p class="input_label">Information:</p>
	        	<input id='information_input' class='input_field' type='text'>
	        </div>

        	<div id="notes_row" class="input_row">
	        	<p class="input_label">Notes:</p>
	        	<textarea id='notes_input' class='input_field'></textarea>
	        </div>
      </div>
      <div class="modal-footer">
        <button id="save_button" type="button" class="btn btn-default" data-dismiss="modal">Save</button>
      </div>
    </div>

  </div>
</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="goBackFunction(<?php echo $consult_id; ?>);">Back to Diagnosis Main</button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);">Continue to Treatment</button>
		</div>
	</div>

</div>

<script type="text/javascript">

function nameClick(patient_id) {
	window.location.href = "profile.php?id=" + patient_id;
}

function consultClick(consult_id, patient_id) {
	window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id;
}

function goBackFunction(consult_id) {
	window.location.href = "diagnoses.php?consult_id=" + consult_id;
}


function continueFunction(consult_id) {
	window.location.href = "treatments.php?consult_id=" + consult_id;
}

function functionClick(consult_id, category_index, category, diagnosis_option_index, diagnosis_option, is_type_custom, notes, diagnosis_id) {

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		
		saveFunction(consult_id, category_index, category, diagnosis_option_index, diagnosis_option, is_type_custom, diagnosis_id);
	});

	if(diagnosis_option != "Other") {
		$("#information_input").val(diagnosis_option);
	} else {
		$("#information_input").val("");
	}
	$("#notes_input").text(notes);

	$("#modal_header").html(category + ": " + diagnosis_option);
	if(diagnosis_option == "Other" || is_type_custom == 2) {
		$("#information_row").show();
	} else {
		$("#information_row").hide();
	}

}

function saveFunction(consult_id, category_index, category, diagnosis_option_index, diagnosis_option, is_type_custom, diagnosis_id) {
	var is_type_custom = (diagnosis_option == "Other" || is_type_custom == 2) ? 2 : 1;
	var information = diagnosis_option_index;
	if(is_type_custom == 2) {
		information = $("#information_input").val();
	}
	var notes = $("#notes_input").val();

	//alertFunction(consult_id + " X " + category_index + " X " + is_type_custom + " X " + information + " X " + notes);
	window.location = "diagnoses2.php?consult_id=" + consult_id + "&category_index=" + category_index + "&is_type_custom=" + is_type_custom + "&type=" + information + "&notes=" + notes + "&diagnosis_id=" + diagnosis_id;
}

function diagnosisClick(consult_id) {
	window.location.href = "diagnoses.php?consult_id=" + consult_id;
}


</script>

