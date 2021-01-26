<?php

session_start();

$filePath = "page_pc.php";
$filePathTarget = "page_pc.php"; 
$fileName = "pc";
$tableName = $fileName; 
$columnOneName = "name";
$columnTwoName = "active";
$tableNameTwo = "user_pc";
$columnOneNameTwo = "user_id";
$columnTwoNameTwo = "pc_id";


	if(isset($_POST['create'])){

		include_once 'connection.php';
		include_once 'input_cleaner.php';
			
		
		$characterName = ms_escape_string($_POST["characterName"]);

		if(empty($characterName)){
			header("Location: ".$filePath."?".$fileName."=pc_empty");
			exit();
		}else{

			if(strlen($characterName)>60){
				header("Location: ".$filePath."?".$fileName."=pc_overflow");
				exit();
			}else{

				if(!preg_match("/^[a-zA-Z0-9-._ ?!]*$/",$characterName)){
					header("Location: ".$filePath."?".$fileName."=pc_invalid");
				exit();
				}else{
					
						//check for already existing matches with same name
						$sql = "SELECT * FROM $tableName WHERE $columnOneName = '$characterName' AND $columnTwoName='1'";
						$stmt = mysqli_query( $connection, $sql);
						$stmtlen = mysqli_num_rows($stmt);
							
						if($stmtlen!=0){
							
							header("Location: ".$filePath."?".$fileName."=character_taken");
							exit();
						}else{

							//creates a character
							$sql = "INSERT INTO $tableName ($columnOneName, $columnTwoName) VALUES ('$characterName' , 1 )";
							
							$stmt = mysqli_query( $connection, $sql);
	
							if (!$stmt) {
								trigger_error(mysqli_error($connection));
								exit();
							}

							//character id
							$sql = "SELECT * FROM $tableName WHERE id = LAST_INSERT_ID()";
							$stmt = mysqli_query( $connection, $sql);
							
							if (!$stmt) {
								trigger_error(mysqli_error($connection));
								exit();
							}
						
							$characterId = mysqli_fetch_assoc($stmt);

							//associates the character to the player 
							$sql = "INSERT INTO $tableNameTwo ($columnOneNameTwo, $columnTwoNameTwo) VALUES ('".$_SESSION['u_id']."','".$characterId['id']."')";

							$stmt = mysqli_query( $connection, $sql);

							if (!$stmt) {
								trigger_error(mysqli_error($connection));
								exit();
							}
							
						}

						header("Location: ".$filePathTarget."?".$fileName." = pc_success");
						exit();	
					
				}
			}
		}
	}
?>    