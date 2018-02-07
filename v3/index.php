<!DOCTYPE html>
<html onclick="closeNav();">


<?php
	require_once 'include/include.php';
	$db->close();

?>

<div id="mySidenav" class="sidenav">
  <a onclick="settingsClick();"><?php echo SETTINGS; ?></a>
  <a onclick="languageClick();"><?php echo LANGUAGE_IDIOMA; ?></a>
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
		var lang_text = getLang(0);
		window.location.href = "settings.php" + lang_text;
	}

	function languageClick() {
		var lang_text = getLang(0);
		window.location.href = "language.php" + lang_text;
	}

</script>

</html>


