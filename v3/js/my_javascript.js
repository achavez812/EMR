
window.onload = function () {
	$("#navigation_header_span").css('width', window.innerWidth - 80);
}

$(window).resize(function() {
  	$("#navigation_header_span").css('width', window.innerWidth - 80);
});

$(function (){
	$('#navigation_header_menu').click(function(e) {
	  e.stopPropagation();
	  if($("#mySidenav").width() == 0) {
	  	document.getElementById("mySidenav").style.width = "200px";
	  } else{
	  	closeNav();
	  }
	});
})

/* Set the width of the side navigation to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

function getLang(secondary_arg) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		if (secondary_arg) {
			extra_text = "&";
		} else {
			extra_text = "?";
		}
		extra_text += "lang=" + lang;
	}
	return extra_text;
}

function formLang(lang, secondary_arg) {
	var extra_text = "";
	if(lang) {
		if (secondary_arg) {
			extra_text = "&";
		} else {
			extra_text = "?";
		}
		extra_text += "lang=" + lang;
	}
	return extra_text;
}

function homeClick() {
	var lang_text = getLang();
	var mode = getURLParameter("mode");
	if(mode) {
		if(mode == 1) { //REGISTRY/BROWSE
			window.location.href = "browse_communities.php" + lang_text;
		} else if (mode == 2) { //TRIAGE/INTAKE
			window.location.href = "triage_intake_patients.php" + lang_text;
		} else if (mode == 3) { //DOCTOR CONSULT
			window.location.href = "medical_consult_patients.php" + lang_text;
		} else {
			window.location.href = "index.php" + lang_text;
		}
	} else {
		window.location.href = "index.php" + lang_text;
	}
}

function isInt(value) {
  var x;
  if (isNaN(value)) {
    return false;
  }
  x = parseFloat(value);
  return (x | 0) === x;
}

function replaceAll(str, find, replace) {
	return str.replace(new RegExp(find, 'g'), replace);
}

function getCurrentDateTime() {
	var current_date = new Date();
	var year = current_date.getFullYear();
	var month = current_date.getMonth() + 1;
	var day = current_date.getDate();

	var hour = current_date.getHours();
	var minute = current_date.getMinutes();
	var second = current_date.getSeconds();

	if(month < 10) {
		month = "0" + month;
	}
	if(day < 10) {
		day = "0" + day;
	}
	if(hour < 10) {
		hour = "0" + hour;
	}
	if(minute < 10) {
		minute = "0" + minute;
	}
	if(second < 10) {
		second = "0" + second;
	}

	return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
}

function getTimeDifferenceInSeconds(date1, date2) {
	var year1 = date1.substr(0, 4);
	var month1 = date1.substr(5, 2);
	var day1 = date1.substr(8, 2);
	var hour1 = date1.substr(11, 2);
	var minute1 = date1.substr(14, 2);
	var second1 = date1.substr(17, 2);

	var year2 = date2.substr(0, 4);
	var month2 = date2.substr(5, 2);
	var day2 = date2.substr(8, 2);
	var hour2 = date2.substr(11, 2);
	var minute2 = date2.substr(14, 2);
	var second2 = date2.substr(17, 2);

	var year_difference = parseInt(year2) - parseInt(year1);
	var month_difference = parseInt(month2) - parseInt(month1);
	var day_difference = parseInt(day2) - parseInt(day1);

	var hour_difference = parseInt(hour2) - parseInt(hour1);
	var minute_difference = parseInt(minute2) - parseInt(minute1);
	var second_difference = parseInt(second2) - parseInt(second1);

	var seconds_in_minute = 60;
	var minutes_in_hour = 60;
	var hours_in_day = 24;
	var days_in_month = 30;
	var months_in_year = 12;

	var seconds_in_hour = seconds_in_minute * minutes_in_hour;
	var seconds_in_day = seconds_in_hour * hours_in_day;
	var seconds_in_month = seconds_in_day * days_in_month;
	var seconds_in_year = seconds_in_month * months_in_year;

	return (year_difference * seconds_in_year) + (month_difference * seconds_in_month) + (day_difference * seconds_in_day) + (hour_difference * seconds_in_hour) + (minute_difference * seconds_in_minute) + second_difference;
}