<?php

session_start();


if(isset($_POST)){

		include_once 'connection.php';
		include_once 'input_cleaner.php';

		$table = ms_escape_string($_POST["table"]);
		$name = ms_escape_string($_POST["name"]);
		$column = ms_escape_string($_POST["column"]);
		$value = ms_escape_string($_POST["value"]);
		
		$table_id = $table.'_id'; 
		$relation = 'pc_'.$table;

		if(empty($table) || empty($name) || empty($column) || empty($value)){
			trigger_error(mysqli_error($connection));
			exit();
		}else{
			
			if(strlen($value)>11){
				trigger_error(mysqli_error($connection));
				exit();
			}else{
				
				if(!preg_match("/^[0-9]*$/",$value)){
					trigger_error(mysqli_error($connection));
					exit();
				}else{

					//check if given table and table information exists to be coorelated
					$sql = "SELECT * FROM $table WHERE name = '".$name."'";

					$stmt = mysqli_query( $connection, $sql);
					
					if(!$stmt){
						trigger_error(mysqli_error($connection));
						exit();
					}
					
					$count = mysqli_num_rows($stmt);
					$id = mysqli_fetch_assoc($stmt)['id'];

					if($count!=1){
						trigger_error(mysqli_error($connection));
						exit();
					}

					//creates a relation and sets a value 
					$sql = "INSERT INTO $relation (pc_id, $table_id, $column)  VALUES ('".$_SESSION['u_pc']."', '".$id."' , '".$value."')";

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