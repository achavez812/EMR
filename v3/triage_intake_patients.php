<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';
	/*	
	if(isset($_GET['show_alert'])) {
		$show_alert = $_GET['show_alert'];
		if($show_alert == 2) {
			echo '<script>';
			echo 'alert("' . HOME_SET_TRIAGE_INTAKE_MESSAGE . '")';
			echo '</script>';
		}
	}
	*/
	$filter_option = FILTER_OPTION_DUE_ALL;
	if(isset($_GET['filter_option'])) {
		$filter_option = $_GET['filter_option'];
	}

	$list1 = "";
	$list2 = "";

	if($filter_option == FILTER_OPTION_PENDING) {
		if($db->hasPatientsWithConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_PENDING)) {
			$list1 = $db->getPatientsByConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_PENDING);
		}
	} else if ($filter_option == FILTER_OPTION_IN_PROGRESS) {
		if($db->hasPatientsWithConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS)) {
			$list2 = $db->getPatientsByConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS);
		}
	} else {
		if($db->hasPatientsWithConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_PENDING)) {
			$list1 = $db->getPatientsByConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_PENDING);
		}
		if($db->hasPatientsWithConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS)) {
			$list2 = $db->getPatientsByConsultStatus(CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS);
		}
	}	


?>

<div id="mySidenav" class="sidenav">
  <a href="#"><?php echo SETTINGS; ?></a>
</div>

<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo TRIAGE_INTAKE; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<a id="back_link" onclick="backClick();"><?php echo BACK_TO_HOME_PAGE; ?></a>
		</div>
	</div>

	<div id="search_row" class="row">
		<div id="search_input_col" class="col-xs-10">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>">
		</div>
		<div id="search_icon_col" class="col-xs-2">
			<img class="icon" src="images/search.png" alt="Search" onclick="searchPatients();" height="28px" width="28px">
		</div>
	</div>

	<div id="filter_options_row" class="row">
		<div class="col-xs-2 filter_col">
			<div id="due_all_button" class="filter_button center_title3 <?php if($filter_option == FILTER_OPTION_DUE_ALL) { echo 'selected_button'; } else { echo 'unselected_button'; } ?>" onclick="filterClick(1);"><?php echo DUE_ALL; ?></div>
		</div>
		<div class="col-xs-5 filter_col">
			<div id="pending_button" class="filter_button center_title3 <?php if($filter_option == FILTER_OPTION_PENDING) { echo 'selected_button'; } else { echo 'unselected_button'; } ?>" onclick="filterClick(2);"><?php echo PENDING; ?></div>
		</div>
		<div  class="col-xs-5 filter_col">
			<div id="in_progress_button" class="filter_button center_title3 <?php if($filter_option == FILTER_OPTION_IN_PROGRESS) { echo 'selected_button'; } else { echo 'unselected_button'; } ?>" onclick="filterClick(3);"><?php echo IN_PROGRESS; ?></div>
		</div>
	</div>


	<?php
	if($filter_option == FILTER_OPTION_DUE_ALL) {
	?>
	<div class="row input_row left_title4">
		<?php echo PENDING_NOT_STARTED; ?>
	</div>
	<?php
	}
	?>

	<?php
	if($filter_option == FILTER_OPTION_DUE_ALL || $filter_option == FILTER_OPTION_PENDING) {
		if($list1 == "") {
	?>
		<div class="row center_title5">
			<?php echo NO_MATCHING_RESULTS; ?>
		</div>
	<?php
		} else {
	?>
		<div class="row">
			<div class="col-xs-12">
				<ul class="list-group">
					<?php
						foreach($list1 as $patient) {
							$patient_id = $patient[PATIENTS_COLUMN_ID];
							$name = $patient[PATIENTS_COLUMN_NAME];
							$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
							$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

							$active_consult_id = $db->getActiveConsultId($patient_id);

							$patient_id = "'" . $patient_id . "'";
							$active_consult_id = "'" . $active_consult_id . "'";

							$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

							echo '<li class="list-group-item" onclick="patientClick(' . $patient_id . ', ' . $active_consult_id . ');">';
					    	echo '<p class="list_item1">' . $name . '</p>';
					    	echo '<p class="list_item2">' . AGE_FIELD . " " . $list_item2_text . '</p>';
					    	echo '<p class="list_item3">' . COMMUNITY_FIELD . " " . $community_name . '</p>';
					    	echo "</li>";
							

						}
					?>
				</ul>
			</div>
		</div>
	<?php
		}
	}
	?>
	
	<?php
	if($filter_option == FILTER_OPTION_DUE_ALL) {
	?>
	<div class="row input_row left_title4">
		<?php echo IN_PROGRESS; ?>
	</div>
	<?php
	}
	?>

	<?php
	if($filter_option == FILTER_OPTION_DUE_ALL || $filter_option == FILTER_OPTION_IN_PROGRESS) {
		if($list2 == "") {
	?>
		<div class="row center_title5">
			<?php echo NO_MATCHING_RESULTS; ?>
		</div>
	<?php
		} else {
	?>
		<div class="row">
			<div class="col-xs-12">
				<ul class="list-group">
					<?php
						foreach($list2 as $patient) {
							$patient_id = $patient[PATIENTS_COLUMN_ID];
							$name = $patient[PATIENTS_COLUMN_NAME];
							$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
							$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

							$active_consult_id = $db->getActiveConsultId($patient_id);

							$patient_id = "'" . $patient_id . "'";
							$active_consult_id = "'" . $active_consult_id . "'";

							$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

							echo '<li class="list-group-item" onclick="patientClick(' . $patient_id . ', ' . $active_consult_id . ');">';
					    	echo '<p class="list_item1">' . $name . '</p>';
					    	echo '<p class="list_item2">' . AGE_FIELD . " " . $list_item2_text . '</p>';
					    	echo '<p class="list_item3">' . COMMUNITY_FIELD . " " . $community_name . '</p>';
					    	echo "</li>";
						}
					?>
				</ul>
			</div>
		</div>
	<?php
		}
	}
	?>
</div>


<script>
	function backClick() {
		var lang_text = getLang();
		window.location.href = "index.php" + lang_text;
	}

	function filterClick(arg) {
		window.location.href = "triage_intake_patients.php?filter_option=" + arg + getLang(1);
	}

function searchPatients(community_name) {
	var search_str = document.getElementById("search_input").value;
	if(search_str) {
		var lang_text = getLang(1);
		window.location.href = "search_patients.php?mode=1&search_str=" + search_str + "&consult_status=1" + lang_text;
	}
}

	function patientClick(patient_id, active_consult_id) {
		var lang_text = getLang(1);
		if(active_consult_id) {
			window.location.href = "consult_active.php?mode=2&consult_id=" + active_consult_id + lang_text;
		} else {
			window.location.href = "profile.php?mode=2&patient_id=" + patient_id + lang_text;
		}
	}

</script>

</html>


