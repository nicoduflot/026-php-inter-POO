<?php
require './vendor/autoload.php';

use Utils\Tools;
use App\MonException;
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
                    <h2>Exceptions</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Exception est une classe Php qui existe par défaut.
                    Pour générer une exception dans un programme, il faut l'appeler à l'intéreur de la fonction a tester.
                </p>
                <code>
                    echo multiplier(20, 12);<br />
                    echo multiplier("test", 23);<br />
                    echo multiplier(113, 42);<br />
                </code>
                <?php
                function multiplier($x, $y)
                {
                    if (!is_numeric($x) || !is_numeric($y)) {
                        throw new Exception('Les deux valeurs doivent être numérique');
                    }
                    return $x * $y;
                }

                

                echo multiplier(20, 12) . '<br />';
                /* echo multiplier('test', 12).'<br />'; */
                ?>
                <p>
                    Si on n'utilise pas de try-catch sur des expression lançant des Exceptions,
                    le reste du programme ne continue, ce qui génère des pages incomplètes.
                </p>
                <p>
                <?php
                    try {
                        echo multiplier(20, 12) . "<br />";
                        echo multiplier("test", 23) . "<br />";
                        echo multiplier(113, 42) . "<br />";
                    } catch (Exception $e) {
                        echo "Une Exception a été lancée : <br />Message : " .
                            $e->getMessage() . "<br />Ligne : " . $e->getLine() .
                            "<br />Code : " . $e->getCode() .
                            "<br />File : " . $e->getFile() .
                            "<br />Trace as string : " . $e->getTraceAsString() .
                            "<br />Previous : " . $e->getPrevious();
                    }
                    ?>
                </p>
                <p>
                    Contrairement au premier exemple, le reste des instructions hors try s'exécutent normalement,
                    donc le reste de la page s'affiche.
                </p>
                <h4>Surcharger Exception : classe étendue personnelle</h4>
                <p>
                    Comme Exception est une classe, il est donc possible de créer sa propre classe étendue d'Exception.
                    En surchargeant les méthodes, on peut ne filtrer ou demander que ses propres exception.
                    Pour, par exemple, n'avoir que getMessage() au retour d'une exception.
                </p>
                <?php
                function multiplier2($x, $y)
                {
                    if (!is_numeric($x) || !is_numeric($y)) {
                        throw new MonException('Les deux valeurs doivent être numérique');
                    }

                    if(func_num_args() > 2){
                        throw new Exception('La fonction n’admet que deux arguments');
                    }

                    return $x * $y;
                }

                try {
                    echo multiplier2(20, 12) . "<br />";
                    echo multiplier2("test", 23) . "<br />";
                    echo multiplier2(113, 42) . "<br />";
                } catch (Exception $e) {
                    echo $e.'<br />'.
                    "<i>Une Exception a été lancée : <br />Message : " .
                    $e->getMessage() . "<br />Ligne : " . $e->getLine() .
                    "<br />Code : " . $e->getCode() .
                    "<br />File : " . $e->getFile() .
                    "<br />Trace as string : " . $e->getTraceAsString() .
                    "<br />Previous : " . $e->getPrevious().'</i>';
                }catch (MonException $e) {
                    echo $e.'<br />'.
                    "<i>Une Exception perso a été lancée : <br />Message : " .
                    $e->getMessage() . "<br />Ligne : " . $e->getLine() .
                    "<br />Code : " . $e->getCode() .
                    "<br />File : " . $e->getFile() .
                    "<br />Trace as string : " . $e->getTraceAsString() .
                    "<br />Previous : " . $e->getPrevious().'</i>';
                }
                ?>
                <h4>Exception dans PDO</h4>
                <p>
                    Il existe des exceptions pour PDO, mais elles ne sont pas natives dans Php, il faut
                    les installer, il existe des dépendances sur packagist installable avec composer
                </p>
                <code>
                    composer require php-kit/ext-pdo
                </code>
                <p>
                <?php
                try{
                    $bdd = new PDO('mysql:host=localhost;dbname=2024-05-27-php-avance;charset=UTF-8', 'root', '');
                }catch(PDOException $e){
                    echo "<i>Une Exception a été lancée : <br />Message : " .
                    $e->getMessage() . "<br />Ligne : " . $e->getLine() .
                    "<br />Code : " . $e->getCode() .
                    "<br />File : " . $e->getFile() .
                    "<br />Trace as string : " . $e->getTraceAsString() .
                    "<br />Previous : " . $e->getPrevious().'</i>';
                }
                ?>
                </p>
            </article>

        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>

</html>