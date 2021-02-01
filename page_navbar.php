<div class="pc_entrance_navbar">
  
  <div class="pc_navbar_left">
    
    <div class="pc_nav_menu"></div>
    <a href="page_intro.php" class="pc_nav_button">Intro</a>
    <a href="page_codex.php" class="pc_nav_button">Codex</a>
    <a href="page_about.php" class="pc_nav_button">About</a>
    <a href="page_contact.php" class="pc_nav_button pc_last_nav_button">Contact</a>
  </div>
  <div class="pc_navbar_right">
  
    <form action="login.php" method="POST">
					
			 <?php
			if(isset($_SESSION['u_name'])){

        echo 
        "<input type='submit' value='Logout' name='logout' class='pc_submit_button' style='margin-top: 0px; width:auto;'>";
      }else{
							
				echo
        "<input type='email' name='userEmail' id='pc_email' placeholder=' e-mail'>
        <input type='password' name='userPassword' id='pc_password' placeholder='password'>
        <input type='submit' value='Login' name='login' class='pc_submit_button' style='margin-top: 0px; width:auto;'>";
			}
			?>
					 
		</form>

    <?php 

      if(isset($_SESSION['u_name'])){
        
        echo "<a href='page_pc.php'>".$_SESSION['u_name']."</a>";
      }else{

        echo "<a href='page_signin.php'><u>Sign In</u></a>";
      }
      
    ?>
  </div>

</div>