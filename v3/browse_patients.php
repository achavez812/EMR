<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';

	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$community_name_arg = "";

	if(isset($_GET[COMMUNITY_NAME_ARG])) {
		$community_name_arg = $_GET[COMMUNITY_NAME_ARG];
		if(!$db->communityExists($community_name_arg)) {
			$community_name_arg = "";
		}
	} 

	if($community_name_arg == "") {
		header("LOCATION: index.php?lang=" . $lang);
	}

?>


<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo $community_name_arg; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<?php
			echo '<a id="back_link" onclick="backClick();">' . BACK_TO_COMMUNITIES . '</a>';
			?>
		</div>
	</div>

	<div id="search_row" class="row">
		<div id="search_input_col" class="col-xs-8">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>">
		</div>
		<div id="search_icon_col" class="col-xs-1">
			<img class="icon" src="images/search.png" alt="Search" onclick="searchPatients(<?php echo '\'' . $community_name_arg . '\''; ?>);" height="28px" width="28px">
		</div>
		<div id="add_patient_col" class="col-xs-3">
			<img class="icon" src="images/add_patient.png" alt="Add Patient" onclick="addPatient(<?php echo "'" . $community_name_arg . "'"; ?>);" height="28px" width="28px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul class="list-group">
				<?php
					$no_patients = true;
					$patients = $db->getPatientsInCommunity($community_name_arg);
					$db->close();
					foreach($patients as $patient) {
						$no_patients = false;
						$id = $patient[PATIENTS_COLUMN_ID];
						$name = $patient[PATIENTS_COLUMN_NAME];
						$exact_date_of_birth_known = $patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
						$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];
						$consult_status = $patient[PATIENTS_COLUMN_CONSULT_STATUS];
						$consult_status_datetime = $patient[PATIENTS_COLUMN_CONSULT_STATUS_DATETIME];


						$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

						echo '<li class="list-group-item" onclick="patientClick(' . $id . ', ' . $mode . ');">';
				    	echo '<p class="list_item1">' . $name . '</p>';
				    	echo '<p class="list_item2">' . AGE_FIELD . " " . $list_item2_text . '</p>';

				    	if($consult_status > 0 || Utilities::isToday($consult_status_datetime)) {
				    		$show_line3 = true;
				    		$list_item3_text;
				    		if($consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_PENDING) {
				    			$list_item3_text = TRIAGE_INTAKE_PENDING;
				    		} else if($consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS) {
				    			$list_item3_text = TRIAGE_INTAKE_IN_PROGRESS;
				    		} else if($consult_status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_PENDING) {
				    			$list_item3_text = MEDICAL_CONSULT_PENDING;
				    		} else if($consult_status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_IN_PROGRESS) {
				    			$list_item3_text = MEDICAL_CONSULT_IN_PROGRESS;
				    		} else if(Utilities::isToday($consult_status_datetime)) {
				    			$list_item3_text = COMPLETED_CONSULT_TODAY;
				    		} else {
				    			$show_line3 = false;
					    	}
					    	if($show_line3) {
					    		echo '<p class="list_item3">' . $list_item3_text . '</p>';
					    	}
					    }
				    	echo "</li>";
					}
					if($no_patients) {
						echo "<p class='center_title'>" . NO_PATIENTS_IN_COMMUNITY_MESSAGE . "</p>";

					}
				?>
			</ul>
		</div>
	</div>

</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "browse_communities.php" + lang_text;
}

function patientClick(patient_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function addPatient(community_name) {
	var lang_text = getLang(1);
	window.location.href = "add_patient.php?mode=1&community_name=" + community_name + lang_text;
}

function searchPatients(community_name) {
	var search_str = document.getElementById("search_input").value;
	if(search_str) {
		var lang_text = getLang(1);
		window.location.href = "search_patients.php?mode=1&search_str=" + search_str + "&community_name=" + community_name + lang_text;
	}
}


</script>

</html>