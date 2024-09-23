<?php
require './vendor/autoload.php';

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
            <article>
                <header>
                    <h2>Exceptions</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Intégrer dans les classes Compte (et les enfants) des méthodes pour enregistrer ou modifier voir supprimer des comptes.
                </p>
                <ul>
                    <li><a href="./creaCompte.php?typecompte=Compte">Un compte</a></li>
                    <li><a href="./creaCompte.php?typecompte=CompteCheque">Un compte chèque</a></li>
                    <li><a href="./creaCompte.php?typecompte=CompteInteret">Un compte intérêt</a></li>
                </ul>
            </article>
            <article>
                <header>
                    <h2>Les comptes enregistrés</h2>
                </header>
                <?php
                $sqlCPT = '
                    SELECT 
                        * 
                    FROM 
                        `compte` 
                    WHERE 
                        `typecompte` = \'Compte\' 
                    ORDER BY 
                        `compte`.`nom`';
                $request = Tools::modBdd($sqlCPT);
                ?>
                <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Numéro de compte</th>
                            <th>Numéro d'agence</th>
                            <th>RIB</th>
                            <th>IBAN</th>
                            <th>Solde</th>
                            <th>Découvert autorisé</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                        //Tools::prePrint($compte);
                        ?>
                        <tr>
                            <td><?php echo $compte['nom'] ?></td>
                            <td><?php echo $compte['prenom'] ?></td>
                            <td><?php echo $compte['numcompte'] ?></td>
                            <td><?php echo $compte['numagence'] ?></td>
                            <td><?php echo $compte['rib'] ?></td>
                            <td><?php echo $compte['iban'] ?></td>
                            <td><?php echo $compte['solde'] . ' ' . $compte['devise'] ?></td>
                            <td><?php echo $compte['decouvert'] ?></td>
                            <td>
                                <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte['uniqueid'] ?>" title="Voir le compte"><button class="btn btn-primary btn-small"><i class="bi bi-card-text"></i></button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                </div>
                <?php
                $request->closeCursor();
                ?>
            </article>
            <article>
                <header>
                    <h2>Les comptes chèques enregistrés</h2>
                </header>
                <?php
                $sqlCCP = '
                SELECT 
                    * 
                FROM 
                    `compte` LEFT JOIN 
                    `carte` on `compte`.`cardid` = `carte`.`id` 
                WHERE 
                    `typecompte` = \'CompteCheque\' 
                ORDER BY 
                    `compte`.`nom`';
                $request = Tools::modBdd($sqlCCP);
                ?>
                <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Numéro de compte</th>
                            <th>Numéro d'agence</th>
                            <th>RIB</th>
                            <th>IBAN</th>
                            <th>Solde</th>
                            <th>Découvert autorisé</th>
                            <th>Numéro de carte</th>
                            <th>Code Pin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                        //Tools::prePrint($compte);
                        ?>
                        <tr>
                            <td><?php echo $compte['nom'] ?></td>
                            <td><?php echo $compte['prenom'] ?></td>
                            <td><?php echo $compte['numcompte'] ?></td>
                            <td><?php echo $compte['numagence'] ?></td>
                            <td><?php echo $compte['rib'] ?></td>
                            <td><?php echo $compte['iban'] ?></td>
                            <td><?php echo $compte['solde'] . ' ' . $compte['devise'] ?></td>
                            <td><?php echo $compte['decouvert'] ?></td>
                            <td><?php echo $compte['cardnumber'] ?></td>
                            <td><?php echo $compte['codepin'] ?></td>
                            <td>
                                <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte['uniqueid'] ?>" title="Voir le compte"><button class="btn btn-primary btn-small"><i class="bi bi-card-text"></i></button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                </div>
                <?php
                $request->closeCursor();
                ?>
            </article>
            <article>
                <header>
                    <h2>Les comptes intérêts enregistrés</h2>
                </header>
                <?php
                $sqlCIT = '
                SELECT 
                    * 
                FROM 
                    `compte` 
                WHERE 
                    `typecompte` = \'CompteInteret\' 
                ORDER BY 
                    `compte`.`nom`';
                $request = Tools::modBdd($sqlCIT);
                ?>
                <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Numéro de compte</th>
                            <th>Numéro d'agence</th>
                            <th>RIB</th>
                            <th>IBAN</th>
                            <th>Solde</th>
                            <th>Taux d'intérêt</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($compte = $request->fetch(PDO::FETCH_ASSOC)){
                        //Tools::prePrint($compte);
                        ?>
                        <tr>
                            <td><?php echo $compte['nom'] ?></td>
                            <td><?php echo $compte['prenom'] ?></td>
                            <td><?php echo $compte['numcompte'] ?></td>
                            <td><?php echo $compte['numagence'] ?></td>
                            <td><?php echo $compte['rib'] ?></td>
                            <td><?php echo $compte['iban'] ?></td>
                            <td><?php echo $compte['solde'] . ' ' . $compte['devise'] ?></td>
                            <td><?php echo ($compte['taux']*100). '%' ?></td>
                            <td>
                                <a href="./gestionCompte.php?action=show&uniqueid=<?php echo $compte['uniqueid'] ?>" title="Voir le compte"><button class="btn btn-primary btn-small"><i class="bi bi-card-text"></i></button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                </div>
                <?php
                $request->closeCursor();
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>

</html>