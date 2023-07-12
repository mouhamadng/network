<?php
   session_start();
    include 'header.php';
    include 'bdd.php';
if(isset($_POST['sign']))
{
    $erreur=0;
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
          $password_u=$_POST['password_u'];   
    }else{
      $erreur_pass="Le Mot de Passe  est Trop court!";
      $erreur++;
    }
    if($erreur!=0)
    {
            require('index.php');
    } 
    else
            {
               $sign=$bdd->prepare("SELECT *FROM  users WHERE email_u=:email_u");
               $sign->bindParam(':email_u',$email_u);
                //J'EXCUTE LA REQUETTE
               $sign->execute();
               $lines=$sign->fetch();
               if( $lines['email_u']==$email_u)
               {
                  //  echo" L'utilisateur est dans la base";
                   if($lines['password_u']==$password_u)
                   {

                    $pers=$email_u."  ".$password_u."\n";
                    if(file_exists("filepers.txt"))
                    {
                          $fichier=fopen('filepers.txt','a');
                          fwrite($fichier,$pers);
                          fclose($fichier);
                          $_SESSION['id']=$lines['id'];
                          $_SESSION['nom_u']=$lines['nom_u'];
                          $_SESSION['pseudo_u']=$lines['pseudo_u'];
                          $_SESSION['email_u']=$lines['email_u'];
                          $_SESSION['photo']=$lines['image_u'];
                        
                          header('location: pagevieuw.php');
                    }else
                    {
                        $fichier=fopen('filepers.txt','a');
                          fclose($fichier);
                    } 
                   }
               }
         }
      }

?>