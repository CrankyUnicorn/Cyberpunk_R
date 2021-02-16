<?php
	
	include_once 'connection.php';
	include_once 'input_cleaner.php';
	

	if(session_id() == '' || !isset($_SESSION)) {
    //if session isn't started
    session_start();
	}
	

	function initialize($connection){//USED TO INITIALIZE THE STATS OF A PLAYER CHARACTER
		
		$keywordOne = "pc"; //player character

		$tableOne = $keywordOne;
		$tableOneId = $_SESSION['u_pc']; 
		
		//query the stats table to know all their ids to apply later on the character sheet
		$sql = "SELECT id FROM stats";
		
		$stats = mysqli_query($connection, $sql);
		
		if (!$stats) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		while ( $stat_id = mysqli_fetch_assoc($stats) ) {
		
			//relate all the stats one by one and set them to 6 further logic will be always in the view state
			$sql = "INSERT INTO pc_stats (pc_id, stats_id, value, max_value) VALUES ('".$tableOneId."','".$stat_id['id']."','6', '20')";
			
			$stmt = mysqli_query( $connection, $sql);
			
			if (!$stmt) {
				trigger_error(mysqli_error($connection));
				exit();
			}
		}

	}


	if (isset($_POST['initialize'])) { //USED TO INITIALIZE THE STATS OF A PLAYER CHARACTER
		
		initialize($connection);
	
		exit();
		
		
	}else if (isset($_POST['view'])) { //USE TO VIEW RELATIONAL TABLES
		
		$keywordOne = "pc"; //player character
		$keywordTwo = ms_escape_string($_POST["table"]);


		if(!preg_match("/^[a-zA-Z0-9_]*$/",$keywordTwo)){
			trigger_error("Error invalid character!");
			exit();
		}


		$tableRelation = $keywordOne."_".$keywordTwo;
		$firstId = $keywordOne."_id";
		$secondId = $keywordTwo."_id";
	
		$tableOne = $keywordOne;
		$tableOneId = $_SESSION['u_pc']; 
	
		$tableTwo = $keywordTwo;
		$tableTwoId = "";


		//query for character stats
		$sql = "SELECT n.name, $tableRelation.value, $tableRelation.max_value 
		FROM $tableRelation
		LEFT JOIN $tableTwo n ON $tableRelation.$secondId = n.id 
		WHERE $tableRelation.$firstId = $tableOneId";

		$sql = "SELECT $tableTwo.name, $tableRelation.value, $tableRelation.max_value 
		FROM $tableRelation
		LEFT JOIN $tableTwo ON $tableRelation.$secondId = $tableTwo.id 
		WHERE $tableRelation.$firstId = $tableOneId";

		$stmt_stats = mysqli_query( $connection, $sql);
		
		if (!$stmt_stats) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		
		//query for character stats
		$sql = "SELECT $tableOne.name AS 'character_name' 
						FROM $tableOne 
						WHERE id = $tableOneId";

		$stmt_pc_name = mysqli_query( $connection, $sql);

		if (!$stmt_pc_name) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		//echo json_encode($stmt);
		$rows = array();
		
		while ($result = mysqli_fetch_assoc($stmt_stats)) {
			$rows[] = $result;
		}

		while ($result = mysqli_fetch_assoc($stmt_pc_name)) {
			$rows[] = $result;
		}
		
		echo json_encode($rows);
		
		exit();


	}else if (isset($_POST['insert'])) { 	//FOR USE IN RELATIONAL TABLES

		$keywordOne = "pc"; //player character
		$keywordTwo = ms_escape_string($_POST["table"]);
		$keywordThree = ms_escape_string($_POST["column"]);
		$keywordFour = ms_escape_string($_POST["name"]);
		$keywordFive = ms_escape_string($_POST["value"]);

		
		if(!preg_match("/^[0-9]*$/",$keywordFive) ||
			!preg_match("/^[a-zA-Z0-9_]*$/",$keywordTwo) ||
			!preg_match("/^[a-zA-Z0-9_]*$/",$keywordThree) || 
			!preg_match("/^[a-zA-Z0-9_]*$/",$keywordFour)){
			trigger_error("Error invalid character!");
			exit();
		}


		$tableRelation = $keywordOne."_".$keywordTwo;
		$firstId = $keywordOne."_id";
		$secondId = $keywordTwo."_id";
		$tableColumn = $keywordThree;
		$tableValue = $keywordFive;
	
		$tableOne = $keywordOne;
		$tableOneId = $_SESSION['u_pc']; 
	
		$tableTwo = $keywordTwo;
		$tableTwoId = "";
		$tableTwoName =  $keywordFour;


		//query the id of the rows with given name
		$sql = "SELECT id FROM $tableTwo WHERE name = '".$tableTwoName."' ";
		
		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		$tableTwoId = mysqli_fetch_assoc($stmt);

		//insert a new relation row in a table
		$sql = "INSERT INTO $tableRelation ($firstId, $secondId, $tableColumn) VALUES ('".$tableOneId."','".$tableTwoId['id']."','".$tableValue."') ";
		
		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}
		
		exit();
	}else if (isset($_POST['update'])) { 	//FOR USE IN RELATIONAL TABLES

		$keywordOne = "pc"; //player character
		$keywordTwo = ms_escape_string($_POST["table"]);
		$keywordThree = ms_escape_string($_POST["column"]);
		$keywordFour = ms_escape_string($_POST["name"]);
		$keywordFive = ms_escape_string($_POST["value"]);


		if(!preg_match("/^[0-9]*$/",$keywordFive) ||
			 !preg_match("/^[a-zA-Z0-9_]*$/",$keywordTwo) || 
			 !preg_match("/^[a-zA-Z0-9_]*$/",$keywordThree) || 
			 !preg_match("/^[a-zA-Z0-9_]*$/",$keywordFour)){
			trigger_error("Error invalid character!");
			exit();
		}
		

		$tableRelation = $keywordOne."_".$keywordTwo;
		$firstId = $keywordOne."_id";
		$secondId = $keywordTwo."_id";
		$tableColumn = $keywordThree;
		$tableValue = $keywordFive;
	
		$tableOne = $keywordOne;
		$tableOneId = $_SESSION['u_pc']; 
	
		$tableTwo = $keywordTwo;
		$tableTwoId = "";
		$tableTwoName =  $keywordFour;


		//query the id of the rows with given name
		$sql = "SELECT id FROM $tableTwo WHERE name = '".$tableTwoName."' ";
		
		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		$tableTwoId = mysqli_fetch_assoc($stmt);

		//insert a new relation row in a table
		$sql = "UPDATE $tableRelation SET  $tableColumn = '".$tableValue."'  WHERE $secondId = '".$tableTwoId['id']."'  AND $firstId = '".$tableOneId."' ";
		
		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}
		
		exit();
	}

?>