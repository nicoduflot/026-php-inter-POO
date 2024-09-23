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
        <section>
            <article>
                <header>
                    <h2>Composer</h2>
                </header>
                <p>
                    Composer est un gestionnaire de paquet, c'est à dire qu'il va aider à installer
                    et gérer des bibliothèques et des dépendances php.
                </p>
                <h3>
                    Installer composer
                </h3>
                <p>
                    On peut installer composer en téléchargeant l'instaleur windows sur le site de composer. Il
                    faut le mettre accessible de partout (ne pas l'installer dans un répertoire spécifique).
                </p>
                <h3>Vérifier l'installation</h3>
                <p>
                    Quand vous êtes à la racine d'un répertoire, à l'aide d'une console, on lance la commande
                    <code>
                        composer
                    </code> puis entrée.
                </p>
                <p>
                    Si composer n'est pas installé ou n'est pas accessible depuis le projet, il faut le réinstaller.
                    Si il est bien accessible, composer vous répond.
                </p>
                <h3>Initialiser composer</h3>
                <p>
                    On va à la racine du projet et on lance dans la console la commande suivante :
                    <code>
                        composer init
                    </code>
                </p>
                <p>
                    vous avez ensuite une série de question auxquelles il faut répondre
                </p>
                <ul>
                    <li>Le nom du projet que vous pouvez laisser par défaut</li>
                    <li>La description du projet</li>
                    <li>L'auteur</li>
                    <li>Stabilité minimale, il va permettre de filtrer les librairies par rapport à la valeur qui vous lui attribuez.
                        En tapant <code>stable</code> tout les packages utilisés doivent être à la version stable.</li>
                    <li>Type du package: Ici il s'agit d'un projet, donc on entre <code>project</code></li>
                    <li>License: la licence va définir comment les autres personnes pourront utiliser votre projet</li>
                    <li>On répond <code>no</code> aux deux avant-dernières questions, pour ne pas jouer avec les interdépendance des paquets.</li>
                    <li>A la toutes dernière question, on réponde <code>n</code>, on s'occupera du psr-4 plus tard.</li>
                </ul>
                <p>
                    A la fin, on vous demande de confirmer la génération du fichier <code>composer.json</code> qui
                    va être le fichier qui référencera les informations, les librairies et les dépendances utilisées dans le projet.
                </p>
                <p>
                    Ce fichier est créé à la racine du projet.
                </p>
                <h3>Installer une dépendance</h3>
                <p>
                    Composer est un installeur, on va lui demander d'aller chercher la dépendance requise et de l'installer
                    dans le projet, on utilisera la commande <code>composer require <nom du paquet></code>.
                </p>
                <p>
                    Par exemple, pour installer les collections de doctrine qu'on va utiliser ensuite,
                    on entrera la commande suivante :
                </p>
                <p>
                    <code>
                        composer require doctrine/collections
                    </code>
                </p>
                <p>
                    on voit ensuite que le fichier <code>composer.json</code> a été mis à jour avec a partie suivante :
                </p>
                <p>
                    <code>
                        "require": {<br />
                        &nbsp;&nbsp;"doctrine/collections": "^2.2"<br />
                        }
                    </code>
                </p>
                <p>
                    Ici, on n'installera pas tous les paquets de doctrine, c'est pour cela qu'on a précisé que l'on
                    choisit <code>doctrine/collections</code>
                </p>
                <h3>Installer d'autres dépendances</h3>
                <p>
                    composer utilise le dépôt officiel des packages (paquets) Php :
                    <a href="https://packagist.org/" target="_blank">Packagist</a>.
                    Vous y trouverez les paquets et la commande pour les installer.
                </p>
                <p>
                    On peut aussi installer d'autre dépendances en modifiant le fichier <code>composer.json</code>.
                    Après <code>"minimum-stability": "stable"</code>, on ajoute un virgule (on signifie qu'un nouvel attribut
                    est ajouté au json) et à la ligne suivante on ajoute :
                </p>
                <p>
                    <code>
                        "require": {<br />
                        &nbsp;&nbsp;"doctrine/collections": "^2.2"<br />
                        }
                    </code>
                </p>
                <p>
                    Ensuite, il faut lancer une commande pour dire à composer d'aller
                    vérifier le fichier <code>composer.json</code> et d'installer les dépendances nouvelles.
                </p>
                <p>
                    <code>
                        composer update
                    </code>
                </p>
                <p>
                    Utiliser cette méthode permet aussi de choisir la version du package, ici on a choisi la
                    dernière version stable, notée <code>"^2.2"</code>
                </p>
                <p>
                    on peut gérer les versions par plage en utilisant des opérateurs de comparaison :
                </p>
                <ul>
                    <li>>=1.0 (version 1 et supérieures)</li>
                    <li>>=1.0 <=2.0 (Version supérieire ou égale à 1 et inférieure ou égale à 2)</li>
                    <li>>=1.0 <1.1 ||>=1.2 (Version supérieire ou égale à 1 et inférieure ou égale à 1.1
                            <b>OU</b> version supérieur ou égal à 1.2)</li>
                    <li>1.0 - 2.0 (plage de version qui équivaut à >=1.0.0 <2.1)</li>
                    <li>1.0.* (version 1.0 à inférieur strictement à 1.1)</li>
                    <li>~1.4 (version supérieur ou égale à 1.4 mais strictement inférieure à 2.0)</li>
                    <li>^1.4.5 (permet les mises à jour mineures suivantes mais pas la mise à jour majeure 2.0)</li>
                </ul>
                <h3>
                    require-dev
                </h3>
                <p>
                    Composer permet de spécifier les dépendances utilisées pour le développement. on inscrira alors un
                    nouvel attribut dans le <code>composer.json</code> nommé <code>require-dev</code>.
                </p>
                <p>
                    Pour l'installer en ligne de commande, il faut utiliser <code>composer install</code> et
                    <code>composer update</code> en utilisant l'option <code>--no-dev</code> pour préciser en production
                    de ne pas installer les dépendances contenues dans <code>require-dev</code>
                </p>
                <p>
                    pour le déploiement et les installation en prod, il suffit d'envoyer le code et les fichiers
                    composer.json et composer.lock, on ne prends pas les code des dépendances (présentes dans le
                    répertoire vendor à la racine). Ensuite on utilise <code>composer install --no-dev</code> pour
                    l'installation et <code>composer update --no-dev</code> pour les mises à jour.
                </p>
                <h3>Autoload</h3>
                <p>
                    Ce fichier de composer permet de pouvoir charger simplement
                    les dépendances installées par composer.
                    On peut ajouter avec composer.json nos propres classes.
                </p>
                <h3>Autoload</h3>
                <p>
                    Ce fichier de composer permet de pouvoir charger simplement
                    les dépendances installées par composer.
                    On peut ajouter avec composer.json nos propres classes.
                </p>
                
                <code>
                "autoload": {<br />
                &nbsp;&nbsp;"psr-4":{<br />
                &nbsp;&nbsp;&nbsp;&nbsp;"App\\": "src/Classes"<br />
                &nbsp;&nbsp;}<br />
                }
                </code>
                <?php
                Tools::prePrint('gogo');
                ?>
                <h3>Installation de Bootstrap</h3>
                <p>
                    Sur la doc de bootstrap, nous allons utiliser cette commande composer :
                </p>
                <code>
                    composer require twbs/bootstrap
                </code>
                <p>
                    Ensuite, comme la dépendance c'est téléchargée dans le répertoire "vendor", qui n'est pas visible
                    par le public, il faut :
                </p>
                <ol>
                    <li>Créer, par exemple, un fichier "assets" à la racine du site</li>
                    <li>Y copier ce qui se trouve à l'intérieur du fichier "dist" présent dans
                        <code>vendor/twbs/bootstrap/dist</code>
                    </li>
                    <li>
                        ensuite faire le lien vers les fichiers requis pour utiliser bootstrap
                    </li>
                </ol>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>