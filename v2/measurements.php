
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
	$measurements = null;

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];

		if(isset($_GET['temperature_units'])) {
			$is_pregnant = $_GET['is_pregnant'];
			if(!$is_pregnant) {
				$is_pregnant = NULL;
			}
			$date_last_menstruation = $_GET['date_last_menstruation'];
			if(!$date_last_menstruation) {
				$date_last_menstruation = NULL;
			}
			$temperature_units = $_GET['temperature_units'];
			if (!$temperature_units) {
				$temperature_units = NULL;
			}			
			$temperature_value = $_GET['temperature_value'];
			if (!$temperature_value) {
				$temperature_value = NULL;
			}
			$blood_pressure_systolic = $_GET['blood_pressure_systolic'];
			if(!$blood_pressure_systolic) {
				$blood_pressure_systolic = NULL;
			}
			$blood_pressure_diastolic = $_GET['blood_pressure_diastolic'];
			if(!$blood_pressure_diastolic) {
				$blood_pressure_diastolic = NULL;
			}
			$pulse_rate = $_GET['pulse_rate'];
			if(!$pulse_rate) {
				$pulse_rate = NULL;
			}
			$blood_oxygen_saturation = $_GET['blood_oxygen_saturation'];
			if(!$blood_oxygen_saturation) {
				$blood_oxygen_saturation = NULL;
			}
			$respiration_rate = $_GET['respiration_rate'];
			if(!$respiration_rate) {
				$respiration_rate = NULL;
			}
			$weight_units = $_GET['weight_units'];
			if(!$weight_units) {
				$weight_units = NULL;
			}
			$weight_value = $_GET['weight_value'];
			if(!$weight_value) {
				$weight_value = NULL;
			}
			$height_units = $_GET['height_units'];
			if(!$height_units) {
				$height_units = NULL;
			}
			$height_value = $_GET['height_value'];
			if(!$height_value) {
				$height_value = NULL;
			}
			$waist_circumference_units = $_GET['waist_circumference_units'];
			if(!$waist_circumference_units) {
				$waist_circumference_units = NULL;
			}
			$waist_circumference_value = $_GET['waist_circumference_value'];
			if(!$waist_circumference_value) {
				$waist_circumference_value = NULL;
			}
			$notes = $_GET['notes'];
			if(!$notes) {
				$notes = NULL;
			}
			$value = $db->createNewMeasurements($consult_id, $is_pregnant, $date_last_menstruation, $temperature_units, $temperature_value, $blood_pressure_systolic, $blood_pressure_diastolic, $pulse_rate, $blood_oxygen_saturation, $respiration_rate, $weight_units, $weight_value, $height_units, $height_value, $waist_circumference_units, $waist_circumference_value, $notes);
			if(isset($_GET['continue'])) {
				//SEND TO THE RIGHT PAGE
				header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&lang=" . $lang);
			} else {
				header("LOCATION: measurements.php?consult_id=" . $consult_id . "&lang=" . $lang);
			}
		}

		if($db->hasMeasurements($consult_id)) {
			$measurements = $db->getMeasurements($consult_id);
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
			<p class="content_p consult_section"><?php echo VITAL_SIGNS_MEASUREMENTS; ?></p>
		</div>
	</div>

	<?php
		if($patient_sex == SEX_FEMALE) {
	?>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<?php
		}
	?>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>
	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>


	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

		<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
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
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo NOTES . ":"; ?></p>
<?php
				if($measurements && isset($measurements['notes'])) {
					$notes = $measurements['notes'];
					echo "<textarea id='notes_input' class='input_field'>$notes</textarea>";
				} else {
					echo "<textarea id='notes_input' class='input_field'></textarea>";
				}
?>	
		</div>
	</div>

<?php
	if($editable) {
?>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 1"; ?>);"><?php echo SAVE_AND_STAY; ?></button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="save(<?php echo $consult_id . ", 2"; ?>);"><?php echo SAVE_AND_CONTINUE; ?></button>
		</div>
	</div>

<?php
	} else {
?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="continueFunction(<?php echo $consult_id; ?>);"><?php echo CONTINUE_WORD; ?></button>
		</div>
	</div>

<?php
	}
?>

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

function consultClick(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
}

function save(consult_id, arg) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(arg == 2) {
		extra_text += "&continue=2";
	}

	var is_pregnant = $("input[name=is_pregnant]:checked").val();
	if(is_pregnant) {
		if(is_pregnant == "yes") {
			is_pregnant = 2;
		} else if (is_pregnant == "no") {
			is_pregnant = 1;
		} else {
			is_pregnant = "";
		}
	} else {
		is_pregnant = "";
	} 

	var date_last_menstruation = $("#date_last_menstruation_input").val();
	if(!date_last_menstruation) {
		date_last_menstruation = "";
	}


	var temperature_units = $("input[name=temperature_units]:checked").val();
	if(temperature_units) {
		if(temperature_units == "celsius") {
			temperature_units = 1;
		} else if (temperature_units == "fahrenheit") {
			temperature_units = 2;
		} else {
			temperature_units = "";
		}
	} else {
		temperature_units = "";
	}
	var temperature_value = document.getElementById("temperature_input").value;
	if(temperature_value) {
		if(!temperature_units) {
			var alert_text = "ERROR: MUST SELECT UNITS FOR TEMPERATURE.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA ESCOGER UNIDADES PARA TEMPERATURA.";
			}
			alert(alert_text);
			return;
		}
	} else {
		temperature_units = "";

	}
	var blood_pressure_systolic = document.getElementById("blood_pressure_systolic_input").value;
	var blood_pressure_diastolic = document.getElementById("blood_pressure_diastolic_input").value;
	var pulse_rate = document.getElementById("pulse_rate_input").value;
	var blood_oxygen_saturation = document.getElementById("blood_oxygen_saturation_input").value;
	var respiration_rate = document.getElementById("respiration_rate_input").value;
	var weight_units = $("input[name=weight_units]:checked").val();
	if(weight_units) {
		if(weight_units == "kilograms") {
			weight_units = 1;
		} else if(weight_units == "pounds") {
			weight_units = 2;
		} else {
			weight_units = "";
		}
	} else {
		weight_units = "";
	}
	var weight_value = document.getElementById("weight_input").value;
	if(weight_value) {
		if(!weight_units) {
			var alert_text = "ERROR: MUST SELECT UNITS FOR WEIGHT.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA ESCOGER UNIDADES PARA PESO.";
			}
			alert(alert_text);
			return;
		}
	} else {
		weight_units = "";
	}
	var height_units = $("input[name=height_units]:checked").val();
	if(height_units) {
		if(height_units == "centimeters") {
			height_units = 1;
		} else if(height_units == "inches") {
			height_units = 2;
		} else {
			height_units = "";
		}
	} else {
		height_units = "";
	}
	var height_value = document.getElementById("height_input").value;
	if(height_value) {
		if(!height_units) {
			var alert_text = "ERROR: MUST SELECT UNITS FOR HEIGHT.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA ESCOGER UNIDADES PARA TALLA.";
			}
			alert(alert_text);
			return;
		}
	} else {
		height_units = "";
	}
	var waist_circumference_units = $("input[name=waist_circumference_units]:checked").val();
	if(waist_circumference_units) {
		if(waist_circumference_units == "centimeters") {
			waist_circumference_units = 1;
		} else if(waist_circumference_units == "inches") {
			waist_circumference_units = 2;
		} else {
			waist_circumference_units = "";
		}
	} else {
		waist_circumference_units = "";
	}
	var waist_circumference_value = document.getElementById("waist_circumference_input").value;
	if(waist_circumference_value) {
		if(!waist_circumference_units) {
			var alert_text = "ERROR: MUST SELECT UNITS FOR WAIST CIRCUMFERENCE.";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA ESCOGER UNIDADES PARA CIRCUNFERENCIA DE CINTURA.";
			}
			alert(alert_text);
			return;
		}
	} else {
		waist_circumference_units = "";
	}

	var notes = document.getElementById("notes_input").value;

	window.location.href = "measurements.php?consult_id=" +  consult_id + "&is_pregnant=" + is_pregnant + "&date_last_menstruation=" + date_last_menstruation + "&temperature_units=" + temperature_units + "&temperature_value=" + temperature_value + "&blood_pressure_systolic=" + blood_pressure_systolic + "&blood_pressure_diastolic=" + blood_pressure_diastolic + "&pulse_rate=" + pulse_rate + "&blood_oxygen_saturation=" + blood_oxygen_saturation + "&respiration_rate=" + respiration_rate + "&weight_units=" + weight_units + "&weight_value=" + weight_value + "&height_units=" + height_units + "&height_value=" + height_value + "&waist_circumference_units=" + waist_circumference_units + "&waist_circumference_value=" + waist_circumference_value + "&notes=" + notes + extra_text; 
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "exam_new2.php?consult_id=" + consult_id + extra_text;
}


</script>

