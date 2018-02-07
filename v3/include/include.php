
<script type="text/javascript" src="js/jquery-3.2.1.min.js" ></script>
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<link rel="stylesheet" href="css/bootstrap.min.css">

<script type="text/javascript" src="js/my_javascript.js" ></script>
<link rel="stylesheet" href="css/my_style.css">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />



<?php
	
	$lang = "en";
	$lang_file = 'include/lang/lang_en.php';
	if(isset($_GET['lang'])) {
		$lang = $_GET['lang'];
		if($lang == "es") {
			$lang_file = 'include/lang/lang_es.php';
		}
	}
	require_once $lang_file;
	require_once 'include/Constants.php';
	require_once 'include/DbOperation.php';
	require_once 'include/Utilities.php';

	
	if($lang == "es") {
		echo '<script type="text/javascript" src="js/Constants_es.js"></script>';
	} else {
		echo '<script type="text/javascript" src="js/Constants_en.js"></script>';
	}

	$db = new DbOperation();

	$db->updateConsults();

?>