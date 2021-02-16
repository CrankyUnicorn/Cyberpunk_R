<?php include 'htmldoc_start.php'; ?>


<div class="pc_intro_div">
  
  <div class="pc_intro_panel">
    
    <h3 style="text-align: center;">User Characters</h3>
    
    <p class="pc_forms_text">Select your character</p>


    <?php include 'connection.php'; ?>

    <!--CHARACTER LIST-->
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
      
      echo "<select class='pc_center pc_selectbox' form='pc_select' name='pc_selected' size='5' multiple='multiple'>";
      
      //echo "<option value='none' selected disabled hidden>Select an Character</option>"; 
      
      if($stmt != false){
        
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
        echo "<form method='post' action='pc_operations.php' id='pc_select' class='pc_form_register'>";
        
        echo "<input type='submit' value='Use' name='use' style='font-size:16px; font-weight:normal; float: right; padding:5px 10px 5px 10px;'>";
        
        echo "<input type='submit' value='Delete' name='delete' style='font-size:16px; font-weight:normal; float: right; margin-right:10px; padding:5px 10px 5px 10px;'>";

        echo "</form>";
      }		

      echo "</div>";
      
    ?>

    <!--CREATE A CHARACTER-->
    <p class="pc_forms_text">Create a new character</p>
    <form action="insert_pc.php" method="post" class="pc_registry pc_form_register">
      
      <div class="pc_form_line">
        <label for="pc_name">Character&nbsp;Name:&nbsp;&nbsp;</label>
        <input type="text" name='characterName' id='pc_name' style="padding:5px;">
      </div>

      <input type='submit' value='Create' name='create' style="font-size:16px; font-weight:normal;">
    </form>
    
 </div>
</div>

<?php include 'htmldoc_end.php'; ?>