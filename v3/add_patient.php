<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';

	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$title_text = ADD_NEW_PATIENT;

	$save = SAVE_NORMAL;
	$redirect = 0;
	$back_text = "";
	$similar_patients = "";

	$patient_id = INVALID_VALUE;

	$name_arg = "";
	$community_name_arg = "";
	$sex_arg = "";
	$exact_date_of_birth_known_arg = "";
	$date_of_birth_arg = "";
	$age_years_arg = "";

	if(isset($_GET[SAVE_ARG])) {
		$name_arg = $_GET[PATIENTS_COLUMN_NAME];
		$community_name_arg = $_GET[PATIENTS_COLUMN_COMMUNITY_NAME];
		$sex_arg = $_GET[PATIENTS_COLUMN_SEX];
		if(isset($_GET[PATIENTS_COLUMN_DATE_OF_BIRTH])) {
			$exact_date_of_birth_known_arg = BOOLEAN_TRUE;
			$date_of_birth_arg = $_GET[PATIENTS_COLUMN_DATE_OF_BIRTH];
		} else {
			$exact_date_of_birth_known_arg = BOOLEAN_FALSE;
			$age_years_arg = (int)$_GET['age_years'];
			$date_of_birth_arg = Utilities::convertAgeYearsToDateOfBirth($age_years_arg);
		}

		if(isset($_GET[PATIENT_ID_ARG])) { //UPDATE EXISTING
			$patient_id = $_GET[PATIENT_ID_ARG];
			$db->updatePatient($patient_id, $name_arg, $community_name_arg, $sex_arg, $exact_date_of_birth_known_arg, $date_of_birth_arg, Utilities::getCurrentDateTime());
		} else { //CREATE NEW
			$save = $_GET[SAVE_ARG];
			if($save != SAVE_OVERWRITE && $db->hasSimilarPatients($name_arg, $sex_arg, $exact_date_of_birth_known_arg, $date_of_birth_arg)) {
				$back_text = BACK_TO_COMMUNITIES;
				$redirect = REDIRECT_COMMUNITIES;

				$save = SAVE_OVERWRITE;
				$similar_patients = $db->getSimilarPatients($name_arg, $sex_arg, $exact_date_of_birth_known_arg, $date_of_birth_arg);
				echo '<script>';
				echo 'alert("' . PATIENT_MATCHES_FOUND . '")';
				echo '</script>';
			} else {
				$patient_id = $db->createPatient($name_arg, $community_name_arg, $sex_arg, $exact_date_of_birth_known_arg, $date_of_birth_arg, Utilities::getCurrentDateTime());
			}
		} 
		if($similar_patients == "") {
			header("LOCATION: profile.php?lang=" . $lang . "&" . MODE_ARG . "=" . $mode . "&" . PATIENT_ID_ARG . "=" . $patient_id);
		}
	} else if(isset($_GET[PATIENT_ID_ARG])) { //DISPLAY EXISTING
		$title_text = EDIT_PATIENT;
		$back_text = BACK_TO_PROFILE;
		$redirect = REDIRECT_PROFILE;

		$patient_id = $_GET[PATIENT_ID_ARG];
		$patient = $db->getPatient($patient_id);

		$name_arg = $patient[PATIENTS_COLUMN_NAME];
		$community_name_arg = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
		$sex_arg = $patient[PATIENTS_COLUMN_SEX];
		$exact_date_of_birth_known_arg = $patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
		$date_of_birth_arg = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

		if($exact_date_of_birth_known_arg == BOOLEAN_FALSE) {
			$age_years_arg = Utilities::getAgeInYears($date_of_birth_arg);
		}
	} else { //DISPLAY NEW
		if(isset($_GET[COMMUNITY_NAME_ARG])) {
			$community_name_arg = $_GET[COMMUNITY_NAME_ARG];
			$back_text = BACK_TO . " " . $community_name_arg;
			$redirect = REDIRECT_PATIENTS;
		} else {
			$back_text = BACK_TO_COMMUNITIES;
			$redirect = REDIRECT_COMMUNITIES;
		}
	}

?>


<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo $title_text; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<?php
			echo '<a id="back_link" onclick="backClick(\'' . $patient_id . '\', \'' . $community_name_arg . '\', \'' . $mode . '\', \'' . $redirect . '\');">' . $back_text . '</a>';
			?>
		</div>
	</div>


	<?php
		if($similar_patients != "") {
	?>

	<div id="patient_matches_row" class="row input_row">
		<div class="col-xs-12">
			<p class="center_title"><?php echo PATIENT_MATCHES; ?></p>
			<?php
			foreach($similar_patients as $similar_patient) {
				$similar_patient_id = $similar_patient[PATIENTS_COLUMN_ID];
				$similar_patient_name = $similar_patient[PATIENTS_COLUMN_NAME];
				$similar_patient_community_name = $similar_patient[PATIENTS_COLUMN_COMMUNITY_NAME];
				$similar_patient_exact_date_of_birth_known = $similar_patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
				$similar_patient_date_of_birth = $similar_patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

				$similar_patient_formatted_date_of_birth = Utilities::formatDateForDisplay($similar_patient_date_of_birth);
				if($similar_patient_exact_date_of_birth_known == BOOLEAN_FALSE) {
					$similar_patient_formatted_date_of_birth .= " " . APPROXIMATE_ABBREVIATION;
				}

				echo '<li class="list-group-item" onclick="similarPatientClick(' . $similar_patient_id . ');">';
		    	echo '<p class="list_item1">' . $similar_patient_name . '</p>';
		    	echo '<p class="list_item2">' . COMMUNITY_FIELD . " " . $similar_patient_community_name . '</p>';
		    	echo '<p class="list_item3">' . DATE_OF_BIRTH_FIELD . " " . $similar_patient_formatted_date_of_birth . '</p>';
		    	echo "</li>";
			}
			?>
		</div>
	</div>

	<?php
		} 
	?>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NAME_FIELD; ?></p>
			<span class="input_field_text_span"><input id="name_input" class="input_field" type="text" value='<?php echo $name_arg; ?>'></span>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo COMMUNITY_FIELD; ?></p>
			<select id="community_select" class="input_field">
				<option value="-1"><?php echo TOUCH_HERE; ?></option>
				<?php
					$existing_community = false;
					$communities = $db->getCommunities();
					if($community_name_arg != "") {
						foreach($communities as $community) {
							$community_name = $community[COMMUNITIES_COLUMN_NAME];
							if($community_name_arg == $community_name) {
								$existing_community = true;
					    		echo '<option value="' . $community_name . '" selected>' . $community_name .'</option>';
					    	} else {
					    		echo '<option value="' . $community_name . '">' . $community_name .'</option>';
					    	}
						}
					} else {
						foreach($communities as $community) {
							$community_name = $community[COMMUNITIES_COLUMN_NAME];
							echo '<option value="' . $community_name . '">' . $community_name .'</option>';
						}
					}

					if($community_name_arg != "" && !$existing_community) {
				?>
						<option value="-2" selected><?php echo OTHER_COMMUNITY; ?></option>
				<?php
					} else {
				?>
						<option value="-2"><?php echo OTHER_COMMUNITY; ?></option>
				<?php
					}
				?>
			</select>
		</div>
	</div>

	<div id="community_custom_row" class="row input_row hidden">
		<div class="col-xs-12">
			<?php
				if($community_name_arg != "" && !$existing_community) {
			?>
					<span class="input_field_text_span"><input id="custom_community_input" class="input_field" type="text" placeholder="<?php echo OTHER_COMMUNITY; ?>" value="<?php echo $community_name_arg; ?>"></span>
			<?php
				} else {
			?>
					<span class="input_field_text_span"><input id="custom_community_input" class="input_field" type="text" placeholder="<?php echo OTHER_COMMUNITY; ?>"></span>
			<?php
				}
			?>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo SEX_FIELD; ?></p>
			<form id="sex_radiogroup" class="input_field">
				<input type="radio" id="radio_sex_male" name="sex" value="1" <?php if($sex_arg == SEX_MALE) echo 'checked'; ?>><label for="radio_sex_male"><?php echo MALE; ?></label>
				<input type="radio" id="radio_sex_female" name="sex" value="2" <?php if($sex_arg == SEX_FEMALE) echo 'checked'; ?>><label for="radio_sex_female"><?php echo FEMALE; ?></label>
			</form>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo IS_EXACT_DOB_KNOWN; ?></p>
			<form id="dob_known_radiogroup" class="input_field">
				<input id="dob_known_yes" type="radio" name="dob_known" value="2" <?php if($exact_date_of_birth_known_arg == BOOLEAN_TRUE) echo 'checked'; ?>><label for="dob_known_yes"><?php echo YES; ?></label>
				<input id="dob_known_no" type="radio" name="dob_known" value="1" <?php if($exact_date_of_birth_known_arg == BOOLEAN_FALSE) echo 'checked'; ?>><label for="dob_known_no"><?php echo NO; ?></label>
			</form>
		</div>
	</div>

	<div id="date_of_birth_row" class="row input_row hidden">
		<div class="col-xs-12">
			<p class="input_label"><?php echo DATE_OF_BIRTH_FIELD; ?></p>
			<input id="date_of_birth_input" class="input_field" type="date" value='<?php echo $date_of_birth_arg; ?>'>
		</div>
	</div>

	<div id="age_row" class="row input_row hidden">
		<div class="col-xs-12">
			<p class="input_label"><?php echo AGE_YEARS_FIELD; ?></p>
			<input id="age_input" class="input_field" type="number" min="1" step="1" value='<?php echo $age_years_arg; ?>'>
		</div>
	</div>

	<div id="button_row" class="row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick(<?php echo "'" . $patient_id . "', '" . $save . "', '" . $mode . "'"; ?>);"><?php echo SAVE_CAPS; ?></button>
		</div>
	</div>



</div>


<script>

if($("#custom_community_input").val()) {
	$('#community_custom_row').removeClass("hidden");
}

if($("#dob_known_yes").is(':checked')) {
	$("#date_of_birth_row").removeClass("hidden");
}

if($("#dob_known_no").is(':checked')) {
	$("#age_row").removeClass("hidden");
}

document.getElementById("community_select").onchange = function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if (value == "-2") {
		$('#community_custom_row').removeClass("hidden");
	} else {
		$('#community_custom_row').addClass("hidden");
	}
}

$("input[name=dob_known]").change(function() {
	var value = $("input[name=dob_known]:checked").val();
	if (value == "2") {
		$('#date_of_birth_row').removeClass("hidden");
		$('#age_row').addClass("hidden");
	} else if (value == "1") {
		$('#date_of_birth_row').addClass("hidden");
		$('#age_row').removeClass("hidden");
	} else {
		$('#date_of_birth_row').addClass("hidden");
		$('#age_row').addClass("hidden");
	}
});

function backClick(patient_id, community_name, mode, redirect) {
	var lang_text = getLang(1);
	if(redirect == 2) {
		window.location.href = "browse_patients.php?mode=" + mode + "&community_name=" + community_name + lang_text;
	} else if (redirect == 3) {		
		window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
	} else {
		window.location.href = "browse_communities.php?&mode=" + mode + lang_text;
	}
}

function similarPatientClick(patient_id) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=1&patient_id=" + patient_id + lang_text;
}

function saveClick(patient_id, save, mode) {
	var valid_submission = true;

	var name = $("#name_input").val();
	if (name == "") {
		valid_submission = false;
	}

	var community_name = $("#community_select").find(":selected").val();
	if (community_name == "-1") {
		valid_submission = false;
	} else if (community_name == "-2") {
		community_name = $("#custom_community_input").val();
		if (community_name == "") {
			valid_submission = false;
		}
	}

	var sex = $("input[name=sex]:checked").val();
	if (sex != "1" && sex != "2") {
		valid_submission = false;
	}

	var dob_known = $("input[name=dob_known]:checked").val();
	var date_of_birth = "";
	var age_years = -1;
	if (dob_known != "1" && dob_known != "2") {
		valid_submission = false;
	} else if (dob_known == "2") {
		date_of_birth = $("#date_of_birth_input").val();
		if (date_of_birth == "") {
			valid_submission = false;
		}
	} else if (dob_known == "1") {
		age_years = $("#age_input").val();
		if (age_years == "") {
			valid_submission = false;
		}
	}

	var lang = getURLParameter("lang");
	var lang_text = formLang(lang, 1);
	if(valid_submission) {
		var url = "add_patient.php?name=" + name + "&community_name=" + community_name + "&sex=" + sex; 
		if(patient_id != '-1') {
			url += "&patient_id=" + patient_id;
		}
		if(dob_known == "2") {
			url += "&date_of_birth=" + date_of_birth;
		} else {
			url += "&age_years=" + age_years;
		}
		window.location.href = url + "&mode=" + mode + "&save=" + save + lang_text;
	} else {
		alert(EMPTY_FIELDS_MUST_COMPLETE_MESSAGE);
	}

}




</script>

</html>


