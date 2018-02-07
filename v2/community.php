
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>


<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php
	$lang = "en";
	$constants_file = '../include/Constants_en.php';
	if(isset($_GET['lang'])) {
		$lang = $_GET['lang'];
		if($lang == "es") {
			$constants_file = '../include/Constants_es.php';
		}
	}
	require_once $constants_file;

	require_once '../include/DbOperation.php';
	require_once '../include/Constants.php';
	require_once '../include/Utilities.php';

	$db = new DbOperation();

	$community_id = $_GET['id'];

	$result = $db->getCommunityById($community_id);
	$community_name = $result['name'];

?>


<div class="container-fluid">

	<div class="row row1">
		<div class="col-xs-12">
			<h1><a href="index.php?lang=<?php echo $lang; ?>"><?php echo COMMUNITIES; ?></a>: <?php echo $community_name; ?></h1>
		</div>
	</div>

	<div class="row row2">

		<div id="search_input_col" class="col-xs-8">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>">
		</div>

		<div id="search_icon_col" class="col-xs-1">
			<img class="icon" src="../images/search.png" alt="Search" onclick="searchPatients();" height="30px" width="30px">
		</div>

		<div id="add_patient_col" class="col-xs-3">
			<img class="icon" src="../images/add_patient.png" alt="Add Patient" onclick="addPatient(<?php echo $community_id; ?>);" height="30px" width="30px">
		</div>

	</div>

	<div class="row row3">

		<div class="col-xs-12">

			<div class="list-group">
	
<?php	

	$cnt = 0;
	$result = $db->getPatientsInCommunity($community_id);
    while($row = $result->fetch_assoc()){
    	$cnt++;
    	$patient_id = $row['id'];
    	$patient_date_of_birth = $row['date_of_birth'];
    	$patient_age_string = Utilities::getCurrentAgeString($patient_date_of_birth, $lang);
    	$patient_name = $row['name'];

    	echo '<a class="list-group-item" onclick="patientClick(' . $patient_id . ');">';
    	echo '<p id="list_item1">' . $patient_name . '</p>';
    	echo '<p id="list_item2">' . AGE . ": " . $patient_age_string . '</p>';
    	echo "</a>";

    }
    if($cnt == 0) {
    	echo "<p class='content_p'>" . NO_PATIENTS_IN_COMMUNITY_MESSAGE . "</p>";
    }

    
?>
			</div>

		</div>

	</div>

</div>



<script type="text/javascript">

function patientClick(patient_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "profile.php?id=" + patient_id + extra_text;
}

function searchPatients() {
	var lang = getURLParameter("lang");
	var text = document.getElementById("search_input").value;
	if (text == "") {
		var alert_text = "EMPTY SEARCH";
		if(lang == "es") {
			alert_text = "Búsqueda Vacío";
		}  
		alert(alert_text);
	} else {
		var extra_text = "";
		if(lang) {
			extra_text = "&lang=" + lang;
		}
		window.location.href = "search.php?text=" + text + extra_text;
	}
}

function addPatient(community_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "add_patient.php?community_id=" + community_id + extra_text;
}

	

</script>
