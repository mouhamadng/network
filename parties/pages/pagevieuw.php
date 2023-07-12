<?php
session_start();
include 'bdd.php';
include 'headers.php';
include 'footer.php';
include 'functions.php';
// if (!isset($_SESSION['id'])) {
//     header("location: sign.php");
//     exit();
// }

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
                            <h4 class="card-title text-center">Mon profil</h4>
                        </div>
                        <div class="card-body user-profile-card mb-3">
                            <?php if (isset($_SESSION['id'])) {


                            ?>
                                <img src="<?php echo '/network/parties/images/' . $_SESSION['photo']; ?>" alt="sas">
                                <h4 class="text-center h6 mt-2"><?= $_SESSION['nom_u'] ?? ''; ?></h4>
                            <?php } else { ?>
                                <img src="/network/parties/images/decon.png" alt="sas">
                                <h4 class="text-center h6 mt-2">Vous êtes deconnecté</h4>

                            <?php }  ?>
                            <p class="text-center small">UI/UX Designer</p>
                            <button class="btn btn-theme btn-sm">Suivre</button>
                            <button class="btn btn-theme btn-sm">Message</button>
                        </div>
                        <hr />
                        <div class="card-heading clearfix mt-3">
                            <h4 class="card-title text-center">Mes competances</h4>
                        </div>
                        <div class="card-body mb-3">
                            <a href="#" class="label label-success mb-2">HTML</a>
                            <a href="#" class="label label-success mb-2">CSS</a>
                            <a href="#" class="label label-success mb-2">Sass</a>
                            <a href="#" class="label label-success mb-2">Bootstrap</a>
                            <a href="#" class="label label-success mb-2">Javascript</a>
                            <a href="#" class="label label-success mb-2">Photoshop</a>
                            <a href="#" class="label label-success">UI</a>
                            <a href="#" class="label label-success">UX</a>
                        </div>
                        <hr />
                    </div>
                </div>
                <div class="col-lg-7 col-xl-6">
                    <div class="card card-white grid-margin">
                        <div class="card-body">
                            <div class="post">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <textarea class="form-control" placeholder="Post" rows="4" name="contenu"></textarea>

                                    <div class="input-group mt-2">
                                        <input class="form-control form-control-sm" id="formFileSm" type="file" name="image">
                                    </div>
                                    <div class="post-options">
                                        <a href="#"><i class="fa fa-camera"></i></a>
                                        <a href="#"><i class="fas fa-video"></i></a>
                                        <a href="#"><i class="fa fa-music"></i></a>
                                        <button class="btn btn-info  float-right" type="submit" name="post">Publier</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="profile-timeline">
                        <ul class="list-unstyled">
                            <?php
                            $sql = $bdd->prepare("SELECT p.id_p, p.contenu_p,p.image_p,p.date_p,p.like_count,u.nom_u,u.pseudo_u,u.image_u FROM post p INNER JOIN users u on p.user_id=u.id ");
                            $sql->execute();
                            $post = $sql->fetchAll(PDO::FETCH_OBJ);
                            ?>
                            <?php foreach ($post as $lines) : ?>
                                <li class="timeline-item ">

                                    <div class="card card-white grid-margin">
                                        <div class="card-body">
                                            <div class="timeline-item-header  id=pagevieuw<?= $lines->id_p; ?>">
                                                 
                                                <img src="<?php echo '/network/parties/images/' . $lines->image_u; ?>" alt="sas">

                                                <p><?= $lines->nom_u; ?></p>
                                                <small><?= $lines->date_p; ?></small>
                                            </div>
                                            <div class="timeline-item-post">

                                                <p> <?= $lines->contenu_p; ?></p>
                                                <div class="card mt-3">
                                                    <img src="<?php echo '/network/parties/images/' . $lines->image_p; ?>">
                                                </div>
                                                <div class="timeline-options">
                                                    <?php
                                                    if (isset($_SESSION['id'])) {

                                                        if (already_liked($lines->id_p)) :
                                                    ?>
                                                            <a href="unlikes.php?id_p=<?= $lines->id_p; ?>"><i class="fa fa-thumbs-up"></i> Je n'aime plus (<?= $lines->like_count; ?>) </a>
                                                        <?php else : ?>
                                                            <a href="likes.php?id_p=<?= $lines->id_p; ?>"><i class="fa fa-thumbs-up"></i> J'aime (<?= $lines->like_count; ?>)</a>
                                                    <?php
                                                        endif;
                                                    }
                                                    ?>

                                                    <?php
                                                    if (isset($_SESSION['id'])) {

                                                        if (already_liked($lines->id_p)) :
                                                    ?>
                                                            <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-comment"></i> Commenter (4)</a>

                                                        <?php else : ?>
                                                            <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-comment"></i> Commenter (4)</a>

                                                    <?php
                                                        endif;
                                                    }
                                                    ?>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="pagevieuw.php?id_p=<?php echo $lines->id_p; ?>" method="POST">
                                                                        <textarea class="form-control" placeholder="Commentaire" name="commentaire"></textarea>
                                                                        <!-- <input type="text" style=" display:none;" name="id_p" value="<?php echo $lines->id_p; ?>"> -->
                                                                        <div class="mt-2">
                                                                            <button class="btn btn-info float-right" type="submit" name="comment">Commenter</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (isset($_SESSION['id'])) {

                                                        if (already_liked($lines->id_p)) :
                                                    ?>
                                                            <a href="https://github.com/login"><i class="fa fa-share"></i> Partager (6)</a>

                                                        <?php else : ?>
                                                            <a href="https://github.com/login"><i class="fa fa-share"></i> Partager (6)</a>

                                                    <?php
                                                        endif;
                                                    }
                                                    ?>
                                                </div>
                                                <!-- AFFICHAGE DU COMMENTAIRE -->
                                                <!-- <?php
                                                        $req = $bdd->prepare("SELECT c.id_c, c.comment, p.contenu_p, p.image_p, u.nom_u, u.pseudo_u, u.image_u 
                                                        FROM comment c 
                                                        INNER JOIN post p ON c.post_id = p.id_p 
                                                        INNER JOIN users u ON c.user_id = u.id ");

                                                        $req->execute();
                                                        $stock = $req->fetchAll(PDO::FETCH_OBJ);
                                                        ?> -->

                                                <div class="timeline-comment">

                                                    <div class="timeline-comment-header">
                                                        <!-- <img src="<?php echo '/network/parties/images/' . $row->image_u; ?>" alt="" /> -->
                                                        <!-- <p><?= $row->nom_u ?? ''; ?></p> -->
                                                        <!-- <p class="timeline-comment-text"><?php echo $row->comment; ?></p> -->
                                                    </div>

                                                </div>

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
                <div class="col-lg-12 col-xl-3">
                    <div class="card card-white grid-margin">
                        <div class="card-heading clearfix">
                            <h4 class="card-title text-center">Suggestions</h4>
                        </div>
                        <div class="card-body">
                            <div class="team">
                                <div class="team-member">
                                    <div class="online on"></div>
                                    <img src="<?php echo '/network/parties/images/' . "profil.jpg"; ?>" alt="" />
                                </div>
                                <div class="team-member">
                                    <div class="online on"></div>
                                    <img src="<?php echo '/network/parties/images/' . "moi.jpg"; ?>" alt="" />
                                </div>
                                <div class="team-member">
                                    <div class="online off"></div>
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-white grid-margin">
                        <div class="card-heading clearfix">
                            <h3 class="card-title text-center" style="color:#016dcb;">A propos de Startus Network</h3>
                        </div>
                        <div class="card-body">
                            <section class="text-center" style="font-size: 16px;">"Startus" est un réseau social dynamique conçu pour favoriser la connectivité, l'interaction et le partage entre ses utilisateurs. Avec une interface conviviale et des fonctionnalités modernes,
                                Startus offre une plateforme polyvalente pour créer des liens, échanger des idées et découvrir de nouvelles opportunités.
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
        </div>
        <!-- end page main wrapper -->
        <div class="page-footer">
            <p class="text-center">Copyright © 2020 Evince All rights reserved.</p>
        </div>
    </div>
</div>


</body>

</html>