
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

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];

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
	$diagnosis_categories = $map->getDiagnosisCategories();
	

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
			<p class="content_p consult_section">Diagnosis</p>
		</div>
	</div>

<?php

	for($index = 0; $index < sizeof($diagnosis_categories); $index++) {
		$diagnosis_category = $diagnosis_categories[$index];
?>
		<li class="list-group-item" onclick="functionClick(<?php echo $consult_id . ", " . $index; ?>);"> 
			<?php
			$has_abnormal_exam = $db->hasConsultAbnormalExamCategory($consult_id, $index - 1);
			if($has_abnormal_exam) {
				$diagnosis_category .= " (Abnormal Exam)";
			}
			echo $diagnosis_category;

			if($db->hasExistingDiagnosisByInformation($consult_id, $index)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
		</li>
<?php		
	}

?>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);">Continue to Treatment</button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="goBackFunction(<?php echo $consult_id; ?>);">Back to Diagnosis</button>
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


function continueFunction(consult_id) {
	window.location.href = "treatments.php?consult_id=" + consult_id;
}

function goBackFunction(consult_id) {
	window.location.href = "diagnoses.php?consult_id=" + consult_id;
}

function functionClick(consult_id, diagnosis_index) {
	window.location.href = "diagnoses2.php?consult_id=" + consult_id + "&category_index=" + diagnosis_index;
}


</script>

