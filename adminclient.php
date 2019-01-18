<?php
include("header-admin.php");
include("fonctions.php");
?>

<?php

// Je définis les variables et les initialisent avec des valeurs vides
$identifiant = $mdp = $email = $mdp2 = "";
$identifiant_err = $mdp_err = $email_err = $mdp2_err = "";

// Execution du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $identifiant = $_POST['identifiant'];
    $email = $_POST['email'];
    $password = $_POST['mdp'];

    insererClient($prenom,
        $nom,
        $identifiant,
        $email,
        $password);
}
?>

<div class="ligne"></div>
<div class="site-section"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Administration du site <a href="" class="btn btn-success event-ajout">Ajouter un
                    client</a></h1>
            <h2 class="sub-header">Liste des utilisateurs</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Date de Création</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $users = bdd_user();
                    while ($user = $users->fetch()) {
                        ?>

                        <tr data-id="<?php echo $user['id']; ?>">
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['prenom']; ?></td>
                            <td><?php echo $user['nom']; ?></td>
                            <td><?php echo $user['identifiant']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['created_at']; ?></td>

                            <td>
                                <a href="" class="btn btn-warning event-edit">Edition</a><br><br>
                                <a href="" class="btn btn-danger event-delete">Supprimer</a>
                            </td>
                        </tr>

                    <?php }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal-edition" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Edition de Commentaire</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Modifier</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-ajout" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="modal-body">
                    <h2>Inscription
                        <small> : Made in World</small>
                    </h2>

                    <div class="row">
                        <div class="col-xs-12col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="prenom" id="prenom" class="form-control input-lg"
                                       placeholder="Prénom" tabindex="1">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="nom" id="nom" class="form-control input-lg" placeholder="Nom"
                                       tabindex="2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" name="identifiant" id="identifiant" class="form-control input-lg"
                               placeholder="Identifiant" tabindex="3">
                    </div>

                    <div class="form-group          ">
                        <input type="email" name="email" id="email" class="form-control input-lg"
                               placeholder="Adresse Email" tabindex="4">
                    </div>

                    <div class="form-group">
                        <input type="password" name="mdp" id="mdp" class="form-control input-lg"
                               placeholder="Mot de passe" tabindex="5">
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6"><input type="submit" value="S'inscrire"
                                                               class="btn btn-primary btn-block btn-lg" tabindex="6">
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-3.3.1.min.js"><\/script>')</script>
<script src="js/alertify.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('.event-ajout').on('click', function (e) {
            e.preventDefault();
            $('#modal-ajout').modal('show');
        });

        $('.event-edit').on('click', function (e) {
            e.preventDefault();
            $('#modal-edit').modal('show');
        });

        $('.event-delete').on('click', function (e) {
            e.preventDefault();

            var id = $(this).parents('tr').data('id');
            var tr = $(this).parents('tr');

            alertify.confirm('Confirmez-vous la suppression ?', 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', function () {
                    $.ajax({
                        method: "POST",
                        url: "supprimerClient.php",
                        data: {id_client: id},
                        dataType: 'json'
                    })
                        .done(function (result) {
                            console.log(result);
                            if (result.status) {
                                tr.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression");
                            }
                        });
                }
                , function () {
                });
        });

    });
</script>

<?php
include("footer.php");
?>
