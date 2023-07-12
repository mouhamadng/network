<?php 
 session_start();
  include 'bdd.php';
 if(isset($_SESSION['id']))
 {
    session_destroy();
    header("location: pagevieuw.php");
 }

?>