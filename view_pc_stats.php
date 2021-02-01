<?php include 'connection.php'; ?>

<?php

	$pc_stats	= array('intel', 'ref', 'dex', 'tech', 'cool', 'will', 'luck', 'luck_max', 'move', 'body', 'emp', 'emp_max', 'humanity', 'humanity_max');

	$keywordOne = "pc";
	$keywordTwo = "stats";

	$tableName = $keywordOne."_".$keywordTwo;
	$columnOneName = $keywordOne."_id";
	$columnTwoName = $keywordTwo."_id";

	$tableOneName = $keywordOne;
	$columnTableOneName = "id"; 

	$tableTwoName = $keywordTwo;
	$columnTableTwoName = "";
	

	$sql = "SELECT * FROM $tableTwoName WHERE id IN
	(SELECT $columnTwoName FROM $tableName WHERE $columnOneName = '".$_SESSION['u_pc']."')";

	$stmt = mysqli_query( $connection, $sql);

	$pc_stat_rel = mysqli_fetch_assoc($stmt);

	if (!$pc_stat_rel) {

		$names = join(",",$pc_stats);   

		$sql = "INSERT INTO stats ($names) VALUES ('10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10')";

		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}

		$last_id = mysqli_insert_id($connection);

		$sql = "INSERT INTO $tableName (pc_id, stats_id) VALUES ('".$_SESSION['u_pc']."', '".$last_id."')";

		$stmt = mysqli_query( $connection, $sql);
		
		if (!$stmt) {
			trigger_error(mysqli_error($connection));
			exit();
		}
	}
	
	$sql = "SELECT * FROM $tableTwoName WHERE id IN (SELECT stats_id FROM $tableName WHERE pc_id = '".$_SESSION['u_pc']."')";

	$stmt = mysqli_query( $connection, $sql);

	$pc_stat = mysqli_fetch_assoc($stmt);
		
	if (!$stmt) {
		trigger_error(mysqli_error($connection));
		exit();
	}

?>
	
	<form action="" method="$_POST" id="status_form">
	<div class="pc_stats_panel">

		<?php 
			$arrey_lenght = count($pc_stats);
			for( $i=0; $i< $arrey_lenght; $i++ ){ 
				$display = 'display:none;';
				$max_value = 20;
				if($pc_stats[$i]!='luck_max' && $pc_stats[$i]!='emp_max' && $pc_stats[$i]!='humanity' && $pc_stats[$i]!='humanity_max'){
					if($pc_stats[$i]=='luck' || $pc_stats[$i]=='emp' || $pc_stats[$i]=='humanity' ){
						$display = 'display:block;';
						$max_value = $pc_stat[$pc_stats[$i+1]];
					}
					echo "
					<div class='pc_stats_block'>
					<div class='pc_stats_block_header'>".$pc_stats[$i]."</div>
					<div style='margin-top: 4px;'>
					<div style='height:16px; width:auto; ".$display."'>
					<label class='pc_stats_block_label'>|</label><input oninput='oninput_value(`".$pc_stats[$i+1]."`)' onblur='onblur_value(`".$pc_stats[$i+1]."`)' class='pc_stats_block_value_max' id='".$pc_stats[$i]."_max_value' name='".$pc_stats[$i+1]."_max_value' value='".$max_value."'>
					</div>
					<div style='height:auto; width:auto;'>
					<input oninput='oninput_value(`".$pc_stats[$i]."`)' onblur='onblur_value(`".$pc_stats[$i]."`)' class='pc_stats_block_value' id='".$pc_stats[$i]."_value' name='".$pc_stats[$i]."_value' value='".$pc_stat[$pc_stats[$i]]."'>
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