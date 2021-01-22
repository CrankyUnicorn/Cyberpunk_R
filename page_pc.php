<?php include 'htmldoc_start.php'; ?>


<div class="pc_intro_div">
  
  <div class="pc_intro_panel">
    
    <h3 style="text-align: center;">User Characters</h3>
    
    <p class="pc_forms_text">Select your character</p>
    
    <?php include "view_pc.php"; ?>

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