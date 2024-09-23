<?php
require './vendor/autoload.php';
use Utils\Tools;
$formMod = false;
$formSup = false;
$bdd = Tools::setBdd('localhost', '2024-05-27-php-avance');
if(isset($_GET['action']) && isset($_GET['idJV']) && $_GET['idJV'] && isset($_GET['idJV']) && $_GET['idJV'] !== ''){
    $idJV = ['id' => $_GET['idJV']];
    if($_GET['action'] !== ''){
        $sql = 'SELECT * FROM `jeux_video` WHERE ID = :id';
        $req = $bdd->prepare($sql);
        $req->execute($idJV);
        $jeuMod = $req->fetch(PDO::FETCH_ASSOC);

        /*Tools::prePrint($jeuMod);*/

        $nom = $jeuMod['nom'];
        $possesseur = $jeuMod['possesseur'];
        $console = $jeuMod['console'];
        $prix = $jeuMod['prix'];
        $nbre_joueurs_max = $jeuMod['nbre_joueurs_max'];
        $commentaires = $jeuMod['commentaires'];
        $id = $idJV['id'];

        if($_GET['action'] === 'mod'){
            $formMod = true;

        }
        if($_GET['action'] === 'sup'){
            $formSup = true;
        }
    }
}

/* cas modification action en bdd */

if(isset($_POST['modJeu']) && $_POST['modJeu'] === 'modJeu' ){
    $sql = 'UPDATE `jeux_video` '.
    'SET 
    `nom` = :nom,
    `possesseur` = :possesseur,
    `console` = :console,
    `prix` = :prix,
    `nbre_joueurs_max` = :nbre_joueurs_max,
    `commentaires` = :commentaires,
    `date_modif` = now()
    WHERE 
    ID = :ID;';
    $params = $_POST;
    unset($params['modJeu']);
    $req = $bdd->prepare($sql);
    $req->execute($params) or die(Tools::prePrint($bdd->errorInfo()));

    header('location: ./pdo.php');
}

if(isset($_POST['supJeu']) && $_POST['supJeu'] === 'supJeu' ){
    $sql = 'DELETE FROM `jeux_video` '.
    'WHERE 
    ID = :ID;';
    $params = $_POST;
    unset($params['supJeu']);
    $req = $bdd->prepare($sql);
    $req->execute($params) or die(Tools::prePrint($bdd->errorInfo()));

    header('location: ./pdo.php');
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation PHP Avancé - Accueil</title>
    <?php
    include './src/includes/headcalls.php';
    ?>
</head>
<body>
    <?php
    include './src/includes/header.php';
    ?>
    <?php
    include './src/includes/navigation.php';
    ?>
    <main class="container">
        <section class="row">
            <article class="col-lg-6 offset-lg-3">
                <header>
                    <h2>Gestion des jeux</h2>
                </header>
                <?php if($formMod){
                    ?>
                    <h3>Modifier le jeu <?php echo $nom ?></h3>
                    <form method="post" action="./actionJV.php">
                        <input type="hidden" name="ID" value="<?php echo $id ?>" />
                        <fieldset class="form-group my-2">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $nom ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="possesseur" class="form-label">Possesseur</label>
                            <input type="text" class="form-control" name="possesseur" id="possesseur" value="<?php echo $possesseur ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="console" class="form-label">COnsole</label>
                            <input type="text" class="form-control" name="console" id="console" value="<?php echo $console ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="text" class="form-control" name="prix" id="prix" value="<?php echo $prix ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="nbJmax" class="form-label">Nombre de joueurs max</label>
                            <input type="text" class="form-control" name="nbre_joueurs_max" id="nbre_joueurs_max" value="<?php echo $nbre_joueurs_max ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="commentaires" class="form-label">Commentaire</label>
                            <input type="text" class="form-control" name="commentaires" id="commentaires" value="<?php echo $commentaires ?>" />
                        </fieldset>
                        <p class="my-2">
                            <button class="btn btn-outline-primary" name="modJeu" type="submit" value="modJeu">Modifier le jeu</button>
                        </p>
                    </form>
                    <?php
                }
                if($formSup){
                    ?>
                    <h3>Modifier le jeu <?php echo $nom ?></h3>
                    <form method="post" action="./actionJV.php">
                        <input type="hidden" name="ID" value="<?php echo $id ?>" />
                        Êtes-vous sûr de vouloir supprimer le jeu suivant : <b><?php echo $nom ?></b> ?
                        <p class="my-2">
                            <button class="btn btn-outline-danger" name="supJeu" type="submit" value="supJeu">Supprimer le jeu</button>
                            <a href="./pdo.php"><button class="btn btn-outline-secondary" type="button">Annuler</button></a>
                        </p>
                    </form>
                    <?php
                }
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>