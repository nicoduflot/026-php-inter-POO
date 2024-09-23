<?php
require './vendor/autoload.php';
use Utils\Tools;
use Doctrine\Common\Collections\ArrayCollection;
use Oeuvres\Oeuvre;
use Oeuvres\Livre;
use Oeuvres\Film;
use Oeuvres\Role;
use Oeuvres\Personne;
use Oeuvres\Periodique;
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
        <section>
            <article>
                <header>
                    <h2>Mediathèque</h2>
                </header>
                <h3>Définition d'une oeuvre</h3>
                <p>
                    Une oeuvre peut être définie par :
                </p>
                <ul>
                    <li>Un ou des créateurs</li>
                    <li>Un titre</li>
                    <li>Une description ou un résumé</li>
                </ul>
                <p>
                    Toutes les oeuvres auront les méthodes suivantes
                </p>
                <ul>
                    <li>ajoutcreateur</li>
                    <li>supprcreateur</li>
                </ul>
                <p>
                    Les différents types d'oeuvres seront des classe enfants étandants la classe oeuvre mais ayant chacunes leurs particularités.
                </p>
                <h3>La classe Oeuvre</h3>
                <?php
                $oeuvre = new Oeuvre('Les zinzins d\'Olive Oued');
                $oeuvre->ajoutcreateur('Pratchett', 'Terry');
                Tools::prePrint($oeuvre);
                ?>
            </article>
        </section>
        <section class="row">
            <article class="col-lg-6">
                <header>
                    <h2>L'objet Livre, un type d'oeuvre</h2>
                </header>
                <p>
                    Livre est une classe enfant d'Oeuvre. Livre aura les attribut supplémentaires suivants
                </p>
                <ul>
                    <li>résumé</li>
                    <li>format</li>
                    <li>genre</li>
                    <li>isbn</li>
                </ul>
                <?php
                $livre = new Livre('Les zinzins d\'Olive Oued', 'Le médiéval-fantastique invente le cinéma', 'Les alchimiste d\'Ank Morpork inventent le celuloid et la guilde des artisans la machine pour projeter les images, les marchands inventent Olive Oued', 'Poche', 'Médieval-fantastique');
                $livre->ajoutcreateur('Pratchett', 'Terry');
                Tools::prePrint($livre);
                ?>
                <h3>UN livre avec plusieurs créateurs ?</h3>
                <?php
                $livre2 = new Livre('De bons présages', 'Un ange et un démon installés sur terre ne désire pas que l\'apocalypse survienne', 'Un ange et un démon installés sur terre ne désire pas que l\'apocalypse survienne', 'Poche', 'Fantastique');
                $livre2->ajoutcreateur('Pratchett', 'Terry');
                $livre2->ajoutcreateur('Gaiman', 'Neil');
                Tools::prePrint($livre2);
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>L'objet Film, un type d'oeuvre</h2>
                </header>
                <p>
                    Film est une classe enfant d'Oeuvre. 
                    Film aura les attributs supplémentaires suivants
                </p>
                <ul>
                    <li>Casting (tableau de Role)</li>
                    <li>synopsis</li>
                    <li>support</li>
                    <li>genre</li>
                </ul>
                <p>
                    Et des méthodes de gestion du casting
                </p>
                <ul>
                    <li>ajouter acteur - personnage casting</li>
                    <li>retirer acteur - personnage casting</li>
                </ul>
                <?php
                $film = new Film('Rambo', 'Un vétéran prends cher', 'C\'était pas ma guerre', 'Dvd', 'Drame');
                $film->ajouterActeur(new Role('John Rambo', new Personne('Stallone', 'Sylvester', '', '')));
                $film->ajoutcreateur('Kotcheff', 'Ted', '');
                tools::prePrint($film);
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>L'objet Périodique, un type d'oeuvre</h2>
                </header>
                <p>
                    Periodique est une classe enfant d'Oeuvre. 
                    Periodique aura les attributs supplémentaires suivants
                </p>
                <ul>
                    <li>Intervenants (tableau de Role)</li>
                    <li>periodicite</li>
                    <li>theme</li>
                </ul>
                <p>
                    Et des méthodes de gestion du casting
                </p>
                <ul>
                    <li>ajouter intervenant - role staff</li>
                    <li>retirer intervenant - rolle staff</li>
                </ul>
                <?php
                 $magazine = new Periodique('Mad Movies', 'Le cinéma d\'horreur', [], 'mensuel', 'Horreur');
                 $magazine->ajouterIntervenant(new Role('Editeur', new Personne('Kurl', 'Karl')));
                 $magazine->ajouterIntervenant(new Role('Journaliste', new Personne('Kael', 'Mickael')));
                 tools::prePrint($magazine);
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>