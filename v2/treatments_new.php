
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>


<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<style>
	.custom_input_field {
		margin-bottom: 0px;
		margin-left: 10px;
	}

	.custom_span {
		margin-bottom: 0px;
		margin-left: 10px;
		font-size: 24px;
	}

	.other_input {
		margin-top: 5px;
	}
</style>

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

	$consult_id = 0;

	$consult;
	$patient_id;
	$diagnosis_id = NULL;

	if(isset($_GET['save'])) {
		$save = $_GET['save'];
		if ($save == 2) {
			$consult_id = $_GET['consult_id'];
			$diagnosis_id = $_GET['diagnosis_id'];
			$treatment_id = $_GET['treatment_id'];
			$type = $_GET['type'];
			if(!$diagnosis_id) {
				$diagnosis_id = NULL;
			}
			if($type === "") {
				$type = NULL;
			}
			$other = $_GET['other'];
			if($other === "") {
				$other = NULL;
			}
			$strength = $_GET['strength'];
			if($strength === "") {
				$strength = NULL;
			}
			$strength_units = $_GET['strength_units'];
			if($strength_units === "") {
				$strength_units = NULL;
			}
			$strength_units_other = $_GET['strength_units_other'];
			if($strength_units_other === "") {
				$strength_units_other = NULL;
			}
			$conc_part_one = $_GET['conc_part_one'];
			if($conc_part_one === "") {
				$conc_part_one = NULL;
			}
			$conc_part_one_units = $_GET['conc_part_one_units'];
			if($conc_part_one_units === "") {
				$conc_part_one_units = NULL;
			}
			$conc_part_one_units_other = $_GET['conc_part_one_units_other'];
			if($conc_part_one_units_other === "") {
				$conc_part_one_units_other = NULL;
			}
			$conc_part_two = $_GET['conc_part_two'];
			if($conc_part_two === "") {
				$conc_part_two = NULL;
			}
			$conc_part_two_units = $_GET['conc_part_two_units'];
			if($conc_part_two_units === "") {
				$conc_part_two_units = NULL;
			}
			$conc_part_two_units_other = $_GET['conc_part_two_units_other'];
			if($conc_part_two_units_other === "") {
				$conc_part_two_units_other = NULL;
			}
			$quantity = $_GET['quantity'];
			if($quantity === "") {
				$quantity = NULL;
			}
			$quantity_units = $_GET['quantity_units'];
			if($quantity_units === "") {
				$quantity_units = NULL;
			}
			$quantity_units_other = $_GET['quantity_units_other'];
			if($quantity_units_other === "") {
				$quantity_units_other = NULL;
			}
			$route = $_GET['route'];
			if($route === "") {
				$route = NULL;
			}
			$route_other = $_GET['route_other'];
			if($route_other === "") {
				$route_other = NULL;
			}
			$prn = $_GET['prn'];
			if($prn === "") {
				$prn = NULL;
			} else {
				if($prn == "prn") {
					$prn = BOOLEAN_TRUE;
				} else if ($prn == "scheduled") {
					$prn = BOOLEAN_FALSE;
				} else {
					$prn = NULL;
				}
			}
			$dosage = $_GET['dosage'];
			if($dosage === "") {
				$dosage = NULL;
			}
			$dosage_units = $_GET['dosage_units'];
			if($dosage_units === "") {
				$dosage_units = NULL;
			}
			$dosage_units_other = $_GET['dosage_units_other'];
			if($dosage_units_other === "") {
				$dosage_units_other = NULL;
			}
			$frequency = $_GET['frequency'];
			if($frequency === "") {
				$frequency = NULL;
			}
			$frequency_other = $_GET['frequency_other'];
			if($frequency_other === "") {
				$frequency_other = NULL;
			}
			$duration = $_GET['duration'];
			if($duration === "") {
				$duration = NULL;
			}
			$duration_units = $_GET['duration_units'];
			if($duration_units === "") {
				$duration_units = NULL;
			}
			$duration_units_other = $_GET['duration_units_other'];
			if($duration_units_other === "") {
				$duration_units_other = NULL;
			}
			$notes = $_GET['notes'];
			if($notes === "") {
				$notes = NULL;
			}

			$db->createNewTreatment($consult_id, $treatment_id, $diagnosis_id, $type, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes);
			header("LOCATION: treatments_new.php?consult_id=" . $consult_id . "&diagnosis_id=" . $diagnosis_id . "&lang=" . $lang);
		}
	}

	if(isset($_GET['delete'])) {
		$delete = $_GET['delete'];
		if ($delete == 2) {
			$consult_id = $_GET['consult_id'];
			$diagnosis_id = $_GET['diagnosis_id'];
			$treatment_id = $_GET['treatment_id'];
			$db->deleteTreatment($treatment_id);

			header("LOCATION: treatments_new.php?consult_id=" . $consult_id . "&diagnosis_id=" . $diagnosis_id . "&lang=" . $lang);
		}
	}

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		$patient_id = $consult["patient_id"];

		if(isset($_GET['diagnosis_id'])) {
			$diagnosis_id = (int)$_GET['diagnosis_id'];
		}

	} else {
		header("LOCATION: index.php");
	}


	$editable = true;

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

?>

<div class="container-fluid">
	<span class="no_display" id="hidden_consult_id"><?php echo $consult_id; ?></span>
	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row consult_link_row">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<?php
				if($diagnosis_id === NULL) {
					echo "<p class='content_p consult_section'>" . TREATMENTS . "</p>";
				} else {
					$diagnosis_text = "General";
					if($diagnosis_id !== 0) {
						$diagnosis = $db->getDiagnosisById($diagnosis_id);
						$other = $diagnosis['other'];
						if($other) {
							$diagnosis_text = $other;
						} else {
							$diagnosis_category = $diagnosis['category'];
							$diagnosis_type = $diagnosis['type'];
							$diagnosis_text = $map->getDiagnosisOptions($diagnosis_category)[$diagnosis_type];
						}
					} 
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id);'>" . TREATMENTS . "</a></p>";
					echo "<p class='content_p'>$diagnosis_text</p>";
				}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul class='list-group'>
			<?php
				if($diagnosis_id === NULL) {
					$diagnosis_id = 0;
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick1($consult_id, \"$diagnosis_id\");'>" . GENERAL;
					$has_treatment = $db->diagnosisHasTreatment($consult_id, $diagnosis_id);
					if($has_treatment) {
						echo '<img class="consult_task_completed" src="../images/checkmark"/>';
					}
					echo "</li>";

					$diagnoses = $db->getDiagnoses($consult_id);
					foreach($diagnoses as $diagnosis) {
						$diagnosis_id = $diagnosis['id'];
						$diagnosis_text = "";
						$other = $diagnosis['other'];
						if($other) {
							$diagnosis_text = $other;
						} else {
							$diagnosis_category = $diagnosis['category'];
							$diagnosis_type = $diagnosis['type'];
							$diagnosis_text = $map->getDiagnosisOptions($diagnosis_category)[$diagnosis_type];
						}

						echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick1($consult_id, \"$diagnosis_id\");'>$diagnosis_text";

						$has_treatment = $db->diagnosisHasTreatment($consult_id, $diagnosis_id);
						if($has_treatment) {
							echo '<img class="consult_task_completed" src="../images/checkmark"/>';
						}
						echo "</li>";
					}
				} else {
					$treatment_array;
					if($diagnosis_id === 0) {
						$treatment_array = $map->getGeneralTreatments();
					} else {
						$diagnosis = $db->getDiagnosisById($diagnosis_id);
						$diagnosis_category = $diagnosis['category'];
						$diagnosis_type = $diagnosis['type'];
						$diagnosis_other = $diagnosis['other'];
						if($diagnosis_other) {
							$treatment_array = [];
						} else {
							$treatment_array = $map->getTreatmentOptions($diagnosis_category, $diagnosis_type);
						}
					}
					foreach($treatment_array as $treatment) {
						$treatment_text = $map->getTreatment($treatment);
						$has_treatment = $db->hasTreatment($consult_id, $diagnosis_id, $treatment);
						$treatment_id = "";
						$other = "";
						$strength = "";
						$strength_units = "";
						$strength_units_other = "";
						$conc_part_one = "";
						$conc_part_one_units = "";
						$conc_part_one_units_other = "";
						$conc_part_two = "";
						$conc_part_two_units = "";
						$conc_part_two_units_other = "";
						$quantity = "";
						$quantity_units = "";
						$quantity_units_other = "";
						$route = "";
						$route_other = "";
						$prn = "";
						$dosage = "";
						$dosage_units = "";
						$dosage_units_other = "";
						$frequency = "";
						$frequency_other = "";
						$duration = "";
						$duration_units = "";
						$duration_units_other = "";
						$notes = "";

						if($has_treatment) {
							$treatment_object = $db->getTreatmentByInformation($consult_id, $diagnosis_id, $treatment);
							$treatment_id = $treatment_object['id'];
							$other = $treatment_object['other'];
							$strength = $treatment_object['strength'];
							$strength_units = $treatment_object['strength_units'];
							$strength_units_other = $treatment_object['strength_units_other'];
							$conc_part_one = $treatment_object['conc_part_one'];
							$conc_part_one_units = $treatment_object['conc_part_one_units'];
							$conc_part_one_units_other = $treatment_object['conc_part_one_units_other'];
							$conc_part_two = $treatment_object['conc_part_two'];
							$conc_part_two_units = $treatment_object['conc_part_two_units'];
							$conc_part_two_units_other = $treatment_object['conc_part_two_units_other'];
							$quantity = $treatment_object['quantity'];
							$quantity_units = $treatment_object['quantity_units'];
							$quantity_units_other = $treatment_object['quantity_units_other'];
							$route = $treatment_object['route'];
							$route_other = $treatment_object['route_other'];
							$prn = $treatment_object['prn'];
							$dosage = $treatment_object['dosage'];
							$dosage_units = $treatment_object['dosage_units'];
							$dosage_units_other = $treatment_object['dosage_units_other'];
							$frequency = $treatment_object['frequency'];
							$frequency_other = $treatment_object['frequency_other'];
							$duration = $treatment_object['duration'];
							$duration_units = $treatment_object['duration_units'];
							$duration_units_other = $treatment_object['duration_units_other'];
							$notes = $treatment_object['notes'];

						}
						echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick2($consult_id, \"$diagnosis_id\", \"$treatment_id\", \"$treatment\", \"$other\", \"$strength\", \"$strength_units\", \"$strength_units_other\", \"$conc_part_one\", \"$conc_part_one_units\", \"$conc_part_one_units_other\", \"$conc_part_two\", \"$conc_part_two_units\", \"$conc_part_two_units_other\", \"$quantity\", \"$quantity_units\", \"$quantity_units_other\", \"$route\", \"$route_other\", \"$prn\", \"$dosage\", \"$dosage_units\", \"$dosage_units_other\", \"$frequency\", \"$frequency_other\", \"$duration\", \"$duration_units\", \"$duration_units_other\", \"$notes\", \"$treatment_text\");'>$treatment_text";

						if($has_treatment) {
							echo '<img class="consult_task_completed" src="../images/checkmark"/>';
						}
						echo "</li>";
					}
					if($diagnosis_id == 0) {
						$diagnosis_id = NULL;
					}
					$custom_treatments = $db->getCustomTreatments($consult_id, $diagnosis_id);
					foreach($custom_treatments as $treatment_object) {
						$treatment_id = $treatment_object['id'];
						$other = $treatment_object['other'];
						$strength = $treatment_object['strength'];
						$strength_units = $treatment_object['strength_units'];
						$strength_units_other = $treatment_object['strength_units_other'];
						$conc_part_one = $treatment_object['conc_part_one'];
						$conc_part_one_units = $treatment_object['conc_part_one_units'];
						$conc_part_one_units_other = $treatment_object['conc_part_one_units_other'];
						$conc_part_two = $treatment_object['conc_part_two'];
						$conc_part_two_units = $treatment_object['conc_part_two_units'];
						$conc_part_two_units_other = $treatment_object['conc_part_two_units_other'];
						$quantity = $treatment_object['quantity'];
						$quantity_units = $treatment_object['quantity_units'];
						$quantity_units_other = $treatment_object['quantity_units_other'];
						$route = $treatment_object['route'];
						$route_other = $treatment_object['route_other'];
						$prn = $treatment_object['prn'];
						$dosage = $treatment_object['dosage'];
						$dosage_units = $treatment_object['dosage_units'];
						$dosage_units_other = $treatment_object['dosage_units_other'];
						$frequency = $treatment_object['frequency'];
						$frequency_other = $treatment_object['frequency_other'];
						$duration = $treatment_object['duration'];
						$duration_units = $treatment_object['duration_units'];
						$duration_units_other = $treatment_object['duration_units_other'];
						$notes = $treatment_object['notes'];
						echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick2($consult_id, \"$diagnosis_id\", \"$treatment_id\", \"\", \"$other\", \"$strength\", \"$strength_units\", \"$strength_units_other\", \"$conc_part_one\", \"$conc_part_one_units\", \"$conc_part_one_units_other\", \"$conc_part_two\", \"$conc_part_two_units\", \"$conc_part_two_units_other\", \"$quantity\", \"$quantity_units\", \"$quantity_units_other\", \"$route\", \"$route_other\", \"$prn\", \"$dosage\", \"$dosage_units\", \"$dosage_units_other\", \"$frequency\", \"$frequency_other\", \"$duration\", \"$duration_units\", \"$duration_units_other\", \"$notes\", \"$other\");'>$other";
						echo '<img class="consult_task_completed" src="../images/checkmark"/>';
						echo "</li>";
					}
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick2($consult_id, \"$diagnosis_id\", \"\", \"\", 2, \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"" . OTHER . "\");'>". OTHER;
					echo "</li>";
				}

				
			?>
			</ul>
		</div>
	</div>


	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 id="modal_header" class="modal-title"></h4>
	      </div>
	      <div class="modal-body">
	      	<div id="other_input_row" class="input_row no_display">
	        	<p class="input_label"><?php echo NAME . ":" ?></p>
	        	<input id='information_input' class='input_field' placeholder="<?php echo OTHER; ?>">
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label consult_section"><?php echo INSCRIPTION_SUBSCRIPTION; ?></p>
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo STRENGTH_PER_UNIT . ":" ?></p>
	        	<input id='strength_input' class='input_field' size='6'>
	        	<select id="strength_select" class="custom_input_field">
	        	<?php
	        		$index = 1;
	        		foreach(STRENGTH_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_strength_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_STRENGTH_UNITS; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo CONCENTRATION_PEDS . ":" ?></p>
	        	<input id='concentration_part_one_input' class='input_field' size='6'>
	        	<select id="concentration_part_one_select" class="custom_input_field">
				<?php
	        		$index = 1;
	        		foreach(CONC_PART_ONE_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<span class="custom_span">/</span>
				<input id='other_concentration_part_one_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_CONC_1_UNITS; ?>">
				<span id="custom_span2" class="custom_span no_display">/</span>
	    	</div>
	    	<div class="input_row">
	        	<input id='concentration_part_two_input' class='input_field' size='6'>
	        	<select id="concentration_part_two_select" class="custom_input_field">
				<?php
	        		$index = 1;
	        		foreach(CONC_PART_TWO_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_concentration_part_two_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_CONC_2_UNITS; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo QUANTITY . ":" ?></p>
	        	<input id='quantity_input' class='input_field' size='4'>
	        	<select id="quantity_select" class="custom_input_field">
				<?php
	        		$index = 1;
	        		foreach(QUANTITY_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_quantity_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_QUANTITY_UNITS; ?>">
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label consult_section"><?php echo PATIENT_USE_DIRECTIONS; ?></p>
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo ROUTE . ":" ?></p>
	        	<select id="route_select" class="input_field">
				<?php
	        		$index = 1;
	        		foreach(ROUTE_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_route_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_ROUTE; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo WHEN; ?></p>
	        	<form id="when_radiogroup" class="input_field">
	        		<input type="radio" id="when_prn" name="when" value="prn"><label for="when_prn"><?php echo PRN; ?></label>
	        		<input type="radio" id="when_scheduled" name="when" value="scheduled"><label for="when_scheduled"><?php echo SCHEDULED; ?></label>
	        	</form>
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo DOSAGE . ":" ?></p>
	        	<input id='dosage_input' class='input_field' size='4'>
	        	<select id="dosage_select" class="custom_input_field">
				<?php
	        		$index = 1;
	        		foreach(DOSAGE_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_dosage_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_DOSAGE_UNITS; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo FREQUENCY . ":" ?></p>
	        	<select id="frequency_select" class="input_field">
				<?php
	        		$index = 1;
	        		foreach(FREQUENCY_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_frequency_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_FREQUENCY; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo DURATION . ":" ?></p>
	        	<input id='duration_input' class='input_field' size='4'>
	        	<select id="duration_select" class="custom_input_field">
				<?php
	        		$index = 1;
	        		foreach(DURATION_UNITS_ARRAY as $label) {
	        			echo "<option value='$index'>$label</option>";
	        			$index++;
	        		}
	        	?>
				  <option value="other"><?php echo OTHER; ?></option>
				</select>
				<input id='other_duration_units_input' class='input_field no_display other_input' placeholder="<?php echo OTHER_DURATION_UNITS; ?>">
	    	</div>
	    	<div class="input_row">
	        	<p class="input_label"><?php echo NOTES . ":"; ?></p>
	        	<textarea id='notes_input' class='input_field'></textarea>
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
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);"><?php echo CONTINUE_WORD; ?></button>
		</div>
	</div>


</div>




<script type="text/javascript">

$("#strength_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_strength_units_input").show();
	} else {
		$("#other_strength_units_input").hide();
	}
});

$("#concentration_part_one_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_concentration_part_one_units_input").show();
		$("#custom_span2").show();
	} else {
		$("#other_concentration_part_one_units_input").hide();
		$("#custom_span2").hide();
	}
});

$("#concentration_part_two_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_concentration_part_two_units_input").show();
	} else {
		$("#other_concentration_part_two_units_input").hide();
	}
});

$("#quantity_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_quantity_units_input").show();
	} else {
		$("#other_quantity_units_input").hide();
	}
});

$("#route_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_route_input").show();
	} else {
		$("#other_route_input").hide();
	}
});

$("#dosage_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_dosage_units_input").show();
	} else {
		$("#other_dosage_units_input").hide();
	}
});

$("#frequency_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_frequency_input").show();
	} else {
		$("#other_frequency_input").hide();
	}
});

$("#duration_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_duration_units_input").show();
	} else {
		$("#other_duration_units_input").hide();
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

function backClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments_new.php?consult_id=" + consult_id + extra_text;
}


function itemClick1(consult_id, diagnosis_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments_new.php?consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + extra_text;
}

function itemClick2(consult_id, diagnosis_id, treatment_id, type, other, strength, strength_units, strength_units_other, conc_part_one, conc_part_one_units, conc_part_one_units_other, conc_part_two, conc_part_two_units, conc_part_two_units_other, quantity, quantity_units, quantity_units_other, route, route_other, prn, dosage, dosage_units, dosage_units_other, frequency, frequency_other, duration, duration_units, duration_units_other, notes, text) {
	$("#modal_header").html(text);
	$("#myModal").show();
	if(other) {
		$("#other_input_row").show();
		if (treatment_id) {
			$("#information_input").val(other);
		}
	} else {
		$("#other_input_row").hide();
	}
	
	if(!treatment_id) {
		$("#delete_button").hide();

		//CLEAR ALL INPUTS
		$("#strength_input").val("");
		$("#strength_select").val("1");
		$("#other_strength_units_input").val("");

		$("#concentration_part_one_input").val("");
		$("#concentration_part_one_select").val("1");
		$("#other_concentration_part_one_units_input").val("");

		$("#concentration_part_two_input").val("");
		$("#concentration_part_two_select").val("1");
		$("#other_concentration_part_two_units_input").val("");

		$("#quantity_input").val("");
		$("#quantity_select").val("1");
		$("#other_quantity_units_input").val("");		

		$("#route_select").val("1");
		$("#other_route_input").val("");

		$("input[name='when'][value='prn']").prop("checked", false);
		$("input[name='when'][value='scheduled']").prop("checked", false);

		$("#dosage_input").val("");
		$("#dosage_select").val("1");
		$("#other_dosage_units_input").val("");

		$("#frequency_select").val("1");
		$("#other_frequency_input").val("");

		$("#duration_input").val("");
		$("#duration_select").val("1");
		$("#other_duration_units_input").val("");

		$("#notes_input").val("");
	} else {
		$("#strength_input").val(strength);
		if(strength_units_other) {
			$("#strength_select").val("other");
			$("#other_strength_units_input").show();
			$("#other_strength_units_input").val(strength_units_other);
		} else {
			if(strength_units) {
				$("#strength_select").val(strength_units);
			} else {
				$("#strength_select").val("1");
			}
			$("#other_strength_units_input").hide();
		}

		$("#concentration_part_one_input").val(conc_part_one);
		if(conc_part_one_units_other) {
			$("#concentration_part_one_select").val("other");
			$("#other_concentration_part_one_units_input").show();
			$("#other_concentration_part_one_units_input").val(conc_part_one_units_other);
		} else {
			if(conc_part_one_units) {
				$("#concentration_part_one_select").val(conc_part_one_units);
			} else {
				$("#concentration_part_one_select").val("1");
			}
			$("#other_concentration_part_one_units_input").hide();
		}

		$("#concentration_part_two_input").val(conc_part_two);
		if(conc_part_two_units_other) {
			$("#concentration_part_two_select").val("other");
			$("#other_concentration_part_two_units_input").show();
			$("#other_concentration_part_two_units_input").val(conc_part_two_units_other);
		} else {
			if(conc_part_two_units) {
				$("#concentration_part_two_select").val(conc_part_two_units);
			} else {
				$("#concentration_part_two_select").val("1");
			}
			$("#other_concentration_part_two_units_input").hide();
		}

		$("#quantity_input").val(quantity);
		if(quantity_units_other) {
			$("#quantity_select").val("other");
			$("#other_quantity_units_input").show();
			$("#other_quantity_units_input").val(quantity_units_other);
		} else {
			if(quantity_units) {
				$("#quantity_select").val(quantity_units);
			} else {
				$("#quantity_select").val("1");
			}
			$("#other_quantity_units_input").hide();
		}

		if(route_other) {
			$("#route_select").val("other");
			$("#other_route_input").show();
			$("#other_route_input").val(route_other);
		} else {
			if(route) {
				$("#route_select").val(route);
			} else {
				$("#route_select").val("1");
			}
			$("#other_route_input").hide();
		}

		$("#dosage_input").val(dosage);
		if(dosage_units_other) {
			$("#dosage_select").val("other");
			$("#other_dosage_units_input").show();
			$("#other_dosage_units_input").val(dosage_units_other);
		} else {
			if(dosage_units) {
				$("#dosage_select").val(dosage_units);
			} else {
				$("#dosage_select").val("1");
			}
			$("#other_dosage_units_input").hide();
		}

		if(prn) {
			if(isInt(prn)) {
				if(prn == '2') {
					$("input[name='when'][value='prn']").prop("checked", true);
				} else if (prn == '1') {
					$("input[name='when'][value='scheduled']").prop("checked", true);
				}
			}
		}

		if(frequency_other) {
			$("#frequency_select").val("other");
			$("#other_frequency_input").show();
			$("#other_frequency_input").val(frequency_other);
		} else {
			if(frequency) {
				$("#frequency_select").val(frequency);
			} else {
				$("#frequency_select").val("1");
			}
			$("#other_frequency_input").hide();
		}

		$("#duration_input").val(duration);
		if(duration_units_other) {
			$("#duration_select").val("other");
			$("#other_duration_units_input").show();
			$("#other_duration_units_input").val(duration_units_other);
		} else {
			if(duration_units) {
				$("#duration_select").val(duration_units);
			} else {
				$("#duration_select").val("1");
			}
			$("#other_duration_units_input").hide();
		}

		$("#notes_input").val(notes);

		$("#delete_button").show();
		$("#delete_button").unbind();
		$("#delete_button").click(function() {
			deleteFunction(consult_id, diagnosis_id, treatment_id);
		});
	}

	$("#save_button").unbind();
	$("#save_button").click(function() { 
		saveFunction(consult_id, diagnosis_id, treatment_id, type, other);
	});

}

function deleteFunction(consult_id, diagnosis_id, treatment_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments_new.php?consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + "&treatment_id=" + treatment_id + "&delete=2" + extra_text;
}

function saveFunction(consult_id, diagnosis_id, treatment_id, type, other) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var valid_submission = true;

	var information = "";
	if (other) {
		var information = $("#information_input").val();
		if(!information) {
			valid_submission = false;
			var alert_text = "ERROR: Must complete inputs";
			if(lang == "es") {
				alert_text = "ERROR: Necesita completar campos.";
			}
			alert(alert_text);
		}
	}

	var strength = $("#strength_input").val();
	var strength_units = $("#strength_select").val();
	var strength_units_other = "";
	if(strength_units == "other") {
		strength_units_other = $("#other_strength_units_input");
		if(!strength_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER STRENGTH UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR CAMPO DE OTRO UNIDADES DE FUERZA O ESCOGER OTRA OPCION";
			}
			alert(alert_text);
		}
	} 

	var conc_part_one = $("#concentration_part_one_input").val();
	var conc_part_one_units = $("#concentration_part_two_select").val();
	var conc_part_one_units_other = "";
	if(conc_part_one_units == "other") {
		conc_part_one_units_other = $("#other_concentration_part_one_units_input");
		if(!conc_part_one_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER CONC 1 UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CONCENTRACION 1 O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	} 

	var conc_part_two = $("#concentration_part_two_input").val();
	var conc_part_two_units = $("#concentration_part_two_select").val();
	var conc_part_two_units_other = "";
	if(conc_part_two_units == "other") {
		conc_part_two_units_other = $("#other_concentration_part_two_units_input");
		if(!conc_part_two_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER CONC 2 UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CONCENTRACION 2 O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	} 

	if((conc_part_one && !conc_part_two) || (!conc_part_one && conc_part_two)) {
		valid_submission = false;
		var alert_text = "ERROR: MUST COMPLETE BOTH CONCENTRATION INPUTS OR LEAVE BOTH BLANK.";
		if(lang == "es") {
			alert_text = "ERROR: NECESITA COMPLETAR LOS DOS CAMPOS DE CONCETRACION O DEJARLOS VACIOS.";
		}
		alert(alert_text);
	}

	var quantity = $("#quantity_input").val();
	var quantity_units = $("#quantity_select").val();
	var quantity_units_other = "";
	if(quantity_units == "other") {
		quantity_units_other = $("#other_quantity_units_input");
		if(!quantity_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER QUANTITY UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE CANTIDAD O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	} 

	var route = $("#route_select").val();
	var route_other = "";
	if(route == "other") {
		route_other = $("#other_route_input");
		if(!route_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER ROUTE INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR EL CAMPA DE RUTA O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	}

	var prn = $("input[name=when]:checked").val();

	var dosage = $("#dosage_input").val();
	var dosage_units = $("#dosage_select").val();
	var dosage_units_other = "";
	if(dosage_units == "other") {
		dosage_units_other = $("#other_dosage_units_input");
		if(!dosage_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER DOSAGE UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE DOSIS O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	} 

	var frequency = $("#frequency_select").val();
	var frequency_other = "";
	if(frequency == "other") {
		frequency_other = $("#other_frequency_input");
		if(!frequency_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER FREQUENCY INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE FRECUENCIA O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	}

	var duration = $("#duration_input").val();
	var duration_units = $("#duration_select").val();
	var duration_units_other = "";
	if(duration_units == "other") {
		duration_units_other = $("#other_duration_units_input");
		if(!duration_units_other) {
			valid_submission = false;
			var alert_text = "ERROR: MUST COMPLETE OTHER DURATION UNITS INPUT OR SELECT ANOTHER OPTION.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA COMPLETAR OTRO UNIDADES DE DURACION O ESCOGER OTRA OPCION.";
			}
			alert(alert_text);
		}
	} 

	//GET ALL VALUES
	var notes = $("#notes_input").val();
	extra_text += "&other=" + information + "&strength=" + strength + "&strength_units=" + strength_units + "&strength_units_other=" + strength_units_other + "&conc_part_one=" + conc_part_one + "&conc_part_one_units=" + conc_part_one_units + "&conc_part_one_units_other=" + conc_part_one_units_other + "&conc_part_two=" + conc_part_two + "&conc_part_two_units=" + conc_part_two_units + "&conc_part_two_units_other=" + conc_part_two_units_other + "&quantity=" + quantity + "&quantity_units=" + quantity_units + "&quantity_units_other=" + quantity_units_other + "&route=" + route + "&route_other=" + route_other + "&prn=" + prn + "&dosage=" + dosage + "&dosage_units=" + dosage_units + "&dosage_units_other=" + dosage_units_other + "&frequency=" + frequency + "&frequency_other=" + frequency_other + "&duration=" + duration + "&duration_units=" + duration_units + "&duration_units_other=" + duration_units_other + "&notes=" + notes;

	if (valid_submission) {
		window.location.href = "treatments_new.php?consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + "&treatment_id=" + treatment_id + "&type=" + type + "&save=2" + extra_text;
	}
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "followup.php?consult_id=" + consult_id + extra_text;
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