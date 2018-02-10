<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';

	if(isset($_GET['importFile'])) {
		$import_file = $_GET['importFile'];
		$db->importData($import_file);
	} else if(isset($_GET['exportFile'])) {
		$export_file = EXPORT_DIRECTORY . $_GET['exportFile'];
		$db->exportData($export_file);
	}

?>




<div id="content" class="container-fluid">
	<div id="navigation_header_row" class="row">
		<div id="navigation_header_col" class="col-xs-12">
			<img id="navigation_header_image" onclick="homeClick();" src="images/home_white.png" alt="Home" height="28px" width="28px">
			<span id="navigation_header_span"><?php echo IMPORT_EXPORT_DATA; ?></span>
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

<div id="importModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo IMPORT_DATA; ?></p>
      </div>
      <div class="modal-body">
      	<div class="input_row">
        	<p class="left_title4"><?php echo SELECT_AN_IMPORT_FILE; ?></p>
        </div>
      	<ul id="import_list" class="list-group">
      	<?php
      		$import_directory_exists = false;
      		$match_found = false;
      		if(file_exists(IMPORT_DIRECTORY)) {
      			$import_directory_exists = true;
	      		$filenames = scandir(IMPORT_DIRECTORY);
	      		for($i = 0; $i < sizeof($filenames); $i++) {
	      			$filename = strval($filenames[$i]);  
	      			if(Utilities::endsWith($filename, ".sql")) {
	      				$match_found = true;
	      				$full_path = IMPORT_DIRECTORY . $filename;
	      				echo '<li class="list-group-item" onclick="importFileClick(\'' . $full_path . '\');">' . $filename . '</li>';
	      			}
	      		}
		    }
      	?>
      	</ul>
      	<?php
      		if(!$import_directory_exists) {
      	?>
      			<div class="input_row">
		        	<p class="center_title4"><?php echo IMPORT_DIRECTORY_DOES_NOT_EXIST; ?></p>
		        </div>
		<?php
      		} else if (!$match_found) {
      	?>
      			<div class="input_row">
		        	<p class="center_title4"><?php echo NO_VALID_FILES_IN_IMPORT_DIRECTORY; ?></p>
		        </div>
      	<?php
      		}
      	?>

      </div>
    </div>
  </div>
</div>

<div id="exportModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button id="modal_close_button" type="button" class="close" data-dismiss="modal">&times;</button>
        <p id="modal_header" class="center_title"><?php echo EXPORT_DATA; ?></p>
      </div>
      <div class="modal-body">
      	<div class="input_row">
        	<p class="left_title4"><?php echo EXPORT_FILENAME_FIELD; ?></p>
        	<p id='export_filename' class='modal_input_field'></p>
        </div>
      </div>
      <div class="modal-footer">
        <button id="export_submit_button" type="button" class="btn btn-default"><?php echo SUBMIT; ?></button>
      </div>
    </div>
  </div>
</div>


<script>

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
}

function importClick() {
	$("#importModal").modal("show");
}

function importFileClick(full_path) {
	window.location.href = "import_export.php?importFile=" + full_path + getLang(1);
}

function exportClick() {
	$("#exportModal").modal("show");
	var currentdate = new Date();
	var current_date = currentdate.getFullYear() + "_" + (currentdate.getMonth()+1)  + "_" + currentdate.getDate() + "T" + currentdate.getHours() + "_"  + currentdate.getMinutes() + "_" + currentdate.getSeconds();

	var filename = current_date + ".sql";

	$("#export_filename").html(filename);

	$("#export_submit_button").click(function() {
		exportSubmit(filename);
	});
}

function exportSubmit($filename) {
	window.location.href = "import_export.php?exportFile=" + $filename + getLang(1);

}

</script>

</html>


