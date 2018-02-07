
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
	$diagnosis_id = -1;

	if (isset($_GET['consult_id']) && isset($_GET['diagnosis_id'])) {
		$consult_id = $_GET['consult_id'];
		$diagnosis_id = $_GET['diagnosis_id'];

		if(isset($_GET["is_name_custom"])) {
			$category_index = $_GET['category_index'];
			$is_diagnosis_type_custom = $_GET['is_diagnosis_type_custom'];
			$diagnosis_type = $_GET['diagnosis_type'];
			$is_name_custom = $_GET['is_name_custom'];
			$name = $_GET['name'];
			$quantity = $_GET['quantity'];
			$notes = $_GET['notes'];
			$treatment_id = $_GET['treatment_id'];
			$db->createNewTreatment($consult_id, $treatment_id, $category_index, $is_diagnosis_type_custom, $diagnosis_type, $is_name_custom, $name, $quantity, $notes);
			header("LOCATION: treatments2.php?consult_id=" . $consult_id . "&diagnosis_id=" . $diagnosis_id);

		}
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

	$treatment_options = array();

	$diagnosis = $db->getDiagnosis($diagnosis_id);
	$category = $diagnosis['category'];
	$category_text = DIAGNOSIS_CATEGORY_ARRAY[$category];
	$is_type_custom = $diagnosis['is_type_custom'];
	$type = $diagnosis['type'];
	$type_text = "";
	$diagnosis_text = $category_text;
	if($is_type_custom == BOOLEAN_FALSE) {
		$type_text = $map->getDiagnosisOptions($category)[$type];
		$diagnosis_text .= ": " . $type_text;
		$treatment_options = $map->getTreatmentOptions($category, $type);
	} else {
		$type_text = $type;
		$diagnosis_text .= ": " . $type;
	}

	$custom_treatments = $db->getCustomTreatments($consult_id, $category, $is_type_custom, $type);
	

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
			<p class="content_p consult_section"><a onclick="treatmentClick(<?php echo $consult_id; ?>)">Treatments: <?php echo $diagnosis_text; ?></a></p>
		</div>
	</div>

<?php

	for($index = 0; $index < sizeof($treatment_options) - 1; $index++) {
		$treatment_option = $treatment_options[$index];
		$has_treatment_option = $db->hasExistingTreatmentOptionByInformation($consult_id, $category, $type, $index);
		$is_name_custom = "";
		$name = $index;
		$quantity = "";
		$notes = "";
		$treatment_id = -1;
		if($has_treatment_option) {
			$the_treatment = $db->getTreatmentByIndex($consult_id, $category, $type, $index);
			$is_name_custom = $the_treatment['is_name_custom'];
			$name = $the_treatment['name'];
			$quantity = $the_treatment['quantity'];
			$notes = $the_treatment['notes'];
			$treatment_id = $the_treatment['id'];
		}
?>
		<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category . ", '" . $category_text . "', " . $is_type_custom . ", '" . $type . "', '" . $type_text . "', '" . $is_name_custom . "', '" . $name . "', '" . $treatment_option . "', '" . $quantity . "', '" . $notes . "', " . $treatment_id . ", " . $diagnosis_id; ?>);"> 
			<?php
			
			echo $treatment_option;

			if($has_treatment_option) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } 
			?>
		</li>
<?php
	}
	$cnt = -1;
	foreach($custom_treatments as $custom_treatment) {
		$treatment_id = $custom_treatment["id"];
		$is_name_custom = 2;
		$name = $custom_treatment["name"];
		$quantity = $custom_treatment['quantity'];
		$notes = $custom_treatment["notes"];
?>

		<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category . ", '" . $category_text . "', " . $is_type_custom . ", '" . $type . "', '" . $type_text . "', '" . $is_name_custom . "', " . "-1" . ", '" . $name . "', '" . $quantity . "', '" . $notes . "', " . $treatment_id . ", " . $diagnosis_id; ?>);"> 
			<?php
			echo $name;
			echo '<img class="consult_task_completed" src="../images/checkmark"/>';
			?>
		</li>


<?php
		$cnt++;
	}

?>

<li class="list-group-item" data-toggle="modal" data-target="#myModal" onclick="functionClick(<?php echo $consult_id . ", " . $category . ", '" . $category_text . "', " . $is_type_custom . ", '" . $type . "', '" . $type_text . "', " . "2" . ", " . "-1" . ", " . "'Other'" . ", " . "''" . ", " . "''" . ", " . "-1" . ", " . $diagnosis_id; ?>);"> Other
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
	      		<p class="input_label">Medication:</p>
	        	<input id='information_input' class='input_field' type='text'>
	        </div>

	        <div id="information_row" class="input_row">
	      		<p class="input_label">Quantity:</p>
	        	<input id='quantity_input' class='input_field' type='text'>
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
			<button class="consult_button" type="button" onclick="goBackFunction(<?php echo $consult_id; ?>);">Back to Treatments Main</button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);">Continue to Followup</button>
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

function treatmentClick(consult_id) {
	window.location.href = "treatments.php?consult_id=" + consult_id;
}

function functionClick(consult_id, diagnosis_category_index, diagnosis_category, is_diagnosis_type_custom, diagnosis_type_index, diagnosis_type, is_name_custom, name_index, name, quantity, notes, treatment_id, diagnosis_id) {
	$("#save_button").unbind();
	$("#save_button").click(function() { 
		
		saveFunction(consult_id, diagnosis_category_index, diagnosis_category, is_diagnosis_type_custom, diagnosis_type_index, diagnosis_type, is_name_custom, name_index, name, treatment_id, diagnosis_id);
	});

	if(name != "Other") {
		$("#information_input").val(name);
	} else {
		$("#information_input").val("");
	}
	$("#quantity_input").val(quantity);
	$("#notes_input").text(notes);

	$("#modal_header").html(diagnosis_type + ": " + name);
	if(name == "Other" || is_name_custom == 2) {
		$("#information_row").show();
	} else {
		$("#information_row").hide();
	}


}

function saveFunction(consult_id, diagnosis_category_index, diagnosis_category, is_diagnosis_type_custom, diagnosis_type_index, diagnosis_type, is_name_custom, name_index, name, treatment_id, diagnosis_id) {
	var diagnosis_type_value = diagnosis_type_index;
	if(is_diagnosis_type_custom == 2) {
		diagnosis_type_value = diagnosis_type;
	}

	var is_name_custom = (name == "Other" || is_name_custom == 2) ? 2 : 1;
	var information = name_index;
	if(is_name_custom == 2) {
		information = $("#information_input").val();
	}
	var quantity = $("#quantity_input").val();
	var notes = $("#notes_input").val();

	window.location.href = "treatments2.php?consult_id=" + consult_id + "&category_index=" + diagnosis_category_index + "&is_diagnosis_type_custom=" + is_diagnosis_type_custom + "&diagnosis_type=" + diagnosis_type_value + "&is_name_custom=" + is_name_custom + "&name=" + information + "&quantity=" + quantity + "&notes=" + notes + "&treatment_id=" + treatment_id + "&diagnosis_id=" + diagnosis_id;
}

function continueFunction(consult_id) {
	alert("Not Implemented");
}

function goBackFunction(consult_id) {
	window.location.href = "treatments.php?consult_id=" + consult_id;
}


</script>

