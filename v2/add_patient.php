
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

	$header_text = ADD_NEW_PATIENT;
	$button_text = CREATE_PATIENT;

	$submit = 1;
	$similar_patients;

	$community_id_arg = "";
	$community_name_arg = "";
	$name = "";
	$sex = "";
	$date_of_birth = "";
	$exact_date_of_birth_known = "";
	$age_years = "";

	$patient_id = "";

	if(isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];
		if($patient_id) { //EXISTING PATIENT
			if(isset($_GET['submit'])) {
				//SUBMIT
				$community_id_arg = $_GET['community_id'];
				$community_name_arg = $_GET['community_name'];
				$name = $_GET['name'];
				$sex = $_GET['sex'];
				$date_of_birth = $_GET['dob'];
				$exact_date_of_birth_known = $_GET['dob_known'];
				$age_years = $_GET['age'];

				if($community_id_arg == 'unlisted') {
					$community_id_arg = $db->createCommunity($community_name_arg);
				}

				if($sex == "male") {
					$sex = SEX_MALE;
				} else if ($sex == "female") {
					$sex = SEX_FEMALE;
				} else {
					header($index_link);
				}

				if($exact_date_of_birth_known == "yes") {
					$exact_date_of_birth_known = BOOLEAN_TRUE;
				} else if ($exact_date_of_birth_known == "no") {
					$exact_date_of_birth_known = BOOLEAN_FALSE;
					$date_of_birth = Utilities::convertAgeYearsToDateOfBirth($age_years);
				} else {
					header($index_link);
				}

				$patient_id = $db->updatePatient($patient_id, $community_id_arg, $name, $sex, $date_of_birth, $exact_date_of_birth_known, Utilities::getCurrentDatetime());
				if($patient_id > 0) {
					header("LOCATION: profile.php?id=" . $patient_id. "&lang=" . $lang);
				}
			} else {
				$header_text = EDIT_PATIENT;
				$button_text = UPDATE_PATIENT;

				$patient = $db->getPatientById($patient_id);
				$community_id_arg = $patient['community_id'];
				$name = $patient['name'];
				$sex = $patient['sex'];
				$date_of_birth = $patient['date_of_birth'];
				$exact_date_of_birth_known = $patient['exact_date_of_birth_known'];
				if($exact_date_of_birth_known == BOOLEAN_FALSE) {
					$age_years = Utilities::getAgeInYears($date_of_birth);
					$date_of_birth = "";
				}
			}
		} else { //NON EXISTING PATIENT
			if(isset($_GET['submit'])) {
				$submit_arg = $_GET['submit'];

				$community_id_arg = $_GET['community_id'];
				$community_name_arg = $_GET['community_name'];
				$name = $_GET['name'];
				$sex = $_GET['sex'];
				$date_of_birth = $_GET['dob'];
				$exact_date_of_birth_known = $_GET['dob_known'];
				$age_years = $_GET['age'];

				if($sex == "male") {
					$sex = SEX_MALE;
				} else if ($sex == "female") {
					$sex = SEX_FEMALE;
				} else {
					header($index_link);
				}

				if($exact_date_of_birth_known == "yes") {
					$exact_date_of_birth_known = BOOLEAN_TRUE;
				} else if ($exact_date_of_birth_known == "no") {
					$exact_date_of_birth_known = BOOLEAN_FALSE;
				} else {
					header($index_link);
				}

				if($submit_arg != 2 && $db->hasSimilarPatient($name, $sex, $date_of_birth, $exact_date_of_birth_known)) {
					$similar_patients = $db->getSimilarPatients($name, $sex, $date_of_birth, $exact_date_of_birth_known);
					$submit = 2;

					if($community_id_arg == 'unlisted') {
						$community_id_arg = '';
					}
				} else {
					if($community_id_arg == 'unlisted') {
						$community_id_arg = $db->createCommunity($community_name_arg);
					}
					if($exact_date_of_birth_known == BOOLEAN_FALSE) {
						$date_of_birth = Utilities::convertAgeYearsToDateOfBirth($age_years);
					}

					$patient_id = $db->createPatient($community_id_arg, $name, $sex, $date_of_birth, $exact_date_of_birth_known, Utilities::getCurrentDatetime());
					if($patient_id > 0) {
						header("LOCATION: profile.php?id=" . $patient_id. "&lang=" . $lang);
					}
				}
			}
		}
	} else {
		if (isset($_GET['community_id'])) {
			$community_id_arg = $_GET['community_id'];
		} 
	}


?>			

<div class="container-fluid">

	<div class="row row1">

		<div class="col-xs-12">

			<h1><?php echo $header_text; ?></h1>
			<?php
				if($submit == 2) {
					echo '<p id="header_message">' . ADD_PATIENT_MATCH_MESSAGE . '</p>';
					echo '<div class="list-group">';
					while($row = $similar_patients->fetch_assoc()){
				    	$temp_patient_id = $row['id'];
				    	$temp_community_id = $row['community_id'];
				    	$temp_community = $db->getCommunityById($temp_community_id);
				    	$temp_community_name = $temp_community['name'];
				    	$patient_date_of_birth = $row['date_of_birth'];
				    	$patient_formatted_dob = Utilities::reformatDateForDisplay($patient_date_of_birth);
				    	$patient_exact_date_of_birth_known = $row['exact_date_of_birth_known'];
				    	if($patient_exact_date_of_birth_known == BOOLEAN_FALSE) {
				    		$patient_formatted_dob .= " (" . APPROXIMATE_ABBREVIATION . ")";
				    	}
				    	$patient_name = $row['name'];

				    	echo '<a class="list-group-item" onclick="patientClick(' . $temp_patient_id . ');">';
				    	echo '<p id="list_item1">' . $patient_name . '</p>';
				    	echo '<p id="list_item2">' . COMMUNITY . ": " . $temp_community_name . '</p>';
				    	echo '<p id="list_item3">' . DATE_OF_BIRTH . $patient_formatted_dob . '</p>';
				    	echo "</a>";
				    }
				    echo '</div>';
				} else {
					echo '<p id="header_message">' . ADD_PATIENT_ENSURE_PATIENT_DOES_NOT_EXIST_MESSAGE . '</p>';
				}
			?>
		
		</div>

	</div>




	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME . ":"; ?></p>
			<input id="name_input" class="input_field" type="text" value='<?php echo $name; ?>'>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo COMMUNITY . ":"; ?></p>
			<select id="community_select" class="input_field">

<?php

	if($community_id_arg == "" && $community_name_arg == "") {
		echo '<option value="touch_here" selected>' . TOUCH_HERE . '</option>';
	} else {
		echo '<option value="touch_here">' . TOUCH_HERE . '</option>';
	}

	$result = $db->getAllCommunities();
    while($row = $result->fetch_assoc()){
    	$community_id = $row['id'];
    	$community_name = $row['name'];
    	if($community_id_arg != "") {
	    	if($community_id_arg == $community_id) {
	    		echo '<option value="' . $community_id . '" selected>' . $community_name .'</option>';
	    	} else {
	    		echo '<option value="' . $community_id . '">' . $community_name .'</option>';
	    	}
	    } else {
	    	echo '<option value="' . $community_id . '">' . $community_name .'</option>';
	    }
    	
    }
    if($community_name_arg == "") {
    	echo '<option value="unlisted">' . UNLISTED_COMMUNITY .'</option>';
    } else {
    	echo '<option value="unlisted" selected>' . UNLISTED_COMMUNITY . '</option>';
    }
?>

				
			</select>
		</div>
	</div>

	<div id="community_custom_row" class="row input_row">
		<div class="col-xs-12">
			<input id="custom_community_input" class="input_field" type="text" placeholder="<?php echo CUSTOM_OTHER; ?>" value='<?php echo $community_name_arg; ?>'>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo SEX . ":"; ?></p>
			<form id="sex_radiogroup" class="input_field">
				<input type="radio" id="radio_sex_male" name="sex" value="male" <?php if($sex == SEX_MALE) echo 'checked'; ?>><label for="radio_sex_male"><?php echo MALE; ?></label>
				<input type="radio" id="radio_sex_female" name="sex" value="female" <?php if($sex == SEX_FEMALE) echo 'checked'; ?>><label for="radio_sex_female"><?php echo FEMALE; ?></label>
			</form>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo IS_EXACT_DOB_KNOWN . ":"; ?></p>
			<form id="dob_known_radiogroup" class="input_field">
				<input id="dob_known_yes" type="radio" name="dob_known" value="yes" <?php if($exact_date_of_birth_known == BOOLEAN_TRUE) echo 'checked'; ?>><label for="dob_known_yes"><?php echo YES; ?></label>
				<input id="dob_known_no" type="radio" name="dob_known" value="no" <?php if($exact_date_of_birth_known == BOOLEAN_FALSE) echo 'checked'; ?>><label for="dob_known_no"><?php echo NO; ?></label>
			</form>
		</div>
	</div>

	<div id="date_of_birth_row" class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo DATE_OF_BIRTH; ?></p>
			<input id="date_of_birth_input" class="input_field" type="date" value='<?php echo $date_of_birth; ?>'>
		</div>
	</div>

	<div id="age_row" class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo AGE_YEARS . ":"; ?></p>
			<input id="age_input" class="input_field" type="number" min="1" step="1" value='<?php echo $age_years; ?>'>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="buttonClick(<?php echo "'" . $patient_id . "', " . $submit; ?>);"><?php echo $button_text; ?></button>
		</div>
	</div>

</div>



<script type="text/javascript">

if($("#dob_known_yes").is(':checked')) {
	$("#date_of_birth_row").show();
}

if($("#dob_known_no").is(':checked')) {
	$("#age_row").show();
}

if ($("#community_select option:selected").val() == "unlisted") {
	$('#community_custom_row').show();
} else {
	$('#community_custom_row').hide();
}

function buttonClick(patient_id, submit) {
	var valid_submission = true;
	if(!patient_id) {
		patient_id = "";
	}
	var name = $("#name_input").val();
	if (name == "") {
		valid_submission = false;
	}

	var community_id = $("#community_select").find(":selected").val();
	var community_name = "";
	if (community_id == "touch_here") {
		valid_submission = false;
	} else if (community_id =="unlisted") {
		community_name = $("#custom_community_input").val();
		if (community_name == "") {
			valid_submission = false;
		}
	}
	
	var sex = $("input[name=sex]:checked").val();
	if (sex != "male" && sex != "female") {
		valid_submission = false;
	}

	var dob_known = $("input[name=dob_known]:checked").val();
	var date_of_birth = "";
	var age = 0;
	if (dob_known != "yes" && dob_known != "no") {
		valid_submission = false;
	} else if (dob_known == "yes") {
		date_of_birth = $("#date_of_birth_input").val();
		if (date_of_birth == "") {
			valid_submission = false;
		}
	} else if (dob_known == "no") {
		age = $("#age_input").val();
		if (age == "") {
			valid_submission = false;
		}
	}

	var lang = getURLParameter("lang");
	if(!valid_submission ) {
		var alert_text = "ERROR: EMPTY FIELD. MUST COMPLETE ALL QUESTIONS.";
		if(lang == "es") {
			alert_text = "ERROR: CAMPO VACÍO. DEBE COMPLETAR TODAS LAS PREGUNTAS.";
		}  
		alert(alert_text);
		return;
	}

	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}

	window.location.href = "add_patient.php?submit=" + submit + "&patient_id=" + patient_id + "&name=" + name + "&community_id=" + community_id + "&community_name=" + community_name + "&sex=" + sex + "&dob_known=" + dob_known + "&dob=" + date_of_birth + "&age=" + age  + extra_text;

}

document.getElementById("community_select").onchange = function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if (value == "unlisted") {
		$('#community_custom_row').show();
	} else {
		$('#community_custom_row').hide();
	}
}

$("input[name=dob_known]").change(function() {
	var value = $("input[name=dob_known]:checked").val();
	if (value == "yes") {
		$('#date_of_birth_row').show();
		$('#age_row').hide();
	} else if (value == "no") {
		$('#date_of_birth_row').hide();
		$('#age_row').show();
	} else {
		$('#date_of_birth_row').hide();
		$('#age_row').hide();
	}
});

function patientClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "profile.php?id=" + patient_id + extra_text;
}

</script>
