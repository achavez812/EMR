<!DOCTYPE html>
<html onclick="closeNav();">

<?php
	require_once 'include/include.php';

	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$back_text = "";
	$redirect = 0;
	$community_name_arg = "";

	if(isset($_GET[COMMUNITY_NAME_ARG])) {
		$community_name_arg = $_GET[COMMUNITY_NAME_ARG];
		if(!$db->communityExists($community_name_arg)) {
			$community_name_arg = "";
		} 
	} 

	$results1 = "";
	$results2 = "";

	$search_str = "";
	if(isset($_GET['search_str'])) {
		$search_str = $_GET['search_str'];
	} 

	if($search_str == "") {
		$lang_text = getLang();
		header("LOCATION: index.php" . $lang_text);
	}

	$consult_status = "";
	if($community_name_arg == "") {
		if(isset($_GET['consult_status'])) {
			$consult_status = $_GET['consult_status'];
		}
		if($consult_status == "") {
			$results1 = $db->searchAllPatients($search_str);
		} else {
			if($consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE) {
				$back_text = BACK_TO_TRIAGE_INTAKE_LIST;
				$redirect = REDIRECT_TRIAGE_INTAKE_LIST;
			} else if ($consult_status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT){
				$back_text = BACK_TO_MEDICAL_CONSULT_LIST;
				$redirect = REDIRECT_MEDICAL_CONSULT_LIST;
			} else if ($consult_status == CONSULT_STATUS_CONSULT_COMPLETED) {
				$back_text = BACK_TO_COMPLETED_CONSULTS_LIST;
				$redirect = REDIRECT_COMPLETED_CONSULT_LIST;
			}
			$results1 = $db->searchPatientsByConsultStatus($search_str, $consult_status);
			$results2 = $db->searchPatientsNotWithConsultStatus($search_str, $consult_status);
		}
	} else {
		$back_text = BACK_TO . " " . $community_name_arg;
		$redirect = REDIRECT_PATIENTS;
		$results1 = $db->searchPatientsByCommunity($search_str, $community_name_arg);
		$results2 = $db->searchPatientsNotInCommunity($search_str, $community_name_arg);
	}

	if($redirect == 0) {
		$back_text = BACK_TO_COMMUNITIES;
		$redirect = REDIRECT_COMMUNITIES;
	}

?>

<div id="mySidenav" class="sidenav">
  <a href="#"><?php echo SETTINGS; ?></a>
</div>

<div id="content" class="container-fluid" onclick="closeNav();">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo SEARCH_RESULTS; ?></span>
			<img id="navigation_header_menu" src="images/menu.png" alt="Menu" height="28px" width="28px">
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<?php
			echo '<a id="back_link" onclick="backClick(\'' . $community_name_arg . '\', \'' . $mode . '\', \'' . $redirect . '\');">' . $back_text . '</a>';
			?>
		</div>
	</div>

	<div id="search_row" class="row">
		<div id="search_input_col" class="col-xs-8">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>" value="<?php echo $search_str; ?>">
		</div>
		<div id="search_icon_col" class="col-xs-1">
			<img class="icon" src="images/search.png" alt="Search" onclick="searchPatients(<?php echo '\'' . $community_name_arg . '\', \'' . $consult_status . '\', \'' . $mode . '\''; ?>);" height="28px" width="28px">
		</div>
		<div id="add_patient_col" class="col-xs-3">
			<img class="icon" src="images/add_patient.png" alt="Add Patient" onclick="addPatient(<?php echo $mode; ?>);" height="28px" width="28px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<p class="left_title2"><?php echo SEARCH_FIELD . " " . $search_str;?></p>
		</div>
	</div>





	<div class="row">
		<div class="col-xs-12">
			<ul class="list-group">
			<?php
				if($results1 != "") {
					if ($redirect == REDIRECT_PATIENTS) {
						echo "<p class='left_title'>" . RESULTS_IN_COMMUNITY . "</p>";
					} else if ($redirect == REDIRECT_TRIAGE_INTAKE_LIST) {
						echo "<p class='left_title'>" . READY_FOR_TRIAGE_INTAKE . "</p>";
					} else if ($redirect == REDIRECT_MEDICAL_CONSULT_LIST) {
						echo "<p class='left_title'>" . READY_FOR_MEDICAL_CONSULT . "</p>";
					} else {
						echo "<p class='left_title'>" . RESULTS . "</p>";
					}
					$no_matches = true;
					foreach($results1 as $patient) {
						$no_matches = false;
						$id = $patient[PATIENTS_COLUMN_ID];
						$name = $patient[PATIENTS_COLUMN_NAME];
						$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
						$exact_date_of_birth_known = $patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
						$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

						$id = "'" . $id . "'";

						$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

						echo '<li class="list-group-item" onclick="patientClick(' . $id . ', ' . $mode . ');">';
				    	echo '<p class="list_item1">' . $name . '</p>';
				    	echo '<p class="list_item2">' . AGE_FIELD . " " . $list_item2_text . '</p>';

				    	if($redirect != REDIRECT_PATIENTS) {
				    		echo '<p class="list_item3">' . COMMUNITY_FIELD . " " . $community_name . '</p>';
				    	}
				    	echo "</li>";

					}

					if($no_matches) {
						echo "<p class='center_title2'>" . NO_MATCHING_RESULTS . "</p>";
					}
				}
				if($results2 != "") {
					echo "<p class='left_title'>" . OTHER_RESULTS . "</p>";
					foreach($results2 as $patient) {
						$no_matches = false;
						$id = $patient[PATIENTS_COLUMN_ID];
						$name = $patient[PATIENTS_COLUMN_NAME];
						$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
						$exact_date_of_birth_known = $patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
						$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

						$id = "'" . $id . "'";

						$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

						echo '<li class="list-group-item" onclick="patientClick(' . $id . ', ' . $mode . ');">';
				    	echo '<p class="list_item1">' . $name . '</p>';
				    	echo '<p class="list_item2">' . AGE_FIELD . " " . $list_item2_text . '</p>';
				    	echo '<p class="list_item3">' . COMMUNITY_FIELD . " " . $community_name . '</p>';
				    	echo "</li>";
				    }


					if($no_matches) {
						echo "<p class='center_title2'>" . NO_MATCHING_RESULTS . "</p>";
					}
				}

			?>

			</ul>
		</div>
	</div>

</div>


<script>

function backClick(community_name, mode, redirect) {
	var lang_text = getLang(1);
	if(redirect == 2) {
		window.location.href = "browse_patients?mode=" + mode + "&community_name=" + community_name + lang_text; 
	} else if (redirect == 4) {
		window.location.href = "triage_intake_patients.php?mode=" + mode + lang_text; 
	} else if (redirect == 5) {
		window.location.href = "medical_consult_patients.php?mode=" + mode + lang_text; 
	} else if (redirect == 6) {
		window.location.href = "completed_consults_today.php?mode=" + mode + lang_text;
	} else {
		window.location.href = "browse_communities.php?mode=" + mode + lang_text;
	}
}

function patientClick(patient_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function addPatient(mode) {
	var lang_text = getLang(1);
	window.location.href = "add_patient.php?mode=" + mode + lang_text;
}

function searchPatients(community_name, consult_status, mode) {
	var search_str = document.getElementById("search_input").value;
	if(search_str) {
		var lang_text = getLang(1);
		if(community_name) {
			window.location.href = "search_patients.php?mode=" + mode + "&search_str=" + search_str + "&community_name=" + community_name + lang_text;
		} else if(consult_status) {
			window.location.href = "search_patients.php?mode=" + mode + "&search_str=" + search_str + "&consult_status=" + consult_status + lang_text;
		} else {
			window.location.href = "search_patients.php?mode=" + mode + "&search_str=" + search_str + lang_text;
		}
	}
}


</script>

</html>