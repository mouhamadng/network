    <?php 
          include 'header.php';
           
    ?>
    <section class="container-fluid forms">
        <div class="loginup ">
            <div class="header-content">
              <header>Startus_Social_Network</header>
                 <form action="traitementS.php" method="POST" class="well">
                     <div class="field input-field <?php if (isset($erreur_email)) echo "has-error has-feedback"; if(isset($email_u)) echo " has-success has-feedback"; ?>"">
                        <input <?php if(isset($email_u)) echo ' value="'.htmlspecialchars($email_u).'"';?> type="text" placeholder="Email" class="input" name="email_u">
                        <?php
					if (isset($erreur_email)) {
						?>
						<i class="glyphicon glyphicon-remove form-control-feedback"></i>
						<span style="color:red;"><?php echo"$erreur_email";?></span>
						<?php
					}
					if (isset($email_u)) {
						?>
						<i class="glyphicon glyphicon-ok form-control-feedback"></i>
						<?php
					}
					?>
                     </div>
                     <div class="field input-field  <?php if (isset($erreur_pass)) echo "has-error has-feedback"; if(isset($password_u)) echo " has-success has-feedback"; ?>"">
                        <input  <?php if(isset($password_u)) echo' value="'.htmlspecialchars($password_u).'"'?> type="password" placeholder="Password" class="password" name="password_u">
                        <i class='bx bx-hide icon-hid'></i>
                        <?php
					if (isset($erreur_pass)) {
						?>
						<i class="glyphicon glyphicon-remove form-control-feedback"></i>
						<span style="color:red;"><?php echo"$erreur_pass";?></span>
						<?php
					}
					if (isset($password_u)) {
						?>
						<i class="glyphicon glyphicon-ok form-control-feedback"></i>
						<?php
					}
					?>
                     </div>
                      <div class="forgot">
                        <a href="" class="forgot-pass">Mot de pass oublié?</a>
                      </div>
                     <div class="field input-field">
                         <button class="btn btn-info form-control btnclr " name="sign" >Se Connecter</button>
                     </div>
                     <div class="forgot">
                          <span>Avez-Vous déjà un compte? <a href="registre.php" class="link signup" class="link signup">S'inscrire</a></span>
                      </div>
                 </form>
            </div>
            <div class="trait">
                 
            </div>
            <div class="media-options">
                     <a href="" class="field apple btn btn-info">
                     <i class='bx bxl-apple apple-icon'></i>
                     <span>Connexion avec icloud</span>
                     </a>
             </div>
             
        </div>

    </section>

    <script src="script.js"></script>

    
 