<!DOCTYPE html>
<html>

<?php
	require_once 'include/include.php';
	$no_communities = $db->isTableEmpty(TABLE_COMMUNITIES);
	if($no_communities) {
		$db->insertBaseCommunities();
	} 

	if(isset($_GET['show_alert'])) {
		$show_alert = $_GET['show_alert'];
		if($show_alert == 2) {
			echo '<script>';
			echo 'alert("' . HOME_SET_REGISTRY_BROWSE_MESSAGE . '")';
			echo '</script>';
		}
	}


?>


<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo COMMUNITIES; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<a id="back_link" onclick="backClick();"><?php echo BACK_TO_HOME_PAGE; ?></a>
		</div>
	</div>

	<div id="search_row" class="row">
		<div id="search_input_col" class="col-xs-8">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>">
		</div>
		<div id="search_icon_col" class="col-xs-1">
			<img class="icon" src="images/search.png" alt="Search" onclick="searchPatients();" height="28px" width="28px">
		</div>
		<div id="add_patient_col" class="col-xs-3">
			<img class="icon" src="images/add_patient.png" alt="Add Patient" onclick="addPatient();" height="28px" width="28px">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<ul class="list-group">
				<?php
					$communities = $db->getCommunities();
					$db->close();
					foreach($communities as $community) {
						$community_name = $community['name'];
						echo '<li class="list-group-item" onclick="communityClick(\'' . $community_name . '\');">' . $community_name . '</li>';
					}
				?>
			</ul>
		</div>
	</div>

</div>


<script>
	function backClick() {
		var lang_text = getLang();
		window.location.href = "index.php" + lang_text;
	}

	function communityClick(community_name) {
		var lang_text = getLang(1);
		window.location.href = "browse_patients.php?mode=1&community_name=" + community_name + lang_text;
	}

	function searchPatients() {
		var search_str = document.getElementById("search_input").value;
		if(search_str) {
			var lang_text = getLang(1);
			window.location.href = "search_patients.php?mode=1&search_str=" + search_str + lang_text;
		}
	}

	function addPatient() {
		var lang_text = getLang(1);
		window.location.href = "add_patient.php?mode=1" + lang_text;
	}
</script>

</html>


