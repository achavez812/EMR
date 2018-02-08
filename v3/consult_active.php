<!DOCTYPE html>
<html onclick="closeNav();">

<?php
	require_once 'include/include.php';


	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}
	$consult_id = INVALID_VALUE;
	$patient_id = INVALID_VALUE;
	$consult_status;
	$consult;
	$patient;

	$show_consult_option = 0;
	if(isset($_GET[SHOW_ARG])) {
		$show_consult_option = $_GET[SHOW_ARG];
		/*
		if($show_consult_option == SHOW_EXAMS) {
			$EXAMS_MAPping_file = "include/ExamMapping_en.php";
			if($lang == "es") {
				$EXAMS_MAPping_file = "include/ExamMapping_es.php";
			}
			require_once $EXAMS_MAPping_file;
		}
		*/
	}

	if(isset($_GET[CONSULT_ID_ARG])) {
		$consult_id = $_GET[CONSULT_ID_ARG];
		$consult = $db->getConsult($consult_id);
		$current_consult_status = $consult[CONSULTS_COLUMN_STATUS];
		$patient_id = $consult[CONSULTS_COLUMN_PATIENT_ID];

		if(isset($_GET['delete_code'])) {
			$triage_intake_status = $db->getTriageIntakeStatus($consult_id);
			$medical_consult_status = $db->getMedicalConsultStatus($consult_id);
			if($triage_intake_status == CONSULT_STATUS_READY_FOR_TRIAGE_PENDING && $medical_consult_status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_PENDING) {
				$db->deleteConsult($consult_id, $patient_id);
				header("LOCATION: profile.php?lang=" . $lang . "&mode=" . $mode . "&patient_id=" . $patient_id);
			} else {
				echo '<script>';
				echo 'alert("' . CANNOT_DELETE_CONSULT_MESSAGE . '");';
				echo '</script>';
			}
		}

		if(isset($_GET[SAVE_ARG])) {
			if(isset($_GET[PRIMARY_CHIEF_COMPLAINTS_ARG])) {
				$primary = $_GET[PRIMARY_CHIEF_COMPLAINTS_ARG];
				$secondary = $_GET[SECONDARY_CHIEF_COMPLAINTS_ARG];
				$db->createChiefComplaints($patient_id, $current_consult_status, $consult_id, CHIEF_COMPLAINT_PRIMARY, $primary);
				$db->createChiefComplaints($patient_id, $current_consult_status, $consult_id, CHIEF_COMPLAINT_SECONDARY, $secondary);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id . "&show=" . $show_consult_option);
			} else if(isset($_GET[HPI_TYPE_ARG]) && isset($_GET[CHIEF_COMPLAINT_ID_ARG])) {
				$chief_complaint_id = $_GET[CHIEF_COMPLAINT_ID_ARG];
				$hpi_type = $_GET[HPI_TYPE_ARG];
				if($hpi_type == HPI_TYPE_PREGNANCY) {
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

					$empty = true;

					if(!$num_weeks_pregnant) {
						$num_weeks_pregnant = NULL;
					} else {
						$empty = false;
					}
					if(!$receiving_prenatal_care) {
						$receiving_prenatal_care = NULL;
					} else {
						$empty = false;
					}
					if(!$taking_prenatal_vitamins) {
						$taking_prenatal_vitamins = NULL;
					} else {
						$empty = false;
					}
					if(!$received_ultrasound) {
						$received_ultrasound = NULL;
					} else {
						$empty = false;
					} 
					if(!$num_live_births && $num_live_births !== '0') {
						$num_live_births = NULL;
					} else {
						$empty = false;
					} 
					if(!$num_miscarriages && $num_miscarriages !== '0') {
						$num_miscarriages = NULL;
					} else {
						$empty = false;
					} 
					if(!$dysuria_urgency_frequency) {
						$dysuria_urgency_frequency = NULL;
					} else {
						$empty = false;
					} 
					if(!$abnormal_vaginal_discharge) {
						$abnormal_vaginal_discharge = NULL;
					} else {
						$empty = false;
					} 
					if(!$vaginal_bleeding) {
						$vaginal_bleeding = NULL;
					} else {
						$empty = false;
					} 
					if(!$previous_pregnancy_complications) {
						$previous_pregnancy_complications = NULL;
					} else {
						$empty = false;
					}
					if(!$complications_notes) {
						$complications_notes = NULL;
					} else {
						$empty = false;
					} 
					if(!$notes) {
						$notes = NULL;
					} else {
						$empty = false;
					} 

					if($empty) {
						$db->deletePregnancyHPI($chief_complaint_id);
					} else {
						$db->createPregnancyHPI($chief_complaint_id, $consult_id, $num_weeks_pregnant, $receiving_prenatal_care, $taking_prenatal_vitamins, $received_ultrasound, $num_live_births, $num_miscarriages, $dysuria_urgency_frequency, $abnormal_vaginal_discharge, $vaginal_bleeding, $previous_pregnancy_complications, $complications_notes, $notes);
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

					$empty = true;

					if(!$o_pain_how && $o_pain_how != '0') {
						$o_pain_how = NULL;
					} else {
						$empty = false;
					}  
					if(!$o_pain_cause && $o_pain_cause != '0') {
						$o_pain_cause = NULL;
					} else {
						$empty = false;
					}  
					if(!$p_pain_provocation && $p_pain_provocation != '0') {
						$p_pain_provocation = NULL;
					} else {
						$empty = false;
					}  
					if(!$p_pain_palliation && $p_pain_palliation != '0') {
						$p_pain_palliation = NULL;
					} else {
						$empty = false;
					}  
					if(!$q_pain_type && $q_pain_type != '0') {
						$q_pain_type = NULL;
					} else {
						$empty = false;
					}  
					if(!$r_pain_region_main && $r_pain_region_main != '0') {
						$r_pain_region_main = NULL;
					} else {
						$empty = false;
					} 
					if(!$r_pain_region_radiates && $r_pain_region_radiates != '0') {
						$r_pain_region_radiates = NULL;
					} else {
						$empty = false;
					}  
					if(!$s_pain_level && $s_pain_level != '0') {
						$s_pain_level = NULL;
					} else {
						$empty = false;
					}  
					if(!$t_pain_begin_time) {
						$t_pain_begin_time = NULL;
					} else {
						$empty = false;
					}  
					if ($t_pain_before == 'yes') {
						$empty = false;
						$t_pain_before = BOOLEAN_TRUE;
					} else if ($t_pain_before == 'no') {
						$empty = false;
						$t_pain_before = BOOLEAN_FALSE;
					} else {
						$t_pain_before = NULL;
					}
					if ($t_pain_current == 'yes') {
						$empty = false;
						$t_pain_current = BOOLEAN_TRUE;
					} else if ($t_pain_current == 'no') {
						$empty = false;
						$t_pain_current = BOOLEAN_FALSE;
					} else {
						$t_pain_current = NULL;
					}
					if(!$notes) {
						$notes = NULL;
					} else {
						$empty = false;
					}  

					if(isset($_GET['name'])) {
						$name = $_GET['name'];
						$db->updateCustomChiefComplaint($chief_complaint_id, $name);
					}

					if($empty) {
						$db->deleteGeneralHPI($chief_complaint_id);
					} else {
						$db->createGeneralHPI($chief_complaint_id, $consult_id, $o_pain_how, $o_pain_cause, $p_pain_provocation, $p_pain_palliation, $q_pain_type, $r_pain_region_main, $r_pain_region_radiates, $s_pain_level, $t_pain_begin_time, $t_pain_before, $t_pain_current, $notes);
					}			
				}
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id . "&show=" . $show_consult_option);
			} else if (isset($_GET['is_pregnant'])) {
				$empty = true;

				$is_pregnant = $_GET['is_pregnant'];
				if(!$is_pregnant) {
					$is_pregnant = NULL;
				} else {
					$empty = false;
				}  
				$date_last_menstruation = $_GET['date_last_menstruation'];
				if(!$date_last_menstruation) {
					$date_last_menstruation = NULL;
				} else {
					$empty = false;
				} 
				$temperature_units = $_GET['temperature_units'];
				if (!$temperature_units) {
					$temperature_units = NULL;
				} else {
					$empty = false;
				} 			
				$temperature_value = $_GET['temperature_value'];
				if (!$temperature_value) {
					$temperature_value = NULL;
				} else {
					$empty = false;
				}  
				$blood_pressure_systolic = $_GET['blood_pressure_systolic'];
				if(!$blood_pressure_systolic) {
					$blood_pressure_systolic = NULL;
				} else {
					$empty = false;
				}  
				$blood_pressure_diastolic = $_GET['blood_pressure_diastolic'];
				if(!$blood_pressure_diastolic) {
					$blood_pressure_diastolic = NULL;
				} else {
					$empty = false;
				}
				$pulse_rate = $_GET['pulse_rate'];
				if(!$pulse_rate) {
					$pulse_rate = NULL;
				} else {
					$empty = false;
				}
				$blood_oxygen_saturation = $_GET['blood_oxygen_saturation'];
				if(!$blood_oxygen_saturation) {
					$blood_oxygen_saturation = NULL;
				} else {
					$empty = false;
				}
				$respiration_rate = $_GET['respiration_rate'];
				if(!$respiration_rate) {
					$respiration_rate = NULL;
				} else {
					$empty = false;
				}
				$weight_units = $_GET['weight_units'];
				if(!$weight_units) {
					$weight_units = NULL;
				} else {
					$empty = false;
				}
				$weight_value = $_GET['weight_value'];
				if(!$weight_value) {
					$weight_value = NULL;
				} else {
					$empty = false;
				}
				$height_units = $_GET['height_units'];
				if(!$height_units) {
					$height_units = NULL;
				} else {
					$empty = false;
				}
				$height_value = $_GET['height_value'];
				if(!$height_value) {
					$height_value = NULL;
				} else {
					$empty = false;
				}
				$waist_circumference_units = $_GET['waist_circumference_units'];
				if(!$waist_circumference_units) {
					$waist_circumference_units = NULL;
				} else {
					$empty = false;
				}
				$waist_circumference_value = $_GET['waist_circumference_value'];
				if(!$waist_circumference_value) {
					$waist_circumference_value = NULL;
				} else {
					$empty = false;
				}
				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				} else {
					$empty = false;
				}

				if($empty) {
					$db->deleteConsultMeasurements($patient_id, $current_consult_status, $consult_id);
				} else {
					$db->createMeasurements($patient_id, $current_consult_status, $consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $height_units, $height_value, $weight_units, $weight_value, $waist_circumference_units, $waist_circumference_value, $notes);
				}

				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id . "&show=" . $show_consult_option);
			} else if (isset($_GET['main_category'])) { //EXAM SAVE
				$exam_id = $_GET['exam_id'];
				$main_category = $_GET['main_category'];
				$arg1 = $_GET['arg1'];
				$arg2 = $_GET['arg2'];
				$arg3 = $_GET['arg3'];
				$arg4 = $_GET['arg4'];
				$is_normal = $_GET['is_normal'];
				$information = $_GET['information'];
				$options = $_GET['options'];
				$other_option = $_GET['other_option'];
				$notes = $_GET['notes'];

				if(!$main_category) {
					$main_category = NULL;
				}

				if(!$arg1) {
					$arg1 = NULL;
				}

				if(!$arg2) {
					$arg2 = NULL;
				}

				if(!$arg3) {
					$arg3 = NULL;
				}

				if(!$arg4) {
					$arg4 = NULL;
				}

				if(!$is_normal) {
					$is_normal = NULL;
				}

				if(!$information) {
					$information = NULL;
				}

				if(!$options) {
					$options = NULL;
				}

				if(!$other_option) {
					$other_option = NULL;
				}

				if(!$notes) {
					$notes = NULL;
				}

				if(!$exam_id) {
					$db->createExam($consult_id, $patient_id, $current_consult_status, $is_normal, $main_category, $arg1, $arg2, $arg3, $arg4, $information, $options, $other_option, $notes);
				} else {
					$db->updateExam($exam_id, $consult_id, $is_normal, $main_category, $arg1, $arg2, $arg3, $arg4, $information, $options, $other_option, $notes);
				}
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=4&consult_id=" . $consult_id . "&main_category=" . $main_category . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&arg3=" . $arg3 . "&arg4=" . $arg4);
			} else if(isset($_GET['diagnosis_id']) && !isset($_GET['treatment_id'])) {
				$diagnosis_id = $_GET['diagnosis_id'];
				$option = $_GET['option'];
				$category = $_GET['category'];
				$other = $_GET['other'];
				$is_chronic = $_GET['is_chronic'];
				$notes = $_GET['notes'];

				if(!$option) {
					$option = NULL;
				}
				if(!$category) {
					$category = NULL;
				}
				if(!$other) {
					$other = NULL;
				}
				if(!$is_chronic) {
					$is_chronic = NULL;
				}
				if(!$notes) {
					$notes = NULL;
				}
				if(!$diagnosis_id) {
					$db->createDiagnosis($patient_id, $consult_id, $current_consult_status, $is_chronic, $category, $option, $other, $notes);
				} else {
					$db->updateDiagnosis($diagnosis_id, $is_chronic, $other, $notes);
				}
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=5&consult_id=" . $consult_id . "&category=" . $category . "&option=" . $option);
			} else if (isset($_GET['treatment_id'])) {
				$diagnosis_option = $_GET['diagnosis_option'];
				$diagnosis_text = $_GET['diagnosis_text'];

				$diagnosis_id = $_GET['diagnosis_id'];
				$treatment_id = $_GET['treatment_id'];
				if(!$diagnosis_id) {
					$diagnosis_id = NULL;
				}
				$type = $_GET['type'];
				if($type === "") {
					$type = NULL;
				}
				$other = $_GET['other'];
				if($other === "") {
					$other = NULL;
				} else {
					$type = NULL;
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

				$add_to_medication_history = $_GET['add_to_medication_history'];
				if($add_to_medication_history === "") {
					$add_to_medication_history = NULL;
				}

				if(!$treatment_id) {
					$db->createTreatment($current_consult_status, $patient_id, $consult_id, $diagnosis_id, $type, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes, $add_to_medication_history);
				} else {
					$db->updateTreatment($patient_id, $consult_id, $treatment_id, $type, $other, $strength, $strength_units, $strength_units_other, $conc_part_one, $conc_part_one_units, $conc_part_one_units_other, $conc_part_two, $conc_part_two_units, $conc_part_two_units_other, $quantity, $quantity_units, $quantity_units_other, $route, $route_other, $prn, $dosage, $dosage_units, $dosage_units_other, $frequency, $frequency_other, $duration, $duration_units, $duration_units_other, $notes, $add_to_medication_history);
				}

				if($diagnosis_id === NULL) {
					$diagnosis_id = -1;
				}
				if(!$diagnosis_text) {
					$diagnosis_text = "";
				}
				
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=6&consult_id=" . $consult_id . "&diagnosis_id=" . $diagnosis_id . "&diagnosis_option=" . $diagnosis_option . "&diagnosis_text=" . $diagnosis_text);
			} else if (isset($_GET['reason'])) {
				$is_needed = $_GET['is_needed'];
				if(!$is_needed) {
					$is_needed = NULL;
				}
				$is_type_custom = $_GET['is_type_custom'];
				if(!$is_type_custom) {
					$is_type_custom = NULL;
				}
				$type = $_GET['type'];
				if(!$type) {
					$type = NULL;
				}
				$is_reason_custom = $_GET['is_reason_custom'];
				if(!$is_reason_custom) {
					$is_reason_custom = NULL;
				}
				$reason = $_GET['reason'];
				if(!$reason) {
					$reason = NULL;
				}
				$notes = $_GET['notes'];
				if(!$notes) {
					$notes = NULL;
				}

				$db->createFollowup($patient_id, $current_consult_status, $consult_id, $is_needed, $is_type_custom, $type, $is_reason_custom, $reason, $notes);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id);
			} else if (isset($_GET['medical_group'])) {
				$location = $_GET['location'];
				$medical_group = $_GET['medical_group'];
				$chief_physician = $_GET['chief_physician'];
				$signing_physician = $_GET['signing_physician'];
				$notes = $_GET['notes'];
				$complete = $_GET['complete'];

				if(!$location) {
					$location = NULL;
				}

				if(!$medical_group) {
					$medical_group = NULL;
				}

				if(!$chief_physician) {
					$chief_physician = NULL;
				}

				if(!$signing_physician) {
					$signing_physician = NULL;
				}

				if(!$notes) {
					$notes = NULL;
				}

				$datetime = NULL;
				if($complete == 2) {
					$datetime = Utilities::getCurrentDateTime();
				}

				$db->updateConsult($consult_id, $medical_group, $chief_physician, $signing_physician, $location, $notes, $datetime);
				if($complete == 2) {
					header("LOCATION: profile.php?lang=" . $lang . "&mode=" . $mode . "&patient_id=" . $patient_id);
				} else {
					header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id);
				}
			}
		} else if(isset($_GET[DELETE_ARG])) {
			if(isset($_GET[CHIEF_COMPLAINT_ID_ARG])) {
				$chief_complaint_id = $_GET[CHIEF_COMPLAINT_ID_ARG];
				$db->deleteChiefComplaint($patient_id, $consult_id, $current_consult_status, $chief_complaint_id); //ALSO DELETES ASSOCIATED HPI IF PRESENT
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id . "&show=" . $show_consult_option);
			} else if (isset($_GET['exam_id'])) {
				$exam_id = $_GET['exam_id'];
				$main_category = $_GET['main_category'];
				$arg1 = $_GET['arg1'];
				$arg2 = $_GET['arg2'];
				$arg3 = $_GET['arg3'];
				$arg4 = $_GET['arg4'];
				$db->deleteExam($exam_id, $patient_id, $consult_id, $current_consult_status);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=4&consult_id=" . $consult_id . "&main_category=" . $main_category . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&arg3=" . $arg3 . "&arg4=" . $arg4);
			} else if (isset($_GET['diagnosis_id']) && !isset($_GET['treatment_id'])) {
				$category = $_GET['category'];
				$option = $_GET['option'];
				$db->deleteDiagnosis($_GET['diagnosis_id'], $patient_id, $consult_id, $current_consult_status);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=5&consult_id=" . $consult_id . "&category=" . $category . "&option=" . $option);
			} else if (isset($_GET['treatment_id'])) {
				$diagnosis_option = $_GET['diagnosis_option'];
				$diagnosis_text = $_GET['diagnosis_text'];
				$diagnosis_id = $_GET['diagnosis_id'];

				$db->deleteTreatment($_GET['treatment_id'], $patient_id, $consult_id, $current_consult_status);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&show=6&consult_id=" . $consult_id . "&diagnosis_id=" . $diagnosis_id . "&diagnosis_option=" . $diagnosis_option . "&diagnosis_text=" . $diagnosis_text);
			} else if(isset($_GET['reason'])) { //FOLLOWUP
				$db->deleteConsultFollowup($patient_id, $consult_id, $current_consult_status);
				header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id);
			}
		}

		if(!$consult) {
			$consult = $db->getConsult($consult_id);
		}
		if($patient_id == INVALID_VALUE) {
			$patient_id = $consult[CONSULTS_COLUMN_PATIENT_ID];
		}
		if(isset($_GET[CONSULTS_COLUMN_STATUS])) {
			$status = $_GET[CONSULTS_COLUMN_STATUS];
			$consult_status = CONSULT_STATUS_NONE;
			if($status == CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE) {
				$consult_status = $db->getTriageIntakeStatus($consult_id); //EITHER 1 or 2
			} else if($status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT){
				$consult_status = $db->getMedicalConsultStatus($consult_id);//EITHER 3 or 4
			}
			$db->updateConsultStatus($patient_id, $consult_id, $consult_status);
		} else {
			$consult_status = $consult[CONSULTS_COLUMN_STATUS];
		}
	} else if(isset($_GET[PATIENT_ID_ARG])) {
		$patient_id = $_GET[PATIENT_ID_ARG];
		$consult_id = $db->startNewConsult($patient_id, Utilities::getCurrentDateTime(), CONSULT_STATUS_READY_FOR_TRIAGE_PENDING);
		header("LOCATION: consult_active.php?lang=" . $lang . "&mode=" . $mode . "&consult_id=" . $consult_id);
	} else {
		header("LOCATION: index.php?lang=" . $lang);
	}

	$patient = $db->getPatient($patient_id);
	$name = $patient[PATIENTS_COLUMN_NAME];
	$patient_sex = $patient[PATIENTS_COLUMN_SEX];
	$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];
	$age_string = Utilities::getCurrentAgeString($date_of_birth, $lang);

	$ready_for = 0;

	if($consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_PENDING || $consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS) {
		$ready_for = CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE;
	} else {
		$ready_for = CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT;
	}

	$triage_intake_extra_text;
	if($consult_status == CONSULT_STATUS_READY_FOR_TRIAGE_PENDING) {
		$triage_intake_extra_text = "(" . PENDING . ")";
	} else {
		$triage_intake_extra_text = "(" . IN_PROGRESS . ")";
	}
	$medical_consult_extra_text;
	if($consult_status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_IN_PROGRESS) {
		$medical_consult_extra_text = "(" . IN_PROGRESS . ")";
	} else {
		$medical_consult_extra_text = "(" . PENDING . ")";
	}

	


?>

<div id="mySidenav" class="sidenav">
	<a onclick="deleteConsultClick(<?php echo $consult_id . ', ' . $mode; ?>);"><?php echo DELETE_CONSULT; ?></a>
</div>
<div id="content" class="container-fluid" onclick="closeNav();">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo ACTIVE_CONSULT; ?></span>
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

	<div id="ready_for_row" class="row">
		<div id="ready_for_triage_intake_col" class="col-xs-6 ready_for_col">
			<?php
				if($ready_for == CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE) {
					echo '<div id="ready_for_triage_intake_div" class="ready_for_div selected_button">' . READY_FOR_TRIAGE_INTAKE_ABBREVIATION . '</div>';
				} else {
					echo '<div id="ready_for_triage_intake_div" class="ready_for_div unselected_button" onclick="switchStatusClick(2)">' . READY_FOR_TRIAGE_INTAKE_ABBREVIATION . '</div>';
				}
			?>
		</div>
		<div id="ready_for_medical_consult_col" class="col-xs-6 ready_for_col">
			<?php
				if($ready_for == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT) {
					echo '<div id="ready_for_triage_intake_div" class="ready_for_div selected_button">' . READY_FOR_MEDICAL_CONSULT_ABBREVIATION . '</div>';
				} else {
					echo '<div id="ready_for_triage_intake_div" class="ready_for_div unselected_button" onclick="switchStatusClick(1)">' . READY_FOR_MEDICAL_CONSULT_ABBREVIATION . '</div>';
				}
			?>
		</div>
	</div>

	<div class="row consult_row" >
		<div class="col-xs-12">
			<div id="triage_intake_header" class="<?php if($ready_for == CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE) { echo "yellow_background"; } ?>">
				<span class="left_title"><?php echo TRIAGE_INTAKE; ?></span>
				<span id="triage_intake_extra_text" class="left_title2 <?php if($ready_for == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT) { echo "hidden"; } ?>"><?php echo $triage_intake_extra_text; ?></span>
			</div>
			<ul class="list-group">
				<li class="list-group-item" onclick="chiefComplaintClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo CHIEF_COMPLAINT_HPI; ?>
					<?php if($db->consultHasChiefComplaint($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>
				</li>
				<li class="list-group-item" onclick="vitalSignsMeasurementsClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo VITALS_MEASUREMENTS; ?>
					<?php if($db->consultHasMeasurements($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>
				</li>
			</ul>
		</div>
	</div>


	<div class="row consult_row" >
		<div class="col-xs-12">
			<div id="medical_consult_header" class="<?php if($ready_for == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT) { echo "yellow_background"; } ?>">
				<span class="left_title"><?php echo MEDICAL_CONSULT; ?></span>
				<span id="medical_consult_extra_text" class="left_title2 <?php if($ready_for == CONSULT_STATUS_READY_FOR_TRIAGE_INTAKE) { echo "hidden"; } ?>"><?php echo $medical_consult_extra_text; ?></span>
			</div>
			<ul class="list-group">
				<li class="list-group-item" onclick="examsClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo EXAMS; ?>
					<?php if($db->consultHasExam($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>
				</li>
				<li class="list-group-item" onclick="diagnosisClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo DIAGNOSIS; ?>
					<?php if($db->consultHasDiagnosis($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>
				</li>
				<li class="list-group-item" onclick="treatmentClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo TREATMENT; ?>
					<?php if($db->consultHasTreatment($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>	
				</li>
				<li class="list-group-item" onclick="followupClick(<?php echo $consult_id . ', ' . $mode;?>);">
					<?php echo FOLLOWUP; ?>
					<?php if($db->consultHasFollowup($consult_id)) { echo '<img class="consult_task_completed" src="images/checkmark"/>'; } ?>	
				</li>
				<li class="list-group-item" onclick="signAndCompleteClick(<?php echo $consult_id . ', ' . $mode;?>);"><?php echo SIGN_AND_COMPLETE; ?></li>
			</ul>
		</div>
	</div>
</div>

<!-- Modal -->

<?php
if($show_consult_option == SHOW_CHIEF_COMPLAINT) {
	$has_primary_chief_complaints = $db->hasChiefComplaints($consult_id, CHIEF_COMPLAINT_PRIMARY);
	$has_secondary_chief_complaints = $db->hasChiefComplaints($consult_id, CHIEF_COMPLAINT_SECONDARY);
?>

<div id="myChiefComplaintModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo CHIEF_COMPLAINT_HPI; ?></p>
      </div>

    <div id="modal_chief_complaints" class="modal-body">
  		<div class="input_row">
  			<p class="center_title4"><?php echo PRIMARY_CHIEF_COMPLAINT; ?></p>
  			<p class="left_title5"><?php echo SELECT_NEW_OPTIONS; ?></p>
  			<select id="primary_chief_complaint_select" class="input_field modal_input_field" multiple>
  				<?php
  				echo "<option value='-1' disabled selected>" . TOUCH_HERE . "</option>";

				foreach(DEFAULT_CHIEF_COMPLAINT_ARRAY as $key) {
					$label = DEFAULT_CHIEF_COMPLAINT_MAP[$key];
					echo "<option value='$key'>$label</option>";
				}
				echo "<option value='" . INVALID_CHIEF_COMPLAINT . "'>" . OTHER . "</option>";

				
				?>
  			</select>
  			<div id="primary_chief_complaint_custom_div" class="hidden input_field">
				<input  class='custom_chief_complaint_input custom_primary_chief_complaint' type='text' placeholder='<?php echo OTHER; ?>'><br>
				<a id="add_custom_primary_chief_complaint" onclick="addCustomPrimaryChiefComplaint();">Add Another</a>
			</div>
  			<?php
  				if(!$has_primary_chief_complaints) {
  			?>
  				<p class="center_title5"><?php echo NONE_PREVIOUSLY_SELECTED; ?></p>
  			<?php
  				} else {
  			?>
	  			<p class="left_title5"><?php echo SELECTED_OPTIONS; ?></p>
	  			<ul class="list-group input_field">
	  				<?php
	  					$primary_chief_complaints = $db->getAllChiefComplaints($consult_id, CHIEF_COMPLAINT_PRIMARY);
	  					foreach($primary_chief_complaints as $primary_chief_complaint) {
	  						$chief_complaint_id = $primary_chief_complaint['id'];
	  						$selected_value = $primary_chief_complaint['selected_value'];
	  						$custom_text = $primary_chief_complaint['custom_text'];

	  						$hpi_type = "";
	  						$hpi_field1 = "";
	  						$hpi_field2 = "";
	  						$hpi_field3 = "";
	  						$hpi_field4 = "";
	  						$hpi_field5 = "";
	  						$hpi_field6 = "";
	  						$hpi_field7 = "";
	  						$hpi_field8 = "";
	  						$hpi_field9 = "";
	  						$hpi_field10 = "";
	  						$hpi_field11 = "";
	  						$hpi_field12 = "";
	  						$has_match = false;
	  						if($selected_value == DEFAULT_CHIEF_COMPLAINT_PREGNANCY_VALUE) {
	  							$type = HPI_TYPE_PREGNANCY;
	  							if($db->hasMatchingPregnancyHPI($chief_complaint_id)) {
	  								$has_match = true;
	  								$hpi = $db->getPregnancyHPI($chief_complaint_id);
	  								$hpi_field1 = $hpi['num_weeks_pregnant'];
			  						$hpi_field2 = $hpi['receiving_prenatal_care'];
			  						$hpi_field3 = $hpi['taking_prenatal_vitamins'];
			  						$hpi_field4 = $hpi['received_ultrasound'];
			  						$hpi_field5 = $hpi['num_live_births'];
			  						$hpi_field6 = $hpi['num_miscarriages'];
			  						$hpi_field7 = $hpi['dysuria_urgency_frequency'];
			  						$hpi_field8 = $hpi['abnormal_vaginal_discharge'];
			  						$hpi_field9 = $hpi['vaginal_bleeding'];
			  						$hpi_field10 = $hpi['previous_pregnancy_complications'];
			  						$hpi_field11 = $hpi['complications_notes'];
			  						$hpi_field12 = $hpi['notes'];
	  							}
	  						} else {
	  							$type = HPI_TYPE_GENERAL;
	  							if($db->hasMatchingGeneralHPI($chief_complaint_id)) {
	  								$has_match = true;
	  								$hpi = $db->getGeneralHPI($chief_complaint_id);
	  								$hpi_field1 = $hpi['o_how'];
			  						$hpi_field2 = $hpi['o_cause'];
			  						$hpi_field3 = $hpi['p_provocation'];
			  						$hpi_field4 = $hpi['p_palliation'];
			  						$hpi_field5 = $hpi['q_type'];
			  						$hpi_field6 = $hpi['r_region_main'];
			  						$hpi_field7 = $hpi['r_region_radiates'];
			  						$hpi_field8 = $hpi['s_level'];
			  						$hpi_field9 = $hpi['t_begin_time'];
			  						$hpi_field10 = $hpi['t_before'];
			  						$hpi_field11 = $hpi['t_current'];
			  						$hpi_field12 = $hpi['notes'];
	  							}
	  						}
	  						if($selected_value == INVALID_CHIEF_COMPLAINT) {
	  							echo '<li class="list-group-item" onclick="existingChiefComplaintClick(\'' . $mode . '\', \'' . $consult_id . '\', \'' . $selected_value . '\', \'' . $custom_text . '\', \'' . CHIEF_COMPLAINT_PRIMARY . '\', \'' . $type . '\', \'' . $chief_complaint_id . '\', \'' . $hpi_field1 . '\', \'' . $hpi_field2 . '\', \'' . $hpi_field3 . '\', \'' . $hpi_field4 . '\', \'' . $hpi_field5 . '\', \'' . $hpi_field6 . '\', \'' . $hpi_field7 . '\', \'' . $hpi_field8 . '\', \'' . $hpi_field9 . '\', \'' . $hpi_field10 . '\', \'' . $hpi_field11 . '\', \'' . $hpi_field12 . '\');">' . $custom_text;
	  							if($has_match) {
	  								echo '<img class="consult_task_completed" src="images/checkmark"/>';
	  							}
	  							echo '</li>';
	  						} else {
	  							$label = Utilities::getChiefComplaintLabel($selected_value);
	  							echo '<li class="list-group-item" onclick="existingChiefComplaintClick(\'' . $mode . '\', \'' . $consult_id . '\', \'' . $selected_value . '\', \'' . $label . '\', \'' . CHIEF_COMPLAINT_PRIMARY . '\', \'' . $type . '\', \'' . $chief_complaint_id . '\', \'' . $hpi_field1 . '\', \'' . $hpi_field2 . '\', \'' . $hpi_field3 . '\', \'' . $hpi_field4 . '\', \'' . $hpi_field5 . '\', \'' . $hpi_field6 . '\', \'' . $hpi_field7 . '\', \'' . $hpi_field8 . '\', \'' . $hpi_field9 . '\', \'' . $hpi_field10 . '\', \'' . $hpi_field11 . '\', \'' . $hpi_field12 . '\');">' . $label;
	  							if($has_match) {
	  								echo '<img class="consult_task_completed" src="images/checkmark"/>';
	  							}
	  							echo '</li>';
	  						}
	  					}
	  				?>
	  			</ul>
  			<?php
  				}
  			?>
  			
        </div>
  		<div class="input_row hidden">
  			<p class="center_title4"><?php echo SECONDARY_CHIEF_COMPLAINT; ?></p>
  			<p class="left_title5"><?php echo SELECT_NEW_OPTIONS; ?></p>
  			<select id="secondary_chief_complaint_select" class="input_field modal_input_field" multiple>
  				<?php
  				echo "<option value='-1' disabled selected>" . TOUCH_HERE . "</option>";

  				foreach(DEFAULT_CHIEF_COMPLAINT_ARRAY as $key) {
					$label = DEFAULT_CHIEF_COMPLAINT_MAP[$key];
					echo "<option value='$key'>$label</option>";
				}
				echo "<option value='" . INVALID_CHIEF_COMPLAINT . "'>" . OTHER . "</option>";

				
				?>
  			</select>
  			<div id="secondary_chief_complaint_custom_div" class="hidden input_field">
				<input  class='custom_chief_complaint_input custom_secondary_chief_complaint' type='text' placeholder='<?php echo OTHER; ?>'><br>
				<a id="add_custom_secondary_chief_complaint" onclick="addCustomSecondaryChiefComplaint();">Add Another</a>
			</div>
  			<?php
  				if(!$has_secondary_chief_complaints) {
  			?>
  				<p class="center_title5"><?php echo NONE_PREVIOUSLY_SELECTED; ?></p>
  			<?php
  				} else {
  			?>
	  			<p class="left_title5"><?php echo SELECTED_OPTIONS; ?></p>
	  			<ul class="list-group input_field">
	  				<?php
	  					$secondary_chief_complaints = $db->getAllChiefComplaints($consult_id, CHIEF_COMPLAINT_SECONDARY);
	  					foreach($secondary_chief_complaints as $secondary_chief_complaint) {
	  						$chief_complaint_id = $secondary_chief_complaint['id'];
	  						$selected_value = $secondary_chief_complaint['selected_value'];
	  						$custom_text = $secondary_chief_complaint['custom_text'];

	  						$hpi_type = "";
	  						$hpi_field1 = "";
	  						$hpi_field2 = "";
	  						$hpi_field3 = "";
	  						$hpi_field4 = "";
	  						$hpi_field5 = "";
	  						$hpi_field6 = "";
	  						$hpi_field7 = "";
	  						$hpi_field8 = "";
	  						$hpi_field9 = "";
	  						$hpi_field10 = "";
	  						$hpi_field11 = "";
	  						$hpi_field12 = "";

	  						$has_match = false;
	  						if($selected_value == DEFAULT_CHIEF_COMPLAINT_PREGNANCY_VALUE) {
	  							$type = HPI_TYPE_PREGNANCY;
	  							if($db->hasMatchingPregnancyHPI($chief_complaint_id)) {
	  								$has_match = true;
	  								$hpi = $db->getPregnancyHPI($chief_complaint_id);
	  								$hpi_field1 = $hpi['num_weeks_pregnant'];
			  						$hpi_field2 = $hpi['receiving_prenatal_care'];
			  						$hpi_field3 = $hpi['taking_prenatal_vitamins'];
			  						$hpi_field4 = $hpi['received_ultrasound'];
			  						$hpi_field5 = $hpi['num_lives_births'];
			  						$hpi_field6 = $hpi['num_miscarriages'];
			  						$hpi_field7 = $hpi['dysuria_urgency_frequency'];
			  						$hpi_field8 = $hpi['abnormal_vaginal_discharge'];
			  						$hpi_field9 = $hpi['vaginal_bleeding'];
			  						$hpi_field10 = $hpi['previous_pregnancy_complications'];
			  						$hpi_field11 = $hpi['complications_notes'];
			  						$hpi_field12 = $hpi['notes'];
	  							}
	  						} else {
	  							$type = HPI_TYPE_GENERAL;
	  							if($db->hasMatchingGeneralHPI($chief_complaint_id)) {
	  								$has_match = true;
	  								$hpi = $db->getGeneralHPI($chief_complaint_id);
	  								$hpi_field1 = $hpi['o_how'];
			  						$hpi_field2 = $hpi['o_cause'];
			  						$hpi_field3 = $hpi['p_provocation'];
			  						$hpi_field4 = $hpi['p_palliation'];
			  						$hpi_field5 = $hpi['q_type'];
			  						$hpi_field6 = $hpi['r_region_main'];
			  						$hpi_field7 = $hpi['r_region_radiates'];
			  						$hpi_field8 = $hpi['s_level'];
			  						$hpi_field9 = $hpi['t_begin_time'];
			  						$hpi_field10 = $hpi['t_before'];
			  						$hpi_field11 = $hpi['t_current'];
			  						$hpi_field12 = $hpi['notes'];
	  							}
	  						}
	  						if($selected_value == INVALID_CHIEF_COMPLAINT) {
	  							echo '<li class="list-group-item" onclick="existingChiefComplaintClick(\'' . $mode . '\', \'' . $consult_id . '\', \'' . $selected_value . '\', \'' . $custom_text . '\', \'' . CHIEF_COMPLAINT_SECONDARY . '\', \'' . $type . '\', \'' . $chief_complaint_id . '\', \'' . $hpi_field1 . '\', \'' . $hpi_field2 . '\', \'' . $hpi_field3 . '\', \'' . $hpi_field4 . '\', \'' . $hpi_field5 . '\', \'' . $hpi_field6 . '\', \'' . $hpi_field7 . '\', \'' . $hpi_field8 . '\', \'' . $hpi_field9 . '\', \'' . $hpi_field10 . '\', \'' . $hpi_field11 . '\', \'' . $hpi_field12 . '\');">' . $custom_text;
	  							if($has_match) {
	  								echo '<img class="consult_task_completed" src="images/checkmark"/>';
	  							}
	  							echo '</li>';
	  						} else {
	  							$label = Utilities::getChiefComplaintLabel($selected_value);
	  							echo '<li class="list-group-item" onclick="existingChiefComplaintClick(\'' . $mode . '\', \'' . $consult_id . '\', \'' . $selected_value . '\', \'' . $label . '\', \'' . CHIEF_COMPLAINT_SECONDARY . '\', \'' . $type . '\', \'' . $chief_complaint_id . '\', \'' . $hpi_field1 . '\', \'' . $hpi_field2 . '\', \'' . $hpi_field3 . '\', \'' . $hpi_field4 . '\', \'' . $hpi_field5 . '\', \'' . $hpi_field6 . '\', \'' . $hpi_field7 . '\', \'' . $hpi_field8 . '\', \'' . $hpi_field9 . '\', \'' . $hpi_field10 . '\', \'' . $hpi_field11 . '\', \'' . $hpi_field12 . '\');">' . $label;
	  							if($has_match) {
	  								echo '<img class="consult_task_completed" src="images/checkmark"/>';
	  							}
	  							echo '</li>';
	  						}
	  					}
	  				?>
	  			</ul>
  			<?php
  				}
  			?>
  			
        </div> 

    </div>
    <div id="modal_general_hpi" class="modal-body hidden">
    	<div class="input_row">
    		<a class="left_title4" onclick="chiefComplaintBack();"><?php echo GO_BACK; ?></a>
    	</div>
    	<div class="input_row">
    		<span class="left_title4"><?php echo SELECTED_FIELD; ?></span>
    		<span id="modal_general_hpi_selected_value" class="left_title5 chief_complaint_label"></span>
    	</div>
    	<div id="modal_general_hpi_custom_text_row" class="input_row hidden">
    		<input id='modal_general_hpi_custom_text_input' type='text'>
    	</div>
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
    	<div class="input_row input_field">
    		<input id='o_pain_how_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='o_pain_cause_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='p_pain_provocation_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='p_pain_palliation_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='q_pain_type_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='r_pain_region_main_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    	<div class="input_row input_field">
    		<input id='r_pain_region_radiates_other' class='hidden' type='text' placeholder='<?php echo OTHER; ?>'>
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
    			}
    		?>
    		</select>
    	</div>
    	<div class="input_row">
    		<p class="input_label"><?php echo HAS_PATIENT_EXPERIENCED_BEFORE; ?></p>
    		<div class="input_field">
	    		<input id="t_pain_before_yes" type='radio' name='t_pain_before' value='yes'><label for="t_pain_before_yes"><?php echo YES; ?></label>
				<input id="t_pain_before_no" type='radio' name='t_pain_before' value='no'><label for="t_pain_before_no"><?php echo NO; ?></label>
			</div>
    	</div>
    	<div class="input_row">
    		<p class="input_label"><?php echo DOES_PATIENT_CURRENTLY_HAVE_ISSUE; ?></p>
    		<div class="input_field">
	    		<input id="t_pain_current_yes" type='radio' name='t_pain_current' value='yes'><label for="t_pain_current_yes"><?php echo YES; ?></label>
				<input id="t_pain_current_no" type='radio' name='t_pain_current' value='no'><label for="t_pain_current_no"><?php echo NO; ?></label>
			</div>
    	</div>
    	<div class="input_row">
        	<p class="input_label"><?php echo NOTES_FIELD; ?></p>
        	<textarea id='general_notes_input' class='input_field'></textarea>
        </div>



    </div>     
    <div id="modal_pregnancy_hpi" class="modal-body hidden">
    	<div class="input_row">
    		<a class="left_title4" onclick="chiefComplaintBack();"><?php echo GO_BACK; ?></a>
    	</div>
    	<div class="input_row">
    		<span class="left_title4"><?php echo SELECTED_FIELD; ?></span>
    		<span class="left_title5 chief_complaint_label"><?php echo PREGNANCY; ?></span>
    	</div>
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
    	<div id="further_explanation_row" class="input_row hidden">
    		<p class="input_label"><?php echo FURTHER_EXPLANATION; ?></p>
    		<textarea id='further_explanation_input' class='input_field'></textarea>
    	</div>
    	<div class="input_row">
    		<p class="input_label"><?php echo NOTES_FIELD; ?></p>
    		<textarea id='pregnancy_notes_input' class='input_field'></textarea>
    	</div>
    </div>   

      <div class="modal-footer">
      	<button id="chief_complaint_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
        <button id="chief_complaint_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
      </div>

    </div>

  </div>
</div>
<?php
}
?>

<?php
if($show_consult_option == SHOW_MEASUREMENTS_VITAL_SIGNS) {
	$measurements = "";
	if($db->consultHasMeasurements($consult_id)) {
		$measurements = $db->getMeasurements($consult_id);
	}
?>

<div id="myMeasurementsModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    	<div class="modal-content">

	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo VITALS_MEASUREMENTS; ?></p>
	      	</div>

		    <div id="modal_measurements" class="modal-body">

		    	<?php
				if($patient_sex == SEX_FEMALE) {
				?>
				<div class="input_row">
					<p class="input_label"><?php echo IS_PREGNANT; ?></p>
					<form id="is_pregnant_radiogroup" class="input_field">
				<?php
					if($measurements && isset($measurements['is_pregnant'])) {
						$is_pregnant = $measurements['is_pregnant'];
						if($is_pregnant == BOOLEAN_FALSE) {
							echo "<input id='is_pregnant_yes' type='radio' name='is_pregnant' value='yes'><label for='is_pregnant_yes'>" . YES . "</label>";
							echo "<input id='is_pregnant_no' type='radio' name='is_pregnant' value='no' checked='checked'><label for='is_pregnant_no'>" . NO . "</label>";
						} else if ($is_pregnant == BOOLEAN_TRUE) {
							echo "<input id='is_pregnant_yes' type='radio' name='is_pregnant' value='yes' checked='checked'><label for='is_pregnant_yes'>" . YES . "</label>";
							echo "<input id='is_pregnant_no' type='radio' name='is_pregnant' value='no'><label for='is_pregnant_no'>" . NO . "</label>";
						}
					} else {
						echo "<input id='is_pregnant_yes' type='radio' name='is_pregnant' value='yes'><label for='is_pregnant_yes'>" . YES . "</label>";
						echo "<input id='is_pregnant_no' type='radio' name='is_pregnant' value='no'><label for='is_pregnant_no'>" . NO . "</label>";
					}
				?>
					</form>
				</div>

				<div class="input_row">
					<p class="input_label"><?php echo DATE_LAST_MENSTRUATION . ":"; ?></p>
				<?php
					if($measurements && isset($measurements['date_last_menstruation'])) {
						$date_last_menstruation = $measurements['date_last_menstruation'];
						echo "<input id='date_last_menstruation_input' class='input_field' type='date' value='$date_last_menstruation'>";
					} else {
						echo "<input id='date_last_menstruation_input' class='input_field' type='date'>";
					}
				?>
				</div>
				<?php
					}
				?>

				<div class="input_row">
					<p class="input_label"><?php echo TEMPERATURE_UNITS . ":"; ?></p>
					<form id="temperature_units_radiogroup" class="input_field">
					<?php
						if($measurements && isset($measurements['temperature_units'])) {
							$temperature_units = $measurements['temperature_units'];
							if($temperature_units == TEMPERATURE_UNITS_CELSIUS) {
								echo "<input id='temperature_units_f' type='radio' name='temperature_units' value='fahrenheit'><label for='temperature_units_f'>" . FAHRENHEIT_ABBREVIATION . "</label>";
								echo "<input id='temperature_units_c' type='radio' name='temperature_units' value='celsius' checked='checked'><label for='temperature_units_c'>" . CELSIUS_ABBREVIATION . "</label>";
							} else if ($temperature_units == TEMPERATURE_UNITS_FAHRENHEIT) {
								echo "<input id='temperature_units_f' type='radio' name='temperature_units' value='fahrenheit' checked='checked'><label for='temperature_units_f'>" . FAHRENHEIT_ABBREVIATION . "</label>";
								echo "<input id='temperature_units_c' type='radio' name='temperature_units' value='celsius'><label for='temperature_units_c'>" . CELSIUS_ABBREVIATION . "</label>";
							}
						} else {
							echo "<input id='temperature_units_f' type='radio' name='temperature_units' value='fahrenheit'><label for='temperature_units_f'>" . FAHRENHEIT_ABBREVIATION . "</label>";
							echo "<input id='temperature_units_c' type='radio' name='temperature_units' value='celsius'><label for='temperature_units_c'>" . CELSIUS_ABBREVIATION . "</label>";
						}
					?>
					</form>
				</div>

				<div class="input_row">
					<p class="input_label"><?php echo TEMPERATURE_VALUE . ":"; ?></p>
					<?php
					if($measurements && isset($measurements['temperature_value'])) {
						$temperature_value = $measurements['temperature_value'];
						echo "<input id='temperature_input' class='input_field' type='number' value='$temperature_value'>";
					} else {
						echo "<input id='temperature_input' class='input_field' type='number'>";
					}
					?>
				</div>

				<div class="input_row">
					<p class="input_label"><?php echo BLOOD_PRESSURE_SYSTOLIC . ":"; ?></p>
					<?php
						if($measurements && isset($measurements['blood_pressure_systolic'])) {
							$blood_pressure_systolic = $measurements['blood_pressure_systolic'];
							echo "<input id='blood_pressure_systolic_input' class='input_field' type='number' value='$blood_pressure_systolic'>";
						} else {
							echo "<input id='blood_pressure_systolic_input' class='input_field' type='number'>";
						}
					?>
				</div>
				<div class="input_row">
					<p class="input_label"><?php echo BLOOD_PRESSURE_DIASTOLIC . ":"; ?></p>
					<?php
						if($measurements && isset($measurements['blood_pressure_diastolic'])) {
							$blood_pressure_diastolic = $measurements['blood_pressure_diastolic'];
							echo "<input id='blood_pressure_diastolic_input' class='input_field' type='number' value='$blood_pressure_diastolic'>";
						} else {
							echo "<input id='blood_pressure_diastolic_input' class='input_field' type='number'>";
						}
					?>
				</div>

				<div class="input_row">
					<p class="input_label"><?php echo PULSE_RATE . ":"; ?></p>
					<?php
						if($measurements && isset($measurements['pulse_rate'])) {
							$pulse_rate = $measurements['pulse_rate'];
							echo "<input id='pulse_rate_input' class='input_field' type='number' value='$pulse_rate'>";
						} else {
							echo "<input id='pulse_rate_input' class='input_field' type='number'>";
						}
					?>
				</div>

				<div class="input_row">
					<p class="input_label"><?php echo BLOOD_OXYGEN_SATURATION . ":"; ?></p>
					<?php
						if($measurements && isset($measurements['blood_oxygen_saturation'])) {
							$blood_oxygen_saturation = $measurements['blood_oxygen_saturation'];
							echo "<input id='blood_oxygen_saturation_input' class='input_field' type='number' value='$blood_oxygen_saturation'>";
						} else {
							echo "<input id='blood_oxygen_saturation_input' class='input_field' type='number'>";
						}
					?>
				</div>

			<div class="input_row">
				<p class="input_label"><?php echo RESPIRATION_RATE . ":"; ?></p>
				<?php
					if($measurements && isset($measurements['respiration_rate'])) {
						$respiration_rate = $measurements['respiration_rate'];
						echo "<input id='respiration_rate_input' class='input_field' type='number' value='$respiration_rate'>";
					} else {
						echo "<input id='respiration_rate_input' class='input_field' type='number'>";
					}
				?>
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo WEIGHT_UNITS . ":"; ?></p>
				<form id="weight_units_radiogroup" class="input_field">
				<?php
					if($measurements && isset($measurements['weight_units'])) {
						$weight_units = $measurements['weight_units'];
						if($weight_units == WEIGHT_UNITS_KILOGRAMS) {
							echo "<input id='weight_units_lb' type='radio' name='weight_units' value='pounds'><label for='weight_units_lb'>" . POUNDS_ABBREVIATION . "</label>";
							echo "<input id='weight_units_kg' type='radio' name='weight_units' value='kilograms' checked='checked'><label for='weight_units_kg'>" . KILOGRAMS_ABBREVIATION . "</label>";
						} else if ($weight_units == WEIGHT_UNITS_POUNDS) {
							echo "<input id='weight_units_lb' type='radio' name='weight_units' value='pounds' checked='checked'><label for='weight_units_lb'>" . POUNDS_ABBREVIATION . "</label>";
							echo "<input id='weight_units_kg' type='radio' name='weight_units' value='kilograms'><label for='weight_units_kg'>" . KILOGRAMS_ABBREVIATION . "</label>";
						}
					} else {
						echo "<input id='weight_units_lb' type='radio' name='weight_units' value='pounds'><label for='weight_units_lb'>" . POUNDS_ABBREVIATION . "</label>";
						echo "<input id='weight_units_kg' type='radio' name='weight_units' value='kilograms'><label for='weight_units_kg'>" . KILOGRAMS_ABBREVIATION . "</label>";
					}
				?>
				</form>
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo WEIGHT_VALUE . ":"; ?></p>
				<?php
					if($measurements && isset($measurements['weight_value'])) {
						$weight_value = $measurements['weight_value'];
						echo "<input id='weight_input' class='input_field' type='number' value='$weight_value'>";
					} else {
						echo "<input id='weight_input' class='input_field' type='number'>";
					}
				?>		
			</div>


			<div class="input_row">
				<p class="input_label"><?php echo HEIGHT_UNITS . ":"; ?></p>
				<form id="height_units_radiogroup" class="input_field">
				<?php
					if($measurements && isset($measurements['height_units'])) {
						$height_units = $measurements['height_units'];
						if($height_units == HEIGHT_UNITS_INCHES) {
							echo "<input id='height_units_cm' type='radio' name='height_units' value='centimeters'><label for='height_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
							echo "<input id='height_units_in' type='radio' name='height_units' value='inches' checked='checked'><label for='height_units_in'>" . INCHES_ABBREVIATION . "</label>";
						} else if ($height_units == HEIGHT_UNITS_CENTIMETERS) {
							echo "<input id='height_units_cm' type='radio' name='height_units' value='centimeters' checked='checked'><label for='height_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
							echo "<input id='height_units_in' type='radio' name='height_units' value='inches'><label for='height_units_in'>" . INCHES_ABBREVIATION . "</label>";
						}
					} else {
						echo "<input id='height_units_cm' type='radio' name='height_units' value='centimeters'><label for='height_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
						echo "<input id='height_units_in' type='radio' name='height_units' value='inches'><label for='height_units_in'>" . INCHES_ABBREVIATION . "</label>";
					}
				?>
				</form>
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo HEIGHT_VALUE . ":"; ?></p>
				<?php
					if($measurements && isset($measurements['height_value'])) {
						$height_value = $measurements['height_value'];
						echo "<input id='height_input' class='input_field' type='number' value='$height_value'>";
					} else {
						echo "<input id='height_input' class='input_field' type='number'>";
					}
				?>		
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo WAIST_CIRCUMFERENCE_UNITS . ":"; ?></p>
				<form id="waist_circumference_units_radiogroup" class="input_field">
				<?php
					if($measurements && isset($measurements['waist_circumference_units'])) {
						$waist_circumference_units = $measurements['waist_circumference_units'];
						if($waist_circumference_units == HEIGHT_UNITS_INCHES) {
							echo "<input id='waist_circumference_units_cm' type='radio' name='waist_circumference_units' value='centimeters'><label for='waist_circumference_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
							echo "<input id='waist_circumference_units_in' type='radio' name='waist_circumference_units' value='inches' checked='checked'><label for='waist_circumference_units_in'>" . INCHES_ABBREVIATION . "</label>";
						} else if ($waist_circumference_units == HEIGHT_UNITS_CENTIMETERS) {
							echo "<input id='waist_circumference_units_cm' type='radio' name='waist_circumference_units' value='centimeters' checked='checked'><label for='waist_circumference_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
							echo "<input id='waist_circumference_units_in' type='radio' name='waist_circumference_units' value='inches'><label for='waist_circumference_units_in'>" . INCHES_ABBREVIATION . "</label>";
						}
					} else {
						echo "<input id='waist_circumference_units_cm' type='radio' name='waist_circumference_units' value='centimeters'><label for='waist_circumference_units_cm'>" . CENTIMETERS_ABBREVIATION . "</label>";
						echo "<input id='waist_circumference_units_in' type='radio' name='waist_circumference_units' value='inches'><label for='waist_circumference_units_in'>" . INCHES_ABBREVIATION . "</label>";
					}
				?>
				</form>
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo WAIST_CIRCUMFERENCE_VALUE . ":"; ?></p>
				<?php
					if($measurements && isset($measurements['waist_circumference_value'])) {
						$waist_circumference_value = $measurements['waist_circumference_value'];
						echo "<input id='waist_circumference_input' class='input_field' type='number' value='$waist_circumference_value'>";
					} else {
						echo "<input id='waist_circumference_input' class='input_field' type='number'>";
					}
				?>		
			</div>

			<div class="input_row">
				<p class="input_label"><?php echo NOTES_FIELD; ?></p>
				<?php
					if($measurements && isset($measurements['notes'])) {
						$notes = $measurements['notes'];
						echo "<textarea id='measurements_notes_input' class='input_field'>$notes</textarea>";
					} else {
						echo "<textarea id='measurements_notes_input' class='input_field'></textarea>";
					}
				?>	
			</div>


		    </div>
	   

	      	<div class="modal-footer">
		      	<button id="measurements_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
		        <button id="measurements_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
	      	</div>

	    </div>
  	</div>
</div>
<?php
}
?>

<?php
if($show_consult_option == SHOW_EXAMS) {
	require_once 'include/ExamMapping.php';

	$normal_exams = $db->getExamsStructured($consult_id, BOOLEAN_TRUE);
	$abnormal_exams = $db->getExamsStructured($consult_id, BOOLEAN_FALSE);

	$json_normal_exams = json_encode($normal_exams, JSON_HEX_TAG);
	$json_abnormal_exams = json_encode($abnormal_exams, JSON_HEX_TAG);

	$map = new ExamMapping();
	$full_map = $map->getFullMapping();
	$json_full_map = json_encode($full_map, JSON_HEX_TAG);


?>

<script type="text/javascript">
var php_full_map = <?php echo $json_full_map; ?>; 
var php_normal_exams = <?php echo $json_normal_exams; ?>; 
var php_abnormal_exams = <?php echo $json_abnormal_exams; ?>; 

</script>

<div id="myExamsModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    	<div class="modal-content">

	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo EXAMS; ?></p>
	      	</div>

		    <div id="modal_exams" class="modal-body">
		    	<div class="input_row">
			    	<p id="exam_type_title" class="left_title5"><?php echo EXAM_TYPE; ?></p>
			    	<a id="exam_type_title_link" class="left_title5 hidden" onclick='examMapClick(<?php echo $consult_id . ', ' . $mode . ', "", "", "", "", ""'; ?>);'><?php echo EXAM_TYPE; ?></a>
		  			<ul id="exam_list" class="list-group"></ul>
		  			<div id="exam_form_stuff" class="hidden">
		  				<div id="other_exam_div" class="hidden">
		  					<p class="input_label"><?php echo OTHER_EXAM_FIELD; ?></p>
		  					<div class="input_field">
								<input  id="exams_other_exam_input" type='text' placeholder='<?php echo OTHER; ?>'><br>
							</div>
		  				</div>
			  			<p class="input_label"><?php echo OPTIONS_FIELD; ?></p>
			  			<select id="exams_select" class="input_field" multiple>
			  				<option id="exams_select_touch_here" value="-1" disabled selected><?php echo TOUCH_HERE; ?></option>
			  				<option id="exams_select_other_option" value="255"><?php echo OTHER; ?></option>
			  			</select>
			  			<div id="exams_select_other_div" class="hidden input_field">
							<input  id="exams_select_other_input" type='text' placeholder='<?php echo OTHER; ?>'><br>
						</div>
						<div id="exams_notes_div" class="input_row">
				    		<p class="input_label"><?php echo NOTES_FIELD; ?></p>
				    		<textarea id='exams_notes' class='input_field'></textarea>
				    	</div>
				    </div>
	  			</ul>
		    </div>

		    <div class="modal-footer">
		      	<button id="exams_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
		        <button id="exams_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>
<?php
}
?>

<?php
if($show_consult_option == SHOW_DIAGNOSES) {
	require_once 'include/DiagnosisMapping.php';

	$map = new DiagnosisMapping();
	$full_map = $map->getFullMapping();
	$json_full_map = json_encode($full_map, JSON_HEX_TAG);

	$main_options = $map->getMainOptions();
	$json_main_options = json_encode($main_options, JSON_HEX_TAG);

	$diagnoses = $db->getDiagnosesStructured($consult_id);

	$json_diagnoses = json_encode($diagnoses, JSON_HEX_TAG);

?>

<script type="text/javascript">
var php_full_map = <?php echo $json_full_map; ?>; 
var php_main_options = <?php echo $json_main_options; ?>; 
var php_diagnoses = <?php echo $json_diagnoses; ?>; 


</script>

<!--
Page 1: Main options, other option, option to go to full list
Page 2: Full list categories, other option (Can go back to Page 1)
Page 3: Within a category, other option (Can go back to Page 1 or Page 2)

-->
<div id="myDiagnosesModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo DIAGNOSES; ?></p>
	      	</div>
		    <div id="modal_diagnoses" class="modal-body">
		    	<div id="diagnosis_header_stuff">
		    		<a id="diagnosisPage1Link" class="left_title5 hidden" onclick='diagnosesPageClick(<?php echo $consult_id . ', ' . $mode . ', 1, ""'; ?>);'><?php echo MAIN_OPTIONS; ?></a>
			    	<p id="diagnosisPage1P" class="left_title5 hidden"><?php echo MAIN_OPTIONS; ?></p>
				    
			    	<a id="diagnosisPage2Link" class="left_title5 hidden" onclick='diagnosesPageClick(<?php echo $consult_id . ', ' . $mode . ', 2, ""'; ?>);'><?php echo CATEGORIES; ?></a>
				    <p id="diagnosisPage2P" class="left_title5 hidden"><?php echo CATEGORIES; ?></p>
				    
				    <a id="diagnosisPage3Link" class="left_title5 hidden" onclick='diagnosesPageClick(<?php echo $consult_id . ', ' . $mode . ', 3, ""'; ?>);'><?php echo CATEGORIES; ?></a>
				    <p id="diagnosisPage3P" class="left_title5 hidden"></p>
				</div>
		    	<ul id="diagnosis_list" class="list-group"></ul>

		    	<div id="diagnosis_form_stuff" class="hidden">
	  				<div id="other_input_row" class="input_row hidden">
				      	<div class="input_row">
				        	<p class="input_label"><?php echo INFORMATION_FIELD; ?></p>
				        	<input id='information_input' class='input_field' placeholder="<?php echo OTHER; ?>">
				        </div>
			    	</div>
			    	<div class="input_row">
			    		<p class="input_label"><?php echo TYPE_FIELD; ?></p>
			    		<form id="type_radiogroup" class="input_field">
				    		<input id='type_chronic' type='radio' name='diagnosis_type' value='2'><label for='type_chronic'><?php echo CHRONIC; ?></label>
							<input id='type_acute' type='radio' name='diagnosis_type' value='1'><label for='type_acute'><?php echo ACUTE; ?></label>
						</form>
			    	</div>
			    	<div class="input_row">
			        	<p class="input_label"><?php echo NOTES_FIELD; ?></p>
			        	<textarea id='diagnoses_notes_input' class='input_field'></textarea>
			        </div>
				    </div>
			    </div>
		    <div class="modal-footer">
		      	<button id="diagnoses_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
		        <button id="diagnoses_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>

<?php
}
?>

<?php
if($show_consult_option == SHOW_TREATMENTS) {
	require_once 'include/TreatmentMapping.php';

	$diagnoses = $db->getDiagnosesStructured($consult_id);
	$json_diagnoses = json_encode($diagnoses, JSON_HEX_TAG);

	$treatment_mapping = new TreatmentMapping();
	$treatment_map = $treatment_mapping->getFullMapping();
	$general_treatments = $treatment_mapping->getGeneralTreatments();

	$json_treatment_map = json_encode($treatment_map, JSON_HEX_TAG);
	$json_general_treatments = json_encode($general_treatments, JSON_HEX_TAG);


	$treatments = $db->getTreatmentsStructured($consult_id);
	$json_treatments = json_encode($treatments, JSON_HEX_TAG);


?>

<script type="text/javascript">
var php_diagnoses = <?php echo $json_diagnoses; ?>; 

var php_treatment_map = <?php echo $json_treatment_map; ?>;
var php_general_treatments = <?php echo $json_general_treatments; ?>;

var php_treatments = <?php echo $json_treatments; ?>;
</script>

<div id="myTreatmentModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo TREATMENTS; ?></p>
	      	</div>
		    <div id="modal_treatment" class="modal-body">
		    	<div id="treatment_header_stuff">
		    		<a id="treatmentPage1Link" class="left_title5 hidden" onclick='treatmentPageClick(<?php echo $consult_id . ', ' . $mode . ', 1, "", ""'; ?>);'><?php echo MAIN_OPTIONS; ?></a>
			    	<p id="treatmentPage1P" class="left_title5 hidden"><?php echo MAIN_OPTIONS; ?></p>
				    
			    	<a id="treatmentPage2Link" class="left_title5 hidden" onclick='treatmentPageClick(<?php echo $consult_id . ', ' . $mode . ', 2, "", ""'; ?>);'><?php echo CATEGORIES; ?></a>
				    <p id="treatmentPage2P" class="left_title5 hidden"></p>
				    
				    <p id="treatmentPage3P" class="left_title5 hidden"></p>
				</div>

		    	<ul id="treatment_list" class="list-group"></ul>

		    	<div id="treatment_form_stuff" class="hidden">


		    		<div id="other_input_row" class="input_row hidden">
			        	<p class="input_label"><?php echo TREATMENT_NAME . ":" ?></p>
			        	<input id='information_input' class='input_field' placeholder="<?php echo OTHER; ?>">
			    	</div>
			    	<div class="input_row">
			    		<p class="input_label underline"><?php echo INSCRIPTION_SUBSCRIPTION; ?></p>
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
						<input id='other_strength_units_input' class='input_field hidden' placeholder="<?php echo OTHER_STRENGTH_UNITS; ?>">
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
						<input id='other_concentration_part_one_units_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_CONC_1_UNITS; ?>">
						<span id="custom_span2" class="custom_span hidden">/</span>
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
						<input id='other_concentration_part_two_units_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_CONC_2_UNITS; ?>">
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
						<input id='other_quantity_units_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_QUANTITY_UNITS; ?>">
			    	</div>
			    	<div class="input_row">
			    		<p class="input_label underline"><?php echo PATIENT_USE_DIRECTIONS; ?></p>
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
						<input id='other_route_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_ROUTE; ?>">
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
						<input id='other_dosage_units_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_DOSAGE_UNITS; ?>">
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
						<input id='other_frequency_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_FREQUENCY; ?>">
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
						<input id='other_duration_units_input' class='input_field hidden other_input' placeholder="<?php echo OTHER_DURATION_UNITS; ?>">
			    	</div>
			    	<div class="input_row">
			        	<p class="input_label"><?php echo NOTES_FIELD; ?></p>
			        	<textarea id='notes_input' class='input_field'></textarea>
			        </div>
			        <div class="input_row">
			        	<p class="input_label"><?php echo ADD_TO_MEDICATION_HISTORY; ?></p>
			        	<form id="add_to_medication_history_radiogroup" class="input_field">
			        		<input type="radio" id="add_to_medication_history_yes" name="add_to_medication_history" value="2"><label for="add_to_medication_history_yes"><?php echo YES; ?></label>
			        		<input type="radio" id="add_to_medication_history_no" name="add_to_medication_history" value="1"><label for="add_to_medication_history_no"><?php echo NO; ?></label>
			        	</form>
			    	</div>
				</div>
			</div>
		    <div class="modal-footer">
		      	<button id="treatment_delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
		        <button id="treatment_save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>

<?php
}
?>

<?php
if($show_consult_option == SHOW_FOLLOWUP) {

	$followup = null;
	$followup_id = "";
	if($db->consultHasFollowup($consult_id)) {
		$followup = $db->getFollowup($consult_id);
		$followup_id = $followup['id'];
	}

	$json_type_array = json_encode(FOLLOWUP_TYPE_ARRAY, JSON_HEX_TAG);
	$json_followup_map = json_encode(FOLLOWUP_REASON_MAP, JSON_HEX_TAG);



?>

<script type="text/javascript">

var php_type_array = <?php echo $json_type_array; ?>;
var php_followup_map = <?php echo $json_followup_map; ?>;

</script>


<div id="myFollowupModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo FOLLOWUP; ?></p>
	      	</div>
		    <div id="modal_followup" class="modal-body">
				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo IS_A_FOLLOWUP_NEEDED; ?></p>
						<form id="followup_referral_radiogroup" class="input_field">
			<?php
							if($followup && isset($followup['is_needed'])) {
								$is_needed = $followup['is_needed'];
								if($is_needed == BOOLEAN_FALSE) {
									echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes'><label for='is_needed_input_yes'>Yes</label>";
									echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no' checked='checked'><label for='is_needed_input_no'>No</label>";
								} else if ($is_needed == BOOLEAN_TRUE) {
									echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes' checked='checked'><label for='is_needed_input_yes'>Yes</label>";
									echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no'><label for='is_needed_input_no'>No</label>";
								}
							} else {
								echo "<input id='is_needed_input_yes' type='radio' name='is_needed_input' value='yes'><label for='is_needed_input_yes'>Yes</label>";
								echo "<input id='is_needed_input_no' type='radio' name='is_needed_input' value='no'><label for='is_needed_input_no'>No</label>";
							}
			?>
						</form>
					</div>
				</div>

				<div id="followup_content_div" class="hidden">
					<div id="type_select_row" class="row input_row">
						<div class="col-xs-12">
							<p class="input_label"><?php echo FOLLOWUP_REFERRAL . ": "; ?></p>
							<select id="type_select" class="input_field">
			<?php
							for($i = 0; $i < sizeof(FOLLOWUP_TYPE_ARRAY); $i++) {
								$type = FOLLOWUP_TYPE_ARRAY[$i];
								$default_set = false;
								if($followup && isset($followup['is_type_custom']) && isset($followup['type'])) {
									$is_type_custom = $followup['is_type_custom'];
									$selected_type = $followup['type'];
									if($i < sizeof(FOLLOWUP_TYPE_ARRAY) - 1 && $is_type_custom == BOOLEAN_FALSE && $selected_type == $i) {
										$default_set = true;
										echo "<option value='$i' selected>$type</option>";
									} else if ($i == sizeof(FOLLOWUP_TYPE_ARRAY) - 1 && $is_type_custom == BOOLEAN_TRUE) {
										$defaut_set = true;
										echo "<option value='other' selected>$type</option>";
									} 
								} 
								if(!$default_set) {
									if($i < sizeof(FOLLOWUP_TYPE_ARRAY) - 1) {
										echo "<option value='$i'>$type</option>";
									} else {
										echo "<option value='other'>$type</option>";
									}
									
								}
							}
			?>
							</select>

						</div>
					</div>

					<div id="custom_type_row" class="row input_row hidden">
						<div class="col-xs-12">
							<p class="input_label"><?php echo FOLLOWUP_REFERRAL_CUSTOM . ": "; ?></p>
				<?php
								if($followup && isset($followup['is_type_custom']) && isset($followup['type'])) {
									$is_type_custom = $followup['is_type_custom'];
									$type = $followup['type'];
									if($is_type_custom == BOOLEAN_TRUE) {
										echo "<input id='type_custom' class='input_field' value='$type'>";
									} else {
										echo "<input id='type_custom' class='input_field'>";
									}
								} else {
									echo "<input id='type_custom' class='input_field'>";
								}
				?>
						</div>
					</div>

					<div id="reason_select_row" class="row input_row hidden">
						<div class="col-xs-12">
							<p class="input_label"><?php echo REASON . ": "; ?></p>
							<select id="reason_select" class="input_field">
			<?php
							$is_type_custom = $followup['is_type_custom'];
							$type = $followup['type'];
							$is_reason_custom = $followup['is_reason_custom'];
							$selected_reason = $followup['reason'];
							if($followup && $is_type_custom == BOOLEAN_FALSE) {
								$reason_array = FOLLOWUP_REASON_MAP[$type];
								if($is_reason_custom == BOOLEAN_TRUE) {
									for($i = 0; $i < sizeof($reason_array); $i++) {
										$reason = $reason_array[$i];
										if($i == sizeof($reason_array) - 1) {
											echo "<option value='other' selected>$reason</option>";
										} else {
											echo "<option value='$i'>$reason</option>";
										}
									}
								} else if($is_reason_custom == BOOLEAN_FALSE) {
									for($i = 0; $i < sizeof($reason_array); $i++) {
										$reason = $reason_array[$i];
										$reason = $reason_array[$i];
										if($i == sizeof($reason_array) - 1) {
											echo "<option value='other'>$reason</option>";
										} else if($i == $selected_reason){
											echo "<option value='$i' selected>$reason</option>";
										} else {
											echo "<option value='$i'>$reason</option>";
										}
									}
								}
							} 
			?>
							</select>

						</div>
					</div>

					<div id="custom_reason_row" class="row input_row hidden">
						<div class="col-xs-12">
							<p class="input_label"><?php echo REASON_CUSTOM . ": "; ?></p>
				<?php
								if($followup && isset($followup['is_reason_custom']) && isset($followup['reason'])) {
									$is_reason_custom = $followup['is_reason_custom'];
									$reason = $followup['reason'];
									if($is_reason_custom == BOOLEAN_TRUE) {
										echo "<input id='reason_custom' class='input_field' value='$reason'>";
									} else {
										echo "<input id='reason_custom' class='input_field'>";
									}
								} else {
									echo "<input id='reason_custom' class='input_field'>";
								}
				?>
						</div>
					</div>

					<div class="row input_row">
						<div class="col-xs-12">
							<p class="input_label"><?php echo NOTES_FIELD; ?></p>
				<?php
								if($followup && isset($followup['notes'])) {
									$notes = $followup['notes'];
									echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
								} else {
									echo "<textarea id='notes_input' class='input_field'></textarea>";
								}
				?>	
						</div>
					</div>

				</div>

			</div>
		    <div class="modal-footer">
		      	<button id="followup_delete_button" type="button" class="btn btn-default <?php if(!$followup) { echo "hidden"; }?>" onclick="followupDeleteClick(<?php echo $consult_id . ', '. $mode . ', \'' . $followup_id . '\''; ?>);"><?php echo DELETE_CAPS; ?></button>
		        <button id="followup_save_button" type="button" class="btn btn-default" onclick="followupSaveClick(<?php echo $consult_id . ', '. $mode . ', \'' . $followup_id . '\''; ?>);"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>

<?php
}
?>

<?php
if($show_consult_option == SHOW_SIGN_AND_COMPLETE) {

	$c_medical_group = $consult['medical_group'];
	$c_chief_physician = $consult['chief_physician'];
	$c_signing_physician = $consult['signing_physician'];
	$c_location = $consult['location'];
	$c_notes = $consult['notes'];
	$c_datetime_completed = $consult['datetime_completed'];


	$group_mapping = $db->getGroupMapping();
	$group_mapping2 = $db->getGroupMapping2();
	$settings = $db->getSettings();
	$locations = $db->getExistingConsultLocations();
	$default_consult_medical_group = $settings['default_consult_medical_group'];
	if($c_medical_group) {
		$default_consult_medical_group = $c_medical_group;
	}
	$default_consult_chief_physician = $settings['default_consult_chief_physician'];
	if($c_chief_physician) {
		$default_consult_chief_physician = $c_chief_physician;
	}
	$default_consult_location = $settings['default_consult_location'];
	if($c_location) {
		$default_consult_location = $c_location;
	}



	$json_group_mapping = json_encode($group_mapping, JSON_HEX_TAG);
	$json_group_mapping2 = json_encode($group_mapping2, JSON_HEX_TAG);
?>

<script type="text/javascript">
var php_group_mapping = <?php echo $json_group_mapping; ?>; 
var php_group_mapping2 = <?php echo $json_group_mapping2; ?>;

</script>


<div id="mySignModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<p id="modal_header" class="center_title"><?php echo SIGN_AND_COMPLETE; ?></p>
	      	</div>
		    <div id="modal_sign" class="modal-body">

		    	<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo LOCATION_FIELD; ?></p>
						<select id="location_select" class="input_field">
							<?php
								$location_match_found = false;
								if($default_consult_location) {
									echo '<option value="-1">' . TOUCH_HERE . '</option>';
									foreach($locations as $location_obj) {
										$location = $location_obj['location'];
										if($location) {
											if($default_consult_location == $location) {
												$location_match_found = true;
									    		echo '<option value="' . $location . '" selected>' . $location .'</option>';
									    	} else {
									    		echo '<option value="' . $location . '">' . $location .'</option>';
									    	}
									    }
								    }
								} else {
									echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
									foreach($locations as $location_obj) {
										$location = $location_obj['location'];
										if($location) {
								    		echo '<option value="' . $location . '">' . $location .'</option>';
								    	}
								    }
								}
							?>
							<option value="-2"><?php echo OTHER; ?></option>
						</select>
						<div id="other_location_div" class="hidden input_field other_field">
							<?php
								if($location_match_found || !$default_consult_location) {
									echo '<input id="other_location_input" type="text" placeholder="' . OTHER . '">';
								} else {
									echo '<input id="other_location_input" type="text" value="' . $default_consult_location . '">';
								}
							?>
						</div>
					</div>
				</div>

				

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo MEDICAL_GROUP_FIELD; ?></p>
						<select id="medical_group_select" class="input_field">
							<?php
								$medical_group_match_found = false;
								if(!empty($default_consult_medical_group)) {
									echo '<option value="-1">' . TOUCH_HERE . '</option>';
									foreach($group_mapping as $medical_group => $chief_physicians) {
										if($default_consult_medical_group == $medical_group) {
											$medical_group_match_found = true;
								    		echo '<option value="' . $medical_group . '" selected>' . $medical_group .'</option>';
								    	} else {
								    		echo '<option value="' . $medical_group . '">' . $medical_group .'</option>';
								    	}
								    }
								} else {
									echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
									foreach($group_mapping as $medical_group => $chief_physicians) {
								    	echo '<option value="' . $medical_group . '">' . $medical_group .'</option>';
								    }
								}
							?>
							<?php
								if($medical_group_match_found || empty($default_consult_medical_group)) {
									echo '<option value="-2">' . OTHER . '</option>';
								} else {
									echo '<option value="-2" selected>' . OTHER . '</option>';
								}
							?>
						</select>
						<div id="other_medical_group_div" class="hidden input_field other_field">
							<?php
								if($medical_group_match_found || empty($default_consult_medical_group)) {
									echo '<input id="other_medical_group_input" type="text" placeholder="' . OTHER . '">';
								} else {
									echo '<input id="other_medical_group_input" type="text" value="' . $default_consult_medical_group . '">';
								}
							?>
						</div>
					</div>
				</div>

				

				<div id="chief_physician_row" class="row input_row hidden">
					<div class="col-xs-12">
						<p class="input_label"><?php echo CHIEF_PHYSICIAN_FIELD; ?></p>
						<select id="chief_physician_select" class="input_field">
							<?php
								$chief_physician_match_found = false;
								if($default_consult_medical_group) {
									$chief_physicians = $group_mapping[$default_consult_medical_group];
									if ($default_consult_chief_physician) {
										echo '<option value="-1">' . TOUCH_HERE . '</option>';
										foreach($chief_physicians as $chief_physician) {
											if($default_consult_chief_physician == $chief_physician) {
												$chief_physician_match_found = true;
									    		echo '<option value="' . $chief_physician . '" selected>' . $chief_physician .'</option>';
									    	} else {
									    		echo '<option value="' . $chief_physician . '">' . $chief_physician .'</option>';
									    	}
									    }
									} else {
										echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
										foreach($chief_physicians as $chief_physician) {
									    	echo '<option value="' . $chief_physician . '">' . $chief_physician .'</option>';
									    }
									}
								}
							?>
							<option value="-2"><?php echo OTHER; ?></option>
						</select>
						<div id="other_chief_physician_div" class="hidden input_field other_field">
							<?php
								if(($medical_group_match_found && $chief_physician_match_found) || !$default_consult_chief_physician) {
									echo '<input id="other_chief_physician_input" type="text" placeholder="' . OTHER . '">';
								} else {
									echo '<input id="other_chief_physician_input" type="text" value="' . $default_consult_chief_physician . '">';
								}
							?>
						</div>
					</div>
				</div>

				<div id="signing_physician_row" class="row input_row hidden">
					<div class="col-xs-12">
						<p class="input_label"><?php echo SIGNING_PHYSICIAN_FIELD; ?></p>
						<select id="signing_physician_select" class="input_field">
							<?php
								$existing_signing_physician_set = false;
								if($default_consult_medical_group) {
									if($c_signing_physician) {
										$signing_physicians = $group_mapping2[$default_consult_medical_group];
									echo '<option value="-1">' . TOUCH_HERE . '</option>';
									foreach($signing_physicians as $signing_physician) {
										if($signing_physician == $c_signing_physician) {
											$existing_signing_physician_set = true;
									    	echo '<option value="' . $signing_physician . '" selected>' . $signing_physician .'</option>';
									    } else {
									    	echo '<option value="' . $signing_physician . '">' . $signing_physician .'</option>';
									    }
								    }
									} else {
										$signing_physicians = $group_mapping2[$default_consult_medical_group];
										echo '<option value="-1" selected>' . TOUCH_HERE . '</option>';
										foreach($signing_physicians as $signing_physician) {
									    	echo '<option value="' . $signing_physician . '">' . $signing_physician .'</option>';
									    }
									}
									
									
								}
								if($default_consult_medical_group && $c_signing_physician && !$existing_signing_physician_set) {
									echo "<option value='-2' selected>" . OTHER . "</option>";
								} else {
									echo "<option value='-2'>" . OTHER . "</option>";
								}
							?>
						</select>
						<?php
							if($default_consult_medical_group && $c_signing_physician && !$existing_signing_physician_set) {
								echo "<div id='other_signing_physician_div' class='input_field other_field'>";
								echo '<input id="other_signing_physician_input" type="text" placeholder="' . OTHER . '" value="' . $c_signing_physician . '">';
								echo "</div>";
							} else {
								echo "<div id='other_signing_physician_div' class='hidden input_field other_field'>";
								echo '<input id="other_signing_physician_input" type="text" placeholder="' . OTHER . '">';
								echo "</div>";
							}
						?>
					</div>
				</div>

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo LOG_CONSULT_AS_COMPLETE; ?></p>
						<form id="consult_complete_radiogroup" class="input_field">
				    		<input id='complete_yes' type='radio' name='consult_complete' value='2' <?php if($c_datetime_completed) { echo "checked"; }?>><label for='complete_yes'><?php echo YES; ?></label>
							<input id='complete_no' type='radio' name='consult_complete' value='1'><label for='complete_no'><?php echo NO; ?></label>
						</form>
					</div>
				</div>

				<div class="row input_row">
					<div class="col-xs-12">
						<p class="input_label"><?php echo NOTES_FIELD; ?></p>
						<textarea id='sign_notes_input' class='input_field'></textarea>
					</div>
				</div>
			</div>
		    <div class="modal-footer">
		      	<button id="sign_delete_button" type="button" class="btn btn-default hidden"><?php echo DELETE_CAPS; ?></button>
		        <button id="sign_save_button" type="button" class="btn btn-default" onclick="signSaveClick(<?php echo $consult_id . ', '. $mode; ?>);"><?php echo SAVE_CAPS; ?></button>
	      	</div>
	    </div>
	</div>
</div>

<?php
}
?>

<div id="myDeleteModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

	    <!-- Modal content-->
	 	<div class="modal-content">
	      	<div class="modal-header">
	        	<button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        	<h4 id="modal_header" class="modal-title"><?php echo DELETE_CONSULT; ?></h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="input_row">
	      			<p class="input_label"><?php echo DELETE_MESSAGE; ?></p>
	      			<p id="delete_message_code_p" class="input_label"></p>
		        	<input id='delete_code_input' class='input_field' type="number">
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button id="delete_submit_button" type="button" class="btn btn-default"><?php echo SUBMIT; ?></button>
	      	</div>
	    </div>

	</div>
</div>



<script>

$(window).on('load',function(){
	var consult_id = getURLParameter("consult_id");
	var mode = getURLParameter("mode");
	var consult_option = getURLParameter("show");
	if(consult_option == 1) {
		chiefComplaintLoad(consult_id, mode, consult_option);
	} else if(consult_option == 3) {
		vitalSignsMeasurementsLoad(consult_id, mode, consult_option);
	} else if (consult_option == 4) {
		examsLoad(consult_id, mode, consult_option);
	} else if (consult_option == 5) {
		diagnosesLoad(consult_id, mode, consult_option);
	} else if (consult_option == 6) {
		treatmentLoad(consult_id, mode, consult_option);
	} else if (consult_option == 7) {
		followupLoad(consult_id, mode, consult_option);
	} else if (consult_option == 8) {
		signAndCompleteLoad(consult_id, mode, consult_option);
	}
});

function chiefComplaintClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=1" + lang_text;
}

function vitalSignsMeasurementsClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=3" + lang_text;
}

function examsClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=4" + lang_text;
}

function diagnosisClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=5" + lang_text;
}

function treatmentClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=6" + lang_text;
}

function followupClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=7" + lang_text;
}

function signAndCompleteClick(consult_id, mode) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&show=8" + lang_text;
}

function deleteConsultClick(consult_id, mode) {
	$("#myDeleteModal").modal('show');
	var val = Math.floor(1000 + (Math.random() * 9000));
	$("#delete_message_code_p").html(val);

	$("#delete_submit_button").unbind();
	$("#delete_submit_button").click(function() { 
		deleteSubmitClick(consult_id, mode, val);
	});

}

function deleteSubmitClick(consult_id, mode, delete_code) {
	if($("#delete_code_input").val() == delete_code) {
		window.location.href = "consult_active.php?save=2&consult_id=" + consult_id + "&mode=" + mode + "&delete_code=" + delete_code + getLang(1);
	} else {
		alert(INCORRECT);
	}
}

function signAndCompleteLoad(consult_id, mode, consult_option) {
	$("#mySignModal").modal('show');
	var medical_group_selected = $("#medical_group_select").val();
	if (medical_group_selected != "-1") {
		$("#chief_physician_row").removeClass("hidden");
		$("#signing_physician_row").removeClass("hidden");
	}

	var other_location = $("#other_location_input").val();
	if(other_location) {
		$("#location_select").val("-2");
		$("#other_location_div").removeClass("hidden");
	}

	var other_medical_group = $("#other_medical_group_input").val();
	if(other_medical_group) {
		$("#other_medical_group_div").removeClass("hidden");
		$("#chief_physician_row").removeClass("hidden");
		$("#chief_physician_select").addClass("hidden");
		$("#other_chief_physician_div").removeClass("hidden");

		$("#signing_physician_row").removeClass("hidden");
		$("#signing_physician_select").addClass("hidden");
		$("#other_signing_physician_div").removeClass("hidden");
	}

	var other_chief_physician = $("#other_chief_physician_input").val();
	if(other_chief_physician) {
		$("#chief_physician_select").val("-2");
		$("#other_chief_physician_div").removeClass("hidden");
	}
}

$("#location_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_location_div").removeClass("hidden");
	} else {
		$("#other_location_div").addClass("hidden");
	}
});


$("#medical_group_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_medical_group_div").removeClass("hidden");
		$("#chief_physician_row").removeClass("hidden");
		$("#chief_physician_select").addClass("hidden");
		$("#other_chief_physician_div").removeClass("hidden");

		$("#signing_physician_row").removeClass("hidden");
		$("#signing_physician_select").addClass("hidden");
		$("#other_signing_physician_div").removeClass("hidden");
	} else {
		$("#other_medical_group_div").addClass("hidden");
		if (value == "-1") {
			$("#chief_physician_row").addClass("hidden");
			$("#signing_physician_row").addClass("hidden");
		} else {
			$("#chief_physician_row").removeClass("hidden");
			$("#chief_physician_select").removeClass("hidden");
			$("#other_chief_physician_div").addClass("hidden");	

			var chief_physicians = php_group_mapping[value];
			$("#chief_physician_select").empty();

			var element = '<option value="-1" selected>' + TOUCH_HERE + '</option>';
			$("#chief_physician_select").append(element);
			for(var i = 0; i < chief_physicians.length; i++) {
				var chief_physician = chief_physicians[i];
				element = '<option value="' + chief_physician + '">' + chief_physician + '</option>';
				$("#chief_physician_select").append(element);
			}	
			 element = '<option value="-2">' + OTHER + '</option>';
			$("#chief_physician_select").append(element);


			$("#signing_physician_row").removeClass("hidden");
			$("#signing_physician_select").removeClass("hidden");
			$("#other_signing_physician_div").addClass("hidden");	

			var signing_physicians = php_group_mapping2[value];
			$("#signing_physician_select").empty();

			var element = '<option value="-1" selected>' + TOUCH_HERE + '</option>';
			$("#signing_physician_select").append(element);
			for(var i = 0; i < signing_physicians.length; i++) {
				var signing_physician = signing_physicians[i];
				element = '<option value="' + signing_physician + '">' + signing_physician + '</option>';
				$("#signing_physician_select").append(element);
			}	
			element = '<option value="-2">' + OTHER + '</option>';
			$("#signing_physician_select").append(element);

		}
	}
});

$("#chief_physician_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_chief_physician_div").removeClass("hidden");
	} else {
		$("#other_chief_physician_div").addClass("hidden");
	}
});

$("#signing_physician_select").change(function() {
	var value = $(this).val();
	if(value == "-2") {
		$("#other_signing_physician_div").removeClass("hidden");
	} else {
		$("#other_signing_physician_div").addClass("hidden");
	}
});

function signSaveClick(consult_id, mode) {
	var location = $("#location_select").val();
	if(location == "-1") {
		location = "";
	} else if (location == "-2") {
		location = $("#other_location_input").val();
	}

	var medical_group = $("#medical_group_select").val();
	if(medical_group == "-1") {
		medical_group = "";
	} else if (medical_group == "-2") {
		medical_group = $("#other_medical_group_input").val();
	}

	var chief_physician = $("#chief_physician_select").val();
	if(chief_physician == "-1") {
		chief_physician = "";
	} else if (chief_physician == "-2") {
		chief_physician = $("#other_chief_physician_input").val();
	}

	var signing_physician = $("#signing_physician_select").val();
	if(signing_physician == "-1") {
		signing_physician = "";
	} else if (signing_physician == "-2") {
		signing_physician = $("#other_signing_physician_input").val();
	}

	var notes = $("#sign_notes_input").val();

	var complete = $('input[name=consult_complete]:checked', '#consult_complete_radiogroup').val();
	if(!complete) {
		complete = "";
	}

	if(!medical_group) {
		chief_physician = "";
		signing_physician = "";
	}

	window.location.href = "consult_active.php?save=2&consult_id=" + consult_id + "&mode=" + mode + "&location=" + location + "&medical_group=" + medical_group + "&chief_physician=" + chief_physician + "&signing_physician=" + signing_physician + "&notes=" + notes + "&complete=" + complete + getLang(1);
}

function followupLoad(consult_id, mode, consult_option) {
	$('#myFollowupModal').modal('show');
}

function followupSaveClick(consult_id, mode, followup_id) {
	var valid_submission = true;

	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var is_followup_needed = $("input[name=is_needed_input]:checked").val();
	var type_selected = $('#type_select').find(":selected").val();
	var type_custom = $('#type_custom').val();
	var reason_selected = $('#reason_select').find(":selected").val();
	var reason_custom = $('#reason_custom').val();
	var notes = $('#notes_input').val();

	var is_needed = 0;
	var is_type_custom = 0;
	var type = "";
	var is_reason_custom = 0;
	var reason = "";

	if(is_followup_needed == 'yes') {
		is_needed = 2;
	} else if (is_followup_needed == 'no') {
		is_needed = 1;
		notes = "";
	} else {
		valid_submission = false;
	}
	if(is_needed == 2) {
		if(type_selected == '0') {
			valid_submission = false;
		} else if(type_selected == 'other') {
			is_type_custom = 2;
			if(type_custom) {
				type = type_custom;
				is_reason_custom = 2;
				if(reason_custom) {
					reason = reason_custom;
				} else {
					valid_submission = false;
				}
			} else {
				valid_submission = false;
			}
		} else {
			is_type_custom = 1;
			type = type_selected;
			if(reason_selected == 'other') {
				is_reason_custom = 2;
				if(reason_custom) {
					reason = reason_custom;
				} else {
					valid_submission = false;
				}
			} else {
				is_reason_custom = 1;
				reason = reason_selected;
			}
		}
	}

	if(!valid_submission) {
		alert(EMPTY_FIELDS_MUST_COMPLETE_MESSAGE);
		return;
	}

	window.location.href = "consult_active.php?save=2&mode=" + mode + "&consult_id=" + consult_id + "&is_needed=" + is_needed + "&is_type_custom=" + is_type_custom + "&type=" + type + "&is_reason_custom=" + is_reason_custom + "&reason=" + reason + "&notes=" + notes + extra_text;
}

function followupDeleteClick(consult_id, mode, followup_id) {
	window.location.href = "consult_active.php?delete=2&mode=" + mode + "&consult_id=" + consult_id + "&reason=" + getLang(1);
}

var is_followup_needed = $("input[name=is_needed_input]:checked").val();
if (is_followup_needed == "yes") {
	$('#followup_content_div').removeClass("hidden");
} else if (is_followup_needed == "no") {
	$('#followup_content_div').addClass("hidden");
} else {
	$('#followup_content_div').addClass("hidden");
}

var type_selected = $('#type_select').find(":selected").val();
if(type_selected == '0') {
	$("#custom_type_row").addClass("hidden");
	$("#custom_reason_row").addClass("hidden");
	$("#reason_select_row").addClass("hidden");
} else if(type_selected == 'other') {
	$("#custom_type_row").removeClass("hidden");
	$("#custom_reason_row").removeClass("hidden");
	$("#reason_select_row").addClass("hidden");
} else {
	$("#custom_type_row").addClass("hidden");
	$("#custom_reason_row").addClass("hidden");
	$("#reason_select_row").removeClass("hidden");


	var reason_selected = $('#reason_select').find(":selected").val();
	if(reason_selected == '0') {
		$("#custom_reason_row").addClass("hidden");
	} else if (reason_selected == 'other') {
		$("#custom_reason_row").removeClass("hidden");
	} else {
		$("#custom_reason_row").addClass("hidden");
	}
}





$("input[name=is_needed_input]").change(function() {
	var value = $("input[name=is_needed_input]:checked").val();
	if (value == "yes") {
		$('#followup_content_div').removeClass("hidden");
	} else if (value == "no") {
		$('#followup_content_div').addClass("hidden");
	} else {
		$('#followup_content_div').addClass("hidden");
	}
});

$("#type_select").change(function() {
	var selected = $('#type_select').find(":selected").val();

	if (selected == "other")  {
		$("#custom_type_row").removeClass("hidden");
		$("#custom_reason_row").removeClass("hidden");
		$("#reason_select_row").addClass("hidden");
	} else if (selected == '0') {
		$("#custom_type_row").addClass("hidden");
		$("#custom_reason_row").addClass("hidden");
		$("#reason_select_row").addClass("hidden");
	} else {
		$("#custom_type_row").addClass("hidden");
		$("#custom_reason_row").addClass("hidden");
		$("#reason_select_row").removeClass("hidden");

		$("#reason_select").empty();
		var reason_array = php_followup_map[selected];
		for(var i = 0; i < reason_array.length; i++) {
			var reason = reason_array[i];
			var element = "";
			if (i == reason_array.length - 1) {
				element = "<option value='other'>" + reason + "</option>";
			} else {
				element = "<option value='" + i + "'>" + reason + "</option>";
			}
			$("#reason_select").append(element);
		}
		
		$("#reason_select option[value='0']").prop("selected", true);
	}
});

$("#reason_select").change(function() {
	var selected = $('#reason_select').find(":selected").val();

	if (selected == "other")  {
		$("#custom_reason_row").removeClass("hidden");
	} else if (selected == '0') {
		$("#custom_reason_row").addClass("hidden");
	} else {
		$("#custom_reason_row").addClass("hidden");
	}
});




</script>

<script type="text/javascript" src="js/my_consult_javascript.js" ></script>


</html>