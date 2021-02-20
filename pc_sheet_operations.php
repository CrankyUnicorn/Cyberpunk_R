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
	
		$pc = $_SESSION['u_pc'];


		//query for character name
		$sql = "SELECT pc.name 
		FROM pc 
		WHERE id = $pc";

		$stmt_pc_name = mysqli_query( $connection, $sql);

		if (!$stmt_pc_name) {
			trigger_error(mysqli_error($connection));
			exit();
		}


		//query for character stats
		$sql = "SELECT stats.name, pc_stats.value, pc_stats.max_value, stats.show_max
		FROM pc_stats
		LEFT JOIN stats ON pc_stats.stats_id = stats.id 
		WHERE pc_stats.pc_id = $pc";

		$stmt_stats = mysqli_query( $connection, $sql);
		
		if (!$stmt_stats) {
			trigger_error(mysqli_error($connection));
			exit();
		}


		//query for character skills
		$sql = "SELECT * 
		FROM 
		(SELECT pc_skill.value, skill.name, skill.category, skill.cost, skill.type 
		FROM pc_skill 
		LEFT JOIN skill 
		ON pc_skill.skill_id = skill.id 
		WHERE pc_skill.pc_id = $pc) t1 
		LEFT JOIN 
		(SELECT pc_stats.value AS stat_value, stats.name AS stat_name
		FROM pc_stats 
		LEFT JOIN stats 
		ON pc_stats.stats_id = stats.id 
		WHERE pc_stats.pc_id = $pc) t2 
		ON ( t1.type = t2.stat_name )";

		$stmt_skills = mysqli_query( $connection, $sql);
		
		if (!$stmt_skills) {
			trigger_error(mysqli_error($connection));
			exit();
		}
	

		$sql = "SELECT name FROM skill";

		$stmt_all_skills = mysqli_query( $connection, $sql);
		
		if (!$stmt_all_skills) {
			trigger_error(mysqli_error($connection));
			exit();
		}
	

		//echo json_encode($stmt);
		$rows = array();
		
		//STATS
		while ($result = mysqli_fetch_assoc($stmt_pc_name)) {
			$result['topic'] = 'character_name';
			$rows[] = $result;
		}

		while ($result = mysqli_fetch_assoc($stmt_stats)) {
			$result['topic'] = 'stats';
			$rows[] = $result;
		}	
		
		while ($result = mysqli_fetch_assoc($stmt_skills)) {
			$result['topic'] = 'skills';
			$rows[] = $result;
		}

		while ($result = mysqli_fetch_assoc($stmt_all_skills)) {
			$result['topic'] = 'all_skills';
			$rows[] = $result;
		}
		
		
		echo json_encode($rows);
		
		exit();

	}else if (isset($_POST['select'])) { //USE TO VIEW RELATIONAL TABLES
		
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

		//query for table
		$sql = "SELECT $tableTwo.name, $tableRelation.value, $tableRelation.max_value
		FROM $tableRelation
		LEFT JOIN $tableTwo ON $tableRelation.$secondId = $tableTwo.id 
		WHERE $tableRelation.$firstId = $tableOneId";

		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		//echo json_encode($stmt);
		$rows = array();
		
		//STATS
		while ($result = mysqli_fetch_assoc($stmt)) {
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
		$tableValue = $keywordFive == null ? 0 : $keywordFive;
	
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