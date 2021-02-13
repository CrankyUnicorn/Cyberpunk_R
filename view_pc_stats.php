<?php include 'connection.php'; ?>

<?php

	$pc_stats	= array('intel', 'ref', 'dex', 'tech', 'cool', 'will', 'luck', 'luck_max', 'move', 'body', 'emp', 'emp_max', 'humanity', 'humanity_max','hp','hp_max','death_save');

	$keywordOne = "pc";
	$keywordTwo = "stats";

	$tableName = $keywordOne."_".$keywordTwo;
	$columnOneName = $keywordOne."_id";
	$columnTwoName = $keywordTwo."_id";

	$tableOneName = $keywordOne;
	$columnTableOneName = "id"; 

	$tableTwoName = $keywordTwo;
	$columnTableTwoName = "";
	
	//check if player character haves stats
	$sql = "SELECT * FROM $tableTwoName WHERE id IN
	(SELECT $columnTwoName FROM $tableName WHERE $columnOneName = '".$_SESSION['u_pc']."')";

	$stmt = mysqli_query( $connection, $sql);

	$pc_stat_rel = mysqli_fetch_assoc($stmt);

	if (!$pc_stat_rel) { //if player character doesn't have stats create them

		$names = join(",",$pc_stats);   

		$sql = "INSERT INTO stats ($names) VALUES ('6', '6', '6', '6', '6', '6', '6', '6', '6', '6', '6', '6', '60', '60','40','40','6')";
		

		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		//coorelate stats to pc by relational table pc_stats
		$last_id = mysqli_insert_id($connection);

		$sql = "INSERT INTO $tableName (pc_id, stats_id) VALUES ('".$_SESSION['u_pc']."', '".$last_id."')";

		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}
	}
	
	
	//get stats of the current player character
	$sql = "SELECT * FROM $tableTwoName WHERE id IN (SELECT $columnTwoName FROM $tableName WHERE pc_id = '".$_SESSION['u_pc']."')";

	$stmt = mysqli_query( $connection, $sql);
	
	if (!$stmt) {
		trigger_error(mysqli_error($connection));
		exit();
	}
	
	$pc_stat_value = mysqli_fetch_assoc($stmt);
	
	
	//calculate humanity and 
	$calculated_humanity = 10 * $pc_stat_value[$pc_stats[10]];
	$calculated_hp = 10 + ( 5 * ceil( ( $pc_stat_value[$pc_stats[5]] + $pc_stat_value[$pc_stats[8]] )/2 ));

	//update newly calculated values
	$sql = "UPDATE $tableTwoName SET $pc_stats[13] = $calculated_humanity , $pc_stats[15] = $calculated_hp WHERE id IN ( SELECT $columnTwoName FROM $tableName WHERE $columnOneName = '".$_SESSION['u_pc']."')";
	
	$stmt = mysqli_query( $connection, $sql);
	
	if (!$stmt) {
		trigger_error(mysqli_error($connection));
		exit();
	}


	//get again stats of the current player character
	$sql = "SELECT * FROM $tableTwoName WHERE id IN (SELECT $columnTwoName FROM $tableName WHERE pc_id = '".$_SESSION['u_pc']."')";

	$stmt = mysqli_query( $connection, $sql);
	
	if (!$stmt) {
		trigger_error(mysqli_error($connection));
		exit();
	}
	
	$pc_stat_value = mysqli_fetch_assoc($stmt);
	
?>


	<form action="" method="post" id="stats_form">
	<div class="pc_stats_panel">


		<?php 
			//go over all the stats and print the ones that may be printable
			$arrey_lenght = count($pc_stats);
			for( $i=0; $i< $arrey_lenght; $i++ ){ 
				
				$display = 'display:none;';
				$max_value = 20;
				
				if($pc_stats[$i]!='luck_max' && $pc_stats[$i]!='emp_max' && $pc_stats[$i]!='humanity_max'&& $pc_stats[$i]!='hp_max'){
				
					if($pc_stats[$i]=='luck' || $pc_stats[$i]=='emp' || $pc_stats[$i]=='humanity' || $pc_stats[$i]=='hp' ){
				
						$display = 'display:block;';
						$max_stat_value = $pc_stat_value[$pc_stats[$i+1]];
						$max_stat_name = $pc_stats[$i+1];
					}else{
						$max_stat_value = 20; //max value of a normal stat 
						$max_stat_name = $pc_stats[$i]."_max";
					}

					//changes the lenght of the stats block humanity and hp
					$style='';
					if ($pc_stats[$i]=='humanity' || $pc_stats[$i]=='hp') {
						$style='width: 175px';
						
					
					}

					echo "
					<div class='pc_stats_block' style='".$style."'>
						<div class='pc_stats_block_header'>".$pc_stats[$i]."</div>
					
						<div style='margin-top: 4px;'>

							<div style='height:16px; width:auto; ".$display."'>
							<label class='pc_stats_block_label'>|</label><input oninput='oninput_max_value(`".$max_stat_name."`)' onblur='onblur_max_value(`".$max_stat_name."`)' class='pc_stats_block_value_max' id='".$max_stat_name."_value' name='".$max_stat_name."_value' value='".$max_stat_value."'>
							</div>

							<div style='height:auto; width:auto;'>
						<input oninput='oninput_value(`".$pc_stats[$i]."`)' onblur='onblur_value(`".$pc_stats[$i]."`)' class='pc_stats_block_value' id='".$pc_stats[$i]."_value' name='".$pc_stats[$i]."_value' value='".$pc_stat_value[$pc_stats[$i]]."'>
						</div>
					
					</div>
				
					<div onclick='up_value(`".$pc_stats[$i]."`)' class='pc_stats_corner_up'></div>
					
					<div onclick='down_value(`".$pc_stats[$i]."`)' class='pc_stats_corner_down'></div>
				
				</div>
				";}
			}
		?>
		
	</div>
</form>
	
<?php
?>