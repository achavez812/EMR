
<script type="text/javascript" src="../js/jquery-3.2.1.min.js" ></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script type="text/javascript" src="../js/bootstrap.min.js" ></script>
<script type="text/javascript" src="../js/my_javascript.js" ></script>

<link rel="stylesheet" href="../css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />



<?php

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
	$db = new DbOperation();
	//$db->clearEverything();

?>

<div class="container-fluid">

	<div class="row row1">
		<div class="col-xs-12">
			<h1><?php echo COMMUNITIES; ?></h1>
		</div>
	</div>

	<div class="row row1">

		<div id="search_input_col" class="col-xs-8">
			<input id="search_input" type="text" placeholder="<?php echo SEARCH_PATIENTS; ?>">
		</div>

		<div id="search_icon_col" class="col-xs-1">
			<img class="icon" src="../images/search.png" alt="Search" onclick="searchPatients();" height="30px" width="30px">
		</div>

		<div id="add_patient_col" class="col-xs-3">
			<img class="icon" src="../images/add_patient.png" alt="Add Patient" onclick="addPatient();" height="30px" width="30px">
		</div>

	</div>

	<div class="row row3">

		<div class="col-xs-12">

			<ul class="list-group">
	
<?php	

	$result = $db->getAllCommunities();
    while($row = $result->fetch_assoc()){
    	$community_id = $row['id'];
    	$community_name = $row['name'];
    
    	echo '<li class="list-group-item" onclick="communityClick(' . $community_id . ');">' . $community_name . '</li>';
    }
    
?>
			</ul>

		</div>

	</div>
	<div id="language_row" class="row">
		<div class="col-xs-12">
			<span id="language_label">Language/Idioma: </span>
			<a class="language_link" onclick='languageClick("en");'>English</a>
			<a class="language_link" onclick='languageClick("es");'>Español</a>
		</div>
	</div>
</div>


<script type="text/javascript">

function languageClick(arg) {
	window.location.href = "index.php?lang=" + arg;
}

function communityClick(community_id) {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "&lang=" + lang;
	}
	window.location.href = "community.php?id=" + community_id + extra_text;
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

function addPatient() {
	var lang = getURLParameter("lang");
	var extra_text = "";
	if(lang) {
		extra_text = "?lang=" + lang;
	}
	window.location.href = "add_patient.php" + extra_text;
}
	

</script>

