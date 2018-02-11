

function chiefComplaintLoad(consult_id, mode, consult_option) {
	$('#myChiefComplaintModal').modal('show');
	//$("#modal_chief_complaints").removeClass("hidden");
	//$("#modal_general_hpi").addClass("hidden");
	//$("#modal_pregnancy_hpi").addClass("hidden");

	$("#chief_complaint_delete_button").addClass("hidden");
	$("#chief_complaint_save_button").unbind();
	$("#chief_complaint_save_button").click(function() { 
		chiefComplaintSaveClick(consult_id, mode);
	});

	document.getElementById("primary_chief_complaint_select").onchange = function() {
		var arr = $(this).val();
		var length = arr.length;

		if(length == 0) {
			$("#primary_chief_complaint_select").val("-1");
		} else if (length == 1) {
			if(arr != "-1") {
				$("#primary_chief_complaint_select option[value='-1']").prop("selected", false);
			}
		} else {
			$("#primary_chief_complaint_select option[value='-1']").prop("selected", false);
		}

		var other_selected = false;
		if(length > 0) {
			other_selected = arr[length-1] == "255";
		}

		if(other_selected) {
			$("#primary_chief_complaint_custom_div").removeClass("hidden");
		} else {
			$(".custom_primary_extra").remove();
			$("#primary_chief_complaint_custom_div").addClass("hidden");
		}
	}

	document.getElementById("secondary_chief_complaint_select").onchange = function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if(length > 0) {
			other_selected = arr[length-1] == "255";
		}

		if(other_selected) {
			$("#secondary_chief_complaint_custom_div").removeClass("hidden");
		} else {
			$(".custom_secondary_extra").remove();
			$("#secondary_chief_complaint_custom_div").addClass("hidden");
		}
	}

	$("#o_pain_how_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#o_pain_how_other").removeClass("hidden");
		} else {
			$("#o_pain_how_other").addClass("hidden");
		}
	});

	$("#o_pain_cause_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#o_pain_cause_other").removeClass("hidden");
		} else {
			$("#o_pain_cause_other").addClass("hidden");
		}
	});

	$("#p_pain_provocation_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#p_pain_provocation_other").removeClass("hidden");
		} else {
			$("#p_pain_provocation_other").addClass("hidden");
		}
	});

	$("#p_pain_palliation_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#p_pain_palliation_other").removeClass("hidden");
		} else {
			$("#p_pain_palliation_other").addClass("hidden");
		}
	});

	$("#q_pain_type_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#q_pain_type_other").removeClass("hidden");
		} else {
			$("#q_pain_type_other").addClass("hidden");
		}
	});

	$("#r_pain_region_main_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#r_pain_region_main_other").removeClass("hidden");
		} else {
			$("#r_pain_region_main_other").addClass("hidden");
		}
	});

	$("#r_pain_region_radiates_select").change(function() {
		var arr = $(this).val();
		var length = arr.length;

		var other_selected = false;
		if (length > 0) {
			other_selected = arr[length-1] == "other";
		}

		if (other_selected)  {
			$("#r_pain_region_radiates_other").removeClass("hidden");
		} else {
			$("#r_pain_region_radiates_other").addClass("hidden");
		}
	});

	$("input[name=any_previous_pregnancy_complications]").change(function() {
		var value = $("input[name=any_previous_pregnancy_complications]:checked").val();
		if (value == "yes") {
			$('#further_explanation_row').removeClass("hidden");
		} else {
			$('#further_explanation_row').addClass("hidden");
		}
	});
}

function chiefComplaintBack() {
	var consult_id = getURLParameter("consult_id");
	var mode = getURLParameter("mode");
	
	$("#modal_chief_complaints").removeClass("hidden");
	$("#modal_general_hpi").addClass("hidden");
	$("#modal_pregnancy_hpi").addClass("hidden");

	$("#chief_complaint_delete_button").addClass("hidden");
	$("#chief_complaint_save_button").unbind();
	$("#chief_complaint_save_button").click(function() { 
		chiefComplaintSaveClick(consult_id, mode);
	});
}

function addCustomPrimaryChiefComplaint() {
	var lang = getURLParameter("lang");
	var other_text = "Other";
	if(lang == "es") {
		other_text = "Otro";
	}

	$('<input class="custom_chief_complaint_input custom_primary_chief_complaint custom_primary_extra" type="text" placeholder="' + other_text + '">').insertBefore("#add_custom_primary_chief_complaint");
}

function addCustomSecondaryChiefComplaint() {
	var lang = getURLParameter("lang");
	var other_text = "Other";
	if(lang == "es") {
		other_text = "Otro";
	}

	$('<input class="custom_chief_complaint_input custom_secondary_chief_complaint custom_secondary_extra" type="text" placeholder="' + other_text + '">').insertBefore("#add_custom_secondary_chief_complaint");
}

function backClick(mode, patient_id) {
	var lang_text = getLang(1);
	window.location.href = "profile.php?mode=" + mode + "&patient_id=" + patient_id + lang_text;
}

function switchStatusClick(ready_for) {
	var value = ready_for == 1 ? "2" : "1";
	//$("#ready_for_select").val(value);
	swapStatus(value);
}

function swapStatus(value) {
	var lang_text = getLang(1);
	var mode = getURLParameter("mode");
	var consult_id = getURLParameter("consult_id");

	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&status=" + value + lang_text;
}

function existingChiefComplaintClick(mode, consult_id, selected_value, custom_text, chief_complaint_type, hpi_type, chief_complaint_id, hpi_field1, hpi_field2, hpi_field3, hpi_field4, hpi_field5, hpi_field6, hpi_field7, hpi_field8, hpi_field9, hpi_field10, hpi_field11, hpi_field12, hpi_field13, hpi_field14) {
	$("#modal_chief_complaints").addClass("hidden");

	if(hpi_type == 1) {
		if(selected_value == "255") {
			var lang = getURLParameter("lang");
			var other_text = "Other";
			if(lang == "es") {
				other_text = "Otro";
			}
			$("#modal_general_hpi_selected_value").text(other_text);
			$("#modal_general_hpi_custom_text_row").removeClass("hidden");
			$("#modal_general_hpi_custom_text_input").val(custom_text);

		} else {
			$("#modal_general_hpi_selected_value").text(custom_text);
			$("#modal_general_hpi_custom_text_row").addClass("hidden");
		}

		$("#modal_pregnancy_hpi").addClass("hidden");
		$("#modal_general_hpi").removeClass("hidden");

		if(hpi_field1) {
			var o_pain_how_array = hpi_field1.split(",");
			var o_pain_how_select_array = hpi_field1.split(",");
			for (var i = 0; i < o_pain_how_array.length; i++) {
				var element = o_pain_how_array[i];
				if(!isInt(element)) {
					o_pain_how_select_array.splice(i);
					o_pain_how_select_array.push('other');
					o_pain_how_array.splice(0, i);
					$("#o_pain_how_other").removeClass("hidden");
					$("#o_pain_how_other").val(o_pain_how_array);
					break;
				}
			}
			$("#o_pain_how_select").val(o_pain_how_select_array);
		} else {
			$("#o_pain_how_select").val("");
		}

		if(hpi_field2) {
			var o_pain_cause_array = hpi_field2.split(",");
			var o_pain_cause_select_array = hpi_field2.split(",");
			for (var i = 0; i < o_pain_cause_array.length; i++) {
				var element = o_pain_cause_array[i];
				if(!isInt(element)) {
					o_pain_cause_select_array.splice(i);
					o_pain_cause_select_array.push('other');
					o_pain_cause_array.splice(0, i);
					$("#o_pain_cause_other").removeClass("hidden");
					$("#o_pain_cause_other").val(o_pain_cause_array);
					break;
				}
			}
			$("#o_pain_cause_select").val(o_pain_cause_select_array);
		} else {
			$("#o_pain_cause_select").val("");
		}

		if(hpi_field3) {
			var p_pain_provocation_array = hpi_field3.split(",");
			var p_pain_provocation_select_array = hpi_field3.split(",");
			for (var i = 0; i < p_pain_provocation_array.length; i++) {
				var element = p_pain_provocation_array[i];
				if(!isInt(element)) {
					p_pain_provocation_select_array.splice(i);
					p_pain_provocation_select_array.push('other');
					p_pain_provocation_array.splice(0, i);
					$("#p_pain_provocation_other").removeClass("hidden");
					$("#p_pain_provocation_other").val(p_pain_provocation_array);
					break;
				}
			}
			$("#p_pain_provocation_select").val(p_pain_provocation_select_array);
		} else {
			$("#p_pain_provocation_select").val("");
		}

		if(hpi_field4) {
			var p_pain_palliation_array = hpi_field4.split(",");
			var p_pain_palliation_select_array = hpi_field4.split(",");
			for (var i = 0; i < p_pain_palliation_array.length; i++) {
				var element = p_pain_palliation_array[i];
				if(!isInt(element)) {
					p_pain_palliation_select_array.splice(i);
					p_pain_palliation_select_array.push('other');
					p_pain_palliation_array.splice(0, i);
					$("#p_pain_palliation_other").removeClass("hidden");
					$("#p_pain_palliation_other").val(p_pain_palliation_array);
					break;
				}
			}
			$("#p_pain_palliation_select").val(p_pain_palliation_select_array);
		} else {
			$("#p_pain_palliation_select").val("");
		}

		if(hpi_field5) {
			var q_pain_type_array = hpi_field5.split(",");
			var q_pain_type_select_array = hpi_field5.split(",");
			for (var i = 0; i < q_pain_type_array.length; i++) {
				var element = q_pain_type_array[i];
				if(!isInt(element)) {
					q_pain_type_select_array.splice(i);
					q_pain_type_select_array.push('other');
					q_pain_type_array.splice(0, i);
					$("#q_pain_type_other").removeClass("hidden");
					$("#q_pain_type_other").val(q_pain_type_array);
					break;
				}
			}
			$("#q_pain_type_select").val(q_pain_type_select_array);
		} else {
			$("#q_pain_type_select").val("");
		}

		if(hpi_field6) {
			var r_pain_region_main_array = hpi_field6.split(",");
			var r_pain_region_main_select_array = hpi_field6.split(",");
			for (var i = 0; i < r_pain_region_main_array.length; i++) {
				var element = r_pain_region_main_array[i];
				if(!isInt(element)) {
					r_pain_region_main_select_array.splice(i);
					r_pain_region_main_select_array.push('other');
					r_pain_region_main_array.splice(0, i);
					$("#r_pain_region_main_other").removeClass("hidden");
					$("#r_pain_region_main_other").val(r_pain_region_main_array);
					break;
				}
			}
			$("#r_pain_region_main_select").val(r_pain_region_main_select_array);
		} else {
			$("#r_pain_region_main_select").val("");
		}

		if(hpi_field7) {
			var r_pain_region_radiates_array = hpi_field7.split(",");
			var r_pain_region_radiates_select_array = hpi_field7.split(",");
			for (var i = 0; i < r_pain_region_radiates_array.length; i++) {
				var element = r_pain_region_radiates_array[i];
				if(!isInt(element)) {
					r_pain_region_radiates_select_array.splice(i);
					r_pain_region_radiates_select_array.push('other');
					r_pain_region_radiates_array.splice(0, i);
					$("#r_pain_region_radiates_other").removeClass("hidden");
					$("#r_pain_region_radiates_other").val(r_pain_region_radiates_array);
					break;
				}
			}
			$("#r_pain_region_radiates_select").val(r_pain_region_radiates_select_array);
		} else {
			$("#r_pain_region_radiates_select").val("");
		}

		$("#s_pain_level").val(hpi_field8);

		//ERROR HERE
		if(hpi_field9) {
			var length = hpi_field9.length;
			var value_part = hpi_field9.substring(0, length - 1);
			var option_part = hpi_field9.substring(length - 1);
			if(isInt(value_part)) {
				$("#t_pain_begin_time").val(value_part);
				$("#t_pain_begin_time_option_select").val(option_part);
			}
		} else {
			$("#t_pain_begin_time").val("");
			$("#t_pain_begin_time_option_select").val("");
		}

		if(hpi_field10) {
			if(isInt(hpi_field10)) {
				if(hpi_field10 == '2') {
					$("input[name='t_pain_before'][value='yes']").prop("checked", true);
				} else if (hpi_field10 == '1') {
					$("input[name='t_pain_before'][value='no']").prop("checked", true);
				}
			}
		} else {
			$("input[name='t_pain_before'][value='yes']").prop("checked", false);
			$("input[name='t_pain_before'][value='no']").prop("checked", false);
		}

		if(hpi_field11) {
			if(isInt(hpi_field11)) {
				if(hpi_field11 == '2') {
					$("input[name='t_pain_current'][value='yes']").prop("checked", true);
				} else if (hpi_field11 == '1') {
					$("input[name='t_pain_current'][value='no']").prop("checked", true);
				}
			}
		} else {
			$("input[name='t_pain_current'][value='yes']").prop("checked", false);
			$("input[name='t_pain_current'][value='no']").prop("checked", false);
		}

		$("#general_notes_input").val(hpi_field12);

	} else {
		$("#modal_general_hpi").addClass("hidden");
		$("#modal_pregnancy_hpi").removeClass("hidden");

		$("#num_weeks_pregnant_input").val(hpi_field1);
		if(hpi_field2) {
			if(hpi_field2 == '2') {
				$("input[name='receiving_prenatal_care'][value='yes']").prop("checked", true);
			} else {
				$("input[name='receiving_prenatal_care'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='receiving_prenatal_care'][value='yes']").prop("checked", false);
			$("input[name='receiving_prenatal_care'][value='no']").prop("checked", false);
		}
		if(hpi_field3) {
			if(hpi_field3 == '2') {
				$("input[name='taking_prenatal_vitamins'][value='yes']").prop("checked", true);
			} else {
				$("input[name='taking_prenatal_vitamins'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='taking_prenatal_vitamins'][value='yes']").prop("checked", false);
			$("input[name='taking_prenatal_vitamins'][value='no']").prop("checked", false);
		}
		if(hpi_field4) {
			if(hpi_field4 == '2') {
				$("input[name='received_ultrasound'][value='yes']").prop("checked", true);
			} else {
				$("input[name='received_ultrasound'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='received_ultrasound'][value='yes']").prop("checked", false);
			$("input[name='received_ultrasound'][value='no']").prop("checked", false);
		}
		$("#num_live_births_input").val(hpi_field5);
		$("#num_miscarriages_input").val(hpi_field6);
		if(hpi_field7) {
			if(hpi_field7 == '2') {
				$("input[name='any_dysuria_urgency_or_frequency'][value='yes']").prop("checked", true);
			} else {
				$("input[name='any_dysuria_urgency_or_frequency'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='any_dysuria_urgency_or_frequency'][value='yes']").prop("checked", false);
			$("input[name='any_dysuria_urgency_or_frequency'][value='no']").prop("checked", false);
		}
		if(hpi_field8) {
			if(hpi_field8 == '2') {
				$("input[name='any_abnormal_vaginal_discharge'][value='yes']").prop("checked", true);
			} else {
				$("input[name='any_abnormal_vaginal_discharge'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='any_abnormal_vaginal_discharge'][value='yes']").prop("checked", false);
			$("input[name='any_abnormal_vaginal_discharge'][value='no']").prop("checked", false);
		}
		if(hpi_field9) {
			if(hpi_field9 == '2') {
				$("input[name='any_vaginal_bleeding'][value='yes']").prop("checked", true);
			} else {
				$("input[name='any_vaginal_bleeding'][value='no']").prop("checked", true);
			}
		} else {
			$("input[name='any_vaginal_bleeding'][value='yes']").prop("checked", false);
			$("input[name='any_vaginal_bleeding'][value='no']").prop("checked", false);
		}
		if(hpi_field10) {
			if(hpi_field10 == '2') {
				$("input[name='any_previous_pregnancy_complications'][value='yes']").prop("checked", true);
				$("#further_explanation_row").removeClass("hidden");
				$("#further_explanation_input").val(hpi_field11);
			} else {
				$("input[name='any_previous_pregnancy_complications'][value='no']").prop("checked", true);
				$("#further_explanation_input").val("");
			}
		} else {
			$("input[name='any_previous_pregnancy_complications'][value='yes']").prop("checked", false);
			$("input[name='any_previous_pregnancy_complications'][value='no']").prop("checked", false);
			$("#further_explanation_input").val("");
		}
		$("#pregnancy_notes_input").val(hpi_field12);
	}

	$("#chief_complaint_delete_button").removeClass("hidden");
	$("#chief_complaint_delete_button").unbind();
	$("#chief_complaint_delete_button").click(function() { 
		chiefComplaintDeleteClick(mode, consult_id, chief_complaint_id);
	});
	$("#chief_complaint_save_button").unbind();
	$("#chief_complaint_save_button").click(function() { 
		hpiSaveClick(consult_id, mode, chief_complaint_id, hpi_type, selected_value);
	});
}


function chiefComplaintDeleteClick(mode, consult_id, chief_complaint_id) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&delete=2&show=1" + lang_text;
}

function hpiPregnancySaveClick(consult_id, mode, chief_complaint_id) {
	var lang = getURLParameter("lang");
	var alert_triggered = false; 

	var num_weeks_pregnant = $("#num_weeks_pregnant_input").val();
	var receiving_prenatal_care = $("input[name=receiving_prenatal_care]:checked").val();
	if(receiving_prenatal_care) {
		if(receiving_prenatal_care == "yes") {
			receiving_prenatal_care = 2;
		} else if (receiving_prenatal_care == "no") {
			receiving_prenatal_care = 1;
		} else {
			receiving_prenatal_care = "";
		}
	} else {
		receiving_prenatal_care = "";
	} 
	var taking_prenatal_vitamins = $("input[name=taking_prenatal_vitamins]:checked").val();
	if(taking_prenatal_vitamins) {
		if(taking_prenatal_vitamins == "yes") {
			taking_prenatal_vitamins = 2;
		} else if (taking_prenatal_vitamins == "no") {
			taking_prenatal_vitamins = 1;
		} else {
			taking_prenatal_vitamins = "";
		}
	} else {
		taking_prenatal_vitamins = "";
	} 
	var received_ultrasound = $("input[name=received_ultrasound]:checked").val();
	if(received_ultrasound) {
		if(received_ultrasound == "yes") {
			received_ultrasound = 2;
		} else if (received_ultrasound == "no") {
			received_ultrasound = 1;
		} else {
			received_ultrasound = "";
		}
	} else {
		received_ultrasound = "";
	} 
	var num_live_births = $("#num_live_births_input").val();
	var num_miscarriages = $("#num_miscarriages_input").val();
	var any_dysuria_urgency_frequency = $("input[name=any_dysuria_urgency_or_frequency]:checked").val();
	if(any_dysuria_urgency_frequency) {
		if(any_dysuria_urgency_frequency == "yes") {
			any_dysuria_urgency_frequency = 2;
		} else if (any_dysuria_urgency_frequency == "no") {
			any_dysuria_urgency_frequency = 1;
		} else {
			any_dysuria_urgency_frequency = "";
		}
	} else {
		any_dysuria_urgency_frequency = "";
	} 
	var any_abnormal_vaginal_discharge = $("input[name=any_abnormal_vaginal_discharge]:checked").val();
	if(any_abnormal_vaginal_discharge) {
		if(any_abnormal_vaginal_discharge == "yes") {
			any_abnormal_vaginal_discharge = 2;
		} else if (any_abnormal_vaginal_discharge == "no") {
			any_abnormal_vaginal_discharge = 1;
		} else {
			any_abnormal_vaginal_discharge = "";
		}
	} else {
		any_abnormal_vaginal_discharge = "";
	} 
	var any_vaginal_bleeding = $("input[name=any_vaginal_bleeding]:checked").val();
	if(any_vaginal_bleeding) {
		if(any_vaginal_bleeding == "yes") {
			any_vaginal_bleeding = 2;
		} else if (any_vaginal_bleeding == "no") {
			any_vaginal_bleeding = 1;
		} else {
			any_vaginal_bleeding = "";
		}
	} else {
		any_vaginal_bleeding = "";
	} 
	var complications_notes = "";
	var any_previous_pregnancy_complications = $("input[name=any_previous_pregnancy_complications]:checked").val();
	if(any_previous_pregnancy_complications) {
		if(any_previous_pregnancy_complications == "yes") {
			any_previous_pregnancy_complications = 2;
			complications_notes = $("#further_explanation_input").val();
			if(!complication_notes) {
				alert_triggered = true;
				var alert_text = "ERROR. MUST PROVIDE FURTHER EXPLANATION";
				if(lang == "es") {
					alert_text = "ERROR. NECESITA LLENAR EXPLICACION ADICIONAL";
				}	
				alert(alert_text);
			}
		} else if (any_previous_pregnancy_complications == "no") {
			any_previous_pregnancy_complications = 1;
		} else {
			any_previous_pregnancy_complications = "";
		}
	} else {
		any_previous_pregnancy_complications = "";
	} 
	var notes = $("#pregnancy_notes_input").val();

	if(!alert_triggered) {
		var lang_text = formLang(lang, 1);
		window.location.href = "consult_active.php?show=1&save=2&mode=" + mode + "&hpi_type=2&consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&num_weeks_pregnant=" + num_weeks_pregnant + "&receiving_prenatal_care=" + receiving_prenatal_care + "&taking_prenatal_vitamins=" + taking_prenatal_vitamins + "&received_ultrasound=" + received_ultrasound + "&num_live_births=" + num_live_births + "&num_miscarriages=" + num_miscarriages + "&dysuria_urgency_frequency=" + any_dysuria_urgency_frequency + "&abnormal_vaginal_discharge=" + any_abnormal_vaginal_discharge + "&vaginal_bleeding=" + any_vaginal_bleeding + "&previous_pregnancy_complications=" + any_previous_pregnancy_complications + "&complications_notes=" + complications_notes + "&notes=" + notes + lang_text; 
	}
}

function hpiGeneralSaveClick(consult_id, mode, chief_complaint_id, selected_value) {
	var lang = getURLParameter("lang");

	var alert_triggered = false;
	var invalid_number_input = false;
	var pain_scale_out_of_range = false;
	var time_input_out_of_range = false;
	var invalid_time_option_select = false;

	var o_pain_how_text = "";
	var o_pain_cause_text = "";
	var p_pain_provocation_text = "";
	var p_pain_palliation_text = "";
	var q_pain_type_text = "";
	var r_pain_region_main_text = "";
	var r_pain_region_radiates_text = "";
	var s_pain_level_text = "";
	var t_pain_begin_time_text = "";
	var t_pain_before_text = "";
	var t_pain_current_text = "";
	var notes_text = "";

	var extra_text = "";
	if(selected_value == "255") {
		var name_text = $("#modal_general_hpi_custom_text_input").val();
		if(!name_text) {
			var alert_text = "ERROR: MUST ENTER A OTHER CHIEF COMPLAINT DESCRIPTION";
			if(lang == "es") {
				alert_text = "ERROR: NECESITA INGRESAR UNA OTRA QUEJA PRINCIPAL DESCRIPCION";
			}
			alert(alert_text);
			return;
		} else {
			extra_text = "&name=" + name_text;
		}
	}


	var o_pain_how_select_array = $("#o_pain_how_select").val();
	var o_pain_how_length = o_pain_how_select_array.length;
	if(o_pain_how_length > 0 && o_pain_how_select_array[o_pain_how_length - 1] == "other") {
		o_pain_how_select_array.splice(o_pain_how_length - 1, 1);
		var custom_input = $("#o_pain_how_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			o_pain_how_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	o_pain_how_text = o_pain_how_select_array.toString();

	var o_pain_cause_select_array = $("#o_pain_cause_select").val();
	var o_pain_cause_length = o_pain_cause_select_array.length;
	if(o_pain_cause_length > 0 && o_pain_cause_select_array[o_pain_cause_length - 1] == "other") {
		o_pain_cause_select_array.splice(o_pain_cause_length - 1, 1);
		var custom_input = $("#o_pain_cause_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			o_pain_cause_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	o_pain_cause_text = o_pain_cause_select_array.toString();

	var p_pain_provocation_select_array = $("#p_pain_provocation_select").val();
	var p_pain_provocation_length = p_pain_provocation_select_array.length;
	if(p_pain_provocation_length > 0 && p_pain_provocation_select_array[p_pain_provocation_length - 1] == "other") {
		p_pain_provocation_select_array.splice(p_pain_provocation_length - 1, 1);
		var custom_input = $("#p_pain_provocation_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
			}
			p_pain_provocation_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	p_pain_provocation_text = p_pain_provocation_select_array.toString();

	var p_pain_palliation_select_array = $("#p_pain_palliation_select").val();
	var p_pain_palliation_length = p_pain_palliation_select_array.length;
	if(p_pain_palliation_length > 0 && p_pain_palliation_select_array[p_pain_palliation_length - 1] == "other") {
		p_pain_palliation_select_array.splice(p_pain_palliation_length - 1, 1);
		var custom_input = $("#p_pain_palliation_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			p_pain_palliation_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	p_pain_palliation_text = p_pain_palliation_select_array.toString();

	var q_pain_type_select_array = $("#q_pain_type_select").val();
	var q_pain_type_length = q_pain_type_select_array.length;
	if(q_pain_type_length > 0 && q_pain_type_select_array[q_pain_type_length - 1] == "other") {
		q_pain_type_select_array.splice(q_pain_type_length - 1, 1);
		var custom_input = $("#q_pain_type_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			q_pain_type_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	q_pain_type_text = q_pain_type_select_array.toString();

	var r_pain_region_main_select_array = $("#r_pain_region_main_select").val();
	var r_pain_region_main_length = r_pain_region_main_select_array.length;
	if(r_pain_region_main_length > 0 && r_pain_region_main_select_array[r_pain_region_main_length - 1] == "other") {
		r_pain_region_main_select_array.splice(r_pain_region_main_length - 1, 1);
		var custom_input = $("#r_pain_region_main_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			r_pain_region_main_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	r_pain_region_main_text = r_pain_region_main_select_array.toString();

	var r_pain_region_radiates_select_array = $("#r_pain_region_radiates_select").val();
	var r_pain_region_radiates_length = r_pain_region_radiates_select_array.length;
	if(r_pain_region_radiates_length > 0 && r_pain_region_radiates_select_array[r_pain_region_radiates_length - 1] == "other") {
		r_pain_region_radiates_select_array.splice(r_pain_region_radiates_length - 1, 1);
		var custom_input = $("#r_pain_region_radiates_other").val();
		if(custom_input) {
			if(isInt(custom_input)) {
				alert_triggered = true;
				invalid_number_input = true;
			}
			r_pain_region_radiates_select_array.push(replaceAll(custom_input, ",", ";"))
		}
	}
	r_pain_region_radiates_text = r_pain_region_radiates_select_array.toString();

	s_pain_level_text = $("#s_pain_level").val();
	if(s_pain_level_text && (s_pain_level_text < 0 || s_pain_level_text > 10)) {
		alert_triggered = true;
		pain_scale_out_of_range = true;
	} 

	t_pain_begin_time_text = $("#t_pain_begin_time").val();
	if(t_pain_begin_time_text && (t_pain_begin_time_text < 1 || t_pain_begin_time_text > 99)) {
		alert_triggered = true;
		time_input_out_of_range = true;
	} else if (t_pain_begin_time_text) {
		var t_pain_begin_time_option_select = $("#t_pain_begin_time_option_select").val();
		if(t_pain_begin_time_option_select) {
			t_pain_begin_time_text += t_pain_begin_time_option_select;
		} else {
			alert_triggered = true;
			invalid_time_option_select = true;
		}
	}
	t_pain_before_text = $("input[name=t_pain_before]:checked").val();
	if(!t_pain_before_text) {
		t_pain_before_text = "";
	}
	t_pain_current_text = $("input[name=t_pain_current]:checked").val();
	if(!t_pain_current_text) {
		t_pain_current_text = "";
	}
	notes_text = $("#general_notes_input").val();

	if(alert_triggered) {
		var alert_text = "ERROR";
		if(invalid_number_input) {
			alert_text = "ERROR: INVALID NUMBER INPUT";
			if(lang == "es") {
				alert_text = "ERROR: ENTRADA DE NÚMERO INVÁLIDO";
			}
		} else if (pain_scale_out_of_range) {
			alert_text = "ERROR: PAIN SCALE OUT OF RANGE";
			if(lang == "es") {
				alert_text = "ERROR: ESCALE DE DOLOR FUERA DE RANGO";
			}
		} else if (time_input_out_of_range) {
			alert_text = "ERROR: TIME INPUT OUT OF RANGE";
			if(lang == "es") {
				alert_text = "ERROR: CAMPO DE TIEMPO FUERA DE RANGO";
			}
		} else if (invalid_time_option_select) {
			alert_text = "ERROR: INVALID TIME OPTION SELECT";
			if(lang == "es") {
				alert_text = "ERROR: ENTRADA DE TIEMPO INVÁLIDO";
			}
		} 
		alert(alert_text);
	} else {
		var lang_text = formLang(lang, 1);
		window.location.href = "consult_active.php?show=1&save=2&mode=" + mode + "&hpi_type=1&consult_id=" + consult_id + "&chief_complaint_id=" + chief_complaint_id + "&o_pain_how=" + o_pain_how_text + "&o_pain_cause=" + o_pain_cause_text + "&p_pain_provocation=" + p_pain_provocation_text + "&p_pain_palliation=" + p_pain_palliation_text + "&q_pain_type=" + q_pain_type_text + "&r_pain_region_main=" + r_pain_region_main_text + "&r_pain_region_radiates=" + r_pain_region_radiates_text + "&s_pain_level=" + s_pain_level_text + "&t_pain_begin_time=" + t_pain_begin_time_text + "&t_pain_before=" + t_pain_before_text + "&t_pain_current=" + t_pain_current_text + "&notes=" + notes_text + extra_text + lang_text; 
	}
}

function hpiSaveClick(consult_id, mode, chief_complaint_id, hpi_type, selected_value) {
	if(hpi_type == 1) {
		hpiGeneralSaveClick(consult_id, mode, chief_complaint_id, selected_value);
	} else if (hpi_type == 2) {
		hpiPregnancySaveClick(consult_id, mode, chief_complaint_id);
	}

}

function chiefComplaintSaveClick(consult_id, mode) {
	var primary = "";
	var secondary = "";

	var other_selected = false;

	var primary_array = $("#primary_chief_complaint_select").val();
	var primary_length = primary_array.length;
	if(primary_length > 0 && primary_array[primary_length - 1] == "255") {
		other_selected = true;
		primary_array.splice(primary_length - 1, 1);
		var custom_inputs = document.getElementsByClassName("custom_primary_chief_complaint");
		for(var i = 0; i < custom_inputs.length; i++) {
			var custom_input = custom_inputs[i].value;
			if(custom_input) {
				primary_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
	} 
	if(primary_array.length > 0) {
		primary = primary_array.toString();
	} 

	if(!primary) {
		if(other_selected) {
			alert(CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE2);
		} else  {
			alert(CHIEF_COMPLAINT_NOTHING_SELECTED_MESSAGE);
		}
	} else {
		window.location.href = "consult_active.php?mode=" + mode + "&consult_id=" + consult_id + "&pcca=" + primary + "&scca=" + secondary + "&save=2&show=1" + getLang(1);
	
	}

	/*
	var secondary_array = $("#secondary_chief_complaint_select").val();
	var secondary_length = secondary_array.length;
	if(secondary_length > 0 && secondary_array[secondary_length - 1] == "255") {
		secondary_array.splice(secondary_length - 1, 1);
		var custom_inputs = document.getElementsByClassName("custom_secondary_chief_complaint");
		for(var i = 0; i < custom_inputs.length; i++) {
			var custom_input = custom_inputs[i].value;
			if(custom_input) {
				secondary_array.push(replaceAll(custom_input, ",", ";"))
			}
		}
	} 
	if(secondary_array.length > 0) {
		secondary = secondary_array.toString();
	} 
	*/

}

//MOVE THIS STUFF LATER
function vitalSignsMeasurementsLoad(consult_id, mode, consult_option) {
	$('#myMeasurementsModal').modal('show');

	$("#measurements_delete_button").addClass("hidden");
	$("#measurements_save_button").unbind();
	$("#measurements_save_button").click(function() { 
		measurementsSaveClick(consult_id, mode);
	});
}

function measurementsSaveClick(consult_id, mode) {
	var lang = getURLParameter("lang");

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
			alert(MEASUREMENTS_TEMPERATURE_UNITS_MESSAGE);
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
			alert(MEASUREMENTS_WEIGHT_UNITS_MESSAGE);
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
			alert(MEASUREMENTS_HEIGHT_UNITS_MESSAGE);
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
			alert(MEASUREMENTS_WAIST_CIRCUMFERENCE_UNITS_MESSAGE);
			return;
		}
	} else {
		waist_circumference_units = "";
	}

	var notes = document.getElementById("measurements_notes_input").value;

	var lang_text = formLang(lang, 1);
	window.location.href = "consult_active.php?save=2&mode=" + mode + "&consult_id=" +  consult_id + "&is_pregnant=" + is_pregnant + "&date_last_menstruation=" + date_last_menstruation + "&temperature_units=" + temperature_units + "&temperature_value=" + temperature_value + "&blood_pressure_systolic=" + blood_pressure_systolic + "&blood_pressure_diastolic=" + blood_pressure_diastolic + "&pulse_rate=" + pulse_rate + "&blood_oxygen_saturation=" + blood_oxygen_saturation + "&respiration_rate=" + respiration_rate + "&weight_units=" + weight_units + "&weight_value=" + weight_value + "&height_units=" + height_units + "&height_value=" + height_value + "&waist_circumference_units=" + waist_circumference_units + "&waist_circumference_value=" + waist_circumference_value + "&notes=" + notes + lang_text; 
}

//MOVE THIS STUFF LATER
function examsLoad(consult_id, mode, consult_option) {
	$('#myExamsModal').modal('show');

	$("#exams_delete_button").addClass("hidden");
	$("#exams_save_button").addClass("hidden");
	$("#exams_save_button").unbind();

	var main_category = getURLParameter("main_category");
	var arg1 = "";
	var arg2 = "";
	var arg3 = "";
	var arg4 = "";
	if(main_category == null) {
		main_category = "";
	} else {
		arg1 = getURLParameter("arg1");
		if(arg1 == null) {
			arg1 = "";
			main_category = "";
		} else {
			arg2 = getURLParameter("arg2");
			if(arg2 == null) {
				arg2 = "";
				arg1 = "";
			} else {
				arg3 = getURLParameter("arg3");
				if(arg3 == null) {
					arg3 = "";
					arg2 = "";
				} else {
					arg4 = getURLParameter("arg4");
					if(arg4 == null) {
						arg4 = "";
						arg3 = "";
					} else {
						arg4 = "";
					}
				}
			}
		}
	}

	examMapClick(consult_id, mode, main_category, arg1, arg2, arg3, arg4, "");

	document.getElementById("exams_select").onchange = function() {
		var arr = $(this).val();
		var length = arr.length;

		if(length == 0) {
			$("#exams_select").val("-1");
		} else if (length == 1) {
			if(arr != "-1") {
				$("#exams_select option[value='-1']").prop("selected", false);
			}
		} else {
			$("#exams_select option[value='-1']").prop("selected", false);
		}

		var other_selected = false;
		if(length > 0) {
			other_selected = arr[length-1] == "255";
		}

		if(other_selected) {
			$("#exams_select_other_div").removeClass("hidden");
		} else {
			$("#exams_select_other_div").addClass("hidden");
		}
	}

}

function examMapClick(consult_id, mode, arg1, arg2, arg3, arg4, arg5, custom) {
	var temp_consult_id = "\"" + consult_id + "\"";
	var new_arg1 = arg1;
	var new_arg2 = arg2;
	var new_arg3 = arg3;
	var new_arg4 = arg4;
	var new_arg5 = arg5;

	var normal_choice = false;
	var other_choice = false;

	var current_map = "";
	if(arg1 == "") {
		current_map = php_full_map;
	} else {
		if(arg1 == EXAMS_NORMAL_CHOICE) {
			normal_choice = true;
		} else if(arg1 == EXAMS_OTHER_CHOICE) {
			other_choice = true;
		}
		if(php_full_map.hasOwnProperty(arg1)) {
			var level1_map = php_full_map[arg1];
			if(arg2 == "") {
				current_map = level1_map;
			} else {
				if(arg2 == EXAMS_NORMAL_CHOICE) {
					normal_choice = true;
				} else if(arg2 == EXAMS_OTHER_CHOICE) {
					other_choice = true;
				}
				if(level1_map.hasOwnProperty(arg2)) {
					var level2_map = level1_map[arg2];
					if(arg3 == "") {
						current_map = level2_map;
					} else {
						if(arg3 == EXAMS_NORMAL_CHOICE) {
							normal_choice = true;
						} else if(arg3 == EXAMS_OTHER_CHOICE) {
							other_choice = true;
						}
						if(level2_map.hasOwnProperty(arg3)) {
							var level3_map = level2_map[arg3];
							if(arg4 == "") {
								current_map = level3_map;
							} else {
								if(arg4 == EXAMS_NORMAL_CHOICE) {
									normal_choice = true;
								} else if(arg4 == EXAMS_OTHER_CHOICE) {
									other_choice = true;
								}
								if(level3_map.hasOwnProperty(arg4)) {
									var level4_map = level3_map[arg4];
									if(arg5 == "") {
										current_map = level4_map;
									} else {
										if(arg5== EXAMS_NORMAL_CHOICE) {
											normal_choice = true;
										} else if(arg5 == EXAMS_OTHER_CHOICE) {
											other_choice = true;
										}
										if(level4_map.hasOwnProperty(arg5)) {
											current_map = level4_map[arg5];
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	if(normal_choice) {
		saveExam(consult_id, mode, "", BOOLEAN_TRUE, arg1, arg2, arg3, arg4, arg5, "", "", "", "");
	} 

	if(current_map == "") {
		current_map = php_full_map;
	}

	$(".exam_list_item").remove();
	$(".exam_header").remove();

	if(arg1 == "") {
		$("#exam_type_title").removeClass("hidden");
		$("#exam_type_title_link").addClass("hidden");		
	} else {
		$("#exam_type_title").addClass("hidden");
		$("#exam_type_title_link").removeClass("hidden");
		if (arg2 == "" && !custom) {
			var header_element1 = "<p class='exam_header left_title5'>" + EXAMS_MAP[arg1] + "</p>";
			$(header_element1).insertBefore("#exam_list");
		} else if ((arg2 == "" && custom) || (arg3 == "" && !custom)) {
			var header_element1 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg1] + "</a>";
			$(header_element1).insertBefore("#exam_list");

			/*
			if(custom) {
				var header_element2 = "<p class='exam_header left_title5'>" + custom + "</p>";
				$(header_element2).insertBefore("#exam_list");
			} else 
			*/
			if(EXAMS_MAP.hasOwnProperty(arg2)) {
				var header_element2 = "<p class='exam_header left_title5'>" + EXAMS_MAP[arg2] + "</p>";
				$(header_element2).insertBefore("#exam_list");
			} 
		} else if ((arg3 == "" && custom) || (arg4 == "" && !custom)) {
			var header_element1 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg1] + "</a>";
			var header_element2 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg2] + "</a>";
			$(header_element1).insertBefore("#exam_list");
			$(header_element2).insertBefore("#exam_list");

			/*
			if(custom) {
				var header_element2 = "<p class='exam_header left_title5'>" + custom + "</p>";
				$(header_element2).insertBefore("#exam_list");
			} else 
			*/
			if(EXAMS_MAP.hasOwnProperty(arg3)) {
				var header_element3 = "<p class='exam_header left_title5'>" + EXAMS_MAP[arg3] + "</p>";
				$(header_element3).insertBefore("#exam_list");
			}
		} else if ((arg4 == "" && custom) || (arg5 == "" && !custom)) {
			var header_element1 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg1] + "</a>";
			var header_element2 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg2] + "</a>";
			var header_element3 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + arg3 + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg3] + "</a>";
			$(header_element1).insertBefore("#exam_list");
			$(header_element2).insertBefore("#exam_list");
			$(header_element3).insertBefore("#exam_list");

			/*
			if(custom) {
				var header_element2 = "<p class='exam_header left_title5'>" + custom + "</p>";
				$(header_element2).insertBefore("#exam_list");
			} else 
			*/
			if(EXAMS_MAP.hasOwnProperty(arg4)) {
				var header_element4 = "<p class='exam_header left_title5'>" + EXAMS_MAP[arg4] + "</p>";
				$(header_element4).insertBefore("#exam_list");
			}
		} else {
			var header_element1 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg1] + "</a>";
			var header_element2 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg2] + "</a>";
			var header_element3 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + arg3 + "\", \"" + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg3] + "</a>";
			var header_element4 = "<a class='exam_header left_title5' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + arg3 + "\", \"" + arg4 + "\", \"" + "\", \"" + "\");'>" + EXAMS_MAP[arg4] + "</a>";
			$(header_element1).insertBefore("#exam_list");
			$(header_element2).insertBefore("#exam_list");
			$(header_element3).insertBefore("#exam_list");
			$(header_element4).insertBefore("#exam_list");

			/*
			if(custom) {
				var header_element2 = "<p class='exam_header left_title5'>" + custom + "</p>";
				$(header_element2).insertBefore("#exam_list");
			} else 
			*/
			if(EXAMS_MAP.hasOwnProperty(arg5)) {
				var header_element5 = "<p class='exam_header left_title5'>" + EXAMS_MAP[arg5] + "</p>";
				$(header_element5).insertBefore("#exam_list");
			}
		}
	}

	if(other_choice || isArray(current_map) || custom) {
		$("#exams_select_touch_here").prop("selected", true);
		$("#exams_select_other_option").prop('selected', false);
		$("#exams_other_exam_input").val("");
		$("#exams_notes").val("");

		$("#exam_list").addClass("hidden");
		$("#exam_form_stuff").removeClass("hidden");
		$(".exam_select_option").remove();

		var array = normal_abnormal_array;
		if(other_choice || custom) {
			$("#other_exam_div").removeClass("hidden");

		} else {
			$("#other_exam_div").addClass("hidden");
			array = current_map;
		}

		var mark_type = determineMark(new_arg1, new_arg2, new_arg3, new_arg4, new_arg5);
		var matching_exam = null;
		if(mark_type > 0) {
			matching_exam = getMatchingExam(new_arg1, new_arg2, new_arg3, new_arg4, new_arg5, custom);
		}

		$("#exams_save_button").removeClass("hidden");
		$("#exams_save_button").unbind();

		if(matching_exam != null) {
			$("#exams_select_touch_here").prop("selected", false);
			var exam_id = matching_exam[0];
			var options = matching_exam[7];
			var other_option = matching_exam[8];
			var notes = matching_exam[9];

			var options_array = options.split(",");

			if(custom) {
				$("#exams_other_exam_input").val(custom);
			}

			$("#exams_notes").val(notes);

			$("#exams_delete_button").removeClass("hidden");
			$("#exams_delete_button").unbind();
			$("#exams_delete_button").click(function() { 
				examsDeleteClick(consult_id, mode, exam_id, new_arg1, new_arg2, new_arg3, new_arg4, new_arg5); //PASS IN EXAM ID
			});

			var array_length = array.length;
			for(var i = 0; i < array_length; i++) {
				var value = array[i];

				var element;
				if(options_array.indexOf(value) == -1) {
					element = "<option class='exam_select_option' value='" + value + "''>" + EXAMS_MAP[value] + "</option>";
				} else {
					element = "<option class='exam_select_option' value='" + value + "'' selected>" + EXAMS_MAP[value] + "</option>";
				}
				
				$(element).insertBefore("#exams_select_other_option");
			}

			if(other_option) {
				$("#exams_select_other_div").removeClass("hidden");
				$("#exams_select_other_option").prop('selected', true);
				$("#exams_select_other_input").val(other_option);
			}

			$("#exams_save_button").click(function() { 
				examsSaveClick(consult_id, mode, exam_id, arg1, arg2, arg3, arg4, arg5);
			});

		} else {
			$("#exams_delete_button").addClass("hidden");
			$("#exams_select_other_div").addClass("hidden");


			var array_length = array.length;
			for(var i = 0; i < array_length; i++) {
				var value = array[i];
				var element = "<option class='exam_select_option' value='" + value + "''>" + EXAMS_MAP[value] + "</option>";
				$(element).insertBefore("#exams_select_other_option");
			}

			$("#exams_save_button").click(function() { 
				examsSaveClick(consult_id, mode, "", arg1, arg2, arg3, arg4, arg5);
			});
		}

	} else {
		$("#exam_list").removeClass("hidden");
		$("#exam_form_stuff").addClass("hidden");
		if (arg1 != "") {
			var temp1_arg1 = arg1;
			var temp1_arg2 = arg2;
			var temp1_arg3 = arg3;
			var temp1_arg4 = arg4;
			var temp1_arg5 = arg5;
			var temp2_arg1 = arg1;
			var temp2_arg2 = arg2;
			var temp2_arg3 = arg3;
			var temp2_arg4 = arg4;
			var temp2_arg5 = arg5;
			if(arg1 == "") {
	    		temp1_arg1 = EXAMS_NORMAL_CHOICE;
	    		temp2_arg1 = EXAMS_OTHER_CHOICE;
	    	} else if (arg2 == "") {
				temp1_arg2 = EXAMS_NORMAL_CHOICE;
				temp2_arg2 = EXAMS_OTHER_CHOICE;
	    	} else if (arg3 == "") {
	    		temp1_arg3 = EXAMS_NORMAL_CHOICE;
	    		temp2_arg3 = EXAMS_OTHER_CHOICE;
	    	} else if (arg4 == "") {
	    		temp1_arg4 = EXAMS_NORMAL_CHOICE;
	    		temp2_arg4 = EXAMS_OTHER_CHOICE;
	    	} else if (arg5 == "") {
	    		temp1_arg5 = EXAMS_NORMAL_CHOICE;
	    		temp2_arg5 = EXAMS_OTHER_CHOICE;
	    	}
	    	var mark_type = determineMark(arg1, arg2, arg3, arg4, arg5);
			var element = "<li class='exam_list_item list-group-item' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + temp1_arg1 + "\", \"" + temp1_arg2 + "\", \"" + temp1_arg3 + "\", \"" + temp1_arg4 + "\", \"" + temp1_arg5 + "\", \"" + "\");'>" + NORMAL_CAPS;

			if (mark_type == 2) {
	    		element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
	    		/*
	    		if(mark_type == 1) {
	    			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
	    		} else if (mark_type == 2) {
	    			element += NORMAL_IN_PARANTHESES;
	    		} else if (mark_type == 3) {
	    			element += ABNORMAL_IN_PARANTHESES;
	    		}
	    		*/
	    	}

			$("#exam_list").append(element);
	    }
		for (var key in current_map) {
		    if (current_map.hasOwnProperty(key)) {
		    	var value = current_map[key];
		    	if(arg1 == "") {
		    		new_arg1 = key;
		    	} else if (arg2 == "") {
					new_arg2 = key;
		    	} else if (arg3 == "") {
		    		new_arg3 = key;
		    	} else if (arg4 == "") {
		    		new_arg4 = key;
		    	} else if (arg5 == "") {
		    		new_arg5 = key;
		    	}
		    	var mark_type = determineMark(new_arg1, new_arg2, new_arg3, new_arg4, new_arg5);



		    	var element = "<li class='exam_list_item list-group-item' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + new_arg1 + "\", \"" + new_arg2 + "\", \"" + new_arg3 + "\", \"" + new_arg4 + "\", \"" + new_arg5 + "\", \"" + "\");'>" + EXAMS_MAP[key];

		    	if (mark_type > 0) {
		    		element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
		    		/*
		    		if(mark_type == 1) {
		    			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
		    		} else if (mark_type == 2) {
		    			element += NORMAL_IN_PARANTHESES;
		    		} else if (mark_type == 3) {
		    			element += ABNORMAL_IN_PARANTHESES;
		    		}
		    		*/
		    	}

		    	element += "</li>";
		    	$("#exam_list").append(element);
		    	
		    }
		}


		//ITERATE OVER CUSTOM
		var custom_exams = getCustomExams(arg1, arg2, arg3, arg4, arg5);
		for(var custom_exam_i = 0; custom_exam_i < custom_exams.length; custom_exam_i++) {
			var custom_exam = custom_exams[custom_exam_i];
			var information = custom_exam[6];
			var element = "<li class='exam_list_item list-group-item' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + arg1 + "\", \"" + arg2 + "\", \"" + arg3 + "\", \"" + arg4 + "\", \"" + arg5 + "\", \"" + information + "\");'>" + information + '<img class="consult_task_completed" src="images/checkmark.png"/>' + "</li>";
			$("#exam_list").append(element);
		}

		if (arg1 != "") {
			var element = "<li class='exam_list_item list-group-item' onclick='examMapClick(" + temp_consult_id + ", " + mode + ", \"" + temp2_arg1 + "\", \"" + temp2_arg2 + "\", \"" + temp2_arg3 + "\", \"" + temp2_arg4 + "\", \"" + temp2_arg5 + "\", \"" + "\");'>" + OTHER + "</li>";
			$("#exam_list").append(element);
		}
	}
}

function isArray(obj) {
	for (var key in obj) {
		if (obj.hasOwnProperty(key)) {
		    var value = obj[key];
			if(typeof value == "object") {
				return false;
			} 
		}
	}
	return true;
}

function examsDeleteClick(consult_id, mode, exam_id, main_category, arg1, arg2, arg3, arg4) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?delete=2&mode=" + mode + "&consult_id=" + consult_id + "&exam_id=" + exam_id + "&main_category=" + main_category + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + arg4 + lang_text;
}

function examsSaveClick(consult_id, mode, exam_id, main_category, arg1, arg2, arg3, arg4) {
	var normal_selected = $("#exams_select option:selected").index() == 1;
	var options = $("#exams_select").val().toString();
	var multiple_selected = options.split(",").length > 1;

	if(!options) {
		alert(EXAM_MUST_SELECT_OPTIONS);
		return;
	}

	if(normal_selected && multiple_selected) {
		alert(EXAM_INVALID_SUBMIT_MESSAGE);
		return;
	} 

	var is_normal = normal_selected ? BOOLEAN_TRUE : BOOLEAN_FALSE;

	var new_arg1 = arg1;
	var new_arg2 = arg2;
	var new_arg3 = arg3;
	var new_arg4 = arg4;

	if(arg2 == "") {
		if(arg1 == "-1") {
			new_arg1 = "";
		}
	} else if (arg3 == "") {
		if(arg2 == "-1") {
			new_arg2 = "";
		}
	} else if (arg4 == "") {
		if(arg3 == "-1") {
			new_arg3 = "";
		}
	} else {
		if(arg4 == "-1") {
			new_arg4 = "";
		}
	}

	var information = "";
	if($("#exams_other_exam_input").is(":visible")) {
		information = $("#exams_other_exam_input").val();
		if(!information) {
			alert(EXAM_NAME_OTHER_MESSAGE);
			return;
		}
	} 

	var other_option = "";
	if($("#exams_select_other_input").is(":visible")) {
		other_option = $("#exams_select_other_input").val();
		if(!other_option) {
			alert(EXAM_NAME_OTHER_MESSAGE1);
			return;
		}
	}

	var notes = $("#exams_notes").val();

	saveExam(consult_id, mode, exam_id, is_normal, main_category, new_arg1, new_arg2, new_arg3, new_arg4, information, options, other_option, notes);
}

function saveExam(consult_id, mode, exam_id, is_normal, main_category, arg1, arg2, arg3, arg4, information, options, other_option, notes) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?save=2&mode=" + mode + "&consult_id=" + consult_id + "&exam_id=" + exam_id + "&is_normal=" + is_normal + "&main_category=" + main_category + "&arg1=" + arg1 + "&arg2=" + arg2 + "&arg3=" + arg3 + "&arg4=" + arg4 + "&information=" + information + "&options=" + options + "&other_option=" + other_option + "&notes=" + notes + lang_text;

}

function getMatchingExam(arg1, arg2, arg3, arg4, arg5, custom) {
	if(custom) {
		var custom_exams = getCustomExams(arg1, arg2, arg3, arg4, arg5);
		for (var i = 0; i < custom_exams.length; i++) {
			var custom_exam = custom_exams[i];
			if(custom_exam[6] == custom) {
				var exam_arg1 = custom_exam[1];
				var exam_arg2 = custom_exam[2];
				var exam_arg3 = custom_exam[3];
				var exam_arg4 = custom_exam[4];
				var exam_arg5 = custom_exam[5];

				if(!exam_arg2 && !arg2) {
					if(arg1 == exam_arg1) {
						return custom_exam;
					}
				} else if (!exam_arg3 && !arg3) {
					if (arg1 == exam_arg1 && arg2 == exam_arg2) {
						return custom_exam;
					}
				} else if (!exam_arg4 && !arg4) {
					if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3) {
						return custom_exam;
					}
				} else if (!exam_arg5 && !arg5) {
					if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4) {
						return custom_exam;
					}
				} else {
					if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4 && arg4 == exam_arg5) {
						return custom_exam;
					}
				}
			}
		}
	} else {
		for(var abnormal_i = 0; abnormal_i < php_abnormal_exams.length; abnormal_i++) {
			var abnormal_exam_array = php_abnormal_exams[abnormal_i];
			var exam_arg1 = abnormal_exam_array[1];
			var exam_arg2 = abnormal_exam_array[2];
			var exam_arg3 = abnormal_exam_array[3];
			var exam_arg4 = abnormal_exam_array[4];
			var exam_arg5 = abnormal_exam_array[5];

			if(!exam_arg2 && !arg2) {
				if(arg1 == exam_arg1) {
					return abnormal_exam_array;
				}
			} else if (!exam_arg3 && !arg3) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2) {
					return abnormal_exam_array;
				}
			} else if (!exam_arg4 && !arg4) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3) {
					return abnormal_exam_array;
				}
			} else if (!exam_arg5 && !arg5) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4) {
					return abnormal_exam_array;
				}
			} else {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4 && arg5 == exam_arg5) {
					return abnormal_exam_array;
				}
			}
		}

		for(var normal_i = 0; normal_i < php_normal_exams.length; normal_i++) {
			var normal_exam_array = php_normal_exams[normal_i];
			var exam_arg1 = normal_exam_array[1];
			var exam_arg2 = normal_exam_array[2];
			var exam_arg3 = normal_exam_array[3];
			var exam_arg4 = normal_exam_array[4];
			var exam_arg5 = normal_exam_array[5];

			if(!exam_arg2 && !arg2) {
				if(arg1 == exam_arg1) {
					return normal_exam_array;
				}
			} else if (!exam_arg3 && !arg3) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2) {
					return normal_exam_array;
				}
			} else if (!exam_arg4 && !arg4) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3) {
					return normal_exam_array;
				}
			} else if (!exam_arg5 && !arg5) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4) {
					return normal_exam_array;
				}
			} else {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4 && arg5 == exam_arg5) {
					return normal_exam_array;
				}
			}
		}
	}
	return null;
}

// 0: None
// 1: Checkmark
// 2: Normal
// 3: Abnormal
function determineMark(arg1, arg2, arg3, arg4, arg5) {
	console.log(arg1 + " " + arg2 + " " + arg3 + " " + arg4 + " " + arg5);

	var mark = 0;

	var normal_mark = determineNormalMark(arg1, arg2, arg3, arg4, arg5);
	if(normal_mark == 2) {
		mark = normal_mark;
	} else {
		var abnormal_mark = determineAbnormalMark(arg1, arg2, arg3, arg4, arg5);
		if(abnormal_mark == 3) {
			mark = abnormal_mark;
		}
	}

	if(mark == 0) {
		if(normal_mark == 1 || abnormal_mark == 1) {
			mark = 1;
		}
	}
	console.log(mark);
	return mark;
}

function determineNormalMark(arg1, arg2, arg3, arg4, arg5) {
	var mark = 0;
	for(var normal_i = 0; normal_i < php_normal_exams.length; normal_i++) {
		var normal_exam_array = php_normal_exams[normal_i];
		var exam_arg1 = normal_exam_array[1];
		var exam_arg2 = normal_exam_array[2];
		var exam_arg3 = normal_exam_array[3];
		var exam_arg4 = normal_exam_array[4];
		var exam_arg5 = normal_exam_array[5];

		if(arg1 == exam_arg1) {
			if(arg2) {
				if(arg2 == exam_arg2) {
					if(arg3) {
						if(arg3 == exam_arg3) {
							if(arg4) {
								if(arg4 == exam_arg4) {
									if(arg5) {
										if(arg5 == exam_arg5) {
											mark = 2;
										} else {
											mark = 0;
										}
									} else {
										if(exam_arg5) {
											mark = 1;
										} else {
											mark = 2;
										}
									}
								}
							} else {
								if(exam_arg4) {
									mark = 1;
								} else {
									mark = 2;
								}
							}
						}
					} else {
						if(exam_arg3) {
							mark = 1;
						} else {
							mark = 2;
						}
					}
				}
			} else {
				if(exam_arg2) {
					mark = 1;
				} else {
					mark = 2;
				}
			}
		} 
		if(mark == 2) {
			break;
		}
	}
	return mark;
}

function getCustomExams(arg1, arg2, arg3, arg4, arg5) {
	console.log("CUSTOM: " + arg1 + " " + arg2 + " " + arg3 + " " + arg4 + " " + arg5);

	var arr = [];
	getCustomNormalExams(arr, arg1, arg2, arg3, arg4, arg5);
	getCustomAbnormalExams(arr, arg1, arg2, arg3, arg4, arg5);
	return arr; 
}

function getCustomNormalExams(arr, arg1, arg2, arg3, arg4, arg5) {
	for(var normal_i = 0; normal_i < php_normal_exams.length; normal_i++) {
		var normal_exam_array = php_normal_exams[normal_i];
		if(normal_exam_array[6]) {
			var exam_arg1 = normal_exam_array[1];
			var exam_arg2 = normal_exam_array[2];
			var exam_arg3 = normal_exam_array[3];
			var exam_arg4 = normal_exam_array[4];
			var exam_arg5 = normal_exam_array[5];

			if(!exam_arg2 && !arg2) {
				if(arg1 == exam_arg1) {
					arr.push(normal_exam_array);
				}
			} else if (!exam_arg3 && !arg3) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2) {
					arr.push(normal_exam_array);
				}
			} else if (!exam_arg4 && !arg4) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3) {
					arr.push(normal_exam_array);
				}
			} else if (!exam_arg5 && !arg5) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4) {
					arr.push(normal_exam_array);
				}
			} else {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4 && arg4 == exam_arg5) {
					arr.push(normal_exam_array);
				}
			}
		}
	}
}

function getCustomAbnormalExams(arr, arg1, arg2, arg3, arg4, arg5) {
	for(var abnormal_i = 0; abnormal_i < php_abnormal_exams.length; abnormal_i++) {
		var abnormal_exam_array = php_abnormal_exams[abnormal_i];
		if(abnormal_exam_array[6]) {
			var exam_arg1 = abnormal_exam_array[1];
			var exam_arg2 = abnormal_exam_array[2];
			var exam_arg3 = abnormal_exam_array[3];
			var exam_arg4 = abnormal_exam_array[4];
			var exam_arg5 = abnormal_exam_array[5];

			if(!exam_arg2 && !arg2) {
				if(arg1 == exam_arg1) {
					arr.push(abnormal_exam_array);
				}
			} else if (!exam_arg3 && !arg3) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2) {
					arr.push(abnormal_exam_array);
				}
			} else if (!exam_arg4 && !arg4) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3) {
					arr.push(abnormal_exam_array);
				}
			} else if (!exam_arg5 && !arg5) {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4) {
					arr.push(abnormal_exam_array);
				}
			} else {
				if (arg1 == exam_arg1 && arg2 == exam_arg2 && arg3 == exam_arg3 && arg4 == exam_arg4 && arg4 == exam_arg5) {
					arr.push(abnormal_exam_array);
				}
			}
		}
	}
}


function determineAbnormalMark(arg1, arg2, arg3, arg4, arg5) {
	var mark = 0;
	for(var abnormal_i = 0; abnormal_i < php_abnormal_exams.length; abnormal_i++) {
		var abnormal_exam_array = php_abnormal_exams[abnormal_i];
		var exam_arg1 = abnormal_exam_array[1];
		var exam_arg2 = abnormal_exam_array[2];
		var exam_arg3 = abnormal_exam_array[3];
		var exam_arg4 = abnormal_exam_array[4];
		var exam_arg5 = abnormal_exam_array[5];

		if(arg1 == exam_arg1) {
			if(arg2) {
				if(arg2 == exam_arg2) {
					if(arg3) {
						if(arg3 == exam_arg3) {
							if(arg4) {
								if(arg4 == exam_arg4) {
									if(arg5) {
										if(arg5 == exam_arg5) {
											mark = 3;
										} else {
											mark = 0;
										}
									} else {
										if(exam_arg5) {
											mark = 1;
										} else {
											mark = 3;
										}
									}
								}
							} else {
								if(exam_arg4) {
									mark = 1;
								} else {
									mark = 3;
								}
							}
						}
					} else {
						if(exam_arg3) {
							mark = 1;
						} else {
							mark = 3;
						}
					}
				}
			} else {
				if(exam_arg2) {
					mark = 1;
				} else {
					mark = 3;
				}
			}
		} 

		if(mark == 3) {
			break;
		}
	}
	return mark;
}

function diagnosesLoad(consult_id, mode, consult_option) {
	var category = getURLParameter("category");
	var option = getURLParameter("option");

	if (category) {
		diagnosesPageClick(consult_id, mode, 3, category)
	} else  {
		diagnosesPageClick(consult_id, mode, 1, "");
	}

	$('#myDiagnosesModal').modal('show');

	$("#diagnoses_delete_button").addClass("hidden");
	$("#diagnoses_save_button").addClass("hidden");
}

function diagnosesPageClick(consult_id, mode, page, category) {
	var temp_consult_id = '\'' + consult_id + '\'';
	$("#diagnoses_delete_button").addClass("hidden");
	$("#diagnoses_save_button").addClass("hidden");

	$("#diagnosis_list").empty();
	$("#diagnosis_list").removeClass("hidden");
	$("#diagnosis_form_stuff").addClass("hidden");
	if(page == 1) {
		$("#diagnosisPage1P").removeClass("hidden");
		$("#diagnosisPage1Link").addClass("hidden");
		$("#diagnosisPage2P").addClass("hidden");
		$("#diagnosisPage2Link").addClass("hidden");
		$("#diagnosisPage3P").addClass("hidden");
		$("#diagnosisPage3Link").addClass("hidden");

		var num_marks_on_page1 = 0;
		for(var main_options_i = 0; main_options_i < php_main_options.length; main_options_i++) {
			var main_option = php_main_options[main_options_i];
			if(optionHasDiagnosis(main_option)) {
				num_marks_on_page1++;
			}
		}
		num_marks_on_page1 += getNumCustomDiagnoses("");


		var element = '<li id="diagnoses_option_full_list" class="diagnosis_list_item list-group-item" onclick="diagnosesPageClick(' + temp_consult_id + ', ' + mode + ', ' + '2' + ', \'\');">' + CATEGORIES_MORE_OPTIONS;
		if(num_marks_on_page1 < getNumDiagnoses()) {
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
		}
		element += '</li>';
		$("#diagnosis_list").append(element);

		for(var main_options_i = 0; main_options_i < php_main_options.length; main_options_i++) {
			var main_option = php_main_options[main_options_i];
			var text = DIAGNOSIS_MAPPING[main_option];

			element = '<li class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', ' + main_option + ', ' + '1' + ', \'\', \'\');">' + text;
			if(optionHasDiagnosis(main_option)) {
				element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			}
			element += '</li>';
			$("#diagnosis_list").append(element);
		}

		var custom_diagnoses = getCustomDiagnoses("");
		for(var custom_diagnosis_i = 0; custom_diagnosis_i < custom_diagnoses.length; custom_diagnosis_i++) {
			var custom_diagnosis = custom_diagnoses[custom_diagnosis_i];
			var text = custom_diagnosis[4];

			element = '<li class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', \'\', ' + '1' + ', \'\', \'' + text + '\');">' + text;
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			element += '</li>';
			$("#diagnosis_list").append(element);
		}
		 
		element = '<li id="diagnoses_option_other" class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', ' + '-1, ' + '1' + ', \'\', \'\');">' + OTHER + '</li>';
		$("#diagnosis_list").append(element);
	} else if (page == 2) {
		$("#diagnosisPage1P").addClass("hidden");
		$("#diagnosisPage1Link").removeClass("hidden");
		$("#diagnosisPage2P").removeClass("hidden");
		$("#diagnosisPage2Link").addClass("hidden");
		$("#diagnosisPage3P").addClass("hidden");
		$("#diagnosisPage3Link").addClass("hidden");

		$("#diagnosisPage2P").html(CATEGORIES);

		for(var key in php_full_map) {
			var category = DIAGNOSIS_MAPPING[key];

			element = '<li class="diagnosis_list_item list-group-item" onclick="diagnosesPageClick(' + temp_consult_id + ', ' + mode + ', ' + '3' + ', ' + key + ');">' + category;
			if(categoryHasDiagnosis(key)) {
				element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			}
			element += '</li>';
			$("#diagnosis_list").append(element);
		}
		 
		//element = '<li id="diagnoses_option_other" class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + consult_id + ', ' + mode + ', ' + '-1, ' + '2' + ', \'\');">' + OTHER + '</li>';
		//$("#diagnosis_list").append(element);
	} else if (page == 3) {
		$("#diagnosisPage1P").addClass("hidden");
		$("#diagnosisPage1Link").removeClass("hidden");
		$("#diagnosisPage2P").addClass("hidden");
		$("#diagnosisPage2Link").removeClass("hidden");
		$("#diagnosisPage3P").removeClass("hidden");
		$("#diagnosisPage3Link").addClass("hidden");


		$("#diagnosisPage2Link").html(CATEGORIES);
		$("#diagnosisPage3P").html(DIAGNOSIS_MAPPING[category]);

		var options = php_full_map[category];
		for (var i = 0; i < options.length; i++) {
			var main_option = options[i];
			var text = DIAGNOSIS_MAPPING[main_option];
			element = '<li class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', ' + main_option + ', ' + '3' + ', ' + category + ', \'\');">' + text;
			if(optionHasDiagnosis(main_option)) {
				element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			}
			element += '</li>';
			$("#diagnosis_list").append(element);
		}

		var custom_diagnoses = getCustomDiagnoses(category);
		for(var custom_diagnosis_i = 0; custom_diagnosis_i < custom_diagnoses.length; custom_diagnosis_i++) {
			var custom_diagnosis = custom_diagnoses[custom_diagnosis_i];
			var text = custom_diagnosis[4];

			element = '<li class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', \'\', ' + '3' + ', ' + category + ', \'' + text + '\');">' + text;
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			element += '</li>';
			$("#diagnosis_list").append(element);
		}
		 
		element = '<li id="diagnoses_option_other" class="diagnosis_list_item list-group-item" onclick="diagnosisItemClick(' + temp_consult_id + ', ' + mode + ', ' + '-1, ' + '3' + ', ' + category + ', \'\');">' + OTHER + '</li>';
		$("#diagnosis_list").append(element);
	}
}


function diagnosisItemClick(consult_id, mode, option, source_page, category, custom_text) {
	$("#diagnosis_list").addClass("hidden");
	$("#diagnosis_form_stuff").removeClass("hidden");

	var existing_diagnosis = null;

	if(source_page == 1) {
		$("#diagnosisPage1P").addClass("hidden");
		$("#diagnosisPage1Link").removeClass("hidden");
		$("#diagnosisPage2P").removeClass("hidden");
		$("#diagnosisPage2Link").addClass("hidden");
		$("#diagnosisPage3P").addClass("hidden");
		$("#diagnosisPage3Link").addClass("hidden");


		if(option == -1 || custom_text) {
			$("#diagnosisPage2P").html(OTHER);
			$("#other_input_row").removeClass("hidden");

			if(custom_text) {
				existing_diagnosis = getCustomDiagnosis("", custom_text);
			}
		} else {
			$("#diagnosisPage2P").html(DIAGNOSIS_MAPPING[option]);
			$("#other_input_row").addClass("hidden");
			existing_diagnosis = getDiagnosis(option);

		}
	} else if (source_page == 2) {
		$("#diagnosisPage1P").addClass("hidden");
		$("#diagnosisPage1Link").removeClass("hidden");
		$("#diagnosisPage2P").addClass("hidden");
		$("#diagnosisPage2Link").removeClass("hidden");
		$("#diagnosisPage3P").removeClass("hidden");
		$("#diagnosisPage3Link").addClass("hidden");


		$("#diagnosisPage2Link").html(CATEGORIES);

		if(option == -1) {
			$("#diagnosisPage3P").html(OTHER);
			$("#other_input_row").removeClass("hidden");
		} else {
			$("#diagnosisPage3P").html(DIAGNOSIS_MAPPING[option]);
			$("#other_input_row").addClass("hidden");
		}

	} else if (source_page == 3) {
		$("#diagnosisPage1P").addClass("hidden");
		$("#diagnosisPage1Link").removeClass("hidden");
		$("#diagnosisPage2P").addClass("hidden");
		$("#diagnosisPage2Link").removeClass("hidden");
		$("#diagnosisPage3P").removeClass("hidden");
		$("#diagnosisPage3Link").removeClass("hidden");


		$("#diagnosisPage2Link").html(CATEGORIES);
		$("#diagnosisPage3Link").html(DIAGNOSIS_MAPPING[category]);
		$("#diagnosisPage3Link").attr("onclick","diagnosesPageClick('"+consult_id+"', '"+mode+"', '3', '"+category+"')");

		if(option == -1 || custom_text) {
			$("#diagnosisPage3P").html(OTHER);
			$("#other_input_row").removeClass("hidden");

			if(custom_text) {
				existing_diagnosis = getCustomDiagnosis(category, custom_text);
			}
		} else {
			$("#diagnosisPage3P").html(DIAGNOSIS_MAPPING[option]);
			$("#other_input_row").addClass("hidden");

			existing_diagnosis = getDiagnosis(option);
		}
	}

	
	$("#diagnoses_delete_button").addClass("hidden");
	$("#information_input").val("");
	$("input[name=diagnosis_type]").prop('checked', false);
	$("#diagnoses_notes_input").val("");

	var diagnosis_id = "";
	if(existing_diagnosis) {
		diagnosis_id = existing_diagnosis[0];
		var is_chronic = existing_diagnosis[1];
		var other = existing_diagnosis[4];
		var notes = existing_diagnosis[5];

		$("#information_input").val(other);
		if(is_chronic == BOOLEAN_TRUE) {
			$("#type_chronic").prop("checked", true);
		} else if (is_chronic == BOOLEAN_FALSE) {
			$("#type_acute").prop("checked", true);
		}
		$("#diagnoses_notes_input").val(notes);


		$("#diagnoses_delete_button").removeClass("hidden");
		$("#diagnoses_delete_button").click(function() { 
			diagnosesDeleteClick(diagnosis_id, consult_id, mode, option, source_page, category);
		});
	}




	$("#diagnoses_save_button").removeClass("hidden");
	$("#diagnoses_save_button").click(function() { 
		diagnosesSaveClick(diagnosis_id, consult_id, mode, option, source_page, category);
	});
}

function diagnosesDeleteClick(diagnosis_id, consult_id, mode, option, source_page, category) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?delete=2&diagnosis_id=" + diagnosis_id + "&consult_id=" + consult_id + "&mode=" + mode + "&option=" + option + "&category=" + category + lang_text;
}

function diagnosesSaveClick(diagnosis_id, consult_id, mode, option, source_page, category) {
	var lang_text = getLang(1);
	var other = "";
	if(option == -1) {
		option = "";
		other = $("#information_input").val();
		if(!other) {
			alert(DIAGNOSIS_EMPTY_OTHER_MESSAGE);
			return;
		}
	}
	var is_chronic = $('input[name=diagnosis_type]:checked').val();
	if(!is_chronic) {
		alert(DIAGNOSIS_EMPTY_CHRONIC_MESSAGE);
		return;
	}

	var notes = $("#diagnoses_notes_input").val();

	window.location.href = "consult_active.php?save=2&diagnosis_id=" + diagnosis_id + "&consult_id=" + consult_id + "&mode=" + mode + "&option=" + option + "&category=" + category + "&other=" + other + "&is_chronic=" + is_chronic + "&notes=" + notes + lang_text;
}

function optionHasDiagnosis(option) {
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(option == php_diagnosis[3]) {
			return true;
		}
	}
	return false;
}

function diagnosisWithCategory() {
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(php_diagnosis[2] > 0) {
			return true;
		}
	}
	return false;
}

function categoryHasDiagnosis(category) {
	var arr = php_full_map[category];

	for(var i = 0; i < arr.length; i++) {
		if(optionHasDiagnosis(arr[i])) {
			return true;
		}
	}
	return false;
	/*
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(category == php_diagnosis[2]) {
			return true;
		}
	}
	return false;
	*/
}

function getCustomDiagnoses(category) {
	var arr = [];
	if(category) {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] && php_diagnosis[2] == category) {
				arr.push(php_diagnosis);
			}
		}
	} else {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] && !php_diagnosis[2]) {
				arr.push(php_diagnosis);
			}
		}
	} 
	return arr;
}

function getNumCustomDiagnoses(category) {
	var cnt = 0;
	if(category) {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] && php_diagnosis[2] == category) {
				cnt++;
			}
		}
	} else {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] && !php_diagnosis[2]) {
				cnt++;
			}
		}
	} 
	return cnt;
}

function getCustomDiagnosis(category, other) {
	if(category) {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] == other && php_diagnosis[2] == category) {
				return php_diagnosis;
			}
		}
	} else {
		for (var i = 0; i < php_diagnoses.length; i++) {
			var php_diagnosis = php_diagnoses[i];
			if(php_diagnosis[4] == other && !php_diagnosis[2]) {
				return php_diagnosis;
			}
		}
	} 
	return null;
}

function getNumDiagnoses() {
	return php_diagnoses.length;
}

function getNumDiagnosesWithOption() {
	var cnt = 0;
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(php_diagnosis[3]) {
			cnt++;
		}
	}
	return cnt;
}

function getNumDiagnosesWithoutCategory() {
	var cnt = 0;
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(!php_diagnosis[2]) {
			cnt++;
		}
	}
	return cnt;
}

function getDiagnosis(option) {
	for (var i = 0; i < php_diagnoses.length; i++) {
		var php_diagnosis = php_diagnoses[i];
		if(option == php_diagnosis[3]) {
			return php_diagnosis;
		}
	}
	return null;
}

function treatmentLoad(consult_id, mode, consult_option) {
	var diagnosis_id = getURLParameter("diagnosis_id");
	var diagnosis_option = getURLParameter('diagnosis_option');
	var diagnosis_text = getURLParameter('diagnosis_text');

	$('#myTreatmentModal').modal('show');

	$("#treatment_delete_button").addClass("hidden");
	$("#treatment_save_button").addClass("hidden");

	if(diagnosis_id === null) {
		treatmentPageClick(consult_id, mode, 1, "", "", "");
	} else {
		if(diagnosis_id == -1) {
			diagnosis_id = "";
		}
		if(diagnosis_option === null) {
			diagnosis_option = "";
		}
		if(diagnosis_text === null) {
			diagnosis_text = "";
		}
		treatmentPageClick(consult_id, mode, 2, diagnosis_id, diagnosis_option, diagnosis_text);

	}
}

function treatmentPageClick(consult_id, mode, page, diagnosis_id, option, diagnosis_text) {
	var temp_consult_id = '\'' + consult_id + '\'';
	$("#treatment_delete_button").addClass("hidden");
	$("#treatment_save_button").addClass("hidden");

	$("#treatment_list").empty();
	$("#treatment_list").removeClass("hidden");
	$("#treatment_form_stuff").addClass("hidden");

	if(page == 1) {
		$("#treatmentPage1Link").addClass("hidden");
		$("#treatmentPage1P").removeClass("hidden");

		$("#treatmentPage2Link").addClass("hidden");
		$("#treatmentPage2P").addClass("hidden");

		$("#treatmentPage3P").addClass("hidden");

		//GENERAL TREATMENTS
		var element = '<li id="treatment_general_list" class="treatment_list_item list-group-item" onclick="treatmentPageClick(' + temp_consult_id + ', ' + mode + ', ' + '2' + ', \'\', \'\', \'\');">' + GENERAL_TREATMENTS;
		if(diagnosisHasTreatment("")) {
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
		}
		element += '</li>';
		$("#treatment_list").append(element);


		for(var i = 0; i < php_diagnoses.length; i++) {
			var diagnosis = php_diagnoses[i];
			var id = diagnosis[0];
			var option = diagnosis[3];
			var other = diagnosis[4];
			var text = other;
			if(!text) {
				text = DIAGNOSIS_MAPPING[option];
			} else {
				option = "\'\'";
			}
			
			var element = '<li class="treatment_list_item list-group-item" onclick="treatmentPageClick(' + temp_consult_id + ', ' + mode + ', ' + '2' + ', \'' + id + '\', ' + option + ', \'' + text + '\');">' + text;
			if(diagnosisHasTreatment(id)) {
				element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			}
			element += '</li>';
			$("#treatment_list").append(element);
		}
	} else if (page == 2) {
		$("#treatmentPage1Link").removeClass("hidden");
		$("#treatmentPage1P").addClass("hidden");

		$("#treatmentPage2Link").addClass("hidden");
		$("#treatmentPage2P").removeClass("hidden");

		$("#treatmentPage3P").addClass("hidden");

		if(diagnosis_text) {
			$("#treatmentPage2P").html(diagnosis_text);
		} else {
			$("#treatmentPage2P").html(GENERAL_TREATMENTS);
		}

		var treatment_options = php_general_treatments
		if(diagnosis_id) {
			if(option) {
				treatment_options = php_treatment_map[option];
			} else {
				treatment_options = {};
			}
		}  

		var diagnosis_id_arg = diagnosis_id;

		if(!option) {
			option = "\'\'";
		}

		for(var i = 0; i < treatment_options.length; i++) {
			var treatment_option = treatment_options[i];
			var treatment_text = TREATMENT_MAPPING[treatment_option];

			var treatment_id = "";
			if(optionHasTreatment(diagnosis_id_arg, treatment_option)) {
				console.log(diagnosis_id_arg + " : " + treatment_option);
				treatment_id = (getTreatment1(diagnosis_id_arg, treatment_option))[0];
			}
			var element = '<li class="treatment_list_item list-group-item" onclick="treatmentItemClick(' + temp_consult_id + ', ' + mode + ', \'' + diagnosis_id + '\', ' + option + ', \'' + diagnosis_text + '\', ' + treatment_option + ', \'' + treatment_id + '\');">' + treatment_text;
			if(treatment_id) {
				element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			}
			element += '</li>';
			$("#treatment_list").append(element);
		}

		//INSERT CUSTOM ONES
		var custom_treatments = getCustomTreatments(diagnosis_id_arg);
		for(var i = 0; i < custom_treatments.length; i++) {
			var custom_treatment = custom_treatments[i];
			var id = custom_treatment[0];
			var other = custom_treatment[3];
			var element = '<li class="treatment_list_item list-group-item" onclick="treatmentItemClick(' + temp_consult_id + ', ' + mode + ', \'' + diagnosis_id + '\', ' + option + ', \'' + diagnosis_text + '\', \'\', \'' + id + '\');">' + other;
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
			
			element += '</li>';
			$("#treatment_list").append(element);

		}




		var element = '<li class="treatment_list_item list-group-item" onclick="treatmentItemClick(' + temp_consult_id + ', ' + mode + ', \'' + diagnosis_id + '\', ' + option + ', \'' + diagnosis_text + '\', ' + '-1, \'\'' + ');">' + OTHER_TREATMENT;
		if(false) {
			element += '<img class="consult_task_completed" src="images/checkmark.png"/>';
		}
		element += '</li>';
		$("#treatment_list").append(element);
	}
}

function treatmentItemClick(consult_id, mode, diagnosis_id, option, diagnosis_text, treatment_option, treatment_id) {
	$("#treatmentPage1Link").removeClass("hidden");
	$("#treatmentPage1P").addClass("hidden");

	$("#treatmentPage2Link").removeClass("hidden");
	$("#treatmentPage2P").addClass("hidden");

	$("#treatmentPage3P").removeClass("hidden");

	if(diagnosis_text) {
		$("#treatmentPage2Link").html(diagnosis_text);
	} else {
		$("#treatmentPage2Link").html(GENERAL_TREATMENTS);
	}

	$("#treatmentPage2Link").attr("onclick","treatmentPageClick('"+consult_id+"', '"+mode+"', '2', '"+diagnosis_id+ "', '" + option + "', '" + diagnosis_text + "')");	

	if(treatment_option == -1 || !treatment_option) {
		$("#treatmentPage3P").html(OTHER_TREATMENT);
		$("#other_input_row").removeClass("hidden");
	} else {
		$("#treatmentPage3P").html(TREATMENT_MAPPING[treatment_option]);
		$("#other_input_row").addClass("hidden");
	}

	if(treatment_id) {
		//PRE-FILL
		$("#treatment_delete_button").removeClass("hidden");
		$("#treatment_delete_button").unbind();
		$("#treatment_delete_button").click(function() { 
			treatmentDeleteClick(consult_id, mode, diagnosis_id, option, diagnosis_text, treatment_option, treatment_id);
		});

		var treatment = getTreatment2(treatment_id);
		var other = treatment[3];
		var strength = treatment[4];
		var strength_units = treatment[5];
		var strength_units_other = treatment[6];
		var conc_part_one = treatment[7];
		var conc_part_one_units = treatment[8];
		var conc_part_one_units_other = treatment[9];
		var conc_part_two = treatment[10];
		var conc_part_two_units = treatment[11];
		var conc_part_two_units_other = treatment[12];
		var quantity = treatment[13];
		var quantity_units = treatment[14];
		var quantity_units_other = treatment[15];
		var route = treatment[16];
		var route_other = treatment[17];
		var prn = treatment[18];
		var dosage = treatment[19];
		var dosage_units = treatment[20];
		var dosage_units_other = treatment[21];
		var frequency = treatment[22];
		var frequency_other = treatment[23];
		var duration = treatment[24];
		var duration_units = treatment[25];
		var duration_units_other = treatment[26];
		var notes = treatment[27];
		var add_to_medication_history = treatment[28];


		if(other) {
			$("#other_input_row").removeClass("hidden");
			$("#information_input").val(other);
		}
		$("#strength_input").val(strength);
		if(strength_units_other) {
			$("#strength_select").val("other");
			$("#other_strength_units_input").removeClass("hidden");
			$("#other_strength_units_input").val(strength_units_other);
		} else {
			if(strength_units) {
				$("#strength_select").val(strength_units);
			} else {
				$("#strength_select").val("1");
			}
			$("#other_strength_units_input").addClass("hidden");
		}

		$("#concentration_part_one_input").val(conc_part_one);
		if(conc_part_one_units_other) {
			$("#concentration_part_one_select").val("other");
			$("#other_concentration_part_one_units_input").removeClass("hidden");
			$("#other_concentration_part_one_units_input").val(conc_part_one_units_other);
		} else {
			if(conc_part_one_units) {
				$("#concentration_part_one_select").val(conc_part_one_units);
			} else {
				$("#concentration_part_one_select").val("1");
			}
			$("#other_concentration_part_one_units_input").addClass("hidden");
		}

		$("#concentration_part_two_input").val(conc_part_two);
		if(conc_part_two_units_other) {
			$("#concentration_part_two_select").val("other");
			$("#other_concentration_part_two_units_input").removeClass("hidden");
			$("#other_concentration_part_two_units_input").val(conc_part_two_units_other);
		} else {
			if(conc_part_two_units) {
				$("#concentration_part_two_select").val(conc_part_two_units);
			} else {
				$("#concentration_part_two_select").val("1");
			}
			$("#other_concentration_part_two_units_input").addClass("hidden");
		}

		$("#quantity_input").val(quantity);
		if(quantity_units_other) {
			$("#quantity_select").val("other");
			$("#other_quantity_units_input").removeClass("hidden");
			$("#other_quantity_units_input").val(quantity_units_other);
		} else {
			if(quantity_units) {
				$("#quantity_select").val(quantity_units);
			} else {
				$("#quantity_select").val("1");
			}
			$("#other_quantity_units_input").addClass("hidden");
		}

		if(route_other) {
			$("#route_select").val("other");
			$("#other_route_input").removeClass("hidden");
			$("#other_route_input").val(route_other);
		} else {
			if(route) {
				$("#route_select").val(route);
			} else {
				$("#route_select").val("1");
			}
			$("#other_route_input").addClass("hidden");
		}

		$("#dosage_input").val(dosage);
		if(dosage_units_other) {
			$("#dosage_select").val("other");
			$("#other_dosage_units_input").removeClass("hidden");
			$("#other_dosage_units_input").val(dosage_units_other);
		} else {
			if(dosage_units) {
				$("#dosage_select").val(dosage_units);
			} else {
				$("#dosage_select").val("1");
			}
			$("#other_dosage_units_input").addClass("hidden");
		}

		if(prn) {
			if(isInt(prn)) {
				if(prn == '2') {
					$("input[name='when'][value='prn']").prop("checked", true);
				} else if (prn == '1') {
					$("input[name='when'][value='scheduled']").prop("checked", true);
				}
			}
		}

		if(frequency_other) {
			$("#frequency_select").val("other");
			$("#other_frequency_input").removeClass("hidden");
			$("#other_frequency_input").val(frequency_other);
		} else {
			if(frequency) {
				$("#frequency_select").val(frequency);
			} else {
				$("#frequency_select").val("1");
			}
			$("#other_frequency_input").addClass("hidden");
		}

		$("#duration_input").val(duration);
		if(duration_units_other) {
			$("#duration_select").val("other");
			$("#other_duration_units_input").removeClass("hidden");
			$("#other_duration_units_input").val(duration_units_other);
		} else {
			if(duration_units) {
				$("#duration_select").val(duration_units);
			} else {
				$("#duration_select").val("1");
			}
			$("#other_duration_units_input").addClass("hidden");
		}

		$("#notes_input").val(notes);

		if(add_to_medication_history) {
			if(isInt(add_to_medication_history)) {
				if(add_to_medication_history == '2') {
					$("input[name='add_to_medication_history'][value='2']").prop("checked", true);
				} else if (add_to_medication_history == '1') {
					$("input[name='add_to_medication_history'][value='1']").prop("checked", true);
				}
			}
		}
	} else {
		$("#treatment_delete_button").addClass("hidden");
	}

	$("#treatment_list").addClass("hidden");
	$("#treatment_form_stuff").removeClass("hidden");
	$("#treatment_save_button").removeClass("hidden");
	$("#treatment_save_button").unbind();
	$("#treatment_save_button").click(function() { 
		treatmentSaveClick(consult_id, mode, diagnosis_id, option, diagnosis_text, treatment_option, treatment_id);
	});
}

function treatmentDeleteClick(consult_id, mode, diagnosis_id, option, diagnosis_text, treatment_option, treatment_id) {
	var lang_text = getLang(1);
	window.location.href = "consult_active.php?delete=2&diagnosis_id=" + diagnosis_id + "&consult_id=" + consult_id + "&mode=" + mode + "&treatment_id=" + treatment_id + "&diagnosis_option=" + option + "&diagnosis_text=" + diagnosis_text + lang_text;

}

function diagnosisHasTreatment(diagnosis_id) {
	if(diagnosis_id) {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[1] == diagnosis_id) {
				return true;
			}
		}
	} else {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(!treatment[1]) {
				return true;
			}
		}
	}
	return false;
}

function optionHasTreatment(diagnosis_id, option) {
	if(diagnosis_id) {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[1] == diagnosis_id) {
				if(option && treatment[2] == option) {
					return true;
				} else if(!option && !treatment[2]) {
					return true;
				}
			}
		}
	} else {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(!treatment[1]) {
				if(option && treatment[2] == option) {
					return true;
				} else if(!option && !treatment[2]) {
					return true;
				}
			}
		}
	}
	return false;
}

function diagnosisHasCustomTreatment(diagnosis_id) {
	if(diagnosis_id) {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[1] == diagnosis_id) {
				if(treatment[3]) {
					return true;
				}
			}
		}
	} else {
		for(var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(!treatment[1]) {
				if(treatment[3]) {
					return true;
				}
			}
		}
	}
	return false;
}

function getCustomTreatments(diagnosis_id) {
	var arr = [];
	if(diagnosis_id) {
		for (var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[3] && treatment[1] == diagnosis_id) {
				arr.push(treatment);
			}
		}
	} else {
		for (var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[3] && !treatment[1]) {
				arr.push(treatment);
			}
		}
	} 
	return arr;
}

function getTreatment1(diagnosis_id, option) {
	if(diagnosis_id) {
		for (var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[1] == diagnosis_id && treatment[2] == option) {
				return treatment;
			}
		}
	} else {
		for (var i = 0; i < php_treatments.length; i++) {
			var treatment = php_treatments[i];
			if(treatment[2] == option && !treatment[1]) {
				return treatment;
			}
		}
	} 
	return null;
}

function getTreatment2(treatment_id) {
	for (var i = 0; i < php_treatments.length; i++) {
		var treatment = php_treatments[i];
		if(treatment[0] == treatment_id) {
			return treatment;
		}
	} 
	return null;
}

function treatmentSaveClick(consult_id, mode, diagnosis_id, option, diagnosis_text, treatment_option, treatment_id) {
	var valid_submission = true;

	var information = "";
	if (treatment_option == -1 || !treatment_option) {
		var information = $("#information_input").val();
		if(!information) {
			valid_submission = false;
			alert(TREATMENT_EMPTY_OTHER_MESSAGE);
		}
	}

	var strength = $("#strength_input").val();
	var strength_units = $("#strength_select").val();
	var strength_units_other = "";
	if(strength_units == "other") {
		strength_units = "";
		strength_units_other = $("#other_strength_units_input").val();
		if(!strength_units_other) {
			valid_submission = false;
			alert(TREATMENT_STRENGTH_UNITS_MESSAGE);
		}
	} 

	var conc_part_one = $("#concentration_part_one_input").val();
	var conc_part_one_units = $("#concentration_part_two_select").val();
	var conc_part_one_units_other = "";
	if(conc_part_one_units == "other") {
		conc_part_one_units = "";
		conc_part_one_units_other = $("#other_concentration_part_one_units_input").val();
		if(!conc_part_one_units_other) {
			valid_submission = false;
			alert(TREATMENT_CONC1_UNITS_MESSAGE);
		}
	} 

	var conc_part_two = $("#concentration_part_two_input").val();
	var conc_part_two_units = $("#concentration_part_two_select").val();
	var conc_part_two_units_other = "";
	if(conc_part_two_units == "other") {
		conc_part_two_units = "";
		conc_part_two_units_other = $("#other_concentration_part_two_units_input").val();
		if(!conc_part_two_units_other) {
			valid_submission = false;
			alert(TREATMENT_CONC2_UNITS_MESSAGE);
		}
	} 

	if((conc_part_one && !conc_part_two) || (!conc_part_one && conc_part_two)) {
		valid_submission = false;
		alert(TREATMENT_CONC_MESSAGE);
	}

	var quantity = $("#quantity_input").val();
	var quantity_units = $("#quantity_select").val();
	var quantity_units_other = "";
	if(quantity_units == "other") {
		quantity_units = "";
		quantity_units_other = $("#other_quantity_units_input").val();
		if(!quantity_units_other) {
			valid_submission = false;
			alert(TREATMENT_QUANTITY_UNITS_MESSAGE);
		}
	} 

	var route = $("#route_select").val();
	var route_other = "";
	if(route == "other") {
		route = "";
		route_other = $("#other_route_input").val();
		if(!route_other) {
			valid_submission = false;
			alert(TREATMENT_ROUTE_OTHER_MESSAGE);
		}
	}

	var prn = $("input[name=when]:checked").val();

	var dosage = $("#dosage_input").val();
	var dosage_units = $("#dosage_select").val();
	var dosage_units_other = "";
	if(dosage_units == "other") {
		dosage_units = "";
		dosage_units_other = $("#other_dosage_units_input").val();
		if(!dosage_units_other) {
			valid_submission = false;
			alert(TREATMENT_DOSAGE_UNITS_MESSAGE);
		} 
	} 

	var frequency = $("#frequency_select").val();
	var frequency_other = "";
	if(frequency == "other") {
		frequency = "";
		frequency_other = $("#other_frequency_input").val();
		if(!frequency_other) {
			valid_submission = false;
			alert(TREATMENT_FREQUENCY_OTHER_MESSAGE);
		}
	}

	var duration = $("#duration_input").val();
	var duration_units = $("#duration_select").val();
	var duration_units_other = "";
	if(duration_units == "other") {
		duration_units = "";
		duration_units_other = $("#other_duration_units_input").val();
		if(!duration_units_other) {
			valid_submission = false;
			alert(TREATMENT_DURATION_UNITS_MESSAGE);
		}
	} 

	//GET ALL VALUES
	var notes = $("#notes_input").val();

	var add_to_medication_history = $("input[name=add_to_medication_history]:checked").val();

	var extra_text = getLang(1);
	extra_text += "&other=" + information + "&strength=" + strength + "&strength_units=" + strength_units + "&strength_units_other=" + strength_units_other + "&conc_part_one=" + conc_part_one + "&conc_part_one_units=" + conc_part_one_units + "&conc_part_one_units_other=" + conc_part_one_units_other + "&conc_part_two=" + conc_part_two + "&conc_part_two_units=" + conc_part_two_units + "&conc_part_two_units_other=" + conc_part_two_units_other + "&quantity=" + quantity + "&quantity_units=" + quantity_units + "&quantity_units_other=" + quantity_units_other + "&route=" + route + "&route_other=" + route_other + "&prn=" + prn + "&dosage=" + dosage + "&dosage_units=" + dosage_units + "&dosage_units_other=" + dosage_units_other + "&frequency=" + frequency + "&frequency_other=" + frequency_other + "&duration=" + duration + "&duration_units=" + duration_units + "&duration_units_other=" + duration_units_other + "&notes=" + notes + "&add_to_medication_history=" + add_to_medication_history;

	if (valid_submission) {
		window.location.href = "consult_active.php?save=2&consult_id=" + consult_id + "&diagnosis_id=" + diagnosis_id + "&diagnosis_option=" + option + "&diagnosis_text=" + diagnosis_text + "&treatment_id=" + treatment_id + "&type=" + treatment_option + extra_text;
	} 
}

$("#strength_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_strength_units_input").removeClass("hidden");
	} else {
		$("#other_strength_units_input").addClass("hidden");
	}
});

$("#concentration_part_one_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_concentration_part_one_units_input").removeClass("hidden");
		$("#custom_span2").removeClass("hidden");
	} else {
		$("#other_concentration_part_one_units_input").addClass("hidden");
		$("#custom_span2").addClass("hidden");
	}
});

$("#concentration_part_two_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_concentration_part_two_units_input").removeClass("hidden");
	} else {
		$("#other_concentration_part_two_units_input").addClass("hidden");
	}
});

$("#quantity_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_quantity_units_input").removeClass("hidden");
	} else {
		$("#other_quantity_units_input").addClass("hidden");
	}
});

$("#route_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_route_input").removeClass("hidden");
	} else {
		$("#other_route_input").addClass("hidden");
	}
});

$("#dosage_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_dosage_units_input").removeClass("hidden");
	} else {
		$("#other_dosage_units_input").addClass("hidden");
	}
});

$("#frequency_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_frequency_input").removeClass("hidden");
	} else {
		$("#other_frequency_input").addClass("hidden");
	}
});

$("#duration_select").change(function() {
	var val = $(this).val();

	if (val == "other")  {
		$("#other_duration_units_input").removeClass("hidden");
	} else {
		$("#other_duration_units_input").addClass("hidden");
	}
});




