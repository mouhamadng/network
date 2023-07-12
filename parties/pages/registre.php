    <?php include 'header.php';
	?>
    <section class="container-fluid forms">
        <div class="loginup ">
            <div class="header-content">
                 <form  method="POST"  action="traitementR.php" class="well" enctype="multipart/form-data">
                     <div class="field input-field <?php if (isset($erreur_nom)) echo "has-error has-feedback"; if(isset($nom_u)) echo " has-success has-feedback"; ?>">
                        <input <?php if(isset($nom_u)) echo ' value="'.htmlspecialchars($nom_u).'"';?> type="text" placeholder="Nom" class="input" name="nom_u">
                        <?php
					if(isset($erreur_nom)) {
						?>
						<i class="glyphicon glyphicon-remove form-control-feedback"></i>
						<span style="color:red;"><?php echo $erreur_nom; ?></span>
						<?php
					}
					if(isset($nom_u)) {
						?>
						<i class="glyphicon glyphicon-ok form-control-feedback"></i>
						<?php
					}
					?>
                </div>
                
                     <div class="field input-field <?php if(isset($erreur_pseudo)) echo " has-error has-feedback"; if(isset($pseudo_u)) echo " has-success has-feedback";?>">
                        <input <?php if(isset($pseudo_u)) echo' value="'.htmlspecialchars($pseudo_u).'"'?> type="text" placeholder="Pseudo" class="input" name="pseudo_u">
                        <?php
					if (isset($erreur_pseudo)) {
						?>
						<i class="glyphicon glyphicon-remove form-control-feedback"></i>
						<span style="color:red;"><?php echo $erreur_pseudo; ?></span>
						<?php
					}
					if (isset($pseudo_u)) {
						?>
						<i class="glyphicon glyphicon-ok form-control-feedback"></i>
						<?php
					}
					?> 
                     </div>
                     <div class="field input-field <?php if(isset($erreur_email)) echo" has-error has-feedback"; if(isset($email_u)) echo" has-success has-feedback";?>">
                        <input <?php if(isset($email_u)) echo' value="'.htmlspecialchars($email_u).'"'?> type="email" placeholder="Email" class="input" name="email_u">
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
                     <div class="field input-field  <?php if(isset($erreur_pass)) echo" has-error has-feedback"; if(isset($password_u)) echo" has-success has-feedback";?>"">
                        <input   <?php if(isset($password_u)) echo' value="'.htmlspecialchars($password_u).'"'?> type="password" placeholder="Password" class="password" name="password_u">
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
                     <div class="field input-field <?php if(isset($erreur_rpass)) echo" has-error has-feedback"; if(isset($rpassword_u)) echo" has-success has-feedback";?>"">
                        <input  <?php if(isset($rpassword_u)) echo' value="'.htmlspecialchars($rpassword_u).'"'?> type="password" placeholder="Confirm Your Password" class="password" name="rpassword_u">
                        <i class='bx bx-hide icon-hid'></i>
                        <?php
					if (isset($erreur_rpass)) {
						?>
						<i class="glyphicon glyphicon-remove form-control-feedback"></i>
						<span style="color:red;"><?php echo"$erreur_rpass";?></span>
						<?php
					}
					if (isset($rpassword_u)) {
						?>
						<i class="glyphicon glyphicon-ok form-control-feedback"></i>
						<?php
					}
					?>
                     </div>
					 <div class="mb-3">
						
						<input class="form-control form-control-sm" id="formFileSm" type="file" name="image">
						</div>
            
                     <div class="field input-field">
                         <button class="btn btn-info form-control btnclr " name="send_u" >Valider</button>
                     </div>
                     <div class="forgot">
                          <span>Avez-Vous déjà un compte? <a href="sign.php" class="link signup">Connexion</a></span>
						  
                      </div>
                 </form>
            </div>
            
        </div>

    </section>

    <script src="script.js"></script>

    
 