<?php
require_once './vendor/autoload.php';

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
                    <h2>Création d'un compte</h2>
                </header>
                <?php
                if (isset($_POST['type'])) {
                    /* traitement des enregistrement de comptes */
                    $typecompte = $_POST['type'];
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $date = new DateTimeImmutable();
                    $numcompte = $date->format('Y-m-d') . '-' . time();
                    $numagence = $_POST['numagence'];
                    $rib = 'RIB - '. $numagence . ' - ' . $numcompte;
                    $iban = 'IBAN - '.$numagence . ' - ' . $numcompte . ' FR';
                    $solde = $_POST['solde'];
                    $decouvert = $_POST['decouvert'];
                    $devise = '€';
                    switch($typecompte){
                        case 'Compte':
                            $compte = new Compte($nom, $prenom, $numcompte, $numagence, $rib, $iban, $solde, $decouvert, $devise);
                            break;
                        case 'CompteCheque':
                            $compte = new CompteCheque($nom, $prenom, $numcompte, $numagence, $rib, $iban, $_POST['numcarte'], $_POST['codepin'], $solde, $decouvert, $devise);
                            break;
                        case 'CompteInteret':
                            echo 'taux : '. floatval($_POST['taux']) .'<br />';
                            $taux = floatval($_POST['taux']);
                            echo $taux;
                            $compte = new CompteInteret($nom, $prenom, $numcompte, $numagence, $rib, $iban, $solde,$taux, $decouvert, $devise);
                            break;
                    }
                    $compte->insertCompte();
                    ?>
                    <h3>Le compte suivant a été enregistré : </h3>
                        <?php
                        echo $compte->ficheCompte();
                        ?>
                    <p>
                        <a href="./classesetpdo.php"><button class="btn btn-outline-secondary btn-small" type="button">Retour à la page des comptes</button></a>
                    </p>
                    <?php
                } else {
                    $typeCompte = (isset($_GET['typecompte'])) ? $_GET['typecompte'] : null;
                ?>
                    <form method="post">
                        <fieldset class="form-control my-2">
                            <legend>
                                Détenteur du compte
                            </legend>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" id="nom" />
                                </div>
                                <div class="col-lg-6">
                                    <label for="prenom">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" id="nom" />
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
                                    <input type="text" class="form-control" name="numagence" id="numagence" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-control my-2">
                            <legend>
                                Détails du compte
                            </legend>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="type">Type compte</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="hidden" name="type" id="type" value="<?php echo $typeCompte ?>" readonly />
                                    <?php echo $typeCompte ?>
                                </div>
                            </div>
                            <?php
                            switch ($typeCompte) {
                                case 'Compte':
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Découvert autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="decouvert" id="decouvert" value="0" />
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case 'CompteCheque':
                                    $numcarte = CompteCheque::generateCardNumber();
                                    $codepin = CompteCheque::generatePin();
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Découvert autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" name="decouvert" id="decouvert" value="0" />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Numéro de carte</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control" name="numcarte" id="numcarte" value="<?php echo $numcarte ?>" />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="codepin">Code secret</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control" name="codepin" id="codepin" value="<?php echo $codepin ?>" />
                                        </div>
                                    </div>
                                <?php
                                    break;
                                case 'CompteInteret':
                                    ?>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="numcarte">Découvert autorisé</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" readonly class="form-control" name="decouvert" id="decouvert" value="0" />
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-6">
                                            <label for="taux">Taux d'intérêts</label>
                                        </div>
                                        <div class="col-lg-6">
                                            <select class="form-select" name="taux" id="taux">
                                                <option value="" selected>Choisir le taux d'intéret</option>
                                                <option value="0.015">1.5%</option>
                                                <option value="0.030">3%</option>
                                                <option value="0.050">5%</option>
                                            </select>
                                        </div>
                                    </div>
                                <?php
                                    break;
                                default:
                                ?>
                                    <script>
                                        document.location.href = "./classesetpdo.php";
                                    </script>
                            <?php
                                    exit();
                            }
                            ?>
                            <div class="row my-2">
                                <div class="col-lg-6">
                                    <label for="solde">Solde</label>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" class="form-control" name="solde" id="solde" />
                                </div>
                            </div>
                        </fieldset>
                        <p>
                            <button class="btn btn-outline-success btn-small" type="submit">
                                Créer et enregistrer le compte
                            </button>
                            <button class="btn btn-outline-warning btn-small" type="reset">
                                Vider le formulaire
                            </button>
                            <a href="./classesetpdo.php"><button class="btn btn-outline-secondary btn-small" type="button">Annuler</button></a>
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