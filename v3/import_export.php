<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';

?>




<div id="content" class="container-fluid">

	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo SETTINGS; ?></span>
		</div>
		<div id="navigation_header_bottom_buffer"></div>		
	</div>

	<div id="link_row" class="row">
		<div class="col-xs-12">
			<a id="back_link" onclick="backClick();">Back to Main Page</a>
		</div>
	</div>

	<div class="row consult_row" >
		<div class="col-xs-12">
			<ul class="list-group">
				<li class="list-group-item" onclick="importClick();">
					<?php echo IMPORT_DATA; ?>
				</li>
				<li class="list-group-item" onclick="exportClick();">
					<?php echo EXPORT_DATA; ?>
				</li>
			</ul>
		</div>
	</div>
	


</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
}

function importClick() {

}

function exportClick() {

}

</script>

</html>


