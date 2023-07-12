<?php

   try{
      $bdd = new PDO("mysql:host=localhost;dbname=startus","root","");
      //echo"connexion reussie";
   }catch(PDOException $e){
       die('Erreur :'.$e->getMessage());
   }

   ?>