<?php include 'connection.php'; ?>

<?php

	$keywordOne = "pc";
	$keywordTwo = "skill";

	$tableName = $keywordOne."_".$keywordTwo;
	$columnOneName = $keywordOne."_id";
	$columnTwoName = $keywordTwo."_id";

	$tableOneName = $keywordOne;
	$columnTableOneName = "id"; 

	$tableTwoName = $keywordTwo;
	$columnTableTwoName = "";
	
	//get skills of the current player character
	$sql = "SELECT * FROM $tableTwoName WHERE id IN (SELECT $columnTwoName FROM $tableName WHERE $columnOneName = '".$_SESSION['u_pc']."')";

	$own_skills = mysqli_query( $connection, $sql);
	
	if (!$own_skills) {
		trigger_error(mysqli_error($connection));
		exit();
	}

?>
	
	<form action="update_pc_sheet.php" method="post" id="skills_form">
	<div class="pc_stats_panel">
		<div id="skills_panel" style="width:100%; margin:10px;">
			<!--skillstart-->

		<?php 
			//go over all the stats and print the ones that may be printable
			while( $skill = mysqli_fetch_assoc($own_skills) ){
				
				//get skills level of the current player character
				$sql = "SELECT * FROM $tableName WHERE pc_id = '".$_SESSION['u_pc']."'";

				$stmt = mysqli_query( $connection, $sql);
				$skill_level = mysqli_fetch_assoc($stmt);
				
				if (!$stmt) {
					trigger_error(mysqli_error($connection));
					exit();
				}

					echo "
					<div class='pc_stats_block pc_stats_block_long'>
						<div class='pc_stats_block_header'>".$skill['category']." - ".$skill['name']." (x".$skill['cost'].")</div>
					
						<div style='margin-top: 6px; height:auto; width:auto;'>
							<table style='width:100%;'>
								<tr>
									<td><label>Level: </label><input class='pc_stats_block_level' id='".$skill['name']."_level' name='".$skill['name']."_level' value='".$skill_level['level']."'></td>
									<td><label>Stat: </label><input class='pc_stats_block_level' id='".$skill['name']."_stat' name='".$skill['name']."_stat' value='".$pc_stat_value[strtolower($skill['type'])]."'></td>
									<td><label>Base: </label><input class='pc_stats_block_level' id='".$skill['name']."_base' name='".$skill['name']."_base' value='".(intval($skill_level['level']) + intval($pc_stat_value[strtolower($skill['type'])]))."'></td>
								
									</tr>
							</table>
					
						</div>
				
						<div onclick='up_value(`".$skill['name']."`)' class='pc_stats_corner_up'></div>
					
						<div onclick='down_value(`".$skill['name']."`)' class='pc_stats_corner_down'></div>
						
						</div>
						";
						
					}
					
				echo "
				</div>
				<!--skillend-->
				";
				
				//get skills of the current player character
				$sql = "SELECT * FROM $tableTwoName";

				$all_skills = mysqli_query( $connection, $sql);

				if (!$all_skills) {
					trigger_error(mysqli_error($connection));
					exit();
				}
				
				//select skills
				echo "
				
				<div style='margin:10px; width:100%;'>
				<select style='padding:5px; width:52%; height:30px;' margin:0px; name='skills' id='select_skills'>
				";

				while($select_skill = mysqli_fetch_assoc($all_skills)){
					echo "
					<option value='".$select_skill['name']."'>".$select_skill['name']."</option>
					";
				}
				
				echo "
				</select>
				
				<input type='button' onclick='drop(`skill`,`level`,getElementValue(`select_skills`),`1`); removeAllChildren();' style='padding:5px; width:23%; float:right; height:30px; margin:0;' value='Delete'>
				
				<input type='button' onclick='insert(`skill`,`level`,getElementValue(`select_skills`),`1`); removeAllChildren();' style='padding:5px; width:23%; float:right; height:30px; margin:margin:0px 10px 0px 0px;' value='Add'>
				";
				
				
			
		?>
	</div>
</form>
	
<?php
?>