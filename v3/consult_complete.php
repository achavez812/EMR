<!DOCTYPE html>
<html onclick="closeNav();">

<?php
	require_once 'include/include.php';


	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$patient_id = INVALID_VALUE;
	$consult = "";
	if(isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		$patient_id = $consult['patient_id'];

		if(isset($_GET['edit_code'])) {
			$setting_edit_code = $db->getSettings()['edit_code'];
			if($setting_edit_code == $_GET['edit_code']) {
				$db->updateConsultStatus($patient_id, $consult_id, CONSULT_STATUS_EDITABLE);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id);
			}
		}
	} else {
		header("LOCATION: index.php?lang=" . $lang);
	}



	$consult_datetime_completed = $consult['datetime_completed'];
	$consult_formatted_date = Utilities::formatDateForDisplay($consult_datetime_completed);

	$patient = $db->getPatient($patient_id);
	$name = $patient[PATIENTS_COLUMN_NAME];
	$patient_sex = $patient[PATIENTS_COLUMN_SEX];
	$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];
	$age_string = Utilities::getCurrentAgeString($date_of_birth, $lang);

	if($lang == "es") {
		echo '<script type="text/javascript" src="js/Constants_es.js"></script>';
	} else {
		echo '<script type="text/javascript" src="js/Constants_en.js"></script>';
	}

	$has_primary_chief_complaint = $db->hasChiefComplaints($consult_id, CHIEF_COMPLAINT_PRIMARY);
	$primary_chief_complaints;
	if($has_primary_chief_complaint) {
		$primary_chief_complaints = $db->getAllChiefComplaints($consult_id, CHIEF_COMPLAINT_PRIMARY);
	}

	/*
	$has_primary_chief_complaint = $db->hasChiefComplaints($consult_id, CHIEF_COMPLAINT_SECONDARY);
	$primary_chief_complaints;
	if($has_primary_chief_complaint) {
		$primary_chief_complaints = $db->getAllChiefComplaints($consult_id, CHIEF_COMPLAINT_SECONDARY);
	}
	*/

	$edit_code = $db->getSettings()['edit_code'];
	if(!$edit_code) {
		$edit_code = ""; 
	}

	$has_measurements = $db->consultHasMeasurements($consult_id);
	$measurements;
	if($has_measurements) {
		$measurements = $db->getMeasurements($consult_id);
	}

	$has_abnormal_exam = $db->consultHasExams($consult_id, BOOLEAN_FALSE);
	$abnormal_exams;
	if($has_abnormal_exam) {
		$abnormal_exams = $db->getExams($consult_id, BOOLEAN_FALSE);
	}

	$has_normal_exam = $db->consultHasExams($consult_id, BOOLEAN_TRUE);
	$normal_exams;
	if($has_normal_exam) {
		$normal_exams = $db->getExams($consult_id, BOOLEAN_TRUE);
	}

	$has_diagnosis = $db->consultHasDiagnosis($consult_id);
	$diagnoses;
	if($has_diagnosis) {
		$diagnoses = $db->getDiagnoses($consult_id);
	}

	$has_treatment = $db->consultHasTreatment($consult_id);
	$treatments;
	if($has_treatment) {
		$treatments = $db->getTreatments($consult_id);
	}

	$has_followup = $db->consultHasFollowup($consult_id);
	$followup;
	if($has_followup) {
		$followup = $db->getFollowup($consult_id);
	}
	


?>

<script>
	var edit_code = <?php echo $edit_code; ?>;
</script>

<div id="mySidenav" class="sidenav">
  	<a href="#"><?php echo SETTINGS; ?></a>
</div>
<div id="content" class="container-fluid" onclick="closeNav();">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo COMPLETED_CONSULT; ?></span>
			<img id="navigation_header_menu" src="images/menu.png" alt="Menu" height="28px" width="28px">
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

	<div class="row">
		<div class="col-xs-12">
			<p class="left_title underline"><?php echo CONSULT . " " . $consult_formatted_date; ?></p>
			<p class="left_title4"><?php echo CHIEF_COMPLAINTS; ?></p>
			<?php
				if($has_primary_chief_complaint) {
					$text = "";
					foreach($primary_chief_complaints as $chief_complaint) {
						$custom_text = $chief_complaint['custom_text'];
						$selected_value = $chief_complaint['selected_value'];
						if(!$custom_text) {
							$text .= DEFAULT_CHIEF_COMPLAINT_MAP[$selected_value] . ", ";
						} else {
							$text .= $custom_text . ", ";
						}
					}
					$text = substr($text, 0, -2);
					echo "<p class='left_title3'>$text</p>";
				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo VITALS_MEASUREMENTS; ?></p>
			<?php
				if($has_measurements) {
					$is_pregnant = $measurements['is_pregnant'];

					$temperature_units = $measurements['temperature_units'];
					$temperature_value = $measurements['temperature_value'];

					$blood_pressure_systolic = $measurements['blood_pressure_systolic'];
					$blood_pressure_diastolic = $measurements['blood_pressure_diastolic'];

					$pulse_rate = $measurements['pulse_rate'];
					$respiration_rate = $measurements['respiration_rate'];

					$blood_oxygen_saturation = $measurements['blood_oxygen_saturation'];

					$waist_circumference_units = $measurements['waist_circumference_units'];
					$waist_circumference_value = $measurements['waist_circumference_value'];
					
					$weight_units = $measurements['weight_units'];
					$weight_value = $measurements['weight_value'];

					$height_units = $measurements['height_units'];
					$height_value = $measurements['height_value'];

					if($is_pregnant) {
						if($is_pregnant == BOOLEAN_TRUE) {
							echo "<p class='left_title3'>" . PATIENT_IS_PREGNANT . "</p>";
						}
					}
					if($temperature_value && $temperature_units) {
						if($temperature_units == TEMPERATURE_UNITS_CELSIUS) {
							echo "<p class='left_title3'>" . TEMPERATURE_FIELD .  $temperature_value . " " . CELSIUS_ABBREVIATION . "</p>";
						} else if ($temperature_units == TEMPERATURE_UNITS_FAHRENHEIT) {
							echo "<p class='left_title3'>" . TEMPERATURE_FIELD .  $temperature_value . " " . FAHRENHEIT_ABBREVIATION . "</p>";
						}
					}

					if($blood_pressure_systolic && $blood_pressure_diastolic) {
						echo "<p class='left_title3'>" . BLOOD_PRESSURE_FIELD . " " . $blood_pressure_systolic . "/" . $blood_pressure_diastolic . "</p>";
					}

					if($pulse_rate) {
						echo "<p class='left_title3'>" . PULSE_RATE . ": " . $pulse_rate . "</p>";
					}

					if($respiration_rate) {
						echo "<p class='left_title3'>" . RESPIRATION_RATE . ": " . $respiration_rate . "</p>";
					}

					if($blood_oxygen_saturation) {
						echo "<p class='left_title3'>" . BLOOD_OXYGEN_SATURATION . ": " . $blood_oxygen_saturation . "</p>";
					}

					if($waist_circumference_units && $waist_circumference_value) {
						if($waist_circumference_units == HEIGHT_UNITS_CENTIMETERS) {
							$in_value = Utilities::convertCMtoIN($waist_circumference_value);
							echo "<p class='left_title3'>" . WAIST_CIRCUMFERENCE_FIELD . " " . $waist_circumference_value . " " . CENTIMETERS_ABBREVIATION . " (" . $in_value . " " . INCHES_ABBREVIATION . ")</p>";
						} else if ($waist_circumference_units == HEIGHT_UNITS_INCHES) {
							$cm_value = Utilities::convertINtoCM($waist_circumference_value);
							echo "<p class='left_title3'>" . WAIST_CIRCUMFERENCE_FIELD . " " . $cm_value . " " . CENTIMETERS_ABBREVIATION . " (" . $waist_circumference_value . " " . INCHES_ABBREVIATION . ")</p>";
						}
					}

					$weight_kg = -1;
					if($weight_units && $weight_value) {
						if($weight_units == WEIGHT_UNITS_POUNDS) {
							$weight_kg = Utilities::convertLBtoKG($weight_value);
							echo "<p class='left_title3'>" . WEIGHT_FIELD . " " . $weight_value . " " . POUNDS_ABBREVIATION . " (" . $weight_kg . " " . KILOGRAMS_ABBREVIATION . ")</p>";
						} else if ($weight_units == WEIGHT_UNITS_KILOGRAMS) {
							$weight_kg = $weight_value;
							$lb_value = Utilities::convertKGtoLB($weight_value);
							echo "<p class='left_title3'>" . WEIGHT_FIELD . " " . $lb_value . " " . POUNDS_ABBREVIATION . " (" . $weight_value . " " . KILOGRAMS_ABBREVIATION . ")</p>";
						}
					}

					$height_cm = -1;
					if($height_units && $height_value) {
						if($height_units == HEIGHT_UNITS_CENTIMETERS) {
							$height_cm = $height_value;
							$height_in = Utilities::convertCMtoIN($height_value);
							echo "<p class='left_title3'>" . HEIGHT_FIELD . " " . $height_value . " " . CENTIMETERS_ABBREVIATION . " (" . $height_in . " " . INCHES_ABBREVIATION . ")</p>";
						} else if ($height_units == HEIGHT_UNITS_INCHES) {
							$height_cm = Utilities::convertINtoCM($height_value);
							echo "<p class='left_title3'>" . HEIGHT_FIELD . " " . $height_cm . " " . CENTIMETERS_ABBREVIATION . " (" . $height_value . " " . INCHES_ABBREVIATION . ")</p>";
						}
					}

					if($weight_kg > 0 && $height_cm > 0) {
						$bmi = Utilities::calculateBMI($weight_kg, $height_cm);
						echo "<p class='left_title3'>" . BMI_FIELD . " " . $bmi . "</p>";
					}

				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo EXAMS; ?></p>
			<?php
				if($has_abnormal_exam || $has_normal_exam) {
					if($has_normal_exam) {
						foreach($normal_exams as $exam) {
							$main_category = $exam['main_category'];
							$arg1 = $exam['arg1'];
							$arg2 = $exam['arg2'];
							$arg3 = $exam['arg3'];
							$arg4 = $exam['arg4'];
							$information = $exam['information'];

							$text = ". ";
							if($main_category) {
								$text .= EXAM_MAPPING[$main_category];
								if($arg1) {
									$text .= ' => ' . EXAM_MAPPING[$arg1];
									if($arg2) {
										$text .= ' => ' . EXAM_MAPPING[$arg2];
										if($arg3) {
											$text .= ' => ' . EXAM_MAPPING[$arg3];
											if($arg4) {
												$text .= ' => ' . EXAM_MAPPING[$arg4];
											}
										}
									}
								}
							}
							if($information) {
								$text .= ' => ' . $information;
							}
							$text .= ' ' . NORMAL_IN_PARANTHESES;
							echo "<p class='left_title3'>$text</p>";
						}
					} 
					if($has_abnormal_exam) {
						foreach($abnormal_exams as $exam) {
							$main_category = $exam['main_category'];
							$arg1 = $exam['arg1'];
							$arg2 = $exam['arg2'];
							$arg3 = $exam['arg3'];
							$arg4 = $exam['arg4'];
							$information = $exam['information'];
							$options = $exam['options'];
							$other_option = $exam['other_option'];
							$notes = $exam['notes'];

							$text = ". ";
							if($main_category) {
								$text .= EXAM_MAPPING[$main_category];
								if($arg1) {
									$text .= ' => ' . EXAM_MAPPING[$arg1];
									if($arg2) {
										$text .= ' => ' . EXAM_MAPPING[$arg2];
										if($arg3) {
											$text .= ' => ' . EXAM_MAPPING[$arg3];
											if($arg4) {
												$text .= ' => ' . EXAM_MAPPING[$arg4];
											}
										}
									}
								}
							}
							if($information) {
								$text .= ' => ' . $information;
							}

							$options_array = explode(",", $options);
							$text .= ' (';
							foreach($options_array as $option) {
								if($option != 255) {
									$text .= EXAM_MAPPING[$option] . ", ";
								}
							}
							if($other_option) {
								$text .= $other_option;
							} else {
								$text = substr($text, 0, -2);
							}
							$text .= ')';

							if($notes) {
								$text .= ': ' . $notes;
							}

							echo "<p class='left_title3'>$text</p>";
						}
					}
					
				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo DIAGNOSES; ?></p>
			<?php
				if($has_diagnosis) {
					foreach($diagnoses as $diagnosis) {
						$is_chronic = $diagnosis['is_chronic'];
						$category = $diagnosis['category'];
						$type = $diagnosis['type'];
						$other = $diagnosis['other'];
						$notes = $diagnosis['notes'];

						$text = ". ";
						if($category) {
							$text .= DIAGNOSIS_MAPPING[$category] . " => ";
						}

						if($other) {
							$text .= $other;
						} else if ($type) {
							$text .= DIAGNOSIS_MAPPING[$type];
						}

						if($is_chronic == BOOLEAN_TRUE) {
							$text .= ' (' . CHRONIC . ')';
						} else {
							$text .= ' (' . ACUTE . ')';
						}

						if($notes) {
							$text .= ': ' . $notes;
						}

						echo "<p class='left_title3'>$text</p>";
					}
				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo TREATMENTS; ?></p>
			<?php
				if($has_treatment) {
					foreach($treatments as $treatment) {
						$type = $treatment['type'];
						$other = $treatment['other'];

						$strength = $treatment['strength'];
						$strength_units = $treatment['strength_units'];
						$strength_units_other = $treatment['strength_units_other'];

						$conc_part_one = $treatment['conc_part_one'];
						$conc_part_one_units = $treatment['conc_part_one_units'];
						$conc_part_one_units_other = $treatment['conc_part_one_units_other'];

						$conc_part_two = $treatment['conc_part_two'];
						$conc_part_two_units = $treatment['conc_part_two_units'];
						$conc_part_two_units_other = $treatment['conc_part_two_units_other'];

						$quantity = $treatment['quantity'];
						$quantity_units = $treatment['quantity_units'];
						$quantity_units_other = $treatment['quantity_units_other'];

						$route = $treatment['route'];
						$route_other = $treatment['route_other'];

						$prn = $treatment['prn'];

						$dosage = $treatment['dosage'];
						$dosage_units = $treatment['dosage_units'];
						$dosage_units_other = $treatment['dosage_units_other'];

						$frequency = $treatment['frequency'];
						$frequency_other = $treatment['frequency_other'];

						$duration = $treatment['duration'];
						$duration_units = $treatment['duration_units'];
						$duration_units_other = $treatment['duration_units_other'];

						$notes = $treatment['notes'];

						$text = ". ";
						if($other) {
							$text .= $other;
						} else if($type) {
							$text .= TREATMENT_MAPPING[$type];
						}



						if($strength) {
							$text .= " " . $strength . " ";
							if($strength_units_other) {
								$text .= $strength_units_other;
							} else {
								$text .= STRENGTH_UNITS_ARRAY[$strength_units - 1];
							}
						} else if ($conc_part_one && $conc_part_two) {
							$text .= " " . $conc_part_one . " ";
							if($conc_part_one_units_other) {
								$text .= $conc_part_one_units_other;
							} else {
								$text .= CONC_PART_ONE_UNITS_ARRAY[$conc_part_one_units - 1];
							}
							$text .= "/" . $conc_part_two . " ";
							if($conc_part_two_units_other) {
								$text .= $conc_part_two_units_other;
							} else {
								$text .= CONC_PART_TWO_UNITS_ARRAY[$conc_part_two_units - 1];
							}
						}

						if($quantity) {
							$text .= ", " . $quantity . " ";
							if($quantity_units_other) {
								$text .= $quantity_units_other;
							} else {
								$text .= QUANTITY_UNITS_ARRAY[$quantity_units - 1];
							}
						}

						$parantheses_present = false;
						if($dosage) {
							if(!$parantheses_present) {
								$parantheses_present = true;
								$text .= "(";
							}
							$text .= $dosage . " ";
							if($dosage_units_other) {
								$text .= $dosage_units_other;
							} else {
								$text .= DOSAGE_UNITS_ARRAY[$dosage_units - 1];
							}
							$text .= ", ";
						}

						if($prn) {
							if(!$parantheses_present) {
								$parantheses_present = true;
								$text .= "(";
							}
							if($prn == BOOLEAN_TRUE) {
								$text .= PRN;
							} else {
								$text .= SCHEDULED;
							}
							$text .= ", ";
						}

						if(($route && $route > 1) || $route_other) {
							if(!$parantheses_present) {
								$parantheses_present = true;
								$text .= "(";
							}

							if($route_other) {
								$text .= $route_other;
							} else {
								$text .= ROUTE_ARRAY[$route - 1];
							}
							$text .= ", ";
						}

						if(($frequency && $frequency > 1) || $frequency_other) {
							if(!$parantheses_present) {
								$parantheses_present = true;
								$text .= "(";
							}

							if($frequency_other) {
								$text .= $frequency_other;
							} else {
								$text .= FREQUENCY_ARRAY[$frequency - 1];
							}
							$text .= ", ";
						}

						if($duration) {
							if(!$parantheses_present) {
								$parantheses_present = true;
								$text .= "(";
							}
							$text .= $duration . " ";
							if($duration_units_other) {
								$text .= $duration_units_other;
							} else {
								$text .= DURATION_UNITS_ARRAY[$duration_units - 1];
							}
							$text .= ", ";
						}

						if($parantheses_present) {
							$text = substr($text, 0, -2) . ")";
						}

						if($notes) {
							$text .= ': ' . $notes;
						}

						echo "<p class='left_title3'>$text</p>";

					}
				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo FOLLOWUP; ?></p>
			<?php
				if($has_followup) {
					$is_needed = $followup['is_needed'];
					$is_type_custom = $followup['is_type_custom'];
					$type = $followup['type'];
					$is_reason_custom = $followup['is_reason_custom'];
					$reason = $followup['reason'];
					$notes = $followup['notes'];

					if($is_needed == BOOLEAN_TRUE) {
						$line1_text = "";
						$line2_text = "";

						if($is_type_custom == BOOLEAN_TRUE) {
							$line1_text = $type;
						}  else {
							$line1_text = FOLLOWUP_TYPE_ARRAY[$type];

						}

						if($is_reason_custom == BOOLEAN_TRUE) {
							$line2_text = $reason;
						} else {
							$line2_text = FOLLOWUP_REASON_MAP[$type][$reason];
						}
						echo "<p class='left_title3'>$line1_text</p>";
						echo "<p class='left_title3'>$line2_text</p>";
						if($notes) {
							echo "<p class='left_title3'>$notes</p>";
						}

					} else  {
						echo "<p class='left_title3'>" . NOT_NEEDED . "</p>";
					}

				} else {
					echo "<p class='left_title3'>" . NO_INFORMATION . "</p>";
				}
			?>
			<p class="left_title4"><?php echo SIGNATURE_INFORMATION; ?></p>
			<?php
				$medical_group = $consult['medical_group'];
				$chief_physician = $consult['chief_physician'];
				$signing_physician = $consult['signing_physician'];
				$location = $consult['location'];
				$notes = $consult['notes'];

				echo "<p class='left_title3'>" . MEDICAL_GROUP_FIELD . " " . $medical_group . "</p>";
				echo "<p class='left_title3'>" . CHIEF_PHYSICIAN_FIELD . " " . $chief_physician . "</p>";
				echo "<p class='left_title3'>" . SIGNING_PHYSICIAN_FIELD . " " . $signing_physician . "</p>";
				echo "<p class='left_title3'>" . LOCATION_FIELD . " " . $location . "</p>";
				if($notes) {
					echo "<p class='left_title3'>$notes</p>";
				}
			?>	
		</div>
	</div>

	<div id="button_row" class="row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="editClick(<?php echo "'" . $consult_id . "', '" . $mode . "'"; ?>);"><?php echo EDIT_CAPS; ?></button>
		</div>
	</div>


</div>

<div id="myEditModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	 	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 id="modal_header" class="modal-title"><?php echo EDIT_VALIDATION; ?></h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="input_row">
		        	<p class="input_label"><?php echo EDIT_CODE . ":"; ?></p>
		        	<input id='edit_code_input' class='input_field'>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button id="submit_button" type="button" class="btn btn-default" onclick="editSubmitClick(<?php echo "'" . $consult_id . "', '" . $mode . "'"; ?>);"><?php echo SUBMIT; ?></button>
	      	</div>
	    </div>

	</div>
</div>



<script>

function backClick(mode, patient_id) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function editClick(consult_id, mode) {
	$("#myEditModal").modal('show');
}

function editSubmitClick(consult_id, mode) {
	if($("#edit_code_input").val() == edit_code) {
		var lang_text = getLang(1);
		window.location.href = "consult_complete.php?edit_code=1234&mode=" + mode + "&consult_id=" + consult_id + lang_text;
	} else {
		alert(INCORRECT);
	}
}



</script>




</html>
