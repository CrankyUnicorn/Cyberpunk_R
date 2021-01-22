<div class="pc_entrance_navbar">
  
  <div class="pc_navbar_left">
    
    <a href="#" style="background-color:var(--emagenta);border:none"></a>
    <a href="page_intro.php">Intro</a>
    <a href="page_codex.php">Codex</a>
    <a href="page_about.php">About</a>
    <a href="page_contact.php" style="border-right: 1px solid var(--emagenta)">Contact</a>
  </div>
  <div class="pc_navbar_right">
  
    <form action="login.php" method="POST">
					
			 <?php
			if(isset($_SESSION['u_name'])){
				echo 
             "<input type='submit' value='logout' name='logout' class='pc_submit_button'>";
				}else{
							
				echo
              "<input type='email' name='userEmail' id='pc_email' style='width:100px; margin-top: 10px'>
              <input type='password' name='userPassword' id='pc_password' style='width:100px; margin-top: 10px'>
              <input type='submit' value='Login' name='login' class='pc_submit_button'>";
			  
			}
			?>
					 
					 
		</form>

    <?php 

      if(isset($_SESSION['u_name'])){
        
        echo "<a  href='game_match.php'>".$_SESSION['u_name']."</a>";
      }else{

        echo "<a href='page_signin.php'><u>Sign In</u></a>";
      }
      
    ?>
  </div>

</div>