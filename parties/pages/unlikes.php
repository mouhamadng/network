<?php
session_start();
include 'bdd.php';

if (!empty($_GET['id_p'])) {
  $stmt = $bdd->prepare("SELECT * FROM liked WHERE post_id=:post_id AND user_id=:user_id");
  $stmt->execute([
    'post_id' => $_GET['id_p'],
    'user_id' => $_SESSION['id']
  ]);
  $count =  $stmt->rowCount();
  if ($count > 0) {
    // SUPPRESSION DANS LA TABLE LIKED 
    $sqlstmt = $bdd->prepare("DELETE FROM liked WHERE post_id=:post_id AND user_id=:user_id");
    $sqlstmt->execute([
      'post_id' => $_GET['id_p'],
      'user_id' => $_SESSION['id']
    ]);
    // MISE À JOUR DU NOMBRE DE LIKE
    $update_like = $bdd->prepare("UPDATE post SET like_count = like_count - 1 WHERE id_p=:post_id");
    $update_like->execute([
      'post_id' => $_GET['id_p'],
    ]);
  }
  header('location: pagevieuw.php?user_id='.$_SESSION['id'].'#pagevieuw'.$_GET['id_p']);
  exit;
}
?>
