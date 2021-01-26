<?php include 'htmldoc_start.php'; ?>

<?php

  $filePath = "edit_pc.php";
  $filePathBack = "page_pc.php";
  $fileName = "pc";
  $tableName = $fileName; 
  $columnOneName = "id";
  $columnTwoName = "active";

  include_once 'connection.php';
  include_once 'input_cleaner.php';
  
	if (!$_SESSION['u_pc']) {
    header("Location: ".$filePathBack."?".$filePath." = pc_use_fail");
    exit();		
  }
	
	//check for character by its id
	$sql = "SELECT * FROM $tableName WHERE $columnOneName = ".$_SESSION['u_pc']." AND $columnTwoName='1'";
	$stmt = mysqli_query( $connection, $sql);
  $stmtlen = mysqli_num_rows($stmt);
  
	if($stmtlen!=1){
    //header("Location: ".$filePathBack."?".$fileName."=no_match");
    //exit();
  }
  
  $stmtres = mysqli_fetch_assoc($stmt);

?>



<div class="pc_intro_div">
  
  <div class="pc_intro_panel">
    
    <?php 
      
      echo "<h3 style='text-align: center;'>".$stmtres['name']."</h3>";
    ?>

    <p class="pc_forms_text">Stats</p>
    
    <?php include "view_pc_stats.php"; ?>

 </div>
</div>

<?php include 'htmldoc_end.php'; ?>

