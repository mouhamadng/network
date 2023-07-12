<?php
      include 'header.php';
      include 'bdd.php';
      
    if(isset($_POST['send_u']))
    {
                $erreur=0;
                //TESTE DU NOM
                if(!empty(trim($_POST['nom_u'])) && mb_strlen($_POST['nom_u'])>=2){
                    $nom_u=trim($_POST['nom_u']);
                }else{
                    $erreur_nom="Le nom doit est incorrect et doit avoir au minimum 2 caracteres";
                    $erreur++;
                }
                //TESTE DU PSEUDO
                if(!empty(trim($_POST['pseudo_u'])) && mb_strlen($_POST['pseudo_u'])>=2){
                    $pseudo_u=trim($_POST['pseudo_u']) ;
                }else{
                    $erreur_pseudo="Le Pseudo Trop court!";
                    $erreur++;
                }
                // TESTE DE L'EMAIL DU USER
                if (!empty(trim($_POST['email_u']))) {
                    if (preg_match("#^[a-z|A-Z]+[a-z1-9-]*@([a-z0-9-._]){2,}\.([a-zA-Z-._]){2,5}$#",strtolower(trim($_POST['email_u'])))) {
                        $email_u=strtolower(trim($_POST['email_u']));
                    }else{
                        $erreur_email="L'adresse mail est incorrect";
                        $erreur++;
                    }
            }
            if(!empty(trim($_POST['password_u']))  && mb_strlen($_POST['password_u'])<6){
                  if($_POST['password_u']==$_POST['rpassword_u'])
                  {
                    $password_u=$_POST['password_u'];
                  }else
                  {
                    $erreur_rpass="Les deux mot de passe ne concordent pas ";
                    $erreur++;
                  }
            }else{
                $erreur_pass="Le Mot de Passe  est Trop court!";
                $erreur++;
            }
            if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']))
            {
                  $photo=$_FILES['image']['name']; //Recuperation du name du champ photo
                  $dest=$_FILES['image']['tmp_name'];
                  $destination = "/network/parties/images/";
                  $dest_path = $_SERVER['DOCUMENT_ROOT'] . $destination; // Chemin absolu de destination
                  $dest_file = $dest_path . $photo;
                  
                  // Déplacement du fichier image téléchargé vers la destination
                  move_uploaded_file($dest, $dest_file);
                 
                 

            }
            

         if($erreur!=0)
          {
                require('registre.php');
        }   
           else
            {
                $users=$nom_u."  ".$pseudo_u."  ".$email_u."  ".$password_u."\n";
                if(file_exists("fileuser.txt"))
                {
                      $fichier=fopen('fileuser.txt','a');
                      fwrite($fichier,$users);
                      fclose($fichier);
                }else
                {
                    $fichier=fopen('fileuser.txt','a');
                      fclose($fichier);
                }
               
               $send=$bdd->prepare("INSERT INTO users(nom_u,pseudo_u,email_u,password_u,image_u) VALUES(:nom_u,:pseudo_u,:email_u,:password_u,:image_u)");
               $send->bindParam(':nom_u',$nom_u);
               $send->bindParam(':pseudo_u',$pseudo_u);
               $send->bindParam(':email_u',$email_u);
               $send->bindParam(':password_u',$password_u);
               $send->bindParam(':image_u',$photo);
                //J'EXCUTE LA REQUETTE
               $send->execute();
               header('location: sign.php');

            }
   }
            
    


    ?>