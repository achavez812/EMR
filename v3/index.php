<!DOCTYPE html>
<html onclick="closeNav();">


<?php
	require_once 'include/include.php';
	if(isset($_GET['show_alert'])) {
		$show_alert = $_GET['show_alert'];
		if($show_alert == 2) {
			echo '<script>';
			echo 'alert("' . INVALID_LOGIN . '")';
			echo '</script>';
		}
	} else if(isset($_GET['settings'])) {
		if($db->usersExist()) {
			$username = $_GET['username'];
			$password = $_GET['password'];
			if($db->validateLogin($username, $password)) {
				$user_id = $db->getUserId($username, $password);
				header("LOCATION: settings.php?lang=" . $lang . "&user_id=" . $user_id);
			} else {
				header("LOCATION: index.php?lang=" . $lang . "&show_alert=2");
			}
		} else {
			header("LOCATION: settings.php?lang=" . $lang . "&show_alert=2");
		}
	} else if(isset($_GET['importExport'])) {
		if($db->usersExist()) {
			$username = $_GET['username'];
			$password = $_GET['password'];
			if($db->validateLogin($username, $password)) {
				header("LOCATION: import_export.php?lang=" . $lang);
			} else {
				header("LOCATION: index.php?lang=" . $lang . "&show_alert=2");
			}
		} else {
			header("LOCATION: settings.php?lang=" . $lang . "&show_alert=2");
		}
	} else if (isset($_GET['importDone'])) {
		echo '<script>';
		echo 'alert("' . IMPORT_DONE_MESSAGE . '")';
		echo '</script>';
	} else if (isset($_GET['exportDone'])) {
		echo '<script>';
		echo 'alert("' . EXPORT_DONE_MESSAGE . '")';
		echo '</script>';
	}

	$db->close();



?>

<div id="mySidenav" class="sidenav">
  <a onclick="languageClick();"><?php echo LANGUAGE_IDIOMA; ?></a>
  <a onclick="settingsClick();"><?php echo SETTINGS; ?></a>
  <a onclick="importExportClick();"><?php echo IMPORT_EXPORT_DATA; ?></a>
</div>

<div id="content" class="container-fluid" onclick="closeNav();">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo HOME; ?></span>
			<img id="navigation_header_menu" src="images/menu.png" alt="Menu" height="28px" width="28px">
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="index_content" class="row">
		<div class="col-xs-12">
			<ul class="list-group">
				<li class="list-group-item" onclick="registryClick();"><?php echo REGISTRY_BROWSE; ?></li>
				<li class="list-group-item" onclick="triageIntakeReadyClick();"><?php echo READY_FOR_TRIAGE_INTAKE; ?></li>
				<li class="list-group-item" onclick="medicalConsultReadyClick();"><?php echo READY_FOR_MEDICAL_CONSULT; ?></li>
				<li class="list-group-item" onclick="completedConsultTodayClick();"><?php echo COMPLETED_CONSULT_TODAY; ?></li>
			</ul>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo LOGIN; ?></p>
      </div>
      <div class="modal-body">
      	<div class="input_row">
        	<p class="left_title4"><?php echo USERNAME_FIELD; ?></p>
        	<input id='username_input' class='modal_input_field'>
        </div>
    	<div class="input_row">
    		<p class="left_title4"><?php echo PASSWORD_FIELD; ?></p>
    		<input id='password_input' class='modal_input_field' type='password'>
    	</div>
      </div>
      <div class="modal-footer">
        <button id="save_button" type="button" class="btn btn-default"><?php echo SUBMIT; ?></button>
      </div>
    </div>

  </div>
</div>




<script>

	function registryClick() {
		var lang_text = getLang(1);
		window.location.href = "browse_communities.php?show_alert=2" + lang_text;
	}

	function triageIntakeReadyClick() {
		var lang_text = getLang(1);
		window.location.href = "triage_intake_patients.php?show_alert=2" + lang_text;
	}

	function medicalConsultReadyClick() {
		var lang_text = getLang(1);
		window.location.href = "medical_consult_patients.php?show_alert=2" + lang_text;
	}

	function completedConsultTodayClick() {
		var lang_text = getLang(0);
		window.location.href = "completed_consults_today.php" + lang_text;
	}

	function settingsClick() {
		$("#myModal").modal("show");
		$("#username_input").val("");
		$("#password_input").val("");
		$("#save_button").click(function() {
			submitClick(1);
		});
	}

	function languageClick() {
		var lang_text = getLang(0);
		window.location.href = "language.php" + lang_text;
	}

	function importExportClick() {
		$("#myModal").modal("show");
		$("#username_input").val("");
		$("#password_input").val("");
		$("#save_button").click(function() {
			submitClick(2);
		});
	}

	function submitClick(arg) {
		var lang_text = getLang(1);
		var username = $("#username_input").val();
		var password = $("#password_input").val();
		if(arg == 1) {
			window.location.href = "index.php?settings=2&username=" + username + "&password=" + password + lang_text;
		} else if (arg == 2) {
			window.location.href = "index.php?importExport=2&username=" + username + "&password=" + password + lang_text;
		}		
	}

</script>

</html>


