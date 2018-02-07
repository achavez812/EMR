<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';

	if(isset($_GET['save'])) {

	}


?>

<script type="text/javascript">

</script>



<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo LANGUAGE_IDIOMA; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<a id="back_link" onclick="backClick();">Back to Main Page</a>
		</div>
	</div>

	<div class="row input_row">
		<div class="col-xs-12">
			<p class="input_label"><?php echo LANGUAGE_IDIOMA . ":"; ?></p>
			<form id="lang_radiogroup" class="input_field">
				<input type="radio" id="radio_lang_en" name="lang" value="en" <?php if($lang == "en") echo 'checked'; ?>><label for="radio_lang_en"><?php echo ENGLISH; ?></label>
				<input type="radio" id="radio_lang_es" name="lang" value="es" <?php if($lang == "es") echo 'checked'; ?>><label for="radio_lang_es"><?php echo SPANISH; ?></label>
			</form>
		</div>
	</div>

	

	<div id="button_row" class="row">
		<div id="button_col" class="col-xs-12">
			<button class="consult_button" type="button" onclick="saveClick();"><?php echo SAVE_CAPS; ?></button>
		</div>
	</div>
	

	


</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
}

function saveClick() {
	var lang = $("input[name=lang]:checked").val();
	if(lang) {
		window.location.href = "index.php?lang=" + lang;
	}
}



</script>

</html>


