<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';


	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$patient_id = INVALID_VALUE;
	if(isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];
	} 

	if(isset($_GET['save'])) {
		$save = $_GET['save'];
		if($save == 2) {
			if(isset($_GET['allergy_id'])) {
				$allergy_id = $_GET['allergy_id'];
				if(!$allergy_id) {
					$allergy_id = -1;
				}
					$name = $_GET['name'];
				if(!$name) {
					$name = NULL;
				}

				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				}

				$datetime = Utilities::getCurrentDateTime();

				$db->createNewHistoryAllergy($patient_id, $allergy_id, $name, $notes, $datetime);
			} else if (isset($_GET['illness_id'])) {
				$illness_id = $_GET['illness_id'];
				if(!$illness_id) {
					$illness_id = -1;
				}
				$is_chronic = $_GET['is_chronic'];
				if(!$is_chronic) {
					$is_chronic = NULL;
				}
				$type = $_GET['type'];
				if(!$type) {
					$type = NULL;
				}
				$other = $_GET['other'];
				if(!$other) {
					$other = NULL;
				}
				$start_date = $_GET['start_date'];
				if(!$start_date) {
					$start_date = NULL;
				}
				$end_date = $_GET['end_date'];
				if(!$end_date) {
					$end_date = NULL;
				}
				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				}
				$datetime = Utilities::getCurrentDateTime();

				$val = $db->createNewHistoryIllness($patient_id, $illness_id, $is_chronic, $type, $other, $start_date, $end_date, $notes, $datetime);

			} else if (isset($_GET['surgery_id'])) {
				$surgery_id = $_GET['surgery_id'];
				if(!$surgery_id) {
					$surgery_id = -1;
				}
				$is_name_custom = $_GET['is_name_custom'];
				$name = $_GET['name'];
				$date = $_GET['date'];
				if(!$date) {
					$date = NULL;
				}
				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				}
				$datetime = Utilities::getCurrentDateTime();

				$db->createNewHistorySurgery($patient_id, $surgery_id, $is_name_custom, $name, $date, $notes, $datetime);
			} else if (isset($_GET['medication_id'])) {
				$medication_id = $_GET['medication_id'];
				if(!$medication_id) {
					$medication_id = -1;
				}
				$name = $_GET['name'];
				if(!$name) {
					$name = NULL;
				}

				$start_date = $_GET['start_date'];
				if(!$start_date) {
					$start_date = NULL;
				}
				$end_date = $_GET['end_date'];
				if(!$end_date) {
					$end_date = NULL;
				}
				$source = 1; //FIGURE THIS OUT

				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				}
				$datetime = Utilities::getCurrentDateTime();

				$db->createNewHistoryMedication($patient_id, NULL, $medication_id, $name, $start_date, $end_date, $source, $notes, $datetime);
			}
			header("LOCATION: history.php?patient_id=" . $patient_id . "&mode=" . $mode . "&lang=" . $lang);
		}
	} else if (isset($_GET['delete'])) {
		$delete = $_GET['delete'];
		if($delete == 2) {
			if(isset($_GET['allergy_id'])) {
				$allergy_id = $_GET['allergy_id'];
				$db->deleteHistoryAllergy($allergy_id);
			} else if (isset($_GET['illness_id'])) {
				$illness_id = $_GET['illness_id'];
				$db->deleteHistoryIllness($illness_id);
			} else if (isset($_GET['surgery_id'])) {
				$surgery_id = $_GET['surgery_id'];
				$db->deleteHistorySurgery($surgery_id);
			} else if (isset($_GET['medication_id'])) {
				$medication_id = $_GET['medication_id'];
				$db->deleteHistoryMedication($medication_id);
			}
			header("LOCATION: history.php?patient_id=" . $patient_id . "&mode=" . $mode . "&lang=" . $lang);
		}
	}
	/*
	$active_consult_id = INVALID_VALUE;
	if(isset($_GET['consult_id'])) {
		$active_consult_id = $_GET['consult_id'];
	}
	*/
	$patient = $db->getPatient($patient_id);
	$name = $patient[PATIENTS_COLUMN_NAME];
	$patient_sex = $patient[PATIENTS_COLUMN_SEX];
	$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];
	$age_string = Utilities::getCurrentAgeString($date_of_birth, $lang);

	$temp_patient_id = "'" . $patient_id . "'";
	if($lang == "es") {
		echo '<script type="text/javascript" src="js/Constants_es.js"></script>';
	} else {
		echo '<script type="text/javascript" src="js/Constants_en.js"></script>';
	}
	


?>

<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo HISTORY; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<?php
			echo '<a id="back_link" onclick="backClick(' . $mode . ', \'' . $patient_id . '\');">' . BACK_TO_PROFILE . '</a>';
			?>
		</div>
	</div>

	<div id="divider_row" class="row">
		<div class="col-xs-12">
			<p class="left_title"><?php echo $name; ?></p>
			<p class="left_title3"><?php echo AGE_FIELD . " " . $age_string; ?></p>
		</div>
	</div>

	<div class="row row_upper_margin">
		<div class="col-xs-10">
			<p class="left_title"><?php echo ALLERGIES; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="images/add.png" alt="Add" onclick="addAllergy(<?php echo $temp_patient_id . ', ' . $mode; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php
			$no_reported_information_allergies = true;
			$nkda = false;
			$allergies = $db->getHistoryAllergies($patient_id);
			while($allergy = $allergies->fetch_assoc()) {
				if($no_reported_information_allergies) {
					$no_reported_information_allergies = false;
					$name = $allergy['name'];
					if(empty($name)) {
						$nkda = true;
						break;
					} else {
						echo '<ul class="list-group history_list">';
					}
				}

				$allergy_id = $allergy['id'];
				$name = $allergy['name'];
				$notes = $allergy['notes'];

				$temp_allergy_id = "'" . $allergy_id . "'";

				echo '<li class="list-group-item" onclick="allergyClick(' . $temp_patient_id . ', ' . $temp_allergy_id . ', ' . $mode . ', \'' . $name . '\', \'' . $notes . '\');">' . $name . '</li>';

			}

			if($no_reported_information_allergies) {
				echo '<p class="left_title2">' . NO_REPORTED_INFORMATION . '</p>';
			} else if($nkda) {
				echo '<p class="left_title2">' . NKDA . '</p>';
			} else {
				echo '</ul>';
			}
		?>
		</div>
	</div>

	<div class="row row_upper_margin">
		<div class="col-xs-10">
			<p class="left_title"><?php echo ILLNESSES_CONDITIONS; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="images/add.png" alt="Add" onclick="addIllnessCondition(<?php echo $temp_patient_id . ', ' . $mode; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php
			$illness_cnt = 0;
			$no_reported_information_illnesses = true;
			$illnesses_conditions = $db->getHistoryIllnesses($patient_id);
			while($illness = $illnesses_conditions->fetch_assoc()) {
				if($no_reported_information_illnesses) {
					$no_reported_information_illnesses = false;
					echo '<ul class="list-group history_list">';
				}

				$illness_id = $illness["id"];
				$consult_id = $illness['consult_id'];
				$is_chronic = $illness['is_chronic'];
				$type = $illness['type'];
				$other = $illness['other'];
				$start_date = $illness['start_date'];
				$end_date = $illness['end_date'];
				$notes = $illness['notes'];

				$display_text = "";
				if($other) {
					$display_text = $other;
				} else if ($consult_id) {
					$display_text = DIAGNOSIS_MAPPING[$type];
				} else {
					$display_text = ILLNESS_ARRAY[$type];
				}

				if($is_chronic == BOOLEAN_TRUE) {
					$display_text .= " (" . CHRONIC . ")";
				} else if ($is_chronic == BOOLEAN_FALSE ) {
					$display_text .= " (" . ACUTE . ")";
				}

				$consult_active = 0;
				if($consult_id) {
					$consult_active = $db->isConsultComplete($consult_id);
				}

				$temp_illness_id = "'" . $illness_id . "'";
				//$temp_consult_id = "'" . $consult_id . "'";

				echo '<li class="list-group-item" onclick="illnessClick(' . $temppatient_id . ', ' . $temp_illness_id . ', ' . $mode . ', \'' . $consult_id . '\', \'' . $consult_active . '\', \'' . $is_chronic . '\', \'' . $type . '\', \'' . $other . '\', \'' . $start_date . '\', \'' . $end_date . '\', \'' . $notes . '\');">' . $display_text . '</li>';
				$illness_cnt++;
				if($illness_cnt >= 10) {
					break;
				}
			}

			if($no_reported_information_illnesses) {
				echo '<p class="left_title2">' . NO_REPORTED_INFORMATION . '</p>';
			} else {
				echo '</ul>';
			}

		?>
		</div>
	</div>

	<div class="row row_upper_margin">
		<div class="col-xs-10">
			<p class="left_title"><?php echo SURGERIES; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="images/add.png" alt="Add" onclick="addSurgery(<?php echo $temp_patient_id . ', ' . $mode; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php
			$no_reported_information_surgeries = true;
			$surgeries = $db->getHistorySurgeries($patient_id);
			while($surgery = $surgeries->fetch_assoc()) {
				if($no_reported_information_surgeries) {
					$no_reported_information_surgeries = false;
					echo '<ul class="list-group history_list">';
				}

				$surgery_id = $surgery["id"];
				$is_name_custom = $surgery['is_name_custom'];
				$name = $surgery['name'];
				$date = $surgery['date'];
				$notes = $surgery['notes'];

				$display_text = "";
				if($is_name_custom == BOOLEAN_TRUE) {
					$display_text = $name;
				} else {
					$display_text = SURGERY_ARRAY[$name];
				}

				if($date) {
					$display_text .= " (" . Utilities::formatDateForDisplay2($date) . ")";
				} 

				$temp_surgery_id = "'" . $surgery_id . "'";

				echo '<li class="list-group-item" onclick="surgeryClick(' . $patient_id . ', ' . $temp_surgery_id . ', ' . $mode . ', ' . $is_name_custom . ', \'' . $name . '\', \'' . $date . '\', \'' . $notes . '\');">' . $display_text . '</li>';
			}

			if($no_reported_information_surgeries) {
				echo '<p class="left_title2">' . NO_REPORTED_INFORMATION . '</p>';
			} else {
				echo '</ul>';
			}
			
		?>
		</div>
	</div>

	<div class="row row_upper_margin">
		<div class="col-xs-10">
			<p class="left_title"><?php echo MEDICATIONS; ?></p>
		</div>
		<div class="col-xs-2">
			<img class="icon" src="images/add.png" alt="Add" onclick="addMedication(<?php echo $temp_patient_id . ', ' . $mode; ?>);" height="25px" width="25px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php
			$no_reported_information_medications = true;
			$medications = $db->getHistoryMedications($patient_id);
			while($medication = $medications->fetch_assoc()) {
				if($no_reported_information_medications) {
					$no_reported_information_medications = false;
					echo '<ul class="list-group history_list">';
				}

				$medication_id = $medication["id"];
				$consult_id = $medication['consult_id'];
				$name = $medication['name'];
				$start_date = $medication['start_date'];
				$end_date = $medication['end_date'];
				$notes = $medication['notes'];

				$display_text = $name;
				if($end_date) {
					$display_text .= " (" . Utilities::formatDateForDisplay($end_date) . ")";
				} else {
					$display_text .= " (Current)";
				}

				$consult_active = 0;
				if($consult_id) {
					$consult_active = $db->isConsultComplete($consult_id);
				}

				$temp_medication_id = "'" . $medication_id . "'";

				echo '<li class="list-group-item" onclick="medicationClick(' . $temp_patient_id . ', ' . $temp_medication_id . ', \'' . $consult_id . '\', \'' . $consult_active . '\', ' . $mode . ', \'' . $name . '\', \'' . $start_date . '\', \'' . $end_date . '\', \'' . $notes . '\');">' . $display_text . '</li>';
			}
			
			if($no_reported_information_medications) {
				echo '<p class="left_title2">' . NO_REPORTED_INFORMATION . '</p>';
			} else {
				echo '</ul>';
			}
			
		?>
		</div>
	</div>

<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"></p>
	      	</div>

		    <div id="modal_allergy" class="modal-body hidden">
	    	<?php
	    		if($no_reported_information_allergies || $nkda) {
	    	?>
	    		<div class="row input_row">
	    			<div class="col-xs-12">
	    				<p class="input_label"><?php echo NKDA . '?'; ?></p>
	    				<form id="allergy_radiogroup" class="input_field">
							<input type="radio" id="radio_nkda_yes" name="nkda" value="yes" <?php if($nkda) { echo "checked"; }; ?>><label for="radio_nkda_yes"><?php echo YES; ?></label>
							<input type="radio" id="radio_nkda_no" name="nkda" value="no"><label for="radio_nkda_no"><?php echo NO; ?></label>
						</form>
	    			</div>
	    		</div>
	    	<?php
	    		}
	    	?>
		    	<div id="allergy_name_row" class='row input_row <?php if($no_reported_information_allergies || $nkda) { echo "hidden"; } ?>'>
					<div class="col-xs-12">
						<p class="input_label"><?php echo ALLERGY_NAME_FIELD; ?></p>
						<input id='allergy_name_input' class='input_field'>
					</div>
				</div>

				<div id="allergy_notes_row" class='row input_row <?php if($no_reported_information_allergies || $nkda) { echo "hidden"; } ?>'>
					<div class="col-xs-12">
						<p class="input_label"><?php echo NOTES_FIELD; ?></p>
						<textarea id='allergy_notes_input' class='input_field'></textarea>
					</div>
				</div>

		    </div>


		    <div id="modal_illness" class="modal-body hidden">
	    		<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo NAME_FIELD; ?></p>
						<select id='illness_select' class='input_field'>
						<?php
							$index = 0;
							foreach(ILLNESS_ARRAY as $default_illness) {
								if($default_illness == OTHER) {
									echo '<option value="other">' . $default_illness .'</option>';
								} else {
									echo '<option value="' . $index . '">' . $default_illness .'</option>';
								}
								$index++;
							}
						?>
						</select>
					</div>
				</div>

				<div id="illness_name_custom_row" class="row input_row hidden">
					<div class="col-xs-12">
						<input id='illness_custom_name_input' class='input_field' placeholder='<?php echo OTHER; ?>'>
					</div>
				</div>

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo TYPE_FIELD; ?></p>
						<form id="type_radiogroup" class="input_field">
							<input type='radio' name='illness_type' id='illness_type_chronic' value='chronic'><label for='illness_type_chronic'><?php echo CHRONIC; ?></label>
							<input type='radio' name='illness_type' id='illness_type_acute' value='acute'><label for='illness_type_acute'><?php echo ACUTE; ?></label>
						</form>
					</div>
				</div>

				<div id="illness_chronic_section" class="hidden">
					<div class="row input_row">
						<div class="col-xs-12">
							<p class="input_label"><?php echo START_DATE_FIELD; ?></p>
							<input id='illness_ongoing_start_date_input' class='input_field' type='date'>
						</div>
					</div>
					<div class="row input_row">
						<div class="col-xs-12">
							<p class="input_label"><?php echo END_DATE_FIELD; ?><span class="normal_span"><?php echo "(" . LEAVE_BLANK_IF_CURRENT . ")"; ?><span></p>
							<input id='illness_ongoing_end_date_input' class='input_field' type='date'>
						</div>
					</div>
				</div>

				<div id="illness_acute_section" class="hidden">
					<div class="row input_row">
						<div class="col-xs-12">
							<p class="input_label"><?php echo DATE_FIELD; ?></p>
							<input id='illness_once_date_input' class='input_field' type='date'>
						</div>
					</div>
				</div>

				<div id="illness_notes_row" class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo NOTES_FIELD; ?></p>
						<textarea id='illness_notes_input' class='input_field'></textarea>
					</div>
				</div>

				<div id="illness_consult_row" class="row input_row hidden">
					<div class="col-xs-12">
						<p class="input_label"><?php echo CANNOT_EDIT_DELETE; ?></p>
						<a id='illness_go_to_consult_row' class="hidden"><?php echo GO_TO_CONSULT; ?></a>
					</div>
				</div>
		    	
		    </div>
		    <div id="modal_surgery" class="modal-body hidden">
		    	<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo SURGERY_NAME_FIELD; ?></p>
						<select id='surgery_select' class='input_field'>
							<?php
							$index = 0;
							foreach(SURGERY_ARRAY as $default_surgery) {
								if($default_surgery == "Other") {
									echo '<option value="other">' . $default_surgery .'</option>';
								} else {
									echo '<option value="' . $index . '">' . $default_surgery .'</option>';
								}
								$index++;
							}
							?>
						</select>
					</div>
				</div>

				<div id="surgery_name_custom_row" class="row input_row hidden">
					<div class="col-xs-12">
						<p class="input_label"><?php echo SURGERY_NAME_FIELD; ?></p>
						<input id='surgery_custom_name_input' class='input_field' placeholder="<?php echo OTHER; ?>">
					</div>
				</div>


				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo DATE_FIELD; ?></p>
						<input id='surgery_date_input' class='input_field' type='month'>
					</div>
				</div>

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo NOTES_FIELD; ?></p>
						<textarea id='surgery_notes_input' class='input_field'></textarea>
					</div>
				</div>
		    	
		    </div>
		    <div id="modal_medication" class="modal-body hidden">
		    	<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo MEDICATION_NAME_FIELD; ?></p>
						<input id='medication_name_input' class='input_field'>
					</div>
				</div>

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo START_DATE_FIELD; ?></p>
						<input id='medication_start_date_input' class='input_field' type='date'>
					</div>
				</div>
				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo END_DATE_FIELD; ?> <span class="normal_span"><?php echo "(" . LEAVE_BLANK_IF_CURRENT . ")"; ?><span></p>
						<input id='medication_end_date_input' class='input_field' type='date'>
					</div>
				</div>


				<div id="medication_notes_row" class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo NOTES_FIELD; ?></p>
						<textarea id='medication_notes_input' class='input_field'></textarea>
					</div>
				</div>

				<div id="medication_consult_row" class="row input_row hidden">
					<div class="col-xs-12">
						<p class="input_label"><?php echo MEDICATION_CONSULT_MESSAGE; ?></p>
						<a id='medication_go_to_consult_row' class="hidden"><?php echo GO_TO_CONSULT; ?></a>
					</div>
				</div>
		    </div>
		    <div class="modal-footer">
		      	<button id="delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
		        <button id="save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>




</div>

<script>

function backClick(mode, patient_id) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function consultClick(mode, patient_id, consult_id) {
	window.location.href = "consult_complete.php?mode=" + mode + "&patient_id=" + patient_id + "&consult_id=" + consult_id + getLang(1);
}


function addAllergy(patient_id, mode) {
	$("#myModal").modal('show');
	$("#modal_header").html(ALLERGIES);
	$("#modal_allergy").removeClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").addClass("hidden");

	$("#delete_button").hide();

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		allergySaveClick(patient_id, mode, "");
	});

	$("#allergy_name_input").val("");
	$("#allergy_notes_input").val("");
}

function allergySaveClick(patient_id, mode, allergy_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}

	if(!allergy_id) {
		allergy_id = "";
	}

	var nkda = $("input[name=nkda]:checked").val();
	var name = "";
	var notes = "";

	if(nkda !== "yes") {
		name = $("#allergy_name_input").val();
		if(!name){
			alert(ALLERGY_NAME_MISSING_MESSAGE);
			return;
		}
		notes = $("#allergy_notes_input").val();
	}

	window.location.href = "history.php?patient_id=" + patient_id + "&mode=" + mode + "&allergy_id=" + allergy_id + "&name=" + name + "&notes=" + notes + "&save=2" + extra_text;
}

function addIllnessCondition(patient_id, mode) {
	$("#myModal").modal('show');
	$("#modal_header").html(ILLNESSES_CONDITIONS);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").removeClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").addClass("hidden");

	$("#delete_button").hide();

	$("#save_button").show();
	$("#save_button").unbind();
	$("#save_button").click(function() { 
		illnessConditionSaveClick(patient_id, mode, "");
	});

	$("#illness_consult_row").addClass("hidden");
	$("#illness_select").val("0");
	$("#illness_name_custom_row").addClass("hidden");
	$("#illness_custom_name_input").val("");
	$("#illness_type_acute").prop("checked", false);
	$("#illness_type_chronic").prop("checked", false);
	$("#illness_chronic_section").addClass("hidden");
	$("#illness_acute_section").addClass("hidden");
	$("#illness_notes_input").val("");
}	

function illnessConditionSaveClick(patient_id, mode, illness_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!illness_id) {
		illness_id = "";
	}
	var type_value = $("#illness_select").find(":selected").val();
	var is_chronic = $("input[name=illness_type]:checked").val();
	var start_date = "";
	var end_date = "";
	if(is_chronic) {
		if(is_chronic == "chronic") {
			is_chronic = 2;
			start_date =  $("#illness_ongoing_start_date_input").val();
			end_date = $("#illness_ongoing_end_date_input").val();
		} else if (is_chronic == "acute") {
			is_chronic = 1;
			start_date =  $("#illness_once_date_input").val();
		} else {
			is_chronic = "";
		}
	} else {
		is_chronic = "";
	} 
	var other = "";
	if(type_value == "0") {
		alert(ILLNESS_NAME_MUST_SELECT_MESSAGE);
		return;
	} else {
		if(type_value == "other") {
			other = $("#illness_custom_name_input").val();
			if(!other) {
				alert(ILLNESS_NAME_CUSTOM_MISSING_MESSAGE);
				return;
			}
		} 
	}
	
	if(!start_date) {
		start_date = "";
	} 
	if(!end_date) {
		end_date = "";
	} 

	var notes = document.getElementById("illness_notes_input").value;

	window.location.href = "history.php?save=2&patient_id=" + patient_id + "&illness_id=" + illness_id + "&type=" + type_value + "&other=" + other + "&is_chronic=" + is_chronic + "&start_date=" + start_date + "&end_date=" + end_date + "&notes=" + notes + extra_text;


}

function addSurgery(patient_id, mode) {
	$("#myModal").modal('show');
	$("#modal_header").html(SURGERIES);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").removeClass("hidden");
	$("#modal_medication").addClass("hidden");

	$("#delete_button").hide();

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		surgerySaveClick(patient_id, mode, "");
	});

	$("#surgery_select").val("0");
	$("#surgery_name_custom_row").addClass("hidden");
	$("#surgery_custom_name_input").val("");
	$("#surgery_date_input").val("");
	$("#surgery_notes_input").val();
}

function surgerySaveClick(patient_id, mode, surgery_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!surgery_id) {
		surgery_id = "";
	}

	var name_value = $("#surgery_select").find(":selected").val();
	var is_name_custom = 0;
	var name = "";
	if(name_value == "0") {
		alert(SURGERY_NAME_MUST_SELECT_MESSAGE);
		return;
	} else {
		if(name_value == "other") {
			is_name_custom = 2;
			name = $("#surgery_custom_name_input").val();
			if(!name) {
				alert(SURGERY_NAME_CUSTOM_MISSING_MESSAGE);
				return;
			}
		} else {
			is_name_custom = 1;
			name = name_value;
		}
	}

	var date = $("#surgery_date_input").val();
	if(!date) {
		date = "";
	} else {
		date += "-01";
	}

	var notes = $("#surgery_notes_input").val();

	window.location.href = "history.php?save=2&patient_id=" + patient_id + "&surgery_id=" + surgery_id + "&is_name_custom=" + is_name_custom + "&name=" + name + "&date=" + date + "&notes=" + notes + extra_text;

}

function addMedication(patient_id, mode) {
	$("#myModal").modal('show');
	$("#modal_header").html(MEDICATIONS);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").removeClass("hidden");

	$("#delete_button").hide();

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		medicationSaveClick(patient_id, mode, "");
	});

	$("#medication_name_input").val("");
	$("#medication_start_date_input").val("");
	$("#medication_end_date_input").val("");
	$("#medication_notes_input").val("");
}

function medicationSaveClick(patient_id, mode, medication_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!medication_id) {
		medication_id = "";
	}
	var name = $("#medication_name_input").val();
	if(!name){
		alert(MEDICATION_NAME_MISSING_MESSAGE);
		return;
	}

	var start_date =  $("#medication_start_date_input").val();
	var end_date = $("#medication_end_date_input").val();

	var notes = $("#medication_notes_input").val();

	window.location.href = "history.php?save=2&patient_id=" + patient_id + "&medication_id=" + medication_id + "&name=" + name + "&start_date=" + start_date + "&end_date=" + end_date + "&notes=" + notes + "&save=2" + extra_text;

}

function allergyClick(patient_id, id, mode, name, notes) {
	$("#myModal").modal('show');
	$("#modal_header").html(ALLERGIES);
	$("#modal_allergy").removeClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").addClass("hidden");


	$("#delete_button").show();
	$("#delete").unbind();
	$("#delete_button").click(function() { 
		allergyDeleteClick(patient_id, mode, id);
	});

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		allergySaveClick(patient_id, mode, id);
	});

	$("#allergy_name_input").val(name);
	$("#allergy_notes_input").val(notes);
}

function allergyDeleteClick(patient_id, mode, id) {
	var lang_text = getLang(1);
	window.location.href = "history.php?delete=2&patient_id=" + patient_id + "&mode=" + mode + "&allergy_id=" + id + lang_text;
}

function illnessClick(patient_id, id, mode, consult_id, consult_complete, is_chronic, type, other, start_date, end_date, notes) {
	$("#myModal").modal('show');
	$("#modal_header").html(ILLNESSES_CONDITIONS);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").removeClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").addClass("hidden");

	//ADD STUFF

	if(consult_id && consult_id > 0) {
		$("#illness_consult_row").removeClass("hidden");
		if(consult_complete == 2) {
			$("#illness_go_to_consult_row").removeClass("hidden");
			$("#illness_go_to_consult_row").click(function() { 
				consultClick(mode, patient_id, consult_id);
			});
		} else {
			$("#illness_go_to_consult_row").addClass("hidden");
		}

		$("#delete_button").hide();
		$("#save_button").hide();

		$("#illness_select").val("other");
		$("#illness_name_custom_row").removeClass("hidden");

		if(other) {
			$("#illness_custom_name_input").val(other);
		} else {
			$("#illness_custom_name_input").val(DIAGNOSIS_MAPPING[type]);
		}

	} else {
		$("#illness_consult_row").addClass("hidden");

		$("#delete_button").show();
		$("#delete").unbind();
		$("#delete_button").click(function() { 
			illnessDeleteClick(patient_id, mode, id);
		});

		$("#save_button").show();
		$("#save_button").unbind();
		$("#save_button").click(function() { 
			illnessConditionSaveClick(patient_id, mode, id);
		});

		if(other) {
			$("#illness_select").val("other");
			$("#illness_name_custom_row").removeClass("hidden");
			$("#illness_custom_name_input").val(other);
		} else {
			$("#illness_select").val(type);
			$("#illness_name_custom_row").addClass("hidden");
		}

	}

	if(is_chronic == BOOLEAN_TRUE) {
		$("#illness_type_chronic").prop("checked", true);
		$("#illness_chronic_section").removeClass("hidden");
		$("#illness_acute_section").addClass("hidden");
		$("#illness_ongoing_start_date_input").val(start_date);
		$("#illness_ongoing_end_date_input").val(end_date);
	} else if (is_chronic == BOOLEAN_FALSE) {
		$("#illness_type_acute").prop("checked", true);
		$("#illness_acute_section").removeClass("hidden");
		$("#illness_chronic_section").addClass("hidden");
		$("#illness_once_date_input").val(start_date);
	}

	$("#illness_notes_input").val(notes);
}

function illnessDeleteClick(patient_id, mode, id) {
	var lang_text = getLang(1);
	window.location.href = "history.php?delete=2&patient_id=" + patient_id + "&mode=" + mode + "&illness_id=" + id + lang_text;
}

function surgeryClick(patient_id, id, mode, is_name_custom, name, date, notes) {
	$("#myModal").modal('show');
	$("#modal_header").html(SURGERIES);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").removeClass("hidden");
	$("#modal_medication").addClass("hidden");


	$("#delete_button").show();
	$("#delete").unbind();
	$("#delete_button").click(function() { 
		surgeryDeleteClick(patient_id, mode, id);
	});

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		surgerySaveClick(patient_id, mode, id);
	});

	//ADD STUFF
	if(is_name_custom == BOOLEAN_TRUE) {
		$("#surgery_select").val("other");
		$("#surgery_name_custom_row").removeClass("hidden");
		$("#surgery_custom_name_input").val(name);
	} else {
		$("#surgery_select").val(name);
		$("#surgery_name_custom_row").addClass("hidden");
	}

	$("#surgery_date_input").val(date.substr(0, 7));
	$("#surgery_notes_input").val(notes);
}

function surgeryDeleteClick(patient_id, mode, id) {
	var lang_text = getLang(1);
	window.location.href = "history.php?delete=2&patient_id=" + patient_id + "&mode=" + mode + "&surgery_id=" + id + lang_text;
}

function medicationClick(patient_id, id, consult_id, consult_complete, mode, name, start_date, end_date, notes) {
	$("#myModal").modal('show');
	$("#modal_header").html(MEDICATIONS);
	$("#modal_allergy").addClass("hidden");
	$("#modal_illness").addClass("hidden");
	$("#modal_surgery").addClass("hidden");
	$("#modal_medication").removeClass("hidden");

	if(consult_id && consult_id > 0) {
		$("#medication_consult_row").removeClass("hidden");
		if(consult_complete == 2) {
			$("#medication_go_to_consult_row").removeClass("hidden");
			$("#medication_go_to_consult_row").click(function() { 
				consultClick(mode, patient_id, consult_id);
			});
		} else {
			$("#medication_go_to_consult_row").addClass("hidden");
		}
	} else {
		$("#medication_consult_row").addClass("hidden");

	}


	$("#delete_button").show();
	$("#delete").unbind();
	$("#delete_button").click(function() { 
		medicationDeleteClick(patient_id, mode, id);
	});

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		medicationSaveClick(patient_id, mode, id);
	});

	//ADD STUFF

	$("#medication_name_input").val(name);
	$("#medication_start_date_input").val(start_date);
	$("#medication_end_date_input").val(end_date);
	$("#medication_notes_input").val(notes);
}

function medicationDeleteClick(patient_id, mode, id) {
	var lang_text = getLang(1);
	window.location.href = "history.php?delete=2&patient_id=" + patient_id + "&mode=" + mode + "&medication_id=" + id + lang_text;
}

$("input[name=nkda]").change(function() {
	var value = $("input[name=nkda]:checked").val();
	if (value == "no") {
		$('#allergy_notes_row').removeClass("hidden");
		$('#allergy_name_row').removeClass("hidden");
	} else {
		$('#allergy_notes_row').addClass("hidden");
		$('#allergy_name_row').addClass("hidden");
	}
});

$("#surgery_select").change(function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if(value == "other") {
		$('#surgery_name_custom_row').removeClass("hidden");
	} else {
		$('#surgery_name_custom_row').addClass("hidden");	
	}
});


$("#illness_select").change(function() {
	var index = this.selectedIndex;
	var value = this.children[index].value;
	if(value == "other") {
		$('#illness_name_custom_row').removeClass("hidden");
	} else {
		$('#illness_name_custom_row').addClass("hidden");	
	}
});

$("input[name=illness_type]").change(function() {
	var value = $("input[name=illness_type]:checked").val();
	if (value == "chronic") {
		$('#illness_notes_row').removeClass("hidden");
		$('#illness_chronic_section').removeClass("hidden");
		$('#illness_acute_section').addClass("hidden");
	} else if (value == "acute") {
		$('#illness_notes_row').removeClass("hidden");
		$('#illness_chronic_section').addClass("hidden");
		$('#illness_acute_section').removeClass("hidden");
	} else {
		$('#illness_notes_row').addClass("hidden");
		$('#illness_chronic_section').addClass("hidden");
		$('#illness_acute_section').addClass("hidden");
	}
});

</script>




</html>
