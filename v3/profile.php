<!DOCTYPE html>
<html onclick="closeNav();">

<?php
	require_once 'include/include.php';

	$mode = MODE_NONE;
	if(isset($_GET[MODE_ARG])) {
		$mode = $_GET[MODE_ARG];
	}

	$patient_id = INVALID_VALUE;
	if(isset($_GET[PATIENT_ID_ARG])) {
		$patient_id = $_GET[PATIENT_ID_ARG];
		if(!$db->patientExists($patient_id)) {
			$patient_id = INVALID_VALUE;
		}
	}

	if($patient_id == INVALID_VALUE) {
		header("LOCATION: index.php?lang=" . $lang);
	}

	if(isset($_GET['message_id'])) {
		$message_id = $_GET['message_id'];
		if(isset($_GET['message'])) {
			$message = $_GET[MESSAGES_COLUMN_MESSAGE];
			$status = $_GET[MESSAGES_COLUMN_STATUS];
			$submitter = $_GET[MESSAGES_COLUMN_SUBMITTER];

			$db->createNewMessage($message_id, $patient_id, $status, $message, $submitter, Utilities::getCurrentDateTime());
		} else {
			$db->deleteMessage($message_id);
		}

		header("LOCATION: profile.php?patient_id=" . $patient_id . "&mode=" . $mode . "&lang=" . $lang);
	}

	$patient = $db->getPatient($patient_id);
	$name = $patient[PATIENTS_COLUMN_NAME];
	$community_name = $patient[PATIENTS_COLUMN_COMMUNITY_NAME];
	$exact_date_of_birth_known = $patient[PATIENTS_COLUMN_EXACT_DATE_OF_BIRTH_KNOWN];
	$date_of_birth = $patient[PATIENTS_COLUMN_DATE_OF_BIRTH];
	$sex = $patient[PATIENTS_COLUMN_SEX];

	$formatted_date_of_birth = Utilities::formatDateForDisplay($date_of_birth);
	if($exact_date_of_birth_known == BOOLEAN_FALSE) {
		$formatted_date_of_birth .= " " . APPROXIMATE_ABBREVIATION;
	}
	$age_string = Utilities::getCurrentAgeString($date_of_birth, $lang);

	$sex_text = Utilities::getSexText($sex);

	$active_consult_id = INVALID_VALUE;
	if($db->hasActiveConsult($patient_id)) {
		$active_consult_id = $db->getActiveConsultId($patient_id);
	}


?>

<div id="mySidenav" class="sidenav">
	<a onclick="editPatient(<?php echo $mode . ', \'' . $patient_id . '\''; ?>);"><?php echo EDIT_PATIENT; ?></a>
	<a data-toggle="modal" data-target="#myModal" onclick="postMessage(<?php echo $mode . ', \'' . $patient_id . '\''; ?>);"><?php echo POST_MESSAGE; ?></a>
</div>

<div id="content" class="container-fluid" onclick="closeNav();">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo PATIENT_PROFILE; ?></span>
			<img id="navigation_header_menu" src="images/menu.png" alt="Menu" height="28px" width="28px">
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<?php
			echo '<a id="back_link" onclick="backClick(' . $mode . ', \'' . $community_name . '\');">' . BACK_TO . " " . $community_name . '</a>';
			?>
		</div>
	</div>

	<div id="divider_row" class="row">
		<div class="col-xs-12">
			<p class="left_title"><?php echo $name; ?></p>
			<p class="left_title3"><?php echo DATE_OF_BIRTH_FIELD . " " . $formatted_date_of_birth; ?></p>
			<p class="left_title3"><?php echo AGE_FIELD . " " . $age_string; ?></p>
			<p class="left_title3"><?php echo SEX_FIELD . " " . $sex_text; ?></p>
		</div>
	</div>


	<div id="profile_button_row" class="row">
		<div class="col-xs-6">
			<button class="fill_button" onclick="consultClick(<?php echo $mode . ', \'' . $patient_id . '\', \'' . $active_consult_id . '\''; ?>);"><?php echo CONSULT_CAPS; ?></button>
		</div>
		<div class="col-xs-6">
			<button class="fill_button" onclick="historyClick(<?php echo $mode . ', \'' . $patient_id . '\', \'' . $active_consult_id . '\''; ?>);"><?php echo HISTORY_CAPS; ?></button>
		</div>
	</div>

	<?php
	$has_active_messages = $db->hasPatientActiveMessages($patient_id);
	if($has_active_messages) {
		$active_messages = $db->getPatientActiveMessages($patient_id);
	?>
	<div class="row">
		<div class="col-xs-12">
			<p class="left_title"><?php echo ACTIVE_MESSAGES; ?></p>
			<ul class="list-group">
			<?php
				$consult_cnt = 0;
				foreach($active_messages as $active_message) {
					$message_id = $active_message['id'];
					$message = $active_message['message'];
					$submitter = $active_message['submitter'];
					$datetime_created = $active_message['datetime_created'];

					

					$temp_patient_id = "'" . $patient_id . "'";
					$temp_active_consult_id = "'" . $active_consult_id . "'";

					$formatted_datetime = Utilities::formatDateTimeForDisplay($datetime_created);

					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='messageClick($mode, \"$patient_id\", \"$message_id\", \"$message\", \"$submitter\", \"$active_consult_id\", \"$formatted_datetime\");'>";
			    	echo '<p class="list_item1">' . $formatted_datetime . '</p>';
			    	echo '<p class="list_item2">' . POSTED_BY_FIELD . " " . $submitter . '</p>';
			    	echo "</li>";
			    	$consult_cnt++;
			    	if($consult_cnt == 10) {
			    		break;
			    	}
				}
			?>
			</ul>
		</div>
	</div>
	<?php
	}
	?>


	<div class="row">
		<div class="col-xs-12">
			<p class="left_title"><?php echo PAST_CONSULTS; ?></p>
<?php
	$has_consults = $db->hasConsults($patient_id);
	if($has_consults) {
		echo '<ul class="list-group">';
		$consults = $db->getConsults($patient_id);
		foreach($consults as $consult){
	    	$consult_id = $consult["id"];
	    	$datetime_started = $consult["datetime_started"];
	    	$status = $consult['status'];

	    	$temp_consult_id = '"' . $consult_id . '"';

	    	$line1_text = Utilities::formatDateForDisplay($datetime_started);
	    	$line2_text = "";

	    	if(isset($consult["datetime_completed"])) {
	    		if($status != CONSULT_STATUS_CONSULT_COMPLETED) {
	    			$status = CONSULT_STATUS_CONSULT_COMPLETED;
	    			$db->updateConsultStatus($patient_id, $consult_id, CONSULT_STATUS_CONSULT_COMPLETED);
	    		}
	    		$datetime_completed = $consult["datetime_completed"];
	    		$line1_text = Utilities::formatDateForDisplay($datetime_completed) . " (" . COMPLETED . ")";
	    	} else {
	    		$line1_text .= " (" . ACTIVE . ")";
	    		if($status == CONSULT_STATUS_READY_FOR_TRIAGE_PENDING) {
	    			$line2_text = TRIAGE_INTAKE_PENDING;
	    		} else if($status == CONSULT_STATUS_READY_FOR_TRIAGE_IN_PROGRESS) {
	    			$line2_text = TRIAGE_INTAKE_IN_PROGRESS;
	    		} else if($status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_PENDING) {
	    			$line2_text = MEDICAL_CONSULT_PENDING;
	    		} else if($status == CONSULT_STATUS_READY_FOR_MEDICAL_CONSULT_IN_PROGRESS) {
	    			$line2_text = MEDICAL_CONSULT_IN_PROGRESS;
	    		} 
	    	}

	    	echo "<li class='list-group-item'onclick='existingConsultClick($mode, $temp_consult_id, $status);'>";
	    	echo '<p class="list_item1">' . $line1_text . '</p>';
	    	if($line2_text != "") {
		    	echo '<p class="list_item2">' . $line2_text . '</p>';
		    }
	    	echo "</li>";
	    	    }
	    echo '</ul>';
	} else {
    	echo '<p class="center_title3">' . NO_PAST_CONSULTS . '</p>';
    } 

?>
		</div>
	</div>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo POST_MESSAGE; ?></p>
      </div>
      <div class="modal-body">
  		<div class="input_row">
        	<p class="left_title4"><?php echo MESSAGE_FIELD; ?></p>
        	<textarea id='message_input' class='modal_input_field'></textarea>
        </div>
      	<div class="input_row">
        	<p class="left_title4"><?php echo NAME_OF_POSTER_FIELD; ?></p>
        	<input id='poster_input' class='modal_input_field'>
        </div>
    	<div class="input_row">
    		<p class="left_title4"><?php echo STATUS_FIELD; ?></p>
    		<form id="status_radiogroup" class="modal_input_field">
	    		<input id='status_active' type='radio' name='status' value='1' checked><label for='status_active'><?php echo ACTIVE; ?></label>
				<input id='status_inactive' type='radio' name='status' value='2'><label for='status_inactive'><?php echo INACTIVE; ?></label>
			</form>
    	</div>

    	<p id="active_consult_a" class="left_title3 hidden"><a><?php echo GO_TO_ACTIVE_CONSULT; ?></a></p>
      </div>
      <div class="modal-footer">
      	<button id="delete_button" type="button" class="btn btn-default"><?php echo DELETE_CAPS; ?></button>
        <button id="save_button" type="button" class="btn btn-default"><?php echo SAVE_CAPS; ?></button>
      </div>
    </div>

  </div>
</div>


<script>

function backClick(mode, community_name) {
	var lang_text = getLang(1);
	window.location.href = "browse_patients.php?mode=" + mode + "&community_name=" + community_name + lang_text;
}

function editPatient(mode, patient_id) {
	var lang_text = getLang(1);
	window.location.href = "add_patient.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function postMessage(mode, patient_id) {
	$("#delete_button").hide();

	$("#message_input").val("");
	$("#poster_input").val("");
	$("#active_consult_a").hide();

	$("#save_button").unbind();
	$("#save_button").click(function() {
		saveMessage(mode, patient_id, -1);
	});
}

function saveMessage(mode, patient_id, message_id) {
	var valid_submission = true;

	var message = $("#message_input").val();
	if(!message) {
		valid_submission = false;
	}
	var poster = $("#poster_input").val();
	if(!poster) {
		valid_submission = false;
	}

	var status = $("input[name=status]:checked").val();
	if(status) {
		if(status != "1" && status != "2") {
			valid_submission = false;;
		}
	} else {
		valid_submission = false;
	} 

	if(!valid_submission) {
		var lang = getURLParameter("lang");
		var alert_text = "ERROR: ALL FIELDS MUST BE COMPLETED";
		if(lang == "es") {
			alert_text = "ERROR: NECESITA COMPLETAR TODOS LOS CAMPOS";
		}
		alert(alert_text);
	} else {
		var lang_text = getLang(1);
		window.location.href = "profile.php?patient_id=" + patient_id + "&message_id=" + message_id + "&message=" + message + "&submitter=" + poster + "&status=" + status + lang_text;
	}
}

function deleteMessage(mode, patient_id, message_id) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + "&message_id=" + message_id + lang_text;
}

function messageClick(mode, patient_id, message_id, message, submitter, active_consult_id, formatted_datetime) {
	var lang = getURLParameter("lang");
	var message_text = (lang == "es") ? "Mensaje: " : "Message: ";
	$("#modal_header").html(message_text + formatted_datetime);
	$("#myModal").show();
	$("#delete_button").show();
	$("#delete_button").unbind();
	$("#delete_button").click(function() {
		deleteMessage(mode, patient_id, message_id);
	});

	$("#save_button").unbind();
	$("#save_button").click(function() {
		saveMessage(mode, patient_id, message_id);
	});


	$("#message_input").val(message);
	$("#poster_input").val(submitter);

	if(active_consult_id != -1) {
		$("#active_consult_a").show();
		$("#active_consult_a").unbind();
		$("#active_consult_a").click(function() {
			consultClick(active_consult_id, patient_id, 0);
		});
	} else {
		$("#active_consult_a").hide();
	}
}

function existingConsultClick(mode, consult_id, status) {
	var lang_text = getLang(1);
	if(status != 5) {
		window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + lang_text;
	} else {
		window.location.href = "consult_complete.php?mode=" + mode + "&consult_id=" + consult_id + lang_text;
	}
}

function consultClick(mode, patient_id, active_consult_id) {
	var lang_text = getLang(1);
	if(active_consult_id == -1) {
		window.location.href = "consult_active.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
	} else {
		window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + active_consult_id + lang_text;
	}
}

function historyClick(mode, patient_id, active_consult_id) {
	var lang_text = getLang(1);
	window.location.href = "history.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
	/*
	if(active_consult_id == -1) {
		window.location.href = "history.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
	} else {
		window.location.href = "history.php?mode=" + mode + "&patient_id=" + patient_id + "&consult_id=" + active_consult_id + lang_text;
	}
	*/
}


</script>

</html>
