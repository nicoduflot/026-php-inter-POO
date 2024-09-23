<?php
require_once './vendor/autoload.php';
session_start();

use App\Compte;
use App\CompteCheque;
use App\CompteInteret;
use Utils\Tools;
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
            <article class="col-lg-8 offset-lg-2">
                <header>
                    <h2>Gestion d'un compte</h2>
                </header>
                <?php
                /* on vient du formulaire mod / supp */
                if(isset($_POST['uniqueid']) && $_POST['uniqueid'] !== ''){
                    $action = $_POST['action'];
                    $params = $_POST;
                    
                    unset($params['action']);
                    $compte = unserialize($_SESSION['compte']);

                    switch($action){
                        case 'mod' :
                                /* faire la modification */
                                /*  */
                                $compte->setDevise($_POST['devise']);
                                $compte->setNom($_POST['nom']);
                                $compte->setPrenom($_POST['prenom']);
                                $compte->setNumcompte($_POST['numcompte']);
                                $compte->setRib($_POST['rib']);
                                $compte->setIban($_POST['iban']);
                                $compte->setSolde(floatval($_POST['solde']));
                                $compte->setDecouvert(floatval($_POST['decouvert']));
                                if($compte->typeCompte() === 'CompteInteret'){
                                    $compte->setTaux(floatval($_POST['taux']));
                                }
                                $compte->modCompte();
                                $_SESSION['compte'] = serialize($compte);
                                ?>
                                <script>
                                    document.location.href = "./classesetpdo.php";
                                </script>
                                <?php
                                break;
                            case 'sup':
                                /* faire la suppression */
                                /*  */
                                $cardnumber = '';
                                if($compte->typeCompte() === 'CompteCheque'){
                                    $cardnumber = $compte->getCarte()->getNumcarte();
                                    $sqlCrt = '
                                    DELETE FROM `carte` where `carte`.`cardnumber` = :cardnumber ;
                                    ';
                                    $paramsCrt = [
                                        'cardnumber' => $cardnumber
                                    ];
                                }
                                $sql = '
                                DELETE FROM `compte` WHERE `compte`.`uniqueid` = :uniqueid
                                ';
                                Tools::modBdd($sql, $params);
                                unset($_SESSION['compte']);
                                if($cardnumber !== ''){
                                    Tools::modBdd($sqlCrt, $paramsCrt);
                                }
                                ?>
                                <script>
                                    document.location.href = "./classesetpdo.php";
                                </script>
                                <?php
                            break;
                        default :
                    }
    

                }

                /* on vient du lien "affichage du compte" */
                if( isset($_GET['action']) && isset($_GET['uniqueid']) && $_GET['uniqueid'] !== '' ){
                    switch($_GET['action']){
                        case 'show':
                            /* on récupère uniqueid */
                            $idcompte = $_GET['uniqueid'];
                            $sql = '
                            SELECT 
                                * 
                            FROM 
                                `compte` LEFT JOIN 
                                `carte` ON `compte`.`cardid` = `carte`.`id`
                            WHERE 
                                `uniqueid` = :uniqueid;
                            ';
                            $params = ['uniqueid' => $idcompte];
                            $request = Tools::modBdd($sql, $params);
                            $data = $request->fetch(PDO::FETCH_ASSOC);
                            switch($data['typecompte']){
                                case 'Compte': 
                                    $compte = new Compte(
                                        $data['nom'], $data['prenom'], 
                                        $data['numcompte'], $data['numagence'], 
                                        $data['rib'], $data['iban'], 
                                        $data['solde'], $data['decouvert'], 
                                        $data['devise'], $data['uniqueid']);
                                    break;
                                case 'CompteCheque':
                                    $compte = new CompteCheque(
                                        $data['nom'], $data['prenom'], 
                                        $data['numcompte'], $data['numagence'], 
                                        $data['rib'], $data['iban'], 
                                        $data['cardnumber'], $data['codepin'], 
                                        $data['solde'], $data['decouvert'], 
                                        $data['devise'], $data['uniqueid']);
                                    break;
                                case 'CompteInteret':
                                    $compte = new CompteInteret(
                                        $data['nom'], $data['prenom'], 
                                        $data['numcompte'], $data['numagence'], 
                                        $data['rib'], $data['iban'], 
                                        $data['solde'], $data['taux'], 
                                        $data['decouvert'], $data['devise'], 
                                        $data['uniqueid']);
                                    break;
                            }
                            $_SESSION['compte'] = serialize($compte);
                            ?>
                            <table class="table caption-top">
                                <caption><b><?php echo $data['typecompte'] ?></b></caption>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th colspan="2">Numéro de compte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $compte->getNom() ?></td>
                                        <td><?php echo $compte->getPrenom() ?></td>
                                        <td colspan="2"><?php echo $compte->getNumcompte() ?></td>
                                    </tr>
                                    <tr>
                                        <th>Numéro d'agence</th>
                                        <th>RIB</th>
                                        <th>IBAN</th>
                                        <th>Solde</th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $compte->getNumagence() ?></td>
                                        <td><?php echo $compte->getRib() ?></td>
                                        <td><?php echo $compte->getIban() ?></td>
                                        <td><?php echo $compte->getSolde() . ' ' . $compte->getDevise() ?></td>
                                    </tr>
                                    <?php
                                    switch($data['typecompte']){
                                        case 'CompteCheque':
                                        ?>
                                        <tr>
                                            <th colspan="2">Numéro de carte</th>
                                            <th colspan="2">Code Pin</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php echo $compte->getCarte()->getNumcarte() ?></td>
                                            <td colspan="2"><?php echo $compte->getCarte()->getCodepin() ?></td>
                                        </tr>
                                        <?php
                                        break;
                                        case 'CompteInteret':
                                        ?>
                                        <tr>
                                            <th>Taux d'intérêt</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $compte->getTaux() ?></td>
                                        </tr>
                                        <?php 
                                        break;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            break;
                        case 'edit':
                            $compte = unserialize($_SESSION['compte']);
                            ?>
                            <b><?php echo $compte->typeCompte() ?></b>
                            <form method="post" action="./gestionCompte.php">
                                <input type="hidden" name="uniqueid" id="uniqueid" value="<?php echo $_GET['uniqueid'] ?>" />
                                <input type="hidden" name="action" id="action" value="edit" />
                                <input type="hidden" name="devise" id="devise" value="<?php echo $compte->getDevise() ?>" />
                                <fieldset class="form-control my-2">
                                    <legend>
                                        Détenteur du compte
                                    </legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $compte->getNom() ?>" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="prenom">Prénom</label>
                                            <input type="text" class="form-control" name="prenom" id="nom" value="<?php echo $compte->getPrenom() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-control my-2">
                                    <legend>Agence</legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numagence">Numéro d'agence</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="numagence" id="numagence"  value="<?php echo $compte->getNumagence() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-control my-2">
                                    <legend>
                                        Détails du compte
                                    </legend>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="type">Type de compte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="type" id="type" value="<?php echo $compte->typeCompte() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcompte">Numéro de compte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="numcompte" id="numcompte" value="<?php echo $compte->getNumcompte() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="rib">RIB</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="text" name="rib" id="rib" value="<?php echo $compte->getRib() ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="iban">IBAN</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control my-2" type="iban" name="iban" id="type" value="<?php echo $compte->getIban() ?>" readonly />
                                        </div>
                                    </div>
                                    <?php
                                    if($compte->typeCompte() === 'CompteCheque'){
                                        ?>
                                        <div class="row my-2">
                                            <div class="col-lg-6">
                                                <label for="numcarte">Numéro de carte</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" readonly class="form-control" name="numcarte" id="numcarte"  value="<?php echo $compte->getCarte()->getNumCarte(); ?>" />
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-lg-6">
                                                <label for="codepin">Code secret</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" readonly class="form-control" name="codepin" id="codepin" value="<?php echo $compte->getCarte()->getCodepin(); ?>" />
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if($compte->typeCompte() === 'CompteInteret'){
                                        ?>
                                        <div class="row my-2">
                                            <div class="col-lg-6">
                                                <label for="taux">Taux d'intérêts</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-select" name="taux" id="taux">
                                                    <option>Choisir le taux d'intéret</option>
                                                    <option <?php echo ($compte->getTaux() === 0.015)? 'selected': '' ?> value="0.015">1.5%</option>
                                                    <option <?php echo ($compte->getTaux() === 0.03)?  'selected': '' ?> value="0.03">3%</option>
                                                    <option <?php echo ($compte->getTaux() === 0.05)?  'selected': '' ?> value="0.05">5%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="solde">Solde</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="solde" id="solde"   value="<?php echo $compte->getSolde() ?>" />
                                        </div>
                                    </div>
                                    <div class="row my-2<?php echo (($compte->typeCompte()) === 'CompteInteret')? ' d-none' : '' ; ?>">
                                        <div class="col-lg-6">
                                            <label for="decouvert">Découvert Autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="decouvert" id="decouvert" value="<?php echo $compte->getDecouvert() ?>" />
                                        </div>
                                    </div>
                                </fieldset>
                                <p>
                                    <button class="btn btn-outline-success btn-small" name="action" value="mod" type="submit">
                                        Valider les modifications
                                    </button>
                                    <button class="btn btn-outline-warning btn-small" type="reset">
                                        Valeurs par défaut
                                    </button>
                                    <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $_GET['uniqueid'] ?>"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
                                </p>
                            </form>
                            <?php
                            break;
                        case 'supp':
                            $compte = unserialize($_SESSION['compte']);
                            ?>
                            <form method="post" action="./gestionCompte.php">
                                <input type="hidden" name="uniqueid" id="uniqueid" value="<?php echo $_GET['uniqueid'] ?>" />
                                <input type="hidden" name="action" id="action" value="supp" />
                                <p>
                                    Valider la suppression du <b><?php echo $compte->typeCompte() ?></b> n° <b><?php echo $compte->getNumcompte() ?></b>
                                </p>
                                <p>
                                <button class="btn btn-outline-success btn-small" name="action" value="sup" type="submit">
                                        Valider la suppression
                                    </button>
                                    <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $_GET['uniqueid'] ?>"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
                                </p>
                            </form>
                            <?php
                            break;
                        default:
                    }
                    ?>
                    <p>
                        <a href="./classesetpdo.php" title="Retour à la liste des compte"><button class="btn btn-secondary btn-small"><i class="bi bi-list"></i></button></a>
                        <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $_GET['uniqueid'] ?>" title="Voir le compte"><button class="btn btn-success btn-small"><i class="bi bi-card-text"></i></button></a>
                        <a href="./gestionCompte.php?action=edit&uniqueid=<?php echo $_GET['uniqueid'] ?>" title="Éditer le compte"><button class="btn btn-secondary btn-small"><i class="bi bi-pencil-fill"></i></button></a>
                        <a href="./gestionCompte.php?action=supp&uniqueid=<?php echo $_GET['uniqueid'] ?>" title="Supprimer le compte"><button class="btn btn-danger btn-small"><i class="bi bi-trash-fill"></i></button></a>
                    </p>
            </article>
            <?php
            }
            ?>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>

</html>