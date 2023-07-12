<?php
if (!function_exists('already_liked')) {
  function already_liked($id_p) {
    global $bdd;
    $stmt = $bdd->prepare("SELECT * FROM liked WHERE post_id=:post_id AND user_id=:user_id");
    $stmt->execute([
      'post_id' => $id_p ,
      'user_id' => $_SESSION['id']
    ]);
    return (bool) $stmt->rowCount();
  }
}
?>
