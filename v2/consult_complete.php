
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>


<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<style>

p {
	font-size: 18px;
	margin-bottom: 5px;
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
	require_once '../include/ExamMapping2_' . $lang . '.php';
	require_once '../include/DiagnosisTreatmentMapping_' . $lang . '.php';

	$db = new DbOperation();
	$exam_mapping;
	if($lang == "es") {
		$exam_mapping = new ExamMapping2_es();
	} else {
		$exam_mapping = new ExamMapping2_en();
	}
	$diagnosis_treatment_mapping;
	if($lang == "es") {
		$diagnosis_treatment_mapping = new DiagnosisTreatmentMapping_es();
	} else {
		$diagnosis_treatment_mapping = new DiagnosisTreatmentMapping_en();
	}

	$consult_id = 0;
	$patient_id = 0;

	if (isset($_GET['consult_id']) && isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		if(!$consult['datetime_completed']) {
			header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
		}

		if(isset($_GET['status'])) {
			$status = $_GET['status'];
			if($status > 1) {
				if($status == CONSULT_STATUS_EDIT && isset($_GET['edit_code'])) {
					$edit_code = $_GET['edit_code'];
					$valid_edit_code = $db->validateEditKey($edit_code);
					if($valid_edit_code) {
						$db->updateConsultStatus($consult_id, $status);
						header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
					} else {
						echo "<script type='text/javascript'>alert(" . INVALID_EDIT_CODE . ");</script>";
					}
				} else if ($status == CONSULT_STATUS_VIEW) {
					$db->updateConsultStatus($consult_id, $status);
					header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
				}

				
				
			}
		}
	} else {
		header($index_link);
	}


	$patient = $db->getPatientById($patient_id);	
	$consult = $db->getConsult($consult_id);


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
	}

	$formatted_datetime_started = Utilities::reformatDateForDisplay2($datetime_started);

	$display_text = CONSULT . " " . $formatted_datetime_started;
	if($in_progress) {
		$display_text .= " (" . IN_PROGRESS . ")";
	} else {
		$display_text .= " (" . COMPLETED . ")";
	}

	$has_primary_chief_complaint = $db->hasPrimaryChiefComplaint($consult_id);
	$primary_chief_complaints;
	if($has_primary_chief_complaint) {
		$primary_chief_complaints = $db->getPrimaryChiefComplaints($consult_id);
	}

	$has_secondary_chief_complaint = $db->hasSecondaryChiefComplaint($consult_id);
	$secondary_chief_complaints;
	if($has_secondary_chief_complaint) {
		$secondary_chief_complaints = $db->getSecondaryChiefComplaints($consult_id);
	}

	$has_measurements = $db->hasMeasurements($consult_id);
	$measurements;
	if($has_measurements) {
		$measurements = $db->getMeasurements($consult_id);
	}

	$has_abnormal_exam = $db->consultHasAbnormalExam($consult_id);
	$abnormal_exams;
	if($has_abnormal_exam) {
		$abnormal_exams = $db->getConsultAbnormalExams($consult_id);
	}

	$has_diagnosis = $db->hasConsultDiagnosis($consult_id);
	$diagnoses;
	if($has_diagnosis) {
		$diagnoses = $db->getDiagnoses($consult_id);
	}

	$has_treatment = $db->hasConsultTreatments($consult_id);
	$treatments;
	if($has_treatment) {
		$treatments = $db->getTreatments($consult_id);
	}

	$has_followup = $db->hasExistingFollowup($consult_id);
	$followup;
	if($has_followup) {
		$followup = $db->getFollowup($consult_id);
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
			<p class="content_p consult_section"><?php echo $display_text; ?></p>
		</div>
	</div>

	<div class="row row3">

		<div class="col-xs-12">
			<p class="content_p"><?php echo PRIMARY_CHIEF_COMPLAINTS; ?></p>
			<?php
				if($has_primary_chief_complaint) {
					$text = "";
					foreach($primary_chief_complaints as $chief_complaint) {
						$is_custom = $chief_complaint['type_is_custom'];
						$type = $chief_complaint['type'];
						if($is_custom == BOOLEAN_FALSE) {
							$text .= DEFAULT_CHIEF_COMPLAINT_LABELS[$type] . ", ";
						} else {
							$text .= $type . ", ";
						}
					}
					$text = substr($text, 0, -2);
					echo "<p>$text</p>";
				} else {
					echo "<p>" . NONE . "</p>";
				}
			?>

			<p class="content_p"><?php echo SECONDARY_CHIEF_COMPLAINTS; ?></p>
			<?php
			if($has_secondary_chief_complaint) {
				$text = "";
					foreach($secondary_chief_complaints as $chief_complaint) {
						$is_custom = $chief_complaint['type_is_custom'];
						$type = $chief_complaint['type'];
						if($is_custom == BOOLEAN_FALSE) {
							$text .= DEFAULT_CHIEF_COMPLAINT_LABELS[$type] . ", ";
						} else {
							$text .= $type . ", ";
						}
					}
					$text = substr($text, 0, -2);
					echo "<p>$text</p>";
			} else {
				echo "<p>" . NONE . "</p>";
			}
			?>

			<p class="content_p"><?php echo VITAL_SIGNS_MEASUREMENTS; ?></p>
			<?php
				if($has_measurements) {
					$temperature_units = $measurements['temperature_units'];
					$temperature_value = $measurements['temperature_value'];

					$blood_pressure_systolic = $measurements['blood_pressure_systolic'];
					$blood_pressure_diastolic = $measurements['blood_pressure_diastolic'];

					$pulse_rate = $measurements['pulse_rate'];

					$blood_oxygen_saturation = $measurements['blood_oxygen_saturation'];
					
					$weight_units = $measurements['weight_units'];
					$weight_value = $measurements['weight_value'];

					$none = true;

					if($weight_value) {
						if($weight_units == WEIGHT_UNITS_POUNDS || $weight_units == WEIGHT_UNITS_KILOGRAMS) {
							$none = false;
							$kg_value = Utilities::convertLBtoKG($weight_value);
							echo "<p>" . WEIGHT . $weight_value . " " . POUNDS_ABBREVIATION . " (" . $kg_value . " " . KILOGRAMS_ABBREVIATION . ")</p>";
						} else if ($weight_units == WEIGHT_UNITS_KILOGRAMS) {
							$none = false;
							$lb_value = Utilities::convertKGtoLB($weight_value);
							echo "<p>" . WEIGHT . $lb_value . " " . POUNDS_ABBREVIATION . " (" . $weight_value . " " . KILOGRAMS_ABBREVIATION . ")</p>";
						}
					}

					if($blood_pressure_systolic && $blood_pressure_diastolic) {
						$none = false;
						echo "<p>" . BP . $blood_pressure_systolic . "/" . $blood_pressure_diastolic . "</p>";
					}

					if($temperature_value) {
						if($temperature_units == TEMPERATURE_UNITS_CELSIUS) {
							$none = false;
							echo "<p>" . TEMP .  $temperature_value . " " . CELSIUS_ABBREVIATION . "</p>";
						} else if ($temperature_units == TEMPERATURE_UNITS_FAHRENHEIT) {
							$none = false;
							echo "<p>" . TEMP .  $temperature_value . " " . FAHRENHEIT_ABBREVIATION . "</p>";
						}
					}

					if($pulse_rate) {
						$none = false;
						echo "<p>" . PULSE . $pulse_rate . "</p>";
					}

					if($blood_oxygen_saturation) {
						$none = false;
						echo "<p>" . O2_SAT . $blood_oxygen_saturation . "</p>";
					}

					if($none) {
						echo "<p>" . NONE . "</p>";
					}

				} else {
					echo "<p>" . NONE . "</p>";
				}
			?>

			<p class="content_p"><?php echo ABNORMAL_EXAMS; ?></p>
			<?php
			if($has_abnormal_exam) {
				foreach($abnormal_exams as $exam) {
					$type = $exam['type'];
					$arg1 = $exam['arg1'];
					$arg2 = $exam['arg2'];
					$arg3 = $exam['arg3'];
					$arg4 = $exam['arg4'];
					$information = $exam['information'];
					$options = $exam['options'];
					$other = $exam['other'];
					$notes = $exam['notes'];

					$text = "";
					if($information) {
						$text = $information;
					} else {
						if ($arg2 === NULL) {
							$text = $exam_mapping->getOptions($type, NULL, NULL, NULL, NULL, NULL)[$arg1];
						} else if ($arg3 === NULL) {
							$text = $exam_mapping->getOptions($type, $arg1, NULL, NULL, NULL, NULL)[$arg2];
						} else if ($arg4 === NULL) {
							$text = $exam_mapping->getOptions($type, $arg1, $arg2, NULL, NULL, NULL)[$arg3];
						} else {
							$text = $exam_mapping->getOptions($type, $arg1, $arg2, $arg3, NULL, NULL)[$arg4];
						}
					}
					$options_array = explode(",", $options);
					
					$map_options = $exam_mapping->getOptions($type, $arg1, $arg2, $arg3, $arg4, NULL);

					$text .= " (";
					foreach($options_array as $option) {
						$text .= $map_options[$option] . ", ";
					}
					if($other) {
						$text .= $other . ", ";
					}
					$text = substr($text, 0, -2);
					$text .= ")";

					if($notes) {
						$text .= ": " . $notes;
					}

					echo "<p>$text</p>";

					
				}
			} else {
				echo "<p>" . NONE . "</p>";
			}
			?>

			<p class="content_p"><?php echo DIAGNOSES; ?></p>
			<?php
			if($has_diagnosis) {
				foreach($diagnoses as $diagnosis) {
					$category = $diagnosis['category'];
					$type = $diagnosis['type'];
					$other = $diagnosis['other'];
					$notes = $diagnosis['notes'];

					$text = "";
					if($other) {
						$text = $other;
					} else {
						$text = $diagnosis_treatment_mapping->getDiagnosisOptions($category)[$type];
					}

					echo "<p>$text</p>";
				}
			} else {
				echo "<p>" . NONE . "</p>";
			}
			?>

			<p class="content_p"><?php echo TREATMENTS; ?></p>
			<?php
			if($has_treatment) {
				foreach($treatments as $treatment) {
					$diagnosis_id = $treatment['diagnosis_id'];
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

					$text1 = "";
					if($other) {
						$text1 = $other;
					} else {
						$text1 = $diagnosis_treatment_mapping->getTreatment($type);
					}

					if($strength) {
						$text1 .= " " . $strength;
						if($strength_units_other) {
							$text1 .= " " . $strength_units_other;
						} else {
							$text1 .= " " . STRENGTH_UNITS_ARRAY[$strength_units - 1];
						}
					}
					if($conc_part_one && $conc_part_two) {
						$text1 .= " " . $conc_part_one;
						if($conc_part_one_units_other) {
							$text1 .= " " . $conc_part_one_units_other;
						} else {
							$text1 .= " " . CONC_PART_ONE_UNITS_ARRAY[$conc_part_one_units - 1];
						}
						$text1 .= "/";
						$text1 .= " " . $conc_part_two;
						if($conc_part_two_units_other) {
							$text1 .= " " . $conc_part_two_units_other;
						} else {
							$text1 .= " " . CONC_PART_TWO_UNITS_ARRAY[$conc_part_two_units - 1];
						}
					}
					if($quantity) {
						$text1 .= ": " . $quantity;
						if($quantity_units_other) {
							$text1 .= " " . $quantity_units_other;
						} else {
							$text1 .= " " . QUANTITY_UNITS_ARRAY[$quantity_units - 1];
						}
					}

					$text2 = "";
					if($prn == 2) {
						$text2 .= PRN . " ";
					} else if ($prn == 1) {
						$text2 .= SCHEDULED . " ";
					}
					if($route_other) {
						$text2 .= $route_other;
					} else if ($route) {
						$text2 .= ROUTE_ARRAY[$route - 1];
					}
					if($text2) {
						$text2 .= ": ";
					}
					if($dosage) {
						$text2 .= $dosage;
						if($dosage_units_other) {
							$text2 .= " " . $dosage_units_other . " ";
						} else {
							$text2 .= " " . DOSAGE_UNITS_ARRAY[$dosage_units - 1] . " ";
						}
					}
					if($frequency_other) {
						$text2 .= $frequency_other;
					} else if ($route) {
						$text2 .= FREQUENCY_ARRAY[$frequency - 1];
					}
					$text3 = "";
					if($duration_units == 4) {
						$text3 .= DURATION_UNITS_ARRAY[4 - 1];
					} else if($duration) {
						$text3 .= $duration . " ";
						if($duration_units_other) {
							$text3 .= $duration_units_other;
						} else {
							$text3 .= DURATION_UNITS_ARRAY[$duration_units - 1];
						}
					}


					if($text1) {
						echo "<p>$text1</p>";
					}
					if($text2) {
						echo "<p>$text2</p>";
					}
					if($text3) {
						echo "<p>$text3</p>";
					}
					if($notes) {
						echo "<p>$notes</p>";
					}
				}
			} else {
				echo "<p>" . NONE . "</p>";
			}
			?>

			<p class="content_p"><?php echo FOLLOWUP; ?></p>
			<?php
			if($has_followup) {
				$is_needed = $followup['is_needed'];
				$is_type_custom = $followup['is_type_custom'];
				$type = $followup['type'];
				$is_reason_custom = $followup['is_reason_custom'];
				$reason = $followup['reason'];

				if($is_needed == BOOLEAN_TRUE) {
					$text1 = "";
					$text2 = "";
					if($is_type_custom == BOOLEAN_TRUE) {
						$text1 = $type;
						$text2 = $reason;
					} else {
						$text1 = TYPE_ARRAY[$type];
						if($is_reason_custom == BOOLEAN_TRUE) {
							$text2 = $reason;
						} else {
							$text2 = REASON_MAP[$type][$reason];
						}
					}
					echo "<p>$text1</p>";
					echo "<p>$text2</p>";
				} else {
					echo "<p>" . NOT_NEEDED . "</p>";
				}
			} else {
				echo "<p>" . NONE . "</p>";
			}
			?>

			<p class="content_p"><?php echo SIGNATURE; ?></p>
			<?php
			$medical_group = $consult['medical_group'];
			$chief_physician = $consult['chief_physician'];
			$signing_physician = $consult['signing_physician'];
			$location = $consult['location'];
			$community = $db->getCommunityById($location)['name'];

			echo "<p>$medical_group</p>";
			echo "<p> " . CHIEF . ": " . $chief_physician. "</p>";
			echo "<p> " . SIGNING . ": " . $signing_physician. "</p>";
			echo "<p>" . LOCATION . ": " . $community . "</p>";

			?>

			<div id="button_row" class="row input_row">
				<div id="button_col" class="col-xs-12">
					<button class="consult_button" type="button" onclick="view(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo VIEW_DETAILS; ?></button>
				</div>
			</div>

		</div>

	</div>

</div>

<script type="text/javascript">

function nameClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "profile.php?id=" + patient_id + extra_text;
}

function view(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href= "consult_complete.php?consult_id=" + consult_id + "&patient_id=" + patient_id + "&status=2" + extra_text;
}




</script>

