
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
	$category = NULL;
	$category_text = NULL;

	if (isset($_GET['save'])) {
		$save = $_GET['save'];
		if($save == 2) {
			$consult_id = $_GET['consult_id'];
			$consult = $db->getConsult($consult_id);
			$patient_id = $consult["patient_id"];
			$diagnosis_id = $_GET['diagnosis_id'];
			$is_chronic = $_GET['is_chronic'];
			$category = $_GET['category'];
			$type = $_GET['type'];
			$other = NULL;
			$notes = NULL;
			if(!$diagnosis_id) {
				$diagnosis_id = NULL;
			}
			if(!$is_chronic) {
				$is_chronic = NULL;
			}
			if(isset($_GET['other'])) {
				$type = NULL;
				$other = $_GET['other'];
			}
			if(isset($_GET['notes'])) {
				$notes = $_GET['notes'];
			}

			$current_datetime = Utilities::getCurrentDateTime();
			$current_date = Utilities::getCurrentDate();
			$result = $db->createNewDiagnosis($consult_id, $patient_id, $diagnosis_id, $is_chronic, $category, $type, $other, $notes, $current_datetime, $current_date);
			echo $result;
			header("LOCATION: diagnoses_new.php?consult_id=" . $consult_id . "&category=" . $category . "&lang=" . $lang);
		}
	}

	if (isset($_GET['delete'])) {
		$delete = $_GET['delete'];
		if($delete == 2) {
			$consult_id = $_GET['consult_id'];
			$diagnosis_id = $_GET['diagnosis_id'];
			$category = $_GET['category'];

			$result = $db->deleteDiagnosis($diagnosis_id);

			header("LOCATION: diagnoses_new.php?consult_id=" . $consult_id . "&category=" . $category . "&lang=" . $lang);
		}
	}

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		$patient_id = $consult["patient_id"];


	} else {
		header($index_link);
	}

	if(isset($_GET['category'])) {
		$category = $_GET['category'];
		$category_text = $map->getDiagnosisOptions(NULL)[$category];
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

	$options = $map->getDiagnosisOptions($category);
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
				if($category === NULL) {
					echo "<p class='content_p consult_section'>" . DIAGNOSIS_CATEGORIES . "</p>";
				} else {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id);'>" . DIAGNOSIS_CATEGORIES . "</a></p>";
					echo "<p class='content_p'>$category_text</p>";
				}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul class='list-group'>
			<?php
				$index = 0;
				foreach($options as $option) {
					$other = 1;
					$arg1 = NULL;
					$arg2 = NULL;
					if($category === NULL) {
						$arg1 = $index;
					} else {
						$arg1 = $category;
						$arg2 = $index;
					}
					$has_diagnosis = $db->hasDiagnosis($consult_id, $arg1, $arg2);
					$diagnosis_id = NULL;
					$is_chronic = NULL;
					$information = NULL;
					$notes = NULL;
					if ($has_diagnosis) {
						$diagnosis = $db->getDiagnosis($consult_id, $arg1, $arg2);
						if($diagnosis) {
							$diagnosis_id = $diagnosis['id'];
							$is_chronic = $diagnosis['is_chronic'];
							$information = $diagnosis['other'];
							$notes = $diagnosis['notes'];
						}
					}
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"$diagnosis_id\", \"$is_chronic\", \"$information\", \"$notes\",  \"$category\", \"$index\", \"$other\", \"$option\");'>$option";
					if($category === NULL && $db->diagnosisCategoryHasAbnormalExam($consult_id, $index)) {
						echo " (" . ABNORMAL . ")";
					}
					if($has_diagnosis) {
						echo '<img class="consult_task_completed" src="../images/checkmark"/>';
					}
					echo "</li>";

					$index++;
				}

				if($category !== NULL) {
					$custom_diagnoses = $db->getCustomDiagnoses($consult_id, $category);
					foreach($custom_diagnoses as $custom_diagnosis) {
						$other = 2;
						$diagnosis_id = $custom_diagnosis['id'];
						$is_chronic = $custom_diagnosis['is_chronic'];
						$information = $custom_diagnosis['other'];
						$notes = $custom_diagnosis['notes'];

						echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"$diagnosis_id\", \"$is_chronic\", \"$information\", \"$notes\",  \"$category\", \"$index\", \"$other\", \"$information\");'>$information";
						echo '<img class="consult_task_completed" src="../images/checkmark"/>';
						echo "</li>";

						$index++;
					}

					$other = 2;
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"\", \"\", \"\", \"\", \"$category\", \"$index\", \"$other\", \"" . OTHER . "\");'>" . OTHER;
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
		      	<div class="input_row">
		        	<p class="input_label"><?php echo INFORMATION . ":"; ?></p>
		        	<input id='information_input' class='input_field' placeholder="<?php echo OTHER; ?>">
		        </div>
	    	</div>
	    	<div class="input_row">
	    		<p class="input_label"><?php echo TYPE . ":"; ?></p>
	    		<form id="type_radiogroup" class="input_field">
		    		<input id='type_chronic' type='radio' name='type' value='chronic'><label for='type_chronic'><?php echo CHRONIC; ?></label>
					<input id='type_acute' type='radio' name='type' value='acute'><label for='type_acute'><?php echo ACUTE; ?></label>
				</form>
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
	window.location.href = "diagnoses_new.php?consult_id=" + consult_id + extra_text;
}


function itemClick(consult_id, diagnosis_id, is_chronic, information, notes, category, index, other, option) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!category) {
		window.location.href = "diagnoses_new.php?consult_id=" + consult_id + "&category=" + index + extra_text;
	} else {
		$("#modal_header").html(option);
		$("#myModal").show();
		if(is_chronic == 2) {
			$("input[name='type'][value='chronic']").prop("checked", true);
		} else if (is_chronic == 1) {
			$("input[name='type'][value='acute']").prop("checked", true);
		} else {
			$("input[name='type'][value='chronic']").prop("checked", false);
			$("input[name='type'][value='acute']").prop("checked", false);
		}

		if(other == 2 || information) {
			$("#other_input_row").show();
			if (information) {
				$("#information_input").val(information);
			}
		} else {
			$("#other_input_row").hide();
		}

		$("#notes_input").val(notes);

		if(!diagnosis_id) {
			$("#delete_button").hide();
		} else {
			$("#delete_button").show();
			$("#delete_button").unbind();
			$("#delete_button").click(function() {
				deleteFunction(consult_id, diagnosis_id, category);
			});
		}

		$("#save_button").unbind();
		$("#save_button").click(function() { 
			saveFunction(consult_id, diagnosis_id, category, index, other);
		});

	}
}

function deleteFunction(consult_id, diagnosis_id, category) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "diagnoses_new.php?consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + "&category=" + category + "&delete=2" + extra_text;
}

function saveFunction(consult_id, diagnosis_id, category, type, other) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var valid_submission = true;

	var is_chronic = $("input[name=type]:checked").val();
	if(is_chronic) {
		if(is_chronic == "chronic") {
			is_chronic = 2;
		} else if (is_chronic == "acute") {
			is_chronic = 1;
		} else {
			is_chronic = "";
		}
	} else {
		is_chronic = "";
	} 

	var notes = $("#notes_input").val();
	if (other == 2) {
		var information = $("#information_input").val();
		if(information) {
			extra_text += "&other=" + information;
		} else {
			var alert_text = "ERROR: Must complete all inputs.";
			if(lang == "es") {
				alert_text = "ERROR: Necesita completar todos los campos.";
			}
			alert(alert_text);
			valid_submission = false;
		}
	}
	if(notes) {
		extra_text += "&notes=" + notes;
	}

	if (valid_submission) {
		window.location.href = "diagnoses_new.php?consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + "&category=" + category + "&type=" + type + "&is_chronic=" + is_chronic + "&save=2" + extra_text;
	}
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "treatments_new.php?consult_id=" + consult_id + extra_text;
}
</script>