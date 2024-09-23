<?php
/* Pour appeler une classe sans utiliser un autoload (généralement avec composer) */
/*
require './src/Classes/Compte.php';
require './src/Classes/Tools.php';
require './src/Classes/Radio.php';
*/

require_once './vendor/autoload.php';

use App\Compte;
use Utils\Tools;
use Media\Radio;

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
    <?php
    include './src/includes/functions.php';
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
                    <h2>Principes de la POO</h2>
                </header>
                <p>
                    Un objet est la réprésentation de quelque chose de matériel ou non à laquelle on associe des propriétés et des actions.
                </p>
                <p>
                    Une voiture, un compte bancaire, un personnage, etc peuvent être définis en tant qu'objets.
                </p>
                <p>
                    Un objet est défini par des attributs et des méthodes.
                </p>
                <h3>Attribut</h3>
                <p>
                    Les attributs sont des éléments ou caractères propres à l'objet.
                </p>
                <p>
                    Un compte bancaire, aura par exemple :
                </p>
                <ul>
                    <li>La civilité nom, prénom du détenteur</li>
                    <li>le solde</li>
                    <li>le numéro d'agence</li>
                    <li>Le rib</li>
                    <li>l'iban</li>
                </ul>
                <h3>Les méthodes</h3>
                <p>
                    Les actions ou capacités applicable à l'objet.
                </p>
                <p>
                    Le compte bancaire de base aura comme méthodes :
                </p>
                <ul>
                    <li>Modifier le solde</li>
                    <li>Effectuer un virement vers un autre objet de type compte</li>
                    <li>Info sur le compte</li>
                </ul>
                <h3>Instance</h3>
                <p>
                    Un objet est une instance d'une classe. La classe défini l'objet, ses attributs et ses méthodes ainsi qu'un constructeur. C'est le constructeur qui gère la création de l'objet final.
                </p>
                <h3>Encapsulation</h3>
                <p>
                    Les attributs et les méthodes de l'objet sont donc encapsulés dans la classe. L'utilisateur de l'objet ne doit pas modifier le code de la classe mais utilisera l'objet via ses méthodes. En général il n'utilise pas directement ses attributs, ils seront <q>privés</q>
                </p>
                <h3>Créer la classe <q>Compte</q></h3>
                <p>
                    On crée les attributs en privé
                </p>
                <p>
                    On crée ensuite le <q>constructor</q>
                </p>
                <p>
                    Le constructeur sert a contruire l'objet lors de son instantiation. Il peut contenir du code et il définit les variables a renseigner lors de l'instanciation.
                </p>
                <p>
                    Comme les attributs sont privés, il faut, pour pouvoir les lire et / ou les modifier, créer des méthodes particulières, nommées getter ( ou Assesseur, pour les lire) et setter (ou Mutateur, pour les modifier).
                </p>
                <?php
                $compte = new Compte('Duflot', 'Nico', 'CCP-987654', '0123456', 'MON RIB', 'MON IBAN FR', 2500);
                prePrint($compte);
                prePrint($compte->getNom());
                $compte->setPrenom('Nicolas');
                prePrint($compte);

                echo $compte->ficheCompte();

                $compteDestinataire = new Compte('Dusse', 'Jean-claude', 'CCP-654321', '987654', 'RIB', 'IBAN', 1500);
                prePrint($compteDestinataire);
                $compte->virement(25, $compteDestinataire);
                prePrint($compteDestinataire);

                prePrint($compte->typeCompte());

                prePrint($compte->showAttr());

                ?>
                <h2>Les classes statiques</h2>
                <p>
                    Se sont des classes, généralement sans constructeur, qui contiennent une série de méthodes que l'on peut invoquer sans avoir besoin de créer une instance de la classe.
                </p>
                <p>
                    Il est d'ailleurs IMPOSSIBLE de créer une instance de classe si elle ne possèdent pas de constructeur
                </p>
                <?php

                /* appel à un attribut statique */
                prePrint(Tools::$pi);

                /* appel à une méthode statique */
                Tools::prePrint(Tools::circo(5));
                
                ?>
            </article>
            <article>
                <header>
                    <h2>Le destructeur</h2>
                </header>
                <p>
                    La "vie" d'un objet est limité à l'éxécution de son script.
                    Il est possible de donner des instruction à l'objet juste avant sa destruction.
                </p>
                <p>
                    La méthode <code>__destruct(){}</code> se lance automatiquement quand un objet est détruit et s'éxécute juste avant sa déstruction complète. 
                    Cela est utiles dans les cas suivant : enregistrement des données de l'objet en BDD, en session
                </p>
            </article>
            <article>
                <header>
                    <h2>Un objet d'une page à l'autre ?</h2>
                </header>
                <p>
                    Donc si un objet est détruit d'une page à l'autre, comment peut-on "passer" cet objet ?
                </p>
                <h3>Serialize / unserialize</h3>
                <p>
                    En utilisant les session PHP, il est possible d'y enregistrer l'objet créé.
                </p>
                <p>
                    <code>$_SESSION['objetSession'] = serialize($objetScript);</code>
                </p>
                <p>
                    L'objet est donc enregistré ou "sérializé" dans la session PHP. Quand on arrive sur l'autre page, on peut donc récupérer cet objet de le "désérializant dans une variable"
                </p>
                <p>
                    <code>$objetScript = unserialize($_SESSION['objetSession']);</code>
                </p>
                <p>
                    En associant donc le destructeur avec l'enregistrement en session de l'objet, on peut donc créer un objet sur une page et l'utiliser sur les autres pages du site ou de l'application.
                </p>
            </article>
            <article>
                <header>
                    <h2>TD Classe Radio</h2>
                </header>
                <p>
                    Une radio uniquement sur la bande FM
                </p>
                <h3>Attributs</h3>
                <ul>
                    <li>marque</li>
                    <li>modele</li>
                    <li>volume</li>
                    <li>frequenceFm</li>
                    <li>frequenceActuelle</li>
                    <li>limiteDb</li>
                </ul>
                <h3>Méthodes</h3>
                <ul>
                    <li>modifierVolume</li>
                    <li>modifierFrequence</li>
                </ul>
                <?php
                $maRadio = new Radio('Radiola', 'Vintage memory');
                prePrint($maRadio);
                $maRadio->modifierVolume(+25);
                prePrint($maRadio->getVolume());
                $maRadio->modifierVolume(+25);
                prePrint($maRadio->getVolume());
                $maRadio->modifierVolume(+25);
                prePrint($maRadio->getVolume());
                $maRadio->modifierVolume(-100);
                prePrint($maRadio->getVolume());
                $maRadio->modifierFrequence(12.8);
                prePrint($maRadio->getFrequenceActuelle());
                $maRadio->modifierFrequence(22.8);
                prePrint($maRadio->getFrequenceActuelle());
                $maRadio->modifierFrequence(-22.8);
                prePrint($maRadio->getFrequenceActuelle());
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>