<?php
include 'likes.php';
include 'bdd.php';
include 'headers.php';
include 'footer.php';
include 'functions.php';
if (!isset($_SESSION['id'])) {
  header("location: sign.php");
  exit();
}

//Traitement de post
//  $chemin = dirname(__DIR__).DIRECTORY_SEPARATOR.'network'.DIRECTORY_SEPARATOR.'parties'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
if (isset($_POST['post'])) {
  if (!empty($_POST['contenu']) && (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']))) {
    $contenu = $_POST['contenu'];
    $photo = $_FILES['image']['name'];
    $image = $_FILES['image']['tmp_name'];
    $destination = "/network/parties/images/";
    $dest_path = $_SERVER['DOCUMENT_ROOT'] . $destination; // Chemin absolu de destination
    $dest_file = $dest_path . $photo;

    // Déplacement du fichier image téléchargé vers la destination
    move_uploaded_file($image, $dest_file);
    $id_u = $_SESSION['id'];
    //INSERTION DANS LA TABLE POST
    $post = $bdd->prepare("INSERT INTO post(contenu_p,image_p,user_id) VALUES(:contenu_p,:image_p,:user_id)");
    $post->bindParam(':contenu_p', $contenu);
    $post->bindParam(':image_p', $photo);
    $post->bindParam(':user_id', $id_u);
    //J'EXCUTE LA REQUETTE
    $post->execute();
  }
}
// TRAITEMENT DE LA TABLE COMMENTAIRE
if (isset($_POST['comment'])) {
  if (!empty($_POST['commentaire'])) {
    $comment = $_POST['commentaire'];
    $id_u = $_SESSION['id'];
    $id_p = $_GET['id_p'];
    // INSERTION DANS LA TABLE COMMENTAIRE
    $insertComment = $bdd->prepare("INSERT INTO comment(post_id, user_id, comment) VALUES(:post_id, :user_id, :comment)");
    $insertComment->bindParam(':post_id', $id_p);
    $insertComment->bindParam(':user_id', $id_u);
    $insertComment->bindParam(':comment', $comment);
    // J'EXÉCUTE LA REQUÊTE
    $insertComment->execute();
    // header("location: pagevieuw.php");
  }
}


?>
<!-- CORPS DE LA PAGE -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container">
  <div class="page-inner no-page-title">
    <!-- start page main wrapper -->
    <div id="main-wrapper">
      <div class="row">
        <div class="col-lg-5 col-xl-3">
          <div class="card card-white grid-margin">
            <div class="card-heading clearfix">
              <h4 class="card-title text-center">Mon Compte</h4>
            </div>
            <div class="card-body user-profile-card mb-3">
              <img src="<?php echo '/network/parties/images/' . $_SESSION['photo']; ?>" alt="sas">
              <h4 class="text-center h6 mt-2"><?= $_SESSION['nom_u'] ?? ''; ?></h4>

              <p class="text-center small">UI/UX Designer</p>
              <button class="btn btn-theme btn-sm">Follow</button>
              <button class="btn btn-theme btn-sm">Message</button>
            </div>
            <hr />

            <div class="card-heading clearfix mt-3">
              <h4 class="card-title">Informations Supplementaires</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-borderless mb-0 text-muted">
                  <tbody>
                    <tr>
                      <th scope="row">Pseudo: </th>
                      <td><?= $_SESSION['pseudo_u'] ?? ''; ?></td>
                    </tr>
                    <tr>
                      <th scope="row">Email:</th>
                      <td><?= $_SESSION['email_u'] ?? ''; ?></td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="profile-timeline col-lg-7 col-xl-6">
          <ul class="list-unstyled">
            <?php
            $id_u = $_SESSION['id'];
            $sql = $bdd->prepare("SELECT  p.id_p, p.contenu_p,p.image_p,u.nom_u,u.pseudo_u,p.like_count,u.image_u FROM post p INNER JOIN users u on p.user_id=u.id WHERE user_id=$id_u ");
            $sql->execute();
            $post = $sql->fetchAll(PDO::FETCH_OBJ);
            // var_dump($post);
            ?>
            <?php foreach ($post as $lines) : ?>
              <li class="timeline-item">

                <div class="card card-white grid-margin">
                  <div class="card-body">
                    <div class="timeline-item-header">

                      <img src="<?php echo '/network/parties/images/' . $lines->image_u; ?>" alt="sas">

                      <p><?= $lines->nom_u; ?></p>
                      <small>3 hours ago</small>
                    </div>
                    <div class="timeline-item-post">

                      <p> <?= $lines->contenu_p; ?></p>
                      <div class="card mt-3">
                        <img src="<?php echo '/network/parties/images/' . $lines->image_p; ?>">
                      </div>
                      <div class="timeline-options">
                        <?php
                        if (already_liked($lines->id_p)) : ?>
                          <a href="unlikes.php?id_p=<?= $lines->id_p; ?>"><i class="fa fa-thumbs-up"></i> Je n'aime plus (<?= $lines->like_count; ?>) </a>
                        <?php else : ?>
                          <a href="likes.php?id_p=<?= $lines->id_p; ?>"><i class="fa fa-thumbs-up"></i> J'aime (<?= $lines->like_count; ?>)</a>
                        <?php endif; ?>

                        <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-comment"></i> Commenter (4)</a>

                        <a href="#"><i class="fa fa-share"></i> Partager (6)</a>
                      </div>
                      <!-- AFFICHAGE DU COMMENTAIRE -->
                      <?php
                      $req = $bdd->prepare("SELECT  * FROM comment WHERE user_id=$id_u ");

                      $req->execute();
                      $stock = $req->fetchAll(PDO::FETCH_OBJ);
                      ?>
                      <?php foreach ($stock as $row) : ?>
                        <div class="timeline-comment">

                          <div class="timeline-comment-header">
                            <img src="<?php echo '/network/parties/images/' . $row->image_u; ?>" alt="" />
                            <p><?= $row->nom_u ?? ''; ?></p>
                            <p class="timeline-comment-text"><?php echo $row->comment; ?></p>
                          </div>

                        </div>
                      <?php endforeach ?>


                    </div>
                  </div>
                </div>
              </li>
            <?php
            endforeach
            ?>

          </ul>
        </div>
      </div>

      <!-- Row -->
    </div> -
    <!-- end page main wrapper -->
    <div class="page-footer">
      <p class="text-center">Copyright © 2020 Evince All rights reserved.</p>
    </div>
  </div>
</div>


</body>

</html>