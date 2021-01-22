<?php

session_start();

$filePath = "page_registry.php";
$filePathLogin = "page_pc.php"; 
$fileName = "user"; 
$tableName = $fileName;
$columnOneName = "name";
$columnTwoName = "email";
$columnThreeName = "password";
$columnFourName = "active";

if(isset($_POST['sign_in'])){

	include_once 'connection.php';
	include_once 'input_cleaner.php';
    
	$userName = ms_escape_string($_POST["userName"]);
	$userEmail = ms_escape_string($_POST["userEmail"]);
	$userPasswordOne = ms_escape_string($_POST["userPasswordOne"]);
	$userPasswordTwo = ms_escape_string($_POST["userPasswordTwo"]);

  if($userPasswordOne != $userPasswordTwo){
		header("Location: ".$filePath."?".$fileName."=signin_password_match");
		exit();
	}

  $userPassword = $userPasswordOne;

	if(empty($userEmail)||empty($userEmail)||empty($userPassword)){
		header("Location: ".$filePath."?".$fileName."=signin_empty");
		exit();
	}else{
		if(!preg_match("/^[a-zA-Z0-9-._ ?!]*$/",$userName)||!preg_match("/^[a-zA-Z0-9-._@]*$/",$userEmail)|| !preg_match("/^[a-zA-Z0-9-_?!.,*]*$/",$userPassword)){
			header("Location: ".$filePath."?".$fileName."=signin_invalid");
		exit();
		}else{
			
			$sql = "SELECT * FROM $tableName WHERE $columnOneName='$userEmail' AND $columnThreeName='1'";
		
			$stmt = mysqli_query( $connection, $sql);
			$stmtlen = mysqli_num_rows($stmt); 
				
			if($stmtlen!=0){
				//multiple active accounts with the same email reference
				header("Location: ".$filePath."?".$fileName."=signin_taken");
				exit();
			}else{

        $sql = "INSERT INTO $tableName ($columnOneName,$columnTwoName,$columnThreeName,$columnFourName) VALUES ('$userName','$userEmail','$userPassword',1)";
        
        $stmt = mysqli_query( $connection, $sql);

				if (!$stmt) {
					trigger_error(mysqli_error($connection));
					exit();
				}

        $sql = "SELECT * FROM $tableName WHERE $columnTwoName='$userEmail'";
        
        $stmt = mysqli_query( $connection, $sql);

        $row = mysqli_fetch_assoc($stmt);

        //session_unset();
        //session_destroy();

				$_SESSION['u_id'] = $row['id'];
				$_SESSION['u_name'] = $row['name'];
				$_SESSION['u_email'] = $row['email'];
        
        sleep(5);
        
        session_start();

				header("Location: ".$filePathLogin."?".$fileName."=signin_success");
				exit();	
			}
		}
	}
}
?>    