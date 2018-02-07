
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

	$consult_id = 0;
	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		if(isset($_GET['chief_complaint_id'])) {
			$chief_complaint_id = $_GET['chief_complaint_id'];

			if(isset($_GET['delete'])) {
				$delete = $_GET['delete'];
				if($delete == BOOLEAN_TRUE) {
					$is_pregnancy = BOOLEAN_FALSE;
					if(isset($_GET['is_pregnancy'])) {
						$is_pregnancy = $_GET['is_pregnancy'];
					}
					$db->deleteHPI($chief_complaint_id, $is_pregnancy);
					header("LOCATION: history_present_illness.php?consult_id=" . $consult_id . "&lang=" . $lang);
				}
			} else if(isset($_GET['is_pregnancy'])) {
				$is_pregnancy = $_GET['is_pregnancy'];
				if($is_pregnancy == BOOLEAN_TRUE) {
					$num_weeks_pregnant = $_GET['num_weeks_pregnant'];
					$receiving_prenatal_care = $_GET['receiving_prenatal_care'];
					$taking_prenatal_vitamins = $_GET['taking_prenatal_vitamins'];
					$received_ultrasound = $_GET['received_ultrasound'];
					$num_live_births = $_GET['num_live_births'];
					$num_miscarriages = $_GET['num_miscarriages'];
					$dysuria_urgency_frequency = $_GET['dysuria_urgency_frequency'];
					$abnormal_vaginal_discharge = $_GET['abnormal_vaginal_discharge'];
					$vaginal_bleeding = $_GET['vaginal_bleeding'];
					$previous_pregnancy_complications = $_GET['previous_pregnancy_complications'];
					$complications_notes = $_GET['complications_notes'];
					$notes = $_GET['notes'];

					$empty = TRUE;
					if(!$num_weeks_pregnant) {
						$num_weeks_pregnant = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$receiving_prenatal_care) {
						$receiving_prenatal_care = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$taking_prenatal_vitamins) {
						$taking_prenatal_vitamins = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$received_ultrasound) {
						$received_ultrasound = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$num_live_births && $num_live_births != 0) {
						$num_live_births = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$num_miscarriages && $num_miscarriages != 0) {
						$num_miscarriages = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$dysuria_urgency_frequency) {
						$dysuria_urgency_frequency = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$abnormal_vaginal_discharge) {
						$abnormal_vaginal_discharge = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$vaginal_bleeding) {
						$vaginal_bleeding = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$previous_pregnancy_complications) {
						$previous_pregnancy_complications = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$complications_notes) {
						$complications_notes = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$notes) {
						$notes = NULL;
					} else {
						$empty = FALSE;
					}

					if(!$empty) {
						$db->createPregnancyHPI($consult_id, $chief_complaint_id, $num_weeks_pregnant, $receiving_prenatal_care, $taking_prenatal_vitamins, $received_ultrasound, $num_live_births, $num_miscarriages, $dysuria_urgency_frequency, $abnormal_vaginal_discharge, $vaginal_bleeding, $previous_pregnancy_complications, $complications_notes, $notes);
					} else {
						$db->deleteHPI($chief_complaint_id, 2);
					}
				} else {
					$o_pain_how = $_GET['o_pain_how'];
					$o_pain_cause = $_GET['o_pain_cause'];
					$p_pain_provocation = $_GET['p_pain_provocation'];
					$p_pain_palliation = $_GET['p_pain_palliation'];
					$q_pain_type = $_GET['q_pain_type'];
					$r_pain_region_main = $_GET['r_pain_region_main'];
					$r_pain_region_radiates = $_GET['r_pain_region_radiates'];
					$s_pain_level = $_GET['s_pain_level'];
					$t_pain_begin_time = $_GET['t_pain_begin_time'];
					$t_pain_before = $_GET['t_pain_before'];
					$t_pain_current = $_GET['t_pain_current'];
					$notes = $_GET['notes'];

					$empty = TRUE;

					if(!$o_pain_how && $o_pain_how != '0') {
						$o_pain_how = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$o_pain_cause && $o_pain_cause != '0') {
						$o_pain_cause = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$p_pain_provocation && $p_pain_provocation != '0') {
						$p_pain_provocation = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$p_pain_palliation && $p_pain_palliation != '0') {
						$p_pain_palliation = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$q_pain_type && $q_pain_type != '0') {
						$q_pain_type = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$r_pain_region_main && $r_pain_region_main != '0') {
						$r_pain_region_main = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$r_pain_region_radiates && $r_pain_region_radiates != '0') {
						$r_pain_region_radiates = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$s_pain_level && $s_pain_level != '0') {
						$s_pain_level = NULL;
					} else {
						$empty = FALSE;
					}
					if(!$t_pain_begin_time) {
						$t_pain_begin_time = NULL;
					} else {
						$empty = FALSE;
					}
					if ($t_pain_before == 'yes') {
						$t_pain_before = BOOLEAN_TRUE;
						$empty = FALSE;
					} else if ($t_pain_before == 'no') {
						$t_pain_before = BOOLEAN_FALSE;
						$empty = FALSE;
					} else {
						$t_pain_before = NULL;
					}
					if ($t_pain_current == 'yes') {
						$t_pain_current = BOOLEAN_TRUE;
						$empty = FALSE;
					} else if ($t_pain_current == 'no') {
						$t_pain_current = BOOLEAN_FALSE;
						$empty = FALSE;
					} else {
						$t_pain_current = NULL;
					}
					if(!$notes) {
						$notes = NULL;
					} else {
						$empty = FALSE;
					}

					if(!$empty) {
						$db->createHPI($consult_id, $chief_complaint_id, $o_pain_how, $o_pain_cause, $p_pain_provocation, $p_pain_palliation, $q_pain_type, $r_pain_region_main, $r_pain_region_radiates, $s_pain_level, $t_pain_begin_time, $t_pain_before, $t_pain_current, $notes);
					} else {
						$db->deleteHPI($chief_complaint_id, 1);
					}
				}
				header("LOCATION: history_present_illness.php?consult_id=" . $consult_id . "&lang=" . $lang);
			} else {
				header("LOCATION: history_present_illness.php?consult_id=" . $consult_id . "&lang=" . $lang);
			}
		}
	} else {
		header($index_link);
	}

	$editable = true;
	$consult = $db->getConsult($consult_id);
	$patient_id = $consult["patient_id"];

	$patient = $db->getPatientById($patient_id);	

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (" . APPROXIMATE_ABBREVIATION . ")";
	}

	$datetime_started = $consult["datetime_started"];
	$in_progress = true;
	if(isset($consult["datetime_completed"])) {
		$in_progress = false;

		$status = $consult['status'];
		if($status != CONSULT_STATUS_EDIT) {
			$editable = false;
		}
	}

	$formatted_datetime_started = Utilities::reformatDateForDisplay2($datetime_started);

	$display_text = CONSULT . " " . $formatted_datetime_started;
	if($in_progress) {
		$display_text .= " (" . IN_PROGRESS . ")";
	} else {
		$display_text .= " (" . COMPLETED . ")";
	}

	$primary_chief_complaints = NULL;
	$secondary_chief_complaints = NULL;

	if($db->hasPrimaryChiefComplaint($consult_id)) {
		$primary_chief_complaints = $db->getPrimaryChiefComplaints($consult_id);
	} 
	if($db->hasSecondaryChiefComplaint($consult_id)) {
		$secondary_chief_complaints = $db->getSecondaryChiefComplaints($consult_id);
	}
	
?>

<div class="container-fluid">

	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
		</div>
	</div>
	<div class="row consult_link_row">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<p class="content_p consult_section"><?php echo HISTORY_OF_PRESENT_ILLNESS; ?></p>
		</div>
	</div>

	<div id="primary_chief_complaints_row" class="row chief_complaints_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo PRIMARY_CHIEF_COMPLAINTS; ?></p>
			<?php
				if($primary_chief_complaints) {
					echo "<ul class='list-group'>";
					foreach($primary_chief_complaints as $chief_complaint) {
						$id = $chief_complaint['id'];
						$type_is_custom = $chief_complaint['type_is_custom'];
						$type = $chief_complaint['type'];
						$text = $type;

						$is_pregnancy = BOOLEAN_FALSE;
						if($type_is_custom == BOOLEAN_FALSE) {
							$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$type];
							if($value == "pregnancy") {
								$is_pregnancy = BOOLEAN_TRUE;
							}
							$text = DEFAULT_CHIEF_COMPLAINT_LABELS[$type];
						}
						if($is_pregnancy == BOOLEAN_TRUE && $db->hasHPI($id, $is_pregnancy)) {
							$hpi = $db->getPregnancyHPI($id);
							$num_weeks_pregnant = $hpi['num_weeks_pregnant'];
							$receiving_prenatal_care = $hpi['receiving_prenatal_care'];
							$taking_prenatal_vitamins = $hpi['taking_prenatal_vitamins'];
							$received_ultrasound = $hpi['received_ultrasound'];
							$num_live_births = $hpi['num_live_births'];
							$num_miscarriages = $hpi['num_miscarriages'];
							$dysuria_urgency_frequency = $hpi['dysuria_urgency_frequency'];
							$abnormal_vaginal_discharge = $hpi['abnormal_vaginal_discharge'];
							$vaginal_bleeding = $hpi['vaginal_bleeding'];
							$previous_pregnancy_complications = $hpi['previous_pregnancy_complications'];
							$complications_notes = $hpi['complications_notes'];
							$notes = $hpi['notes'];

							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='pregnancyExistingClick($consult_id, $id, \"" . $text . "\", \"" . $num_weeks_pregnant . "\", \"" . $receiving_prenatal_care . "\", \"" . $taking_prenatal_vitamins . "\", \"" . $received_ultrasound . "\", \"" . $num_live_births . "\", \"" . $num_miscarriages . "\", \"" . $dysuria_urgency_frequency . "\", \"" . $abnormal_vaginal_discharge . "\", \"" . $vaginal_bleeding . "\", \"" . $previous_pregnancy_complications . "\", \"" . $complications_notes . "\", \"" . $notes . "\");'>$text<img class='consult_task_completed' src='../images/checkmark'/></li>";
						} else if($is_pregnancy == BOOLEAN_FALSE && $db->hasHPI($id, $is_pregnancy)) {
							$hpi = $db->getHPI($id);
							$o_pain_how = $hpi['o_pain_how'];
							$o_pain_cause = $hpi['o_pain_cause'];
							$p_pain_provocation = $hpi['p_pain_provocation'];
							$p_pain_palliation = $hpi['p_pain_palliation'];
							$q_pain_type = $hpi['q_pain_type'];
							$r_pain_region_main = $hpi['r_pain_region_main'];
							$r_pain_region_radiates = $hpi['r_pain_region_radiates'];
							$s_pain_level = $hpi['s_pain_level'];
							$t_pain_begin_time = $hpi['t_pain_begin_time'];
							$t_pain_before = $hpi['t_pain_before'];
							$t_pain_current = $hpi['t_pain_current'];
							$notes = $hpi['notes'];

							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='chiefComplaintExistingClick($consult_id, $id, \"" . $text . "\", \"" . $o_pain_how . "\", \"" . $o_pain_cause . "\", \"" . $p_pain_provocation . "\", \"" . $p_pain_palliation . "\", \"" . $q_pain_type . "\", \"" . $r_pain_region_main . "\", \"" . $r_pain_region_radiates . "\", \"" . $s_pain_level . "\", \"" . $t_pain_begin_time . "\", \"" . $t_pain_before . "\", \"" . $t_pain_current . "\", \"" . $notes . "\");'>$text<img class='consult_task_completed' src='../images/checkmark'/></li>";
						} else {
							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='chiefComplaintEmptyClick($consult_id, $id, \"" . $text . "\", $is_pregnancy);'>$text</li>";
						}
					}
					echo "</ul>";
				} else {
					echo "<p class='content_p3'>" . NONE . "</p>";
				}
			?>
		</div>
	</div>

	<div id="secondary_chief_complaints_row" class="row chief_complaints_row">
		<div class="col-xs-12">
			<p class="content_p2"><?php echo SECONDARY_CHIEF_COMPLAINTS; ?></p>
			<?php
				if($secondary_chief_complaints) {
					echo "<ul class='list-group'>";
					foreach($secondary_chief_complaints as $chief_complaint) {
						$id = $chief_complaint['id'];
						$type_is_custom = $chief_complaint['type_is_custom'];
						$type = $chief_complaint['type'];
						$text = $type;

						$is_pregnancy = BOOLEAN_FALSE;
						if($type_is_custom == BOOLEAN_FALSE) {
							$value = DEFAULT_CHIEF_COMPLAINT_VALUES[$type];
							if($value == "pregnancy") {
								$is_pregnancy = BOOLEAN_TRUE;
							}
							$text = DEFAULT_CHIEF_COMPLAINT_LABELS[$type];
						}

						if($is_pregnancy == BOOLEAN_TRUE && $db->hasHPI($id, $is_pregnancy)) {
							$hpi = $db->getPregnancyHPI($id);
							$num_weeks_pregnant = $hpi['num_weeks_pregnant'];
							$receiving_prenatal_care = $hpi['receiving_prenatal_care'];
							$taking_prenatal_vitamins = $hpi['taking_prenatal_vitamins'];
							$received_ultrasound = $hpi['received_ultrasound'];
							$num_live_births = $hpi['num_live_births'];
							$num_miscarriages = $hpi['num_miscarriages'];
							$dysuria_urgency_frequency = $hpi['dysuria_urgency_frequency'];
							$abnormal_vaginal_discharge = $hpi['abnormal_vaginal_discharge'];
							$vaginal_bleeding = $hpi['vaginal_bleeding'];
							$previous_pregnancy_complications = $hpi['previous_pregnancy_complications'];
							$complications_notes = $hpi['complications_notes'];
							$notes = $hpi['notes'];

							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='pregnancyExistingClick($consult_id, $id, \"" . $text . "\", \"" . $num_weeks_pregnant . "\", \"" . $receiving_prenatal_care . "\", \"" . $taking_prenatal_vitamins . "\", \"" . $received_ultrasound . "\", \"" . $num_live_births . "\", \"" . $num_miscarriages . "\", \"" . $dysuria_urgency_frequency . "\", \"" . $abnormal_vaginal_discharge . "\", \"" . $vaginal_bleeding . "\", \"" . $previous_pregnancy_complications . "\", \"" . $complications_notes . "\", \"" . $notes . "\");'>$text<img class='consult_task_completed' src='../images/checkmark'/></li>";
						} else if($is_pregnancy == BOOLEAN_FALSE && $db->hasHPI($id, $is_pregnancy)) {
							$hpi = $db->getHPI($id);
							$o_pain_how = $hpi['o_pain_how'];
							$o_pain_cause = $hpi['o_pain_cause'];
							$p_pain_provocation = $hpi['p_pain_provocation'];
							$p_pain_palliation = $hpi['p_pain_palliation'];
							$q_pain_type = $hpi['q_pain_type'];
							$r_pain_region_main = $hpi['r_pain_region_main'];
							$r_pain_region_radiates = $hpi['r_pain_region_radiates'];
							$s_pain_level = $hpi['s_pain_level'];
							$t_pain_begin_time = $hpi['t_pain_begin_time'];
							$t_pain_before = $hpi['t_pain_before'];
							$t_pain_current = $hpi['t_pain_current'];
							$notes = $hpi['notes'];

							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='chiefComplaintExistingClick($consult_id, $id, \"" . $text . "\", \"" . $o_pain_how . "\", \"" . $o_pain_cause . "\", \"" . $p_pain_provocation . "\", \"" . $p_pain_palliation . "\", \"" . $q_pain_type . "\", \"" . $r_pain_region_main . "\", \"" . $r_pain_region_radiates . "\", \"" . $s_pain_level . "\", \"" . $t_pain_begin_time . "\", \"" . $t_pain_before . "\", \"" . $t_pain_current . "\", \"" . $notes . "\");'>$text<img class='consult_task_completed' src='../images/checkmark'/></li>";
						} else {
							echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='chiefComplaintEmptyClick($consult_id, $id, \"" . $text . "\", $is_pregnancy);'>$text</li>";
						}
					}
					echo "</ul>";
				} else {
					echo "<p class='content_p3'>" . NONE . "</p>";
				}
			?>
		</div>
	</div>

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
      	<div id="normal_body">
	    	<div class="input_row">
	    		<p class="input_label"><?php echo HOW_DID_THE_PAIN_BEGIN; ?></p>
	    		<select id="o_pain_how_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(O_PAIN_HOW_ARRAY); $i++) {
	    				$element = O_PAIN_HOW_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='o_pain_how_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo WHAT_CAUSED_THE_PAIN; ?></p>
	    		<select id="o_pain_cause_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(O_PAIN_CAUSE_ARRAY); $i++) {
	    				$element = O_PAIN_CAUSE_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='o_pain_cause_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo WHAT_WORSENS_THE_PAIN; ?></p>
	    		<select id="p_pain_provocation_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(P_PAIN_PROVOCATION_ARRAY); $i++) {
	    				$element = P_PAIN_PROVOCATION_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='p_pain_provocation_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo WHAT_LESSENS_THE_PAIN; ?></p>
	    		<select id="p_pain_palliation_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(P_PAIN_PALLIATION_ARRAY); $i++) {
	    				$element = P_PAIN_PALLIATION_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='p_pain_palliation_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo TYPE_OF_PAIN; ?></p>
	    		<select id="q_pain_type_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(Q_PAIN_TYPE_ARRAY); $i++) {
	    				$element = Q_PAIN_TYPE_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='q_pain_type_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo MAIN_REGION_OF_PAIN; ?></p>
	    		<select id="r_pain_region_main_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(R_PAIN_REGION_ARRAY); $i++) {
	    				$element = R_PAIN_REGION_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='r_pain_region_main_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo REGIONS_WHERE_PAIN_RADIATES; ?>:</p>
	    		<select id="r_pain_region_radiates_select" class="input_field" multiple>
	    		<?php
	    			for($i = 0; $i < sizeof(R_PAIN_REGION_ARRAY); $i++) {
	    				$element = R_PAIN_REGION_ARRAY[$i];
	    				echo "<option value='$i'>$element</option>";
	    			}
	    			echo "<option value='other'>" . OTHER . "</option>"; 
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<input id='r_pain_region_radiates_other' class='no_display input_field' type='text' placeholder='<?php echo OTHER; ?>'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo PAIN_SEVERITY; ?></p>
	    		<input id='s_pain_level' class='input_field' type='number' min='0' max='10'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo HOW_LONG_SINCE_ISSUE_BEGAN; ?></p>
	    		<input id='t_pain_begin_time' class='input_field' type='number' min='1' max='99'>
	    		<select id="t_pain_begin_time_option_select" class="input_field">
	    		<?php
	    			for($i = 0; $i < sizeof(TIME_OPTION_ARRAY); $i++) {
	    				$element = TIME_OPTION_ARRAY[$i];
	    				$value = TIME_OPTION_ARRAY_ABBREVIATIONS[$i];
	    				echo "<option value='$value'>$element</option>";
	    				//ERROR HERE. NEED AN ARRAY THAT IS SAME IN BOTH (CURRENTLY GRABBIG FIRST LETTER WHICH DIFFERS)
	    			}
	    		?>
	    		</select>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo HAS_PATIENT_EXPERIENCED_BEFORE; ?></p>
	    		<input id="t_pain_before_yes" type='radio' name='t_pain_before' value='yes'><label for="t_pain_before_yes"><?php echo YES; ?></label>
				<input id="t_pain_before_no" type='radio' name='t_pain_before' value='no'><label for="t_pain_before_no"><?php echo NO; ?></label>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo DOES_PATIENT_CURRENTLY_HAVE_ISSUE; ?></p>
	    		<input id="t_pain_current_yes" type='radio' name='t_pain_current' value='yes'><label for="t_pain_current_yes"><?php echo YES; ?></label>
				<input id="t_pain_current_no" type='radio' name='t_pain_current' value='no'><label for="t_pain_current_no"><?php echo NO; ?></label>
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo NOTES . ": "; ?></p>
	        	<textarea id='notes_input' class='input_field'></textarea>
	        </div>
	       </div>
	       <div id="pregnancy_body">
	       	<div class="input_row">
	    		<p class="input_label"><?php echo HOW_MANY_WEEKS_PREGNANT; ?></p>
	    		<input id='num_weeks_pregnant_input' class='input_field' type='number' min='0' max='50'>
	    	</div>
	       	<div class="input_row">
	    		<p class="input_label"><?php echo RECEIVING_PRENATAL_CARE; ?></p>
	    		<form id="receiving_prenatal_care_radiogroup" class="input_field">
		    		<input id='receiving_prenatal_care_yes' type='radio' name='receiving_prenatal_care' value='yes'><label for='receiving_prenatal_care_yes'><?php echo YES; ?></label>
					<input id='receiving_prenatal_care_no' type='radio' name='receiving_prenatal_care' value='no'><label for='receiving_prenatal_care_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo TAKING_PRENATAL_VITAMINS; ?></p>
	    		<form id="taking_prenatal_vitamins_radiogroup" class="input_field">
		    		<input id='taking_prenatal_vitamins_yes' type='radio' name='taking_prenatal_vitamins' value='yes'><label for='taking_prenatal_vitamins_yes'><?php echo YES; ?></label>
					<input id='taking_prenatal_vitamins_no' type='radio' name='taking_prenatal_vitamins' value='no'><label for='taking_prenatal_vitamins_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo RECEIVED_ULTRASOUND; ?></p>
	    		<form id="received_ultrasound_radiogroup" class="input_field">
		    		<input id='received_ultrasound_yes' type='radio' name='received_ultrasound' value='yes'><label for='received_ultrasound_yes'><?php echo YES; ?></label>
					<input id='received_ultrasound_no' type='radio' name='received_ultrasound' value='no'><label for='received_ultrasound_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo HOW_MANY_LIVE_BIRTHS; ?></p>
	    		<input id='num_live_births_input' class='input_field' type='number' min='0' max='50'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo HOW_MANY_MISCARRIAGES; ?></p>
	    		<input id='num_miscarriages_input' class='input_field' type='number' min='0' max='50'>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo ANY_DYSURIA_URGENCY_OR_FREQUENCY; ?></p>
	    		<form id="any_dysuria_urgency_or_frequency_radiogroup" class="input_field">
		    		<input id='any_dysuria_urgency_or_frequency_yes' type='radio' name='any_dysuria_urgency_or_frequency' value='yes'><label for='any_dysuria_urgency_or_frequency_yes'><?php echo YES; ?></label>
					<input id='any_dysuria_urgency_or_frequency_no' type='radio' name='any_dysuria_urgency_or_frequency' value='no'><label for='any_dysuria_urgency_or_frequency_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo ANY_ABNORMAL_VAGINAL_DISCHARGE; ?></p>
	    		<form id="any_abnormal_vaginal_discharge_radiogroup" class="input_field">
		    		<input id='any_abnormal_vaginal_discharge_yes' type='radio' name='any_abnormal_vaginal_discharge' value='yes'><label for='any_abnormal_vaginal_discharge_yes'><?php echo YES; ?></label>
					<input id='any_abnormal_vaginal_discharge_no' type='radio' name='any_abnormal_vaginal_discharge' value='no'><label for='any_abnormal_vaginal_discharge_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo ANY_VAGINAL_BLEEDING; ?></p>
	    		<form id="any_vaginal_bleeding_radiogroup" class="input_field">
		    		<input id='any_vaginal_bleeding_yes' type='radio' name='any_vaginal_bleeding' value='yes'><label for='any_vaginal_bleeding_yes'><?php echo YES; ?></label>
					<input id='any_vaginal_bleeding_no' type='radio' name='any_vaginal_bleeding' value='no'><label for='any_vaginal_bleeding_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo ANY_PREVIOUS_PREGNANCY_COMPLICATIONS; ?></p>
	    		<form id="any_previous_pregnancy_complications_radiogroup" class="input_field">
		    		<input id='any_previous_pregnancy_complications_yes' type='radio' name='any_previous_pregnancy_complications' value='yes'><label for='any_previous_pregnancy_complications_yes'><?php echo YES; ?></label>
					<input id='any_previous_pregnancy_complications_no' type='radio' name='any_previous_pregnancy_complications' value='no'><label for='any_previous_pregnancy_complications_no'><?php echo NO; ?></label>
				</form>
	    	</div>
	    	<div id="further_explanation_row" class="input_row no_display">
	    		<p class="input_label"><?php echo FURTHER_EXPLANATION; ?></p>
	    		<textarea id='further_explanation_input' class='input_field'></textarea>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo NOTES . ":"; ?></p>
	    		<textarea id='pregnancy_notes_input' class='input_field'></textarea>
	    	</div>

	       </div>
      </div>
      <div class="modal-footer">
      	<?php
      		if($editable) {
      	?>
      	<button id="delete_button" type="button" class="btn btn-default" data-dismiss="modal"><?php echo DELETE; ?></button>
        <button id="save_button" type="button" class="btn btn-default"><?php echo SAVE; ?></button>

        <?php
        	}
        ?>
      </div>
    </div>

  </div>
</div>


	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 2"; ?>);"><?php echo CONTINUE_WORD; ?></button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 1"; ?>);"><?php echo GO_BACK; ?></button>
		</div>
	</div>

</div>


<script type="text/javascript">

$("#o_pain_how_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#o_pain_how_other").show();
	} else {
		$("#o_pain_how_other").hide();
	}
});

$("#o_pain_cause_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#o_pain_cause_other").show();
	} else {
		$("#o_pain_cause_other").hide();
	}
});

$("#p_pain_provocation_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#p_pain_provocation_other").show();
	} else {
		$("#p_pain_provocation_other").hide();
	}
});

$("#p_pain_palliation_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#p_pain_palliation_other").show();
	} else {
		$("#p_pain_palliation_other").hide();
	}
});

$("#q_pain_type_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#q_pain_type_other").show();
	} else {
		$("#q_pain_type_other").hide();
	}
});

$("#r_pain_region_main_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#r_pain_region_main_other").show();
	} else {
		$("#r_pain_region_main_other").hide();
	}
});

$("#r_pain_region_radiates_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == "other";
	}

	if (other_selected)  {
		$("#r_pain_region_radiates_other").show();
	} else {
		$("#r_pain_region_radiates_other").hide();
	}
});

$("input[name=any_previous_pregnancy_complications]").change(function() {
	var value = $("input[name=any_previous_pregnancy_complications]:checked").val();
	if (value == "yes") {
		$('#further_explanation_row').show();
	} else if (value == "no") {
		$('#further_explanation_row').hide();
	} else {
		$('#further_explanation_row').hide();
	}
});

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

function pregnancyExistingClick(consult_id, chief_complaint_id, text, num_weeks_pregnant, receiving_prenatal_care, taking_prenatal_vitamins, received_ultrasound, num_live_births, num_miscarriages, dysuria_urgency_frequency, abnormal_vaginal_discharge, vaginal_bleeding, previous_pregnancy_complications, complications_notes, notes) {
	$("#modal_header").html(text);
	$("#normal_body").hide();
	$("#pregnancy_body").show();
	$("#save_button").unbind();
	$("#save_button").click(function() { 
		saveFunction(consult_id, chief_complaint_id, 2);
	});
	$("#delete_button").show();
	$("#delete_button").click(function() {
		deleteFunction(consult_id, chief_complaint_id, 2);
	});

	$("#num_weeks_pregnant_input").val(num_weeks_pregnant);

	if(receiving_prenatal_care) {
		if(receiving_prenatal_care == '2') {
			$("input[name='receiving_prenatal_care'][value='yes']").prop("checked", true);
		} else {
			$("input[name='receiving_prenatal_care'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='receiving_prenatal_care'][value='yes']").prop("checked", false);
		$("input[name='receiving_prenatal_care'][value='no']").prop("checked", false);
	}
	if(taking_prenatal_vitamins) {
		if(taking_prenatal_vitamins == '2') {
			$("input[name='taking_prenatal_vitamins'][value='yes']").prop("checked", true);
		} else {
			$("input[name='taking_prenatal_vitamins'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='taking_prenatal_vitamins'][value='yes']").prop("checked", false);
		$("input[name='taking_prenatal_vitamins'][value='no']").prop("checked", false);
	}
	if(received_ultrasound) {
		if(received_ultrasound == '2') {
			$("input[name='received_ultrasound'][value='yes']").prop("checked", true);
		} else {
			$("input[name='received_ultrasound'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='received_ultrasound'][value='yes']").prop("checked", false);
		$("input[name='received_ultrasound'][value='no']").prop("checked", false);
	}
	$("#num_live_births_input").val(num_live_births);
	$("#num_miscarriages_input").val(num_miscarriages);
	if(dysuria_urgency_frequency) {
		if(dysuria_urgency_frequency == '2') {
			$("input[name='any_dysuria_urgency_or_frequency'][value='yes']").prop("checked", true);
		} else {
			$("input[name='any_dysuria_urgency_or_frequency'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='any_dysuria_urgency_or_frequency'][value='yes']").prop("checked", false);
		$("input[name='any_dysuria_urgency_or_frequency'][value='no']").prop("checked", false);
	}
	if(abnormal_vaginal_discharge) {
		if(abnormal_vaginal_discharge == '2') {
			$("input[name='any_abnormal_vaginal_discharge'][value='yes']").prop("checked", true);
		} else {
			$("input[name='any_abnormal_vaginal_discharge'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='any_abnormal_vaginal_discharge'][value='yes']").prop("checked", false);
		$("input[name='any_abnormal_vaginal_discharge'][value='no']").prop("checked", false);
	}
	if(vaginal_bleeding) {
		if(vaginal_bleeding == '2') {
			$("input[name='any_vaginal_bleeding'][value='yes']").prop("checked", true);
		} else {
			$("input[name='any_vaginal_bleeding'][value='no']").prop("checked", true);
		}
	} else {
		$("input[name='any_vaginal_bleeding'][value='yes']").prop("checked", false);
		$("input[name='any_vaginal_bleeding'][value='no']").prop("checked", false);
	}
	if(previous_pregnancy_complications) {
		if(previous_pregnancy_complications == '2') {
			$("input[name='any_previous_pregnancy_complications'][value='yes']").prop("checked", true);
			$("#further_explanation_row").show();
			$("#further_explanation_input").val(complication_notes);
		} else {
			$("input[name='any_previous_pregnancy_complications'][value='no']").prop("checked", true);
			$("#further_explanation_input").val("");
		}
	} else {
		$("input[name='any_previous_pregnancy_complications'][value='yes']").prop("checked", false);
		$("input[name='any_previous_pregnancy_complications'][value='no']").prop("checked", false);
		$("#further_explanation_input").val("");
	}
	$("#pregnancy_notes_input").val(notes);
}

function chiefComplaintExistingClick(consult_id, chief_complaint_id, text, o_pain_how, o_pain_cause, p_pain_provocation, p_pain_palliation, q_pain_type, r_pain_region_main, r_pain_region_radiates, s_pain_level, t_pain_begin_time, t_pain_before, t_pain_current, notes) {
	$("#modal_header").html(text);
	$("#normal_body").show();
	$("#pregnancy_body").hide();
	$("#save_button").unbind();
	$("#save_button").click(function() { 
		saveFunction(consult_id, chief_complaint_id, 1);
	});
	$("#delete_button").show();
	$("#delete_button").click(function() {
		deleteFunction(consult_id, chief_complaint_id, 1);
	});

	if(o_pain_how) {
		var o_pain_how_array = o_pain_how.split(",");
		var o_pain_how_select_array = o_pain_how.split(",");
		for (var i = 0; i < o_pain_how_array.length; i++) {
			var element = o_pain_how_array[i];
			if(!isInt(element)) {
				o_pain_how_select_array.splice(i);
				o_pain_how_select_array.push('other');
				o_pain_how_array.splice(0, i);
				$("#o_pain_how_other").show();
				$("#o_pain_how_other").val(o_pain_how_array);
				break;
			}
		}
		$("#o_pain_how_select").val(o_pain_how_select_array);
	} else {
		$("#o_pain_how_select").val("");
	}

	if(o_pain_cause) {
		var o_pain_cause_array = o_pain_cause.split(",");
		var o_pain_cause_select_array = o_pain_cause.split(",");
		for (var i = 0; i < o_pain_cause_array.length; i++) {
			var element = o_pain_cause_array[i];
			if(!isInt(element)) {
				o_pain_cause_select_array.splice(i);
				o_pain_cause_select_array.push('other');
				o_pain_cause_array.splice(0, i);
				$("#o_pain_cause_other").show();
				$("#o_pain_cause_other").val(o_pain_cause_array);
				break;
			}
		}
		$("#o_pain_cause_select").val(o_pain_cause_select_array);
	} else {
		$("#o_pain_cause_select").val("");
	}

	if(p_pain_provocation) {
		var p_pain_provocation_array = p_pain_provocation.split(",");
		var p_pain_provocation_select_array = p_pain_provocation.split(",");
		for (var i = 0; i < p_pain_provocation_array.length; i++) {
			var element = p_pain_provocation_array[i];
			if(!isInt(element)) {
				p_pain_provocation_select_array.splice(i);
				p_pain_provocation_select_array.push('other');
				p_pain_provocation_array.splice(0, i);
				$("#p_pain_provocation_other").show();
				$("#p_pain_provocation_other").val(p_pain_provocation_array);
				break;
			}
		}
		$("#p_pain_provocation_select").val(p_pain_provocation_select_array);
	} else {
		$("#p_pain_provocation_select").val("");
	}

	if(p_pain_palliation) {
		var p_pain_palliation_array = p_pain_palliation.split(",");
		var p_pain_palliation_select_array = p_pain_palliation.split(",");
		for (var i = 0; i < p_pain_palliation_array.length; i++) {
			var element = p_pain_palliation_array[i];
			if(!isInt(element)) {
				p_pain_palliation_select_array.splice(i);
				p_pain_palliation_select_array.push('other');
				p_pain_palliation_array.splice(0, i);
				$("#p_pain_palliation_other").show();
				$("#p_pain_palliation_other").val(p_pain_palliation_array);
				break;
			}
		}
		$("#p_pain_palliation_select").val(p_pain_palliation_select_array);
	} else {
		$("#p_pain_palliation_select").val("");
	}

	if(q_pain_type) {
		var q_pain_type_array = q_pain_type.split(",");
		var q_pain_type_select_array = q_pain_type.split(",");
		for (var i = 0; i < q_pain_type_array.length; i++) {
			var element = q_pain_type_array[i];
			if(!isInt(element)) {
				q_pain_type_select_array.splice(i);
				q_pain_type_select_array.push('other');
				q_pain_type_array.splice(0, i);
				$("#q_pain_type_other").show();
				$("#q_pain_type_other").val(q_pain_type_array);
				break;
			}
		}
		$("#q_pain_type_select").val(q_pain_type_select_array);
	} else {
		$("#q_pain_type_select").val("");
	}

	if(r_pain_region_main) {
		var r_pain_region_main_array = r_pain_region_main.split(",");
		var r_pain_region_main_select_array = r_pain_region_main.split(",");
		for (var i = 0; i < r_pain_region_main_array.length; i++) {
			var element = r_pain_region_main_array[i];
			if(!isInt(element)) {
				r_pain_region_main_select_array.splice(i);
				r_pain_region_main_select_array.push('other');
				r_pain_region_main_array.splice(0, i);
				$("#r_pain_region_main_other").show();
				$("#r_pain_region_main_other").val(r_pain_region_main_array);
				break;
			}
		}
		$("#r_pain_region_main_select").val(r_pain_region_main_select_array);
	} else {
		$("#r_pain_region_main_select").val("");
	}

	if(r_pain_region_radiates) {
		var r_pain_region_radiates_array = r_pain_region_radiates.split(",");
		var r_pain_region_radiates_select_array = r_pain_region_radiates.split(",");
		for (var i = 0; i < r_pain_region_radiates_array.length; i++) {
			var element = r_pain_region_radiates_array[i];
			if(!isInt(element)) {
				r_pain_region_radiates_select_array.splice(i);
				r_pain_region_radiates_select_array.push('other');
				r_pain_region_radiates_array.splice(0, i);
				$("#r_pain_region_radiates_other").show();
				$("#r_pain_region_radiates_other").val(r_pain_region_radiates_array);
				break;
			}
		}
		$("#r_pain_region_radiates_select").val(r_pain_region_radiates_select_array);
	} else {
		$("#r_pain_region_radiates_select").val("");
	}

	$("#s_pain_level").val(s_pain_level);

	//ERROR HERE
	if(t_pain_begin_time) {
		var length = t_pain_begin_time.length;
		var value_part = t_pain_begin_time.substring(0, length - 1);
		var option_part = t_pain_begin_time.substring(length - 1);
		if(isInt(value_part)) {
			$("#t_pain_begin_time").val(value_part);
			$("#t_pain_begin_time_option_select").val(option_part);
		}
	} else {
		$("#t_pain_begin_time").val("");
		$("#t_pain_begin_time_option_select").val("");
	}

	if(t_pain_before) {
		if(isInt(t_pain_before)) {
			if(t_pain_before == '2') {
				$("input[name='t_pain_before'][value='yes']").prop("checked", true);
			} else if (t_pain_before == '1') {
				$("input[name='t_pain_before'][value='no']").prop("checked", true);
			}
		}
	} else {
		$("input[name='t_pain_before'][value='yes']").prop("checked", false);
		$("input[name='t_pain_before'][value='no']").prop("checked", false);
	}

	if(t_pain_current) {
		if(isInt(t_pain_current)) {
			if(t_pain_current == '2') {
				$("input[name='t_pain_current'][value='yes']").prop("checked", true);
			} else if (t_pain_current == '1') {
				$("input[name='t_pain_current'][value='no']").prop("checked", true);
			}
		}
	} else {
		$("input[name='t_pain_current'][value='yes']").prop("checked", false);
		$("input[name='t_pain_current'][value='no']").prop("checked", false);
	}

	$("#notes_input").val(notes);
}

function chiefComplaintEmptyClick(consult_id, chief_complaint_id, text, is_pregnancy) {
	$("#modal_header").html(text);
	if(is_pregnancy == 2) {
		$("#normal_body").hide();
		$("#pregnancy_body").show();

		$("#num_weeks_pregnant_input").val("");
		$("input[name='receiving_prenatal_care'][value='yes']").prop("checked", false);
		$("input[name='receiving_prenatal_care'][value='no']").prop("checked", false);
		$("input[name='taking_prenatal_vitamins'][value='yes']").prop("checked", false);
		$("input[name='taking_prenatal_vitamins'][value='no']").prop("checked", false);
		$("input[name='received_ultrasound'][value='yes']").prop("checked", false);
		$("input[name='received_ultrasound'][value='no']").prop("checked", false);
		$("#num_live_births_input").val("");
		$("#num_miscarriages_input").val("");
		$("input[name='any_dysuria_urgency_frequency'][value='yes']").prop("checked", false);
		$("input[name='any_dysuria_urgency_frequency'][value='no']").prop("checked", false);
		$("input[name='any_abnormal_vaginal_discharge'][value='yes']").prop("checked", false);
		$("input[name='any_abnormal_vaginal_discharge'][value='no']").prop("checked", false);
		$("input[name='vaginal_bleeding'][value='yes']").prop("checked", false);
		$("input[name='vaginal_bleeding'][value='no']").prop("checked", false);
		$("input[name='any_previous_pregnancy_complications'][value='yes']").prop("checked", false);
		$("input[name='any_previous_pregnancy_complications'][value='no']").prop("checked", false);
		$("#further_explanation_input").val("");
		$("#pregnancy_notes_input").val("");
	} else {
		$("#normal_body").show();
		$("#pregnancy_body").hide();

		$("#o_pain_how_select").val("");
		$("#o_pain_cause_select").val("");	
		$("#p_pain_provocation_select").val("");
		$("#p_pain_palliation_select").val("");
		$("#q_pain_type_select").val("");
		$("#r_pain_region_main_select").val("");
		$("#r_pain_region_radiates_select").val("");
		$("#s_pain_level").val("");
		$("#t_pain_begin_time").val("");
		$("#t_pain_begin_time_option_select").val("");
		$("input[name='t_pain_before'][value='yes']").prop("checked", false);
		$("input[name='t_pain_before'][value='no']").prop("checked", false);
		$("input[name='t_pain_current'][value='yes']").prop("checked", false);
		$("input[name='t_pain_current'][value='no']").prop("checked", false);
		$("#notes_input").val("");
	}
	$("#save_button").unbind();
	$("#save_button").click(function() { 
		saveFunction(consult_id, chief_complaint_id, is_pregnancy);
	});
	$("#delete_button").hide();
}

function deleteFunction(consult_id, chief_complaint_id, is_pregnancy) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_present_illness.php?consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&delete=2" + extra_text + "&is_pregnancy=" + is_pregnancy; 
}

function saveFunction(consult_id, chief_complaint_id, is_pregnancy) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var alert_triggered = false; 
	if(is_pregnancy == 2) {
		var num_weeks_pregnant = $("#num_weeks_pregnant_input").val();
		var receiving_prenatal_care = $("input[name=receiving_prenatal_care]:checked").val();
		if(receiving_prenatal_care) {
			if(receiving_prenatal_care == "yes") {
				receiving_prenatal_care = 2;
			} else if (receiving_prenatal_care == "no") {
				receiving_prenatal_care = 1;
			} else {
				receiving_prenatal_care = "";
			}
		} else {
			receiving_prenatal_care = "";
		} 
		var taking_prenatal_vitamins = $("input[name=taking_prenatal_vitamins]:checked").val();
		if(taking_prenatal_vitamins) {
			if(taking_prenatal_vitamins == "yes") {
				taking_prenatal_vitamins = 2;
			} else if (taking_prenatal_vitamins == "no") {
				taking_prenatal_vitamins = 1;
			} else {
				taking_prenatal_vitamins = "";
			}
		} else {
			taking_prenatal_vitamins = "";
		} 
		var received_ultrasound = $("input[name=received_ultrasound]:checked").val();
		if(received_ultrasound) {
			if(received_ultrasound == "yes") {
				received_ultrasound = 2;
			} else if (received_ultrasound == "no") {
				received_ultrasound = 1;
			} else {
				received_ultrasound = "";
			}
		} else {
			received_ultrasound = "";
		} 
		var num_live_births = $("#num_live_births_input").val();
		var num_miscarriages = $("#num_miscarriages_input").val();
		var any_dysuria_urgency_frequency = $("input[name=any_dysuria_urgency_or_frequency]:checked").val();
		if(any_dysuria_urgency_frequency) {
			if(any_dysuria_urgency_frequency == "yes") {
				any_dysuria_urgency_frequency = 2;
			} else if (any_dysuria_urgency_frequency == "no") {
				any_dysuria_urgency_frequency = 1;
			} else {
				any_dysuria_urgency_frequency = "";
			}
		} else {
			any_dysuria_urgency_frequency = "";
		} 
		var any_abnormal_vaginal_discharge = $("input[name=any_abnormal_vaginal_discharge]:checked").val();
		if(any_abnormal_vaginal_discharge) {
			if(any_abnormal_vaginal_discharge == "yes") {
				any_abnormal_vaginal_discharge = 2;
			} else if (any_abnormal_vaginal_discharge == "no") {
				any_abnormal_vaginal_discharge = 1;
			} else {
				any_abnormal_vaginal_discharge = "";
			}
		} else {
			any_abnormal_vaginal_discharge = "";
		} 
		var any_vaginal_bleeding = $("input[name=any_vaginal_bleeding]:checked").val();
		if(any_vaginal_bleeding) {
			if(any_vaginal_bleeding == "yes") {
				any_vaginal_bleeding = 2;
			} else if (any_vaginal_bleeding == "no") {
				any_vaginal_bleeding = 1;
			} else {
				any_vaginal_bleeding = "";
			}
		} else {
			any_vaginal_bleeding = "";
		} 
		var complications_notes = "";
		var any_previous_pregnancy_complications = $("input[name=any_previous_pregnancy_complications]:checked").val();
		if(any_previous_pregnancy_complications) {
			if(any_previous_pregnancy_complications == "yes") {
				any_previous_pregnancy_complications = 2;
				complications_notes = $("#further_explanation_input").val();
				if(!complication_notes) {
					alert_triggered = true;
					var alert_text = "ERROR. MUST PROVIDE FURTHER EXPLANATION";
					if(lang == "es") {
						alert_text = "ERROR. NECESITA LLENAR EXPLICACION ADICIONAL";
					}	
					alert(alert_text);
				}
			} else if (any_previous_pregnancy_complications == "no") {
				any_previous_pregnancy_complications = 1;
			} else {
				any_previous_pregnancy_complications = "";
			}
		} else {
			any_previous_pregnancy_complications = "";
		} 
		var notes = $("#notes_input").val();

		if(!alert_triggered) {
			window.location.href = "history_present_illness.php?consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&is_pregnancy=" + is_pregnancy + "&num_weeks_pregnant=" + num_weeks_pregnant + "&receiving_prenatal_care=" + receiving_prenatal_care + "&taking_prenatal_vitamins=" + taking_prenatal_vitamins + "&received_ultrasound=" + received_ultrasound + "&num_live_births=" + num_live_births + "&num_miscarriages=" + num_miscarriages + "&dysuria_urgency_frequency=" + any_dysuria_urgency_frequency + "&abnormal_vaginal_discharge=" + any_abnormal_vaginal_discharge + "&vaginal_bleeding=" + any_vaginal_bleeding + "&previous_pregnancy_complications=" + any_previous_pregnancy_complications + "&complications_notes=" + complications_notes + "&notes=" + notes + extra_text; 
		}

	} else {
		var invalid_number_input = false;
		var pain_scale_out_of_range = false;
		var time_input_out_of_range = false;
		var invalid_time_option_select = false;

		var o_pain_how_text = "";
		var o_pain_cause_text = "";
		var p_pain_provocation_text = "";
		var p_pain_palliation_text = "";
		var q_pain_type_text = "";
		var r_pain_region_main_text = "";
		var r_pain_region_radiates_text = "";
		var s_pain_level_text = "";
		var t_pain_begin_time_text = "";
		var t_pain_before_text = "";
		var t_pain_current_text = "";
		var notes_text = "";

		var o_pain_how_select_array = $("#o_pain_how_select").val();
		var o_pain_how_length = o_pain_how_select_array.length;
		if(o_pain_how_length > 0 && o_pain_how_select_array[o_pain_how_length - 1] == "other") {
			o_pain_how_select_array.splice(o_pain_how_length - 1, 1);
			var custom_input = $("#o_pain_how_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				o_pain_how_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		o_pain_how_text = o_pain_how_select_array.toString();

		var o_pain_cause_select_array = $("#o_pain_cause_select").val();
		var o_pain_cause_length = o_pain_cause_select_array.length;
		if(o_pain_cause_length > 0 && o_pain_cause_select_array[o_pain_cause_length - 1] == "other") {
			o_pain_cause_select_array.splice(o_pain_cause_length - 1, 1);
			var custom_input = $("#o_pain_cause_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				o_pain_cause_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		o_pain_cause_text = o_pain_cause_select_array.toString();

		var p_pain_provocation_select_array = $("#p_pain_provocation_select").val();
		var p_pain_provocation_length = p_pain_provocation_select_array.length;
		if(p_pain_provocation_length > 0 && p_pain_provocation_select_array[p_pain_provocation_length - 1] == "other") {
			p_pain_provocation_select_array.splice(p_pain_provocation_length - 1, 1);
			var custom_input = $("#p_pain_provocation_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
				}
				p_pain_provocation_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		p_pain_provocation_text = p_pain_provocation_select_array.toString();

		var p_pain_palliation_select_array = $("#p_pain_palliation_select").val();
		var p_pain_palliation_length = p_pain_palliation_select_array.length;
		if(p_pain_palliation_length > 0 && p_pain_palliation_select_array[p_pain_palliation_length - 1] == "other") {
			p_pain_palliation_select_array.splice(p_pain_palliation_length - 1, 1);
			var custom_input = $("#p_pain_palliation_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				p_pain_palliation_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		p_pain_palliation_text = p_pain_palliation_select_array.toString();

		var q_pain_type_select_array = $("#q_pain_type_select").val();
		var q_pain_type_length = q_pain_type_select_array.length;
		if(q_pain_type_length > 0 && q_pain_type_select_array[q_pain_type_length - 1] == "other") {
			q_pain_type_select_array.splice(q_pain_type_length - 1, 1);
			var custom_input = $("#q_pain_type_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				q_pain_type_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		q_pain_type_text = q_pain_type_select_array.toString();

		var r_pain_region_main_select_array = $("#r_pain_region_main_select").val();
		var r_pain_region_main_length = r_pain_region_main_select_array.length;
		if(r_pain_region_main_length > 0 && r_pain_region_main_select_array[r_pain_region_main_length - 1] == "other") {
			r_pain_region_main_select_array.splice(r_pain_region_main_length - 1, 1);
			var custom_input = $("#r_pain_region_main_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				r_pain_region_main_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		r_pain_region_main_text = r_pain_region_main_select_array.toString();

		var r_pain_region_radiates_select_array = $("#r_pain_region_radiates_select").val();
		var r_pain_region_radiates_length = r_pain_region_radiates_select_array.length;
		if(r_pain_region_radiates_length > 0 && r_pain_region_radiates_select_array[r_pain_region_radiates_length - 1] == "other") {
			r_pain_region_radiates_select_array.splice(r_pain_region_radiates_length - 1, 1);
			var custom_input = $("#r_pain_region_radiates_other").val();
			if(custom_input) {
				if(isInt(custom_input)) {
					alert_triggered = true;
					invalid_number_input = true;
				}
				r_pain_region_radiates_select_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
		r_pain_region_radiates_text = r_pain_region_radiates_select_array.toString();

		s_pain_level_text = $("#s_pain_level").val();
		if(s_pain_level_text && (s_pain_level_text < 0 || s_pain_level_text > 10)) {
			alert_triggered = true;
			pain_scale_out_of_range = true;
		} 

		t_pain_begin_time_text = $("#t_pain_begin_time").val();
		if(t_pain_begin_time_text && (t_pain_begin_time_text < 1 || t_pain_begin_time_text > 99)) {
			alert_triggered = true;
			time_input_out_of_range = true;
		} else if (t_pain_begin_time_text) {
			var t_pain_begin_time_option_select = $("#t_pain_begin_time_option_select").val();
			if(t_pain_begin_time_option_select) {
				t_pain_begin_time_text += t_pain_begin_time_option_select;
			} else {
				alert_triggered = true;
				invalid_time_option_select = true;
			}
		}
		t_pain_before_text = $("input[name=t_pain_before]:checked").val();
		if(!t_pain_before_text) {
			t_pain_before_text = "";
		}
		t_pain_current_text = $("input[name=t_pain_current]:checked").val();
		if(!t_pain_current_text) {
			t_pain_current_text = "";
		}
		notes_text = $("#notes_input").val();

		if(alert_triggered) {
			var alert_text = "ERROR";
			if(invalid_number_input) {
				alert_text = "ERROR: INVALID NUMBER INPUT";
				if(lang == "es") {
					alert_text = "ERROR: ENTRADA DE NÚMERO INVÁLIDO";
				}
			} else if (pain_scale_out_of_range) {
				alert_text = "ERROR: PAIN SCALE OUT OF RANGE";
				if(lang == "es") {
					alert_text = "ERROR: ESCALE DE DOLOR FUERA DE RANGO";
				}
			} else if (time_input_out_of_range) {
				alert_text = "ERROR: TIME INPUT OUT OF RANGE";
				if(lang == "es") {
					alert_text = "ERROR: CAMPO DE TIEMPO FUERA DE RANGO";
				}
			} else if (invalid_time_option_select) {
				alert_text = "ERROR: INVALID TIME OPTION SELECT";
				if(lang == "es") {
					alert_text = "ERROR: ENTRADA DE TIEMPO INVÁLIDO";
				}
			} 
			alert(alert_text);
		}


		if(!alert_triggered) {
			window.location.href = "history_present_illness.php?consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&o_pain_how=" + o_pain_how_text + "&o_pain_cause=" + o_pain_cause_text + "&p_pain_provocation=" + p_pain_provocation_text + "&p_pain_palliation=" + p_pain_palliation_text + "&q_pain_type=" + q_pain_type_text + "&r_pain_region_main=" + r_pain_region_main_text + "&r_pain_region_radiates=" + r_pain_region_radiates_text + "&s_pain_level=" + s_pain_level_text + "&t_pain_begin_time=" + t_pain_begin_time_text + "&t_pain_before=" + t_pain_before_text + "&t_pain_current=" + t_pain_current_text + "&notes=" + notes_text + "&is_pregnancy=" + is_pregnancy + extra_text; 
		}
	}
}

//action == 0: stay
//action == 1: back
//action == 2: next
function save(consult_id, action) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}

	if(action == 2) {
		window.location.href = "measurements.php?consult_id=" + consult_id + extra_text;
	} else if(action == 1) {
		window.location.href = "chief_complaints.php?consult_id=" + consult_id + extra_text;
	} else {

	}

}

function replaceAll(str, find, replace) {
	return str.replace(new RegExp(find, 'g'), replace);
}

function isInt(value) {
  var x;
  if (isNaN(value)) {
    return false;
  }
  x = parseFloat(value);
  return (x | 0) === x;
}



</script>

