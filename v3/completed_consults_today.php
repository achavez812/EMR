<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';


	$list = "";
	if($db->hasPatientsWithCompletedConsultToday()) {
		$list = $db->getPatientsWithCompletedConsultToday();
	}



?>


<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo COMPLETED_CONSULTS_TODAY_ABBREVIATION; ?></span>
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



	<?php
		if($list == "") {
	?>
		<div class="row left_title4">
			<?php echo NO_COMPLETED_CONSULTS_TODAY; ?>
		</div>
	<?php
		} else {
			$num_matches = $list->num_rows;

	?>
		<div class="row left_title4">
			<?php echo $num_matches . " " . COMPLETED_CONSULT_TODAY; ?>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<ul class="list-group">
					<?php
						foreach($list as $patient) {
							$patient_id = $patient[PATIENTS_COLUMN_ID];
							$name = $patient[PATIENTS_COLUMN_NAME];
							$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
							$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];

							$recent_consult_id = $db->getRecentConsultId($patient_id);

							$patient_id = "'" . $patient_id . "'";
							$recent_consult_id = "'" . $recent_consult_id . "'";

							$list_item2_text = Utilities::getCurrentAgeString($date_of_birth, $lang);

							echo '<li class="list-group-item" onclick="patientClick(' . $patient_id . ', ' . $recent_consult_id . ');">';
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
	?>
	
</div>


<script>
	function backClick() {
		var lang_text = getLang();
		window.location.href = "index.php" + lang_text;
	}

function searchPatients() {
	var search_str = document.getElementById("search_input").value;
	if(search_str) {
		var lang_text = getLang(1);
		window.location.href = "search_patients.php?mode=1&search_str=" + search_str + "&consult_status=5" + lang_text;
	}
}

	function patientClick(patient_id, recent_consult_id) {
		var lang_text = getLang(1);
		window.location.href = "profile.php?patient_id=" + patient_id + lang_text;
	}

</script>

</html>


