<!DOCTYPE html>
<html>


<?php
	require_once 'include/include.php';

	$current_import_dir = "";
	$current_export_dir = "";
	if(isset($_GET['importFile'])) {
		$import_file = $_GET['importFile'];
		$db->importData($import_file);
	} else if(isset($_GET['exportFile'])) {
		$export_file = $_GET['exportFile'];
		$db->exportData($export_file);
	} else if (isset($_GET['import'])) {
		$current_import_dir = $_GET['import'];
	} else if (isset($_GET['export'])) {
		$current_export_dir = $_GET['export'];
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
      	<?php
      	if($current_import_dir == BASE_IMPORT_EXPORT_DIRECTORY) {
      		$current_import_dir = "";
      	}
      	if($current_import_dir) {
      		$last = strrpos($current_import_dir, "/");
      		$next_to_last = strrpos($current_import_dir, "/", $last - strlen($current_import_dir) - 1);
      		$back_dir = substr($current_import_dir, 0, $next_to_last + 1);
        ?>
        <div class="input_row">
          <a class="left_title4" onclick="importFileClick(<?php echo '\'' . $back_dir . '\', 2'; ?>);"><?php echo GO_BACK; ?></a>
        </div>
        <?php
    	}
        ?>
      	<div class="input_row">
      	<?php
      		if($current_import_dir) {
      			$relative_dir = substr($current_import_dir, strlen(BASE_IMPORT_EXPORT_DIRECTORY));
      	?>
      		<p class="left_title4"><?php echo CURRENT_DIRECTORY_FIELD . " " . $relative_dir; ?></p>

      	<?php
      		}
      	?>
        	<p class="left_title4"><?php echo SELECT_AN_IMPORT_FILE; ?></p>
        </div>
      	<ul id="import_list" class="list-group">
      	<?php
      		$import_directory_exists = false;
      		$base_directory = $current_import_dir ? $current_import_dir : BASE_IMPORT_EXPORT_DIRECTORY;
      		if(is_dir($base_directory)) {
      			$import_directory_exists = true;
	      		$filenames = scandir($base_directory);
	      		for($i = 2; $i < sizeof($filenames); $i++) { //SKIPS OVER "." and ".."
	      			$filename = strval($filenames[$i]);
	      			$full_path = $base_directory . $filename;
	      			if(is_dir($full_path)) {
	      				$full_path .= '/';
	      				echo '<li class="list-group-item" onclick="importFileClick(\'' . $full_path . '\', 2);">' . $filename . '</li>';
	      			} else if ($current_import_dir && Utilities::endsWith($full_path, ".sql")) {
	      				echo '<li class="list-group-item" onclick="importFileClick(\'' . $full_path . '\', 1);">' . $filename . '</li>';
	      			}
	      		}
		    }
      	?>
      	</ul>
      	<?php
      		if(!$import_directory_exists) {
      	?>
      			<div class="input_row">
		        	<p id="no_import_directory_p" class="center_title4"><?php echo IMPORT_DIRECTORY_DOES_NOT_EXIST; ?></p>
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
      	<?php
      	if($current_export_dir == BASE_IMPORT_EXPORT_DIRECTORY) {
      		$current_export_dir = "";
      	}
      	if($current_export_dir) {
      		$last = strrpos($current_export_dir, "/");
      		$next_to_last = strrpos($current_export_dir, "/", $last - strlen($current_export_dir) - 1);
      		$back_dir = substr($current_export_dir, 0, $next_to_last + 1);
        ?>
        <div class="input_row">
          <a class="left_title4" onclick="exportDirClick(<?php echo '\'' . $back_dir . '\''; ?>);"><?php echo GO_BACK; ?></a>
        </div>
        <?php
    	}
      		if($current_export_dir) {
      			$relative_dir = substr($current_export_dir, strlen(BASE_IMPORT_EXPORT_DIRECTORY));
      	?>
      		<p class="left_title4"><?php echo CURRENT_DIRECTORY_FIELD . " " . $relative_dir; ?></p>

      	<?php
      		}
      		$export_directory_exists = false;
      		$inner_directories_exist = false;
      		$base_directory = $current_export_dir ? $current_export_dir : BASE_IMPORT_EXPORT_DIRECTORY;
      		$filenames = "";
      		if(is_dir($base_directory)) {
      			$export_directory_exists = true;
	      		$filenames = scandir($base_directory);
	      		for($i = 2; $i < sizeof($filenames); $i++) { //SKIPS OVER "." and ".."
	      			$filename = strval($filenames[$i]);
	      			$full_path = $base_directory . $filename;
	      			if(is_dir($full_path)) {
	      				$inner_directories_exist = true;
	      			}
	      		}
	      	}

	      	if($inner_directories_exist) {
	    ?>
	    	<div class="input_row">
	        	<p class="left_title4"><?php echo SELECT_EXPORT_DIRECTORY; ?></p>
	        </div>
	      	<ul id="export_list" class="list-group">
	    <?php
	      		for($i = 2; $i < sizeof($filenames); $i++) { //SKIPS OVER "." and ".."
	      			$filename = strval($filenames[$i]);
	      			$full_path = $base_directory . $filename;
	      			if(is_dir($full_path)) {
	      				$inner_directories_exist = true;
	      				$full_path .= '/';
	      				echo '<li class="list-group-item" onclick="exportDirClick(\'' . $full_path . '\');">' . $filename . '</li>';
	      			} 
	      		}
	      	}
      	?>
      	</ul>
      	<?php
      		if(!$export_directory_exists) {
      	?>
      			<div class="input_row">
		        	<p id="no_export_directory_p" class="center_title4"><?php echo EXPORT_DIRECTORY_DOES_NOT_EXIST; ?></p>
		        </div>
		<?php
      		} else if(!$inner_directories_exist) {
      	?>
      			<div class="input_row">
		        	<p id="no_inner_directories_p" class="center_title4"><?php echo NO_MORE_DIRECTORIES; ?></p>
		        </div>
		<?php
      		}

      	?>
      	<?php
      		if($current_export_dir) {
      	?>
	      	<div class="input_row">
	        	<p class="center_title4"><?php echo HIT_SAVE_TO_EXPORT_TO_THIS_DIRECTORY; ?></p>
	        	<p class="center_title4"><?php echo EXPORT_FILENAME_FIELD; ?></p>
	        	<p id="export_filename_p" class="center_title4"></p>
	        </div>
	     <?php
	 		}
	     ?>
	      </div>
	      <div class="modal-footer">
	        <button id="export_save_button" type="button" class="btn btn-default <?php if(!$current_export_dir) { echo 'hidden'; }?>"><?php echo SAVE_CAPS; ?></button>
	      </div>
	    </div>
    </div>
  </div>
</div>


<script>

if(getURLParameter("import")) {
	$("#importModal").modal("show");
}

if(getURLParameter("export")) {
	var currentdate = new Date();
	var current_date = currentdate.getFullYear() + "_" + (currentdate.getMonth()+1)  + "_" + currentdate.getDate() + "T" + currentdate.getHours() + "_"  + currentdate.getMinutes() + "_" + currentdate.getSeconds();

	var filename = current_date + ".sql";
	var full_path = getURLParameter("export") + filename;
	$("#export_filename_p").html(filename);
	$("#exportModal").modal("show");
	$("#export_save_button").click(function() {
		exportSubmit(full_path);
	});

}

function backClick() {
	var lang_text = getLang();
	window.location.href = "index.php" + lang_text;
}

function importClick() {
	$("#importModal").modal("show");
}

function importFileClick(full_path, is_dir) {
	if(is_dir == 2) {
		window.location.href = "import_export.php?import=" + full_path + getLang(1);
	} else {
		window.location.href = "import_export.php?importFile=" + full_path + getLang(1);
	}
}

function exportClick() {
	$("#exportModal").modal("show");
	/*
	var currentdate = new Date();
	var current_date = currentdate.getFullYear() + "_" + (currentdate.getMonth()+1)  + "_" + currentdate.getDate() + "T" + currentdate.getHours() + "_"  + currentdate.getMinutes() + "_" + currentdate.getSeconds();

	var filename = current_date + ".sql";

	$("#export_filename").html(filename);

	$("#export_submit_button").click(function() {
		exportSubmit(filename);
	});
	*/
}

function exportDirClick(full_path) {
	window.location.href = "import_export.php?export=" + full_path + getLang(1);
}

function exportSubmit($filename) {
	window.location.href = "import_export.php?exportFile=" + $filename + getLang(1);

}

</script>

</html>


