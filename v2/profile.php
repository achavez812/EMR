
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

	if (!isset($_GET["id"])) {
		header($index_link);
	} 

	$patient_id = $_GET["id"];
	$patient = $db->getPatientById($patient_id);

	if(isset($_GET['message_id'])) {
		$message_id = $_GET['message_id'];
		if(isset($_GET['save'])) {
			$message_id = $_GET['message_id'];
			$message = $_GET['message'];
			$poster = $_GET['poster'];
			$status = $_GET['status'];

			$datetime = Utilities::getCurrentDateTime();

			$db->createNewMessage($message_id, $patient_id, NULL, $status, $message, $poster, $datetime);
		} else if (isset($_GET['delete'])) {
			$db->deleteMessage($message_id);
		}
		header("LOCATION: profile.php?id=" . $patient_id . "&lang=" . $lang);
	}

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];


	$community_id = $patient["community_id"];

	$community = $db->getCommunityById($community_id);
	$community_name = $community["name"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (" . APPROXIMATE_ABBREVIATION . ")";
	}

	$age_text = Utilities::getCurrentAgeString($patient_dob, $lang);

	$sex_text = "";
	if ($patient_sex == SEX_FEMALE) {
		$sex_text = FEMALE;
	} else if ($patient_sex == SEX_MALE) {
		$sex_text = MALE;
	} else {
		$sex_text = DESCONOCIDO;
	}

	$consults = $db->getConsults($patient_id);

	$active_consult_id = 0;
	if ($db->hasActiveConsult($patient_id)) {
		$active_consult_id = $db->getActiveConsult($patient_id)['id'];
	}

?>

<div class="container-fluid">

	<div id="profile_row1" class="row row1"> 
		<div class="col-xs-12">
			<h1><?php echo $patient_name; ?></h1>
			<p class="profile_header_p"><?php echo COMMUNITY . ": "; ?><a onclick="communityClick(<?php echo $community_id; ?>);"><?php echo $community_name; ?></a></p>
			<p class="profile_header_p"><?php echo DATE_OF_BIRTH . $date_of_birth_text; ?></p>
			<p class="profile_header_p"><?php echo AGE . ": " . $age_text; ?></p>
		</div>
	</div>
	<div id="profile_row2" class="row row1 last_row">
		<div class="col-xs-8">
			<p class="profile_header_p"><?php echo SEX . ": " . $sex_text; ?></p>
		</div>
		<div class="col-xs-4">
			<a id="edit_button" onclick="editPatient(<?php echo $patient_id ?>);"><?php echo EDIT; ?></a>
		</div>
	</div>



	<div class="row row2">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="newConsultButtonClick(<?php echo $patient_id; ?>);"><?php echo NEW_CONSULT; ?></button>
			<button class="consult_button" type="button" onclick="medicalHistoryClick(<?php echo $patient_id; ?>);"><?php echo MEDICAL_HISTORY; ?></button>
			<button class="consult_button" data-toggle="modal" data-target="#myModal" type="button" onclick="postMessageClick(<?php echo $patient_id; ?>);"><?php echo POST_MESSAGE; ?></button>
		</div>
	</div>

<?php
	$has_active_messages = $db->hasPatientActiveMessages($patient_id);
	if($has_active_messages) {
		$active_messages = $db->getPatientActiveMessages($patient_id);
?>
	<div class="row row3">
		<div class="col-xs-12">
			<p id="profile_history_p"><?php echo ACTIVE_MESSAGES; ?></p>
			<div class="list-group">
			<?php
				foreach($active_messages as $active_message) {
					$message_id = $active_message['id'];
					$message = $active_message['message'];
					$submitter = $active_message['submitter'];
					$datetime_created = $active_message['datetime_created'];

					$formatted_datetime = Utilities::reformatDateTimeForDisplay($datetime_created);

					echo "<a class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='messageClick($patient_id, $message_id, \"$message\", \"$submitter\", $active_consult_id, \"$formatted_datetime\");'>";
			    	echo '<p id="list_item1">' . $formatted_datetime . '</p>';
			    	echo '<p id="list_item2">' . POSTED_BY . ": " . $submitter . '</p>';
			    	echo "</a>";

				}
			?>
			</div>
		</div>
	</div>
<?php
	}
?>

	<div class="row row3">
		<div class="col-xs-12">
			<p id="profile_history_p"><?php echo EXISTING_CONSULTS; ?></p>
<?php
	$no_consults = true;
	while($consult = $consults->fetch_assoc()){
		if($no_consults) {
			$no_consults = false;
			//Put starting tag
			echo '<ul class="list-group">';
		}
    	$consult_id = $consult["id"];
    	$datetime_started = $consult["datetime_started"];
    	$in_progress = true;
    	$edit_mode = 1;
    	$status = $consult['status'];
    	if($status && $status > 1) {
    		$db->updateConsultStatus($consult_id, 1);
    	}

    	if(isset($consult["datetime_completed"])) {
    		$in_progress = false;
    	}

    	$formatted_datetime_started = Utilities::reformatDateForDisplay($datetime_started);
    	$in_progress_arg = 1;

    	$display_text = $formatted_datetime_started;
    	if($in_progress) {
    		$in_progress_arg = 2;
    		$display_text .= " (" . IN_PROGRESS . ")";
    	} else {
    		$display_text .= " (" . COMPLETED . ")";
    	}
    
    	echo '<li class="list-group-item" onclick="consultClick(' . $consult_id . ', ' . $patient_id . ', ' . $in_progress_arg . ');">' . $display_text . '</li>';
    }
    if($no_consults) {
    	//Message saying no history
    	echo '<p id="no_consults_p">' . NO_CONSULTS_FOR_PATIENT . '</p>';
    } else {
    	//Put closing tag
    	echo '</ul>';
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
	        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 id="modal_header" class="modal-title"><?php echo MESSAGE; ?></h4>
	      </div>
	      <div class="modal-body">
	      	<div id="other_input_row" class="input_row">
	      		<div class="input_row">
		        	<p class="input_label"><?php echo MESSAGE . ":"; ?></p>
		        	<textarea id='message_input' class='input_field'></textarea>
		        </div>
		      	<div class="input_row">
		        	<p class="input_label"><?php echo NAME_OF_POSTER . ":"; ?></p>
		        	<input id='poster_input' class='input_field'>
		        </div>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo STATUS . ":"; ?></p>
	    		<form id="status_radiogroup" class="input_field">
		    		<input id='status_active' type='radio' name='status' value='active' checked><label for='status_active'><?php echo ACTIVE; ?></label>
					<input id='status_inactive' type='radio' name='status' value='inactive'><label for='status_inactive'><?php echo INACTIVE; ?></label>
				</form>
	    	</div>

	    	<p id="active_consult_a" class="content_p no_display"><a><?php echo GO_TO_ACTIVE_CONSULT; ?></a></p>
	    	
	      </div>
	      <div class="modal-footer">
	      	<button id="delete_button" type="button" class="btn btn-default"><?php echo DELETE; ?></button>
	        <button id="save_button" type="button" class="btn btn-default"><?php echo SAVE; ?></button>
	      </div>
	    </div>

	  </div>
	</div>

</div>

<script type="text/javascript">

function messageClick(patient_id, message_id, message, submitter, active_consult_id, datetime) {
	$("#modal_header").html(datetime);
	$("#myModal").show();
	$("#delete_button").show();
	$("#delete_button").unbind();
	$("#delete_button").click(function() {
		deleteMessage(patient_id, message_id);
	});

	$("#save_button").unbind();
	$("#save_button").click(function() {
		saveMessage(patient_id, message_id);
	});


	$("#message_input").val(message);
	$("#poster_input").val(submitter);

	if(active_consult_id) {
		$("#active_consult_a").show();
		$("#active_consult_a").unbind();
		$("#active_consult_a").click(function() {
			consultClick(active_consult_id, patient_id, 0);
		});
	} else {
		$("#active_consult_a").hide();
	}
	
}

function postMessageClick(patient_id) {
	var lang = getURLParameter("lang");
	var message_text = (lang == "es") ? "Mensaje" : "Message";
	$("#modal_header").html(message_text);
	$("#delete_button").hide();

	$("#message_input").val("");
	$("#poster_input").val("");
	$("#active_consult_a").hide();

	$("#save_button").unbind();
	$("#save_button").click(function() {
		saveMessage(patient_id, -1);
	});
}

function saveMessage(patient_id, message_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}

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
		if(status == "active") {
			status = 1;
		} else if (status == "inactive") {
			status = 2;
		} else {
			valid_submission = false;;
		}
	} else {
		valid_submission = false;
	} 

	if(!valid_submission) {
		var alert_text = "ERROR: ALL FIELDS MUST BE COMPLETED";
		if(lang == "es") {
			alert_text = "ERROR: NECESITA COMPLETAR TODOS LOS CAMPOS";
		}
		alert(alert_text);
	} else {
		window.location.href = "profile.php?id=" + patient_id + "&message_id=" + message_id + "&message=" + message + "&poster=" + poster + "&status=" + status + "&save=2" + extra_text;
	}
}

function deleteMessage(patient_id, message_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "profile.php?id=" + patient_id + "&message_id=" + message_id + "&delete=2" + extra_text;
}

function editPatient(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "add_patient.php?patient_id=" + patient_id + extra_text;
}

function communityClick(community_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "community.php?id=" + community_id + extra_text;
}

function newConsultButtonClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "consult_active.php?patient_id=" + patient_id + extra_text;
}

function medicalHistoryClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "medical_history.php?patient_id=" + patient_id + extra_text;
}

function consultClick(consult_id, patient_id, in_progress) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if (in_progress == 2) {
		window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
	} else {
		window.location.href = "consult_complete.php?patient_id=" + patient_id + "&consult_id=" + consult_id + extra_text;
	}
}


</script>

