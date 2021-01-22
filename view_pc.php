<?php include 'connection.php'; ?>

<?php

	$keywordOne = "user";
	$keywordTwo = "pc";

	$tableName = $keywordOne."_".$keywordTwo;
	$columnOneName = $keywordOne."_id";
	$columnTwoName = $keywordTwo."_id";

	$tableOneName = $keywordOne;
	$columnTableOneName = "email"; 

	$tableTwoName = $keywordTwo;
	$columnTableTwoName = "";
	
	$rowColorState = 0;
	$rowColor = "pc_evenColor";


	$sql = "SELECT * FROM $tableTwoName WHERE id IN
	(SELECT $columnTwoName FROM $tableName WHERE $columnOneName IN 
	(SELECT id FROM $tableOneName WHERE $columnTableOneName = '".$_SESSION["u_email"]."'))";

	$stmt = mysqli_query( $connection, $sql);

		
	echo "<br><div class='pc_intro_table'>";
	echo "<table class='pc_center pc_table'>";
	echo "<tr class=".$rowColor."><th>ID</th><th>Name</th><th>Description</th><th>Active</th></tr>";
	
	if($stmt != false){
		
		while($row = mysqli_fetch_assoc($stmt)){
					
			if($rowColorState===0){
				$rowColor = "pc_oddColor";
				$rowColorState = 1;
			}else{
				$rowColor = "pc_evenColor";
				$rowColorState = 0;
			}

			echo "<tr class='".$rowColor." pc_selected_match'>
			<td>".$row['id']."</td>
			<td><label for='".$row['id']."'>".$row['name']."</label></td>
			<td>".$row['description']."</td>
			<td>".$row['active']."</td>
			</tr>";

			
		}
	}	
	echo "</table>";
	

	mysqli_data_seek($stmt,0);
	if($stmt != false){
		echo	"<form action='page_use_pc.php' id='selector'>";
		while($row = mysqli_fetch_assoc($stmt)){

			echo "<input type='radio'style='visibility: hidden;' name='character_id' id='".$row['id']."' value='".$row['id']."'>";
			
		}
			echo "<input type='submit' value='Select' name='create' style='font-size:16px; font-weight:normal; float: right; padding:5px;'>";
			echo "</form>";
	}			

	echo "</div>";
	
?>