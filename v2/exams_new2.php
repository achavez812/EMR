
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
	require_once '../include/ExamMapping2_' . $lang . '.php';

	$map;
	if($lang == "es") {
		$map = new ExamMapping2_es();
	} else {
		$map = new ExamMapping2_en();
	}
	$db = new DbOperation();

	$consult_id = 0;

	$consult;
	$patient_id;
	$type = NULL;
	$type_text = NULL;
	$arg1 = NULL;
	$arg1_text = NULL;
	$arg2 = NULL;
	$arg2_text = NULL;
	$arg3 = NULL;
	$arg3_text = NULL;
	$arg4 = NULL;
	$arg4_text = NULL;
	$exam_id = NULL;

	if (isset($_GET['consult_id'])) {
		$consult_id = $_GET['consult_id'];
		$consult = $db->getConsult($consult_id);
	} else {
		header($index_link);
	}

	if(isset($_GET['type'])) {
		$type = $_GET['type'];
		$type_text = $map->getOptions(NULL, NULL, NULL, NULL, NULL, NULL)[$type];
	}
	if(isset($_GET['arg1'])) {
		$arg1 = $_GET['arg1'];
		$arg1_text = $map->getOptions($type, NULL, NULL, NULL, NULL, NULL)[$arg1];
	}
	if(isset($_GET['arg2'])) {
		$arg2 = $_GET['arg2'];
		$arg2_text = $map->getOptions($type, $arg1, NULL, NULL, NULL, NULL)[$arg2];
	}
	if(isset($_GET['arg3'])) {
		$arg3 = $_GET['arg3'];
		$arg3_text = $map->getOptions($type, $arg1, $arg2, NULL, NULL, NULL)[$arg3];
	}
	if(isset($_GET['arg4'])) {
		$arg4 = $_GET['arg4'];
		$arg4_text = $map->getOptions($type, $arg1, $arg2, $arg3, NULL, NULL)[$arg4];
	}

	if(isset($_GET['delete'])) {
		$delete = $_GET['delete'];
		if($delete == 2) {
			$exam_id = $_GET['exam_id'];
			$db->deleteExam($exam_id);

			if($arg2 == NULL) {
				header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&lang=" . $lang);
			} else if ($arg3 == NULL) {
				header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&lang=" . $lang);
			} else if ($arg4 == NULL) {
				header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&lang=" . $lang);
			} else {
				header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&arg3=" . $arg3 . "&lang=" . $lang);
			}
		}
	}


	if(isset($_GET['save'])) {
		$normal = $_GET['normal'];
		$information = NULL;
		$notes = NULL;
		$options = NULL;
		$other = NULL;
		if(isset($_GET['information'])) {
			$information = $_GET['information'];
		}
		if(isset($_GET['notes'])) {
			$notes = $_GET['notes'];
		}
		if(isset($_GET['options'])) {
			$options = $_GET['options'];
		}
		if(isset($_GET['other'])) {
			$other = $_GET['other'];
		}
		if(isset($_GET['exam_id'])) {
			$exam_id = $_GET['exam_id'];
		}
		
		$db->createNewExam($consult_id, $exam_id, $normal, $type, $arg1, $arg2, $arg3, $arg4, $information, $options, $other, $notes);
		
		if($arg2 == NULL) {
			header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&lang=" . $lang);
		} else if ($arg3 == NULL) {
			header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&lang=" . $lang);
		} else if ($arg4 == NULL) {
			header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&lang=" . $lang);
		} else {
			header("LOCATION: exams_new2.php?consult_id=" . $consult_id . "&type=" . $type . "&arg1=" . $arg1 . "&arg2=" . $arg2 . "&arg3=" . $arg3 . "&lang=" . $lang);
		}
		
		
	}



	$editable = true;
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

	$options = $map->getOptions($type, $arg1, $arg2, $arg3, $arg4, NULL);
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
				if($type == NULL) {
					echo "<p class='content_p consult_section'>" . EXAMS_MAIN_TYPE . "</p>";
				} else if($arg1 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null, null);'>" . EXAMS_MAIN_TYPE . "</a></p>";
					echo "<p class='content_p'>$type_text</p>";
				} else if ($arg2 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null, null);'>" . EXAMS_MAIN_TYPE . "</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, null, null, null);'>$type_text</a></p>";
					echo "<p class='content_p'>$arg1_text</p>";
				} else if ($arg3 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null, null);'>" . EXAMS_MAIN_TYPE . "</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, null, null, null);'>$type_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'>$arg2_text</p>";
				} else if ($arg4 == NULL) {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null, null);'>" . EXAMS_MAIN_TYPE . "</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, null, null, null);'>$type_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, $arg2, null);'>$arg2_text</a></p>";
					echo "<p class='content_p'>$arg3_text</p>";
				} else {
					echo "<p class='content_p consult_section'><a onclick='backClick($consult_id, null, null, null, null);'>" . EXAMS_MAIN_TYPE . "</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, null, null, null);'>$type_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, null, null);'>$arg1_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, $arg2, null);'>$arg2_text</a></p>";
					echo "<p class='content_p'><a onclick='backClick($consult_id, $type, $arg1, $arg2, $arg3);'>$arg3_text</a></p>";
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
					$has_exam = FALSE;
					$has_normal_exam = $db->hasNormalExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index);
					$has_abnormal_exam = $db->hasAbnormalExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index);
					if($type == NULL) {
						$has_exam = $db->hasExam($consult_id, 1, NULL, NULL, NULL, NULL, NULL, $index);
						if(!$map->isEnd($index, NULL, NULL, NULL, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($index, NULL, NULL, NULL, NULL, NULL));

						}
					} else if ($arg1 == NULL) {
						$has_exam = $db->hasExam($consult_id, 1, $type, NULL, NULL, NULL, NULL, $index);
						if (!$map->isEnd($type, $index, NULL, NULL, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($type, $index, NULL, NULL, NULL, NULL));
						}
					} else if ($index != 0 && $arg2 == NULL) {
						$has_exam = $db->hasExam($consult_id, 1, $type, $arg1, NULL, NULL, NULL, $index);
						if(!$map->isEnd($type, $arg1, $index, NULL, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($type, $arg1, $index, NULL, NULL, NULL));
						}
					} else if ($index != 0 && $arg3 == NULL) {
						$has_exam = $db->hasExam($consult_id, 1, $type, $arg1, $arg2, NULL, NULL, $index);
						if(!$map->isEnd($type, $arg1, $arg2, $index, NULL, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($type, $arg1, $arg2, $index, NULL, NULL));
						}
					} else if ($index != 0 && $arg4 == NULL) {
						$has_exam = $db->hasExam($consult_id, 1, $type, $arg1, $arg2, $arg3, NULL, $index);
						if(!$map->isEnd($type, $arg1, $arg2, $arg3, $index, NULL)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($type, $arg1, $arg2, $arg3, $index, NULL));
						}
					} else if ($index != 0) {
						$has_exam = $db->hasExam($consult_id, 1, $type, $arg1, $arg2, $arg3, $arg4, $index);
						if(!$map->isEnd($type, $arg1, $arg2, $arg3, $arg4, $index)) {
							$end = BOOLEAN_TRUE;
							$end_array = implode(",", $map->getOptions($type, $arg1, $arg2, $arg3, $arg4, $index));
						}
					} else {
						$has_exam = $db->hasExam($consult_id, 2, $type, $arg1, $arg2, $arg3, $arg4, $index);
						if($has_exam) {
							$exam_id = $db->getNormalExamId($consult_id, $type, $arg1, $arg2, $arg3, $arg4);
						}
					}

					$existing_is_normal = "";
					$existing_information = "";
					$existing_options = "";
					$existing_other = "";
					$existing_notes = "";
					if($has_exam && $end == BOOLEAN_TRUE) {
						$specific_exam = $db->getExam($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index);
						$exam_id = $specific_exam['id'];
						$existing_is_normal = $specific_exam['is_normal'];
						$existing_options = $specific_exam['options'];
						$existing_other = $specific_exam['other'];
						$existing_notes = $specific_exam['notes'];
					} else if ($index != 0 || !$has_exam) {
						$exam_id = "";
					}

					$other = BOOLEAN_FALSE;

					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"$exam_id\", \"$type\", \"$arg1\", \"$arg2\", \"$arg3\", \"$arg4\", \"$index\", \"$end\", \"$other\", \"$end_array\", \"$option\", \"$existing_is_normal\", \"\", \"$existing_options\", \"$existing_other\", \"$existing_notes\");'>$option";
					if($has_normal_exam) {
						echo " (" . NORMAL . ")";
					} else if ($has_abnormal_exam) {
						echo " (" . ABNORMAL . ")";
					}
					if($has_exam) { echo '<img class="consult_task_completed" src="../images/checkmark"/>'; }
					echo "</li>";

					$index++;
				}

				$custom_exams = $db->getCustomExams($consult_id, $type, $arg1, $arg2, $arg3, $arg4, $index);
				foreach ($custom_exams as $custom_exam) {
					$custom_exam_id = $custom_exam['id'];
					$custom_is_normal = $custom_exam['is_normal'];
					$custom_type = $custom_exam['type'];
					$custom_arg1 = $custom_exam['arg1'];
					$custom_arg2 = $custom_exam['arg2'];
					$custom_arg3 = $custom_exam['arg3'];
					$custom_arg4 = $custom_exam['arg4'];
					$custom_information = $custom_exam['information'];
					$custom_options = $custom_exam['options'];
					$custom_other = $custom_exam['other'];
					$custom_notes = $custom_exam['notes'];
					$other = BOOLEAN_TRUE;
					$end = BOOLEAN_TRUE;
					$end_array = implode(",", ["Normal", "Abnormal"]);
					if($lang == "es") {
						$end_array = implode(",", ["Normal", "Anormal"]);
					}
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, $custom_exam_id, \"$custom_type\", \"$custom_arg1\", \"$custom_arg2\", \"$custom_arg3\", \"$custom_arg4\", \"$index\", \"$end\", \"$other\", \"$end_array\", \"$custom_information\", \"$custom_is_normal\", \"$custom_information\", \"$custom_options\", \"$custom_other\", \"$custom_notes\");'>$custom_information";

					if($custom_is_normal == BOOLEAN_TRUE) {
						echo " (" . NORMAL . ")";
					} else {
						echo " (" . ABNORMAL . ")";
					}
					echo '<img class="consult_task_completed" src="../images/checkmark"/>';
					echo"</li>";
					$index++;
				}



				if($type != NULL) {
					$other = BOOLEAN_TRUE;
					$end = BOOLEAN_TRUE;
					$end_array = implode(",", ["Normal", "Abnormal"]);
					if($lang == "es") {
						$end_array = implode(",", ["Normal", "Anormal"]);
					}
					echo "<li class='list-group-item' data-toggle='modal' data-target='#myModal' onclick='itemClick($consult_id, \"$exam_id\", \"$type\", \"$arg1\", \"$arg2\", \"$arg3\", \"$arg4\", \"$index\", \"$end\", \"$other\", \"$end_array\", \"other\", \"\", \"\", \"\", \"\", \"\");'>" . OTHER . "</li>";
					
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
	    		<p class="input_label"><?php echo OPTIONS . ":"; ?></p>
	    		<select id="final_options_select" class="input_field" multiple></select>
	    	</div>
	    	
	    	<div id="other_input_div" class="input_row no_display">
	      		<input id="other_input" class="input_field" placeholder="<?php echo CUSTOM_OTHER; ?>">
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

$("#modal_close_button").click(function(){
	$("#other_input_div").hide();
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

function backClick(consult_id, type, arg1, arg2, arg3) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!type) {
		window.location.href="exams_new2.php?consult_id=" + consult_id + extra_text;
	} else if(!arg1) {
		window.location.href="exams_new2.php?consult_id=" + consult_id + "&type=" + type + extra_text;
	} else if (!arg2) {
		window.location.href="exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + extra_text;
	} else if (!arg3) {
		window.location.href="exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + extra_text;
	} else {
		window.location.href="exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + extra_text;
	}
}


function itemClick(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index, end, other, end_array, option, existing_is_normal, existing_custom_information, existing_options, existing_other, existing_notes) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if (end == 2) {
		if(exam_id) {
			$("#delete_button").show();
			$("#delete_button").unbind();
			$("#delete_button").click(function() {
				deleteFunction(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index);
			});
		} else {
			$("#delete_button").hide();
		}


		var array = end_array.split(",");
		if(lang == "es") {
			array.push("Otro");
		} else {
			array.push("Other");
		}
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
			saveFunction(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index, other, end_array);
		});

		if(exam_id) {
			var select_array = existing_options.split(",");
			$("#final_options_select").val(select_array);
			if(existing_custom_information) {
				$("#other_input_row").show();
				$("#information_input").val(existing_custom_information);
			} else {
				$("#other_input_row").hide();
			}
			if(existing_other) {
				$("other_input_div").show();
				$("#other_input").val(existing_other);
			} else {
				$("other_input_div").hide();
			}
			$("#notes_input").val(existing_notes);
		}
	} else {
		$("#myModal").hide();
		if(!type) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + index + extra_text;
		} else if (!arg1) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + index + extra_text;
		} else {
			if(index == 0) {
				if(exam_id) {
					deleteFunction(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index);
				} else {
					if (!arg2) {
						window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&normal=2&save=2" + extra_text;
					} else if (!arg3) {
						window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&normal=2&save=2" + extra_text;
					} else if (!arg4) {
						window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&normal=2&save=2" + extra_text;
					} else {
						alert("CHECK THIS");
					}
				}
			} else {
				if (!arg2) {
					window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + index + extra_text;
				} else if (!arg3) {
					window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index + extra_text;
				} else if (!arg4) {
					window.location.href = "exams_new2.php?consult_id=" + consult_id + "&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index + extra_text;
				} else {
					alert("ERROR");
				}
			}
		}
	}
}

function deleteFunction(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	if(!arg1) {
		window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id + "&type=" + type + "&arg1=" + index + "&delete=2" + extra_text;
	} else if (!arg2) {
		window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + index + "&delete=2" + extra_text;
	} else if (!arg3) {
		window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index + "&delete=2" + extra_text;
	} else if(!arg4) {
		window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index + "&delete=2" + extra_text;
	} else {
		alert("ERROR");
	}
}

function saveFunction(consult_id, exam_id, type, arg1, arg2, arg3, arg4, index, other, end_array) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	var valid_submission = true;

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
				if (i == myOpts.length - 1) {
					var other = $("#other_input").val();
					if(other) {
						extra_text += "&other=" + other;
					} else {
						valid_submission = false;
					}
				}
			}
			options += i + ",";
		}
	}

	if (normal_selected && abnormal_selected) {
		var alert_text = "ERROR: Invalid combination selected";
		if(lang == "es") {
			alert_text = "ERROR: Combinación seleccionada no válida.";
		}
		alert(alert_text);
	} else if (!normal_selected && !abnormal_selected) {
		var alert_text = "ERROR: No option selected";
		if(lang == "es") {
			alert_text = "ERROR: Ninguna opcion seleccionado.";
		}
		alert(alert_text);
	} else if (!valid_submission) {
		var alert_text = "ERROR: Must complete all inputs.";
		if(lang == "es") {
			alert_text = "ERROR: Necesita completar todos los campos.";
		}
		alert(alert_text);
	} else {
		options = options.slice(0, -1);
		var normal = 2;
		if(abnormal_selected) {
			normal = 1;
		}

		if(!arg1) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id + "&type=" + type + "&arg1=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if (!arg2) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if (!arg3) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else if(!arg4) {
			window.location.href = "exams_new2.php?consult_id=" + consult_id + "&exam_id=" + exam_id +"&type=" + type + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + index + "&options=" + options + "&normal=" + normal + "&save=2" + extra_text;
		} else {
			alert("ERROR");
		}
	}
}

function continueFunction(consult_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "diagnoses_new.php?consult_id=" + consult_id + extra_text;
}
</script>