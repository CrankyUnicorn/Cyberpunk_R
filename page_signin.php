<?php include 'htmldoc_start.php'; ?>


<div class="pc_intro_div">
  
  <div class="pc_intro_panel">
    
    <h3 style="text-align: center;">Sign In</h3>
    
    <p class="pc_forms_text">Create your account</p>
    
    <form action="insert_user.php" method="post" class="pc_registry pc_form_register">
      
      <div class="pc_form_line">
        <label for="pc_name">Nickname:&nbsp;&nbsp;</label>
        <input type="text" name='userName' id='pc_name'>
      </div>
      
      <div class="pc_form_line">
        <label for="pc_email_registry">Email&nbsp;Address:&nbsp;&nbsp;</label>
        <input type="email" name='userEmail' id='pc_email_registry'>
      </div>
      
      <div class="pc_form_line">
        <label for="pc_password_one">Password:&nbsp;&nbsp;</label>
        <input type="password" name='userPasswordOne' id='pc_password_one'>
      </div>

      <div class="pc_form_line">
        <label for="pc_password_two">Password:&nbsp;&nbsp;</label>
       <input type="password" name='userPasswordTwo' id='pc_password_two'>
      </div>
      
      <br><input type='submit' value='Sign In' name='sign_in' style="font-size:16px; font-weight:normal;">
    </form>
 </div>
</div>

<?php include 'htmldoc_end.php'; ?>