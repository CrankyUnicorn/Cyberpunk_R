<?php

session_start();

$filePath = "page_pc.php";
$filePathTarget = "page_pc_sheet.php"; 
$fileName = "pc";
$tableName = $fileName; 
$columnOneName = "id";
$columnTwoName = "active";
$tableNameTwo = "user_pc";
$columnOneNameTwo = "user_id";
$columnTwoNameTwo = "pc_id";


	if(isset($_POST['delete'])){

		include_once 'connection.php';
		include_once 'input_cleaner.php';
		
		$selectedCharacter = ms_escape_string($_POST["pc_selected"]);
		
		if(empty($selectedCharacter)){
			header("Location: ".$filePath."?".$fileName."=pc_empty");
			exit();
		}else{
			
			if(strlen($selectedCharacter)>11){
				header("Location: ".$filePath."?".$fileName."=pc_overflow");
				exit();
			}else{
				
				if(!preg_match("/^[0-9]*$/",$selectedCharacter)){
					header("Location: ".$filePath."?".$fileName."=pc_invalid");
					exit();
				}else{
					
					//check for character by its id 
					$sql = "SELECT * FROM $tableName WHERE $columnOneName = '".$selectedCharacter."' AND $columnTwoName='1'";
					$stmt = mysqli_query( $connection, $sql);
					$stmtlen = mysqli_num_rows($stmt);
					
					if($stmtlen==0){
						
						header("Location: ".$filePath."?".$fileName."=no_match");
						exit();
					}else if($stmtlen>1){
						
							header("Location: ".$filePath."?".$fileName."=multi_match");
							exit();
					}else{
							
							//creates a character
							$sql = "UPDATE $tableName SET $columnTwoName=0 WHERE id='".$selectedCharacter."'";
							
							$stmt = mysqli_query( $connection, $sql);
							
							if (!$stmt) {
								trigger_error(mysqli_error($connection));
								exit();
							}
							
						header("Location: ".$filePath."?".$fileName." = pc_delete_success");
						exit();	
						
					}
				}
			}
		}

	}else if(isset($_POST['use'])){
		include_once 'connection.php';
		include_once 'input_cleaner.php';
		
		$selectedCharacter = ms_escape_string($_POST["pc_selected"]);
		
		if (!$selectedCharacter) {
			header("Location: ".$filePath."?".$fileName." = pc_use_fail");
			exit();		
		}

		$_SESSION['u_pc'] = $selectedCharacter;
		header("Location: ".$filePathTarget."?".$fileName." = pc_use_success");
		exit();	
	}
?>    