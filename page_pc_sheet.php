<?php include 'htmldoc_start.php'; ?>

<?php

  $filePathBack = "page_pc.php";

  include_once 'connection.php';
  include_once 'input_cleaner.php';
  
	if (!$_SESSION['u_pc']) {
    header("Location: ".$filePathBack."?".$filePath." = pc_use_fail");
    exit();		
  }

?>


<div class="pc_intro_div" id="sheet_page_div">

</div>

<?php include 'htmldoc_end.php'; ?>

