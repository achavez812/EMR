
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