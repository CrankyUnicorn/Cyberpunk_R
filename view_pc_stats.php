<?php include 'connection.php'; ?>

<?php

	$keywordOne = "pc";
	$keywordTwo = "pc";

	$tableName = $keywordOne."_".$keywordTwo;
	$columnOneName = $keywordOne."_id";
	$columnTwoName = $keywordTwo."_id";

	$tableOneName = $keywordOne;
	$columnTableOneName = "email"; 

	$tableTwoName = $keywordTwo;
	$columnTableTwoName = "";
	

	$sql = "SELECT * FROM $tableTwoName WHERE id IN
	(SELECT $columnTwoName FROM $tableName WHERE $columnOneName IN 
	(SELECT id FROM $tableOneName WHERE $columnTableOneName = '".$_SESSION["u_pc"]."'))";

	$stmt = mysqli_query( $connection, $sql);

?>
	
	<div class="pc_stats_panel">
		<form action="update_pc_status.php" method="$_POST" id="status_form	">

		<div class="pc_stats_block">
			<div class="pc_stats_block_header">DEX</div>
			<div style="margin-top: 4px;">
				<div style="height:16px; width:auto; display:none;">
					<label class="pc_stats_block_label">|</label><input class="pc_stats_block_value_max" id="dex_max_value" name="dex_max_value" value=
					<?php ?>>
				</div>
				<div style="height:auto; width:auto; ">
					<input class="pc_stats_block_value" id="dex_value" name="dex_value" value=
					<?php ?>>
				</div>
			</div>
			
			<div onclick="up_value('dex')" class='pc_stats_corner_up'></div>
			<div onclick="down_value('dex')" class='pc_stats_corner_down'></div>
		</div>

		</form>
	</div>
	
<?php
	/*if($stmt != false){
		
		while($row = mysqli_fetch_assoc($stmt)){
			if ($row['active'] == 0) {
				continue;
			}

			if($rowColorState===0){
				$rowColor = "pc_selectbox_oddColor";
				$rowColorState = 1;
			}else{
				$rowColor = "pc_selectbox_evenColor";
				$rowColorState = 0;
			}
			
			echo "<option class='".$rowColor." pc_selectbox_item' value='".$row['id']."'>".$row['name']."";
			
			if($row['description']){
				echo "- ".$row['description']."";

			}

			echo "</option>"; 
			
		}
	}	
	echo "</select>";
	
	mysqli_data_seek($stmt,0);
	if($stmt != false){
		echo "<form method='post' action='update_pc.php' id='pc_select' class='pc_form_register'>";
		
		echo "<input type='submit' value='Use' name='use' style='font-size:16px; font-weight:normal; float: right; padding:5px 10px 5px 10px;'>";
		echo "<input type='submit' value='Delete' name='delete' style='font-size:16px; font-weight:normal; float: right; margin-right:10px; padding:5px 10px 5px 10px;'>";

		echo "</form>";
	}		

	echo "</div>";
	*/
?>