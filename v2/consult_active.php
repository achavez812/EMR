
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
	$patient_id = 0;

	if (isset($_GET['consult_id']) && isset($_GET['patient_id'])) {
		$consult_id = $_GET['consult_id'];
		$patient_id = $_GET['patient_id'];
	} else if (isset($_GET['patient_id'])) {
		$patient_id = $_GET['patient_id'];
		$consult_id = $db->startNewConsult($patient_id, Utilities::getCurrentDateTime());
 
		header("LOCATION: consult_active.php?patient_id=" . $patient_id . "&consult_id=" . $consult_id . "&lang=" . $lang);
	} else {
		header($index_link);
	}

	if(isset($_GET['status'])) {
		$status = $_GET['status'];
		if($status == CONSULT_STATUS_FINAL) {
			$db->updateConsultStatus($consult_id, $status);
			header("LOCATION: consult_complete.php?patient_id=" . $patient_id . "&consult_id=" . $consult_id . "&lang=" . $lang);
		} else if($status == CONSULT_STATUS_EDIT && isset($_GET['edit_code'])) {
			$edit_code = $_GET['edit_code'];
			$valid_edit_code = $db->validateEditKey($edit_code);
			if($valid_edit_code) {
				$db->updateConsultStatus($consult_id, $status);
				header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
			} else {
				echo "<script type='text/javascript'>alert('" . INVALID_EDIT_CODE . "');</script>";
			}
		} else if ($status == CONSULT_STATUS_VIEW) {
			$db->updateConsultStatus($consult_id, $status);
			header("LOCATION: consult_active.php?consult_id=" . $consult_id . "&patient_id=" . $patient_id . "&lang=" . $lang);
		}
	}

	$patient = $db->getPatientById($patient_id);	
	$consult = $db->getConsult($consult_id);

	$status = $consult['status'];

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
			<p class="content_p"><?php echo $display_text; ?></p>
		</div>
	</div>

	<?php
		if($status == CONSULT_STATUS_VIEW) {
			echo "<p class='content_p'>" . NOT_EDITABLE . "</p>";
		}
		if($status == CONSULT_STATUS_EDIT) {
			echo "<p class='content_p'>" . YES_EDITABLE . "</p>";
	?>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="finalizeFunction(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo FINALIZE; ?></button>
		</div>
	</div>

	<?php
		}
	?>

	<div class="row row3">

		<div class="col-xs-12">

			<ul class="list-group">
				<li class="list-group-item" onclick="chiefComplaintsClick(<?php echo $consult_id; ?>);"><?php echo CHIEF_COMPLAINT; ?> 
					<?php if($db->hasChiefComplaint($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>
				
				<li class="list-group-item" onclick="historyPresentIllnessClick(<?php echo $consult_id; ?>);"><?php echo HISTORY_OF_PRESENT_ILLNESS; ?>
					<?php if($db->consultHasHPI($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>
				
				<li class="list-group-item" onclick="measurementsClick(<?php echo $consult_id; ?>);"><?php echo VITAL_SIGNS_MEASUREMENTS; ?>
					<?php if($db->hasMeasurements($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>

				<li class="list-group-item" onclick="examsNewClick(<?php echo $consult_id; ?>);"><?php echo EXAMS; ?>
					<?php if($db->hasExams($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>
				
				<li class="list-group-item" onclick="diagnosesClick(<?php echo $consult_id; ?>);"><?php echo DIAGNOSIS; ?>
					<?php if($db->hasConsultDiagnosis($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>
				<li class="list-group-item" onclick="treatmentsClick(<?php echo $consult_id; ?>);"><?php echo TREATMENTS; ?>
					<?php if($db->hasConsultTreatments($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>
				<li class="list-group-item" onclick="followupClick(<?php echo $consult_id; ?>);"><?php echo FOLLOWUP; ?>
				<?php if($db->hasExistingFollowup($consult_id)) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; } ?>
				</li>

				<li class="list-group-item" onclick="signCompleteClick(<?php echo $consult_id; ?>);"><?php echo SIGN_AND_COMPLETE; ?></li>

			</ul>

		</div>

	</div>

	<?php
		if($status == CONSULT_STATUS_VIEW) {
	?>
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button data-toggle='modal' data-target='#myModal' class="consult_button" type="button" onclick="edit(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo EDIT_CONSULT; ?></button>
		</div>
	</div>

	<?php
		}
	?>

	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 id="modal_header" class="modal-title"><?php echo EDIT_VALIDATION; ?></h4>
	      </div>
	      <div class="modal-body">
	      	<div class="input_row">
		      	<div class="input_row">
		        	<p class="input_label"><?php echo EDIT_CODE . ":"; ?></p>
		        	<input id='edit_code_input' class='input_field'>
		        </div>
	    	</div>
	      </div>
	      <div class="modal-footer">
	        <button id="submit_button" type="button" class="btn btn-default"><?php echo SUBMIT; ?></button>
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

function finalizeFunction(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?consult_id=" + consult_id + "&patient_id=" + patient_id + "&status=1" + extra_text;
}

function chiefComplaintsClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "chief_complaints.php?consult_id=" + consult_id + extra_text;
}

function historyPresentIllnessClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "history_present_illness.php?consult_id=" + consult_id + extra_text;
}

function measurementsClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "measurements.php?consult_id=" + consult_id + extra_text;
}

function examsClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "exams.php?consult_id=" + consult_id + extra_text;
}

function examsNewClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "exams_new2.php?consult_id=" + consult_id + extra_text;
}

function diagnosesClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "diagnoses_new.php?consult_id=" + consult_id + extra_text;
}

function treatmentsClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments_new.php?consult_id=" + consult_id + extra_text;
}

function followupClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "followup.php?consult_id=" + consult_id + extra_text;
}

function signCompleteClick(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "sign_complete.php?consult_id=" + consult_id + extra_text;
}

function edit(consult_id, patient_id) {
	$("#myModal").show();
	$("#submit_button").unbind();
	$("#submit_button").click(function() { 
		submitFunction(consult_id, patient_id);
	});
}

function submitFunction(consult_id, patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var edit_code = $("#edit_code_input").val();
	window.location.href= "consult_active.php?consult_id=" + consult_id + "&patient_id=" + patient_id + "&edit_code=" + edit_code + "&status=3" + extra_text;
}

</script>

