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

	$patient_id = 0;

	if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];
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


	$active_consult_id = "";
	if($db->hasActiveConsult($patient_id)) {
		$active_consult_id = $db->getActiveConsult($patient_id)["id"];
	}

?>

<div class="container-fluid">

	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row row2 consult_link_row">
		<div class="col-xs-12">
<?php
			if($active_consult_id) {
				echo "<p class='content_p'><a onclick='consultClick($active_consult_id, $patient_id);'>" . GO_TO_ACTIVE_CONSULT . "</a></p>";
			}
?>
			<p class="content_p consult_section"><?php echo MEDICAL_HISTORY; ?></p>
		</div>
	</div>
		<div class="row row3">
		<div class="col-xs-10">
			<p class="content_p"><?php echo ALLERGIES; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="../images/add.png" alt="Add" onclick="addAllergy(<?php echo $patient_id; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row row4">
		<div class="col-xs-12">
<?php
	$no_allergies = true;
	$allergies = $db->getHistoryAllergies($patient_id);
	while($allergy = $allergies->fetch_assoc()) {
		if($no_allergies) {
			$no_allergies = false;
			$name = $allergy['name'];
			if($name === NULL) {
				echo '<p class="no_entries_p">' . NKDA . '</p>';
				break;
			} else {
				echo '<ul class="list_group">';
			}
		}
		$allergy_id = $allergy['id'];
		$name = $allergy['name'];
		$display_text = $name;
		echo '<li class="list-group-item" onclick="allergyClick(' . $patient_id . ', ' . $allergy_id . ');">' . $display_text . '</li>';
	}
	if($no_allergies) {
		echo '<p class="no_entries_p">' . NO_REPORTED_INFORMATION . '</p>';
	} else {
		echo '</ul>';
	}

?>
		</div>
	</div>
	<div class="row row5">
		<div class="col-xs-10">
			<p class="content_p"><?php echo ILLNESSES_CONDITIONS; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="../images/add.png" alt="Add" onclick="addIllnessCondition(<?php echo $patient_id; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row row6">
		<div class="col-xs-12">
<?php
	$no_illnesses = true;
	$illnesses = $db->getHistoryIllnesses($patient_id);
	while($illness = $illnesses->fetch_assoc()) {
		if($no_illnesses) {
			$no_illnesses = false;
			echo '<ul class="list_group">';
		}
		$illness_id = $illness["id"];
		$category = $illness['category'];
		$consult_id = $illness['consult_id'];
		$is_chronic = $illness['is_chronic'];
		$type = $illness['type'];
		$other = $illness['other'];
		$end_date = $illness['end_date'];

		$display_text = "";
		if($other) {
			$display_text = $other;
		} else if ($consult_id) {
			$display_text = $map->getDiagnosisOptions($category)[$type];
		} else {
			$display_text = ILLNESS_ARRAY[$type];
		}

		if($is_chronic == BOOLEAN_TRUE) {
			$display_text .= " (" . CHRONIC . ")";
		} else if ($is_chronic == BOOLEAN_FALSE ) {
			$display_text .= " (" . ACUTE . ")";
		}

		echo '<li class="list-group-item" onclick="illnessClick(' . $patient_id . ', ' . $illness_id . ');">' . $display_text . '</li>';

	}
	if($no_illnesses) {
		echo '<p class="no_entries_p">' . NO_REPORTED_INFORMATION . '</p>';
	} else {
		echo '</ul>';
	}

?>
		</div>
	</div>

	<div class="row row7">
		<div class="col-xs-10">
			<p class="content_p"><?php echo SURGERIES; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="../images/add.png" alt="Add" onclick="addSurgery(<?php echo $patient_id; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row row8">
		<div class="col-xs-12">
<?php
	$no_surgeries = true;
	$surgeries = $db->getHistorySurgeries($patient_id);
	while($surgery = $surgeries->fetch_assoc()) {
		if($no_surgeries) {
			$no_surgeries = false;
			echo '<ul class="list_group">';
		}
		$surgery_id = $surgery["id"];
		$is_name_custom = $surgery['is_name_custom'];
		$name = $surgery['name'];
		$date = $surgery['date'];

		$display_text = "";
		if($is_name_custom == BOOLEAN_TRUE) {
			$display_text = $name;
		} else {
			$display_text = SURGERY_ARRAY[$name];
		}

		if($date) {
			$display_text .= " (" . Utilities::reformatDateForDisplay($date) . ")";
		} 

		echo '<li class="list-group-item" onclick="surgeryClick(' . $patient_id . ', ' . $surgery_id . ');">' . $display_text . '</li>';

	}
	if($no_surgeries) {
		echo '<p class="no_entries_p">' . NO_REPORTED_INFORMATION . '</p>';
	} else {
		echo '</ul>';
	}

?>
		</div>
	</div>

	<div class="row row9">
		<div class="col-xs-10">
			<p class="content_p"><?php echo MEDICATIONS; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="../images/add.png" alt="Add" onclick="addMedication(<?php echo $patient_id; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row row10">
		<div class="col-xs-12">
<?php
	$no_medications = true;
	$medications = $db->getHistoryMedications($patient_id);
	while($medication = $medications->fetch_assoc()) {
		if($no_medications) {
			$no_medications = false;
			echo '<ul class="list_group">';
		}
		$medication_id = $medication["id"];
		$name = $medication['name'];
		$end_date = $medication['end_date'];

		$display_text = $name;
		if($end_date) {
			$display_text .= " (" . Utilities::reformatDateForDisplay($end_date) . ")";
		} else {
			$display_text .= " (Current)";
		}
		

		echo '<li class="list-group-item" onclick="medicationClick(' . $patient_id . ', ' . $medication_id . ');">' . $display_text . '</li>';
	}
	if($no_medications) {
		echo '<p class="no_entries_p">' . NO_REPORTED_INFORMATION . '</p>';
	} else {
		echo '</ul>';
	}

?>
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

function consultClick(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
}

function allergyClick(patient_id, allergy_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_allergy.php?patient_id=" + patient_id + "&allergy_id=" + allergy_id + extra_text;
}

function illnessClick(patient_id, illness_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_illness.php?patient_id=" + patient_id + "&illness_id=" + illness_id + extra_text;
}

function surgeryClick(patient_id, surgery_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_surgery.php?patient_id=" + patient_id + "&surgery_id=" + surgery_id + extra_text;

}

function medicationClick(patient_id, medication_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_medication.php?patient_id=" + patient_id + "&medication_id=" + medication_id + extra_text;
}

function addAllergy(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_allergy.php?patient_id=" + patient_id + extra_text;
}

function addIllnessCondition(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_illness.php?patient_id=" + patient_id + extra_text;
}

function addSurgery(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_surgery.php?patient_id=" + patient_id + extra_text;
}

function addMedication(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_medication.php?patient_id=" + patient_id + extra_text;
}



</script>

