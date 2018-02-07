
<script type="text/javascript" src="../js/jquery-3.2.1.min" ></script>
<link rel="stylesheet" href="../css/bootstrap.min">
<script type="text/javascript" src="../js/bootstrap.min" ></script>

<link rel="stylesheet" href="../css/style">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


<?php
	require_once '../include/DbOperation.php';
	require_once '../include/Constants.php';
	require_once '../include/Utilities.php';
	require_once '../include/ExamMapping.php';

	$map = new ExamMapping();
	$db = new DbOperation();

	$consult_id = 0;

	$consult;
	$patient_id;
	$arg1 = NULL;
	$arg1_text = NULL;
	$arg2 = NULL;
	$arg2_text = NULL;
	$arg3 = NULL;
	$arg3_text = NULL;
	$arg4 = NULL;
	$arg4_text = NULL;

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
		$patient_id = $consult["patient_id"];
	} else {
		header("LOCATION: index.php");
	}

	if(isset($_GET['arg1'])) {
		$arg1 = $_GET['arg1'];
		$arg1_text = $map->getOptions(NULL, NULL, NULL, NULL)[$arg1];
	}
	if(isset($_GET['arg2'])) {
		$arg2 = $_GET['arg2'];
		$arg2_text = $map->getOptions($arg1, NULL, NULL, NULL)[$arg2];
	}
	if(isset($_GET['arg3'])) {
		$arg3 = $_GET['arg3'];
		$arg3_text = $map->getOptions($arg1, $arg2, NULL, NULL)[$arg3];
	}
	if(isset($_GET['arg4'])) {
		$arg4 = $_GET['arg4'];
		$arg4_text = $map->getOptions($arg1, $arg2, $arg3, NULL)[$arg4];
	}

	if(isset($_GET['save'])) {
		$normal = $_GET['normal'];
		$information = NULL;
		$notes = NULL;
		$options = NULL;
		if(isset($_GET['information'])) {
			$information = $_GET['information'];
		}
		if(isset($_GET['notes'])) {
			$notes = $_GET['notes'];
		}
		if(isset($_GET['options'])) {
			$options = $_GET['options'];
		}
		$db->createNewExam($consult_id, $normal, $arg1, $arg2, $arg3, $arg4, $information, $options, $notes);
		if($arg2 == NULL) {
			header("LOCATION: exams_new.php?consult_id=" . $consult_id);
		} else if ($arg3 == NULL) {
			header("LOCATION: exams_new.php?consult_id=" . $consult_id . "&arg1=" . $arg1);
		} else if ($arg4 == NULL) {
			header("LOCATION: exams_new.php?consult_id=" . $consult_id . "&arg1=" . $arg1 . "&arg2=" . $arg2);
		} else {
			header("LOCATION: exams_new.php?consult_id=" . $consult_id . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&arg3=" . $arg3);
		}

	}


	$patient = $db->getPatientById($patient_id);	

	$patient_name = $patient["name"];
	$patient_sex = $patient["sex"];
	$patient_dob = $patient["date_of_birth"];
	$exact_dob_known = $patient["exact_date_of_birth_known"];

	$date_of_birth_text = Utilities::reformatDateForDisplay($patient_dob);
	if ($exact_dob_known == BOOLEAN_FALSE) {
		$date_of_birth_text .= " (App.)";
	}

	$age_text = Utilities::getCurrentAgeString($patient_dob);

	$sex_text = "";
	if ($patient_sex == SEX_FEMALE) {
		$sex_text = "Female";
	} else if ($patient_sex == SEX_MALE) {
		$sex_text = "Male";
	} else {
		$sex_text = "Unknown";
	}

	$datetime_started = $consult["datetime_started"];
	$in_progress = true;
	if(isset($consult["datetime_completed"])) {
		$in_progress = false;
	}

	$formatted_datetime_started = Utilities::reformatDateForDisplay2($datetime_started);

	$display_text = "Consult " . $formatted_datetime_started;
	
	if($in_progress) {
		$display_text .= " (In Progress)";
	} else {
		$display_text .= " (Completed)";
	}

	if ($arg2 == '0' || $arg3 == '0' || $arg4 == '0') {
		echo "<p>NORMAL SELECTION</p>";
	}
	$options = $map->getOptions($arg1, $arg2, $arg3, $arg4);
	if ($options == NULL) {
		//END OF THE ROAD
		echo "<p>END OF THE ROAD</p>";
	} 
	//echo implode(", ", $options);

?>

<div class="container-fluid">
	<span class="no_display" id="hidden_consult_id"><?php echo $consult_id; ?></span>
	<div id="profile_row1" class="row row1 last_row">
		<div class="col-xs-12">
			<h1><a onclick="nameClick(<?php echo $patient_id; ?>);"><?php echo $patient_name; ?></a></h1>
			<p class="profile_header_p">Date of Birth: <?php echo $date_of_birth_text; ?></p>
		</div>
	</div>

	<div class="row consult_link_row">
		<div class="col-xs-12">
			<p class="content_p"><a onclick="consultClick(<?php echo $consult_id . ', ' . $patient_id; ?>);"><?php echo $display_text; ?></a></p>
			<?php
				if($arg1 == NULL) {
					echo "<p class='content_p consult_section'>Exams Main Categories</p>";
				} else if ($arg2 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null);'>Exams Main Categories</a></p>";
					echo "<p class='content_p'>$arg1_text</p>";
				} else if ($arg3 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null);'>Exams Main Categories</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'>$arg2_text</p>";
				} else if ($arg4 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null);'>Exams Main Categories</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, $arg2, null);'>$arg2_text</a></p>";
					echo "<p class='content_p'>$arg3_text</p>";
				} else {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null);'>Exams Main Categories</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, $arg2, null);'>$arg2_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $arg1, $arg2, $arg3);'>$arg3_text</a></p>";
					echo "<p class='content_p'>$arg4_text</p>";
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
					$end = BOOLEAN_FALSE;
					$end_array = "";
					if ($arg1 == NULL) {
						if (!$map->isEnd($index, NULL, NULL, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($index, NULL, NULL, NULL, NULL));
						}
					} else if ($index != 0 && $arg2 == NULL) {
						if(!$map->isEnd($arg1, $index, NULL, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($arg1, $index, NULL, NULL, NULL));
						}
					} else if ($index != 0 && $arg3 == NULL) {
						if(!$map->isEnd($arg1, $arg2, $index, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($arg1, $arg2, $index, NULL, NULL));
						}
					} else if ($index != 0 && $arg4 == NULL) {
						if(!$map->isEnd($arg1, $arg2, $arg3, $index, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($arg1, $arg2, $arg3, $index, NULL));
						}
					} else if ($index != 0) {
						if(!$map->isEnd($arg1, $arg2, $arg3, $arg4, $index)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($arg1, $arg2, $arg3, $arg4, $index));
						}
					}

					$other = $arg1 != NULL && ($index == sizeof($options) - 1) ? BOOLEAN_TRUE : BOOLEAN_FALSE;
					
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"$arg1\", \"$arg2\", \"$arg3\", \"$arg4\", \"$index\", \"$end\", \"$other\", \"$end_array\", \"$option\");'>$option</li>";

					$index++;
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
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="modal_header" class="modal-title"></h4>
      </div>
      <div class="modal-body">
      	<div class="input_row">
	      	<div id="other_input_row" class="input_row no_display">
	        	<p class="input_label">Information:</p>
	        	<input id='information_input' class='input_field' placeholder="Other">
	        </div>
    	</div>
    	<div class="input_row">
    		<p class="input_label">Options:</p>
    		<select id="final_options_select" class="input_field" multiple></select>
    	</div>
    	<!--
    	<div id="other_input_div" class="input_row no_display">
      		<input id="other_input" class="input_field" placeholder="Other/Custom">
    	</div>
    	-->
    	<div class="input_row">
        	<p class="input_label">Notes:</p>
        	<textarea id='notes_input' class='input_field'></textarea>
        </div>
      </div>
      <div class="modal-footer">
      	<button id="delete_button" type="button" class="btn btn-default" data-dismiss="modal">Delete</button>
        <button id="save_button" type="button" class="btn btn-default">Save</button>
      </div>
    </div>

  </div>
</div>
	
	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveStay(<?php echo $consult_id; ?>);">Save and Stay</button>
		</div>
	</div>

	<div id="button_row" class="row input_row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveContinue(<?php echo $consult_id . ", " . $patient_id; ?>);">Save and Continue</button>
		</div>
	</div>

</div>

<script type="text/javascript">
/*
$("#final_options_select").change(function() {
	var arr = $(this).val();
	var length = arr.length;

	var other_selected = false;
	if (length > 0) {
		other_selected = arr[length-1] == $('#final_options_select option:last-child').val();
	}

	if (other_selected)  {
		$("#other_input_div").show();
	} else {
		$("#other_input_div").hide();
	}
});
*/


function nameClick(patient_id) {
	window.location.href = "profile.php?id=" + patient_id;
}

function consultClick(consult_id, patient_id) {
	window.location.href = "consult_active.php?patient_id=" + patient_id + "&consult_id=" + consult_id;
}

function backClick(consult_id, arg1, arg2, arg3) {
	if(!arg1) {
		window.location.href="exams_new.php?consult_id=" + consult_id;
	} else if (!arg2) {
		window.location.href="exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1;
	} else if (!arg3) {
		window.location.href="exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2;
	} else {
		window.location.href="exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3;
	}
}

function itemClick(consult_id, arg1, arg2, arg3, arg4, index, end, other, end_array, option) {
	if (end == 2) {
		var array = end_array.split(",");
		var optionsString = "";
		for(var i = 0; i < array.length; i++) {
		    optionsString += "<option value='" + i + "'>" + array[i] + "</option>";
		}
		$('#final_options_select').html(optionsString);
		if(other == 2) {
			$("#other_input_row").show();
		} else {
			$("#other_input_row").hide();
		}

		$("#modal_header").html(option);
		$("#myModal").show();

		$("#save_button").unbind();
		$("#save_button").click(function() { 
			saveFunction(consult_id, arg1, arg2, arg3, arg4, index, other, end_array);
		});
	} else {
		$("#myModal").hide();
		if(!arg1) {
			window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + index;
		} else {
			if(index == 0) {
				if (!arg2) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&normal=2&save=2";
				} else if (!arg3) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&normal=2&save=2";
				} else if (!arg4) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&normal=2&save=2";
				} else {
					alert("CHECK THIS");
				}
			} else {
				if (!arg2) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + index;
				} else if (!arg3) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index;
				} else if (!arg4) {
					window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index;
				} else {
					alert("CHECK THIS");
				}
			}
		}
	}
}

function saveFunction(consult_id, arg1, arg2, arg3, arg4, index, other, end_array) {
	var valid_submission = true;

	var extra_text = "";
	var normal_selected = false;
	var abnormal_selected = false;
	var information = "";
	var notes = $("#notes_input").val();
	if(notes) {
		extra_text += "&notes=" + notes;
	}
	var options = "";
	if (other == 2) {
		information = $("#information_input").val();
		if(information) {
			extra_text += "&information=" + information;
		} else {
			alert("Must complete inputs");
			valid_submission = false;
		}
	}

	var options_selected = $("#final_options_select").val();

	var myOpts = document.getElementById('final_options_select').options;
	for(var i = 0; i < myOpts.length; i++) {
		if(options_selected.indexOf(myOpts[i].value) >= 0) {
			if (i == 0) {
				normal_selected = true;
			} else {
				abnormal_selected = true;
			}
			options += i + ",";
		}
	}

	if (normal_selected && abnormal_selected) {
		alert("Invalid combination selected");
	} else if (!normal_selected && !abnormal_selected) {
		alert("No option selected");
	} else if (valid_submission) {
		options = options.slice(0, -1);
		var normal = 2;
		if(abnormal_selected) {
			normal = 1;
		}

		if(!arg1) {
			window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if (!arg2) {
			window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if (!arg3) {
			window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if(!arg4) {
			window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index + "&options=" + options + "&normal=" + normal + "&save=2";
		} else {
			alert("CHECK THIS");
		}
	}

	


	
	/*
	if (!arg2) {
		window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + index + "&normal=1&save=2";
	} else if (!arg3) {
		window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index + "&normal=1&save=2";
	} else if (!arg4) {
		window.location.href = "exams_new.php?consult_id=" + consult_id + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index + "&normal=1&save=2";
	} else {
		alert("CHECK THIS");
	}
	*/
}

function saveStay(consult_id) {


}

function saveContinue(consult_id, patient_id) {

}


</script>

