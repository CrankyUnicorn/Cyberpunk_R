<?php

session_start();

$filePath = "page_pc_stats.php";
$fileName = "stats";
$tableName = $fileName; 


if(isset($_POST)){

		include_once 'connection.php';
		include_once 'input_cleaner.php';
		
		$target_stat = ms_escape_string($_POST["target"]);
		$characterStat = ms_escape_string($_POST["$target_stat"]);
		
		if(empty($characterStat)){
			trigger_error(mysqli_error($connection));
			exit();
		}else{
			
			if(strlen($characterStat)>11){
				trigger_error(mysqli_error($connection));
				exit();
			}else{
				
				if(!preg_match("/^[0-9]*$/",$characterStat)){
					trigger_error(mysqli_error($connection));
					exit();
				}else{
					
					$sql = "UPDATE $tableName SET $target_stat = '".$characterStat."' WHERE id IN
					(SELECT stats_id FROM pc_stats WHERE pc_id = '".$_SESSION['u_pc']."')";

					$stmt = mysqli_query( $connection, $sql);
					
					
					if(!$stmt){
						trigger_error(mysqli_error($connection));
						exit();
					}
					
					exit();	
					
				}
			}
		}
	}
?>    