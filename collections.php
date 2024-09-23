<?php
require './vendor/autoload.php';
use Utils\Tools;
use Doctrine\Common\Collections\ArrayCollection;
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
                    <h2>Collections</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Les collections permettent de créer des collections de tableaux
                </p>
                <code>
                    $collection = new ArrayCollection();<br />
                    $collection->add("Nicolas Duflot");
                </code>
                <p>
                    La doc complète de ArrayCollection se trouve <a href="https://www.doctrine-project.org/projects/doctrine-collections/en/stable/index.html" target="_blank">Ici</a>
                </p>
                <?php
                /* 
                si on n'utilise pas use Doctrine\Common\Collections\ArrayCollection;
                pour appeler les collections il faut
                $collection = new Doctrine\Common\Collections\ArrayCollection(); 
                */

                $collection = new ArrayCollection();
                Tools::prePrint($collection);
                $collection->add('Nicolas Duflot');
                Tools::prePrint($collection);
                $collection->add('Benoit Poulard');
                $collection->add('Pierre Coste');
                Tools::prePrint($collection);
                echo $collection->key().'<br />';
                //$collection->remove(0);
                //$collection->removeElement('Nicolas Duflot');
                $collection->clear();
                $collection->add('Nicolas Duflot');
                $collection->add('Benoit Poulard');
                $collection->add('Pierre Coste');
                Tools::prePrint($collection);
                $contains = $collection->contains('Nicolas Duflot');
                Tools::prePrint($contains);
                $contains = $collection->contains('Nicolas');
                Tools::prePrint($contains);
                Tools::prePrint($collection->count());
                for($i = 0; $i < $collection->count(); $i++){
                    print_r($collection->get($collection->key()));
                    echo ';';
                    $collection->next();
                }
                $collection->first();
                Tools::prePrint($collection->key());
                $collection->add('Geralt Derive');
                $collection->add('Cixi');
                $collection->add('Lanfeust');
                Tools::prePrint($collection);
                $numberList = new ArrayCollection([1,2,3,4,5,6,7,8]);
                $filteredCollection = $numberList->filter(function($element){
                    return $element > 3;
                });

                Tools::prePrint($filteredCollection);
                
                $filteredCollection = $numberList->filter(function($element){
                    if($element %2 === 0){
                        return $element;
                    }
                });
                Tools::prePrint($filteredCollection);
                
                $partitionned = $numberList->partition(function($key, $value){
                    if($value %2 === 0){
                        return $value;
                    }
                });

                Tools::prePrint($partitionned);

                $collection->set('toto', 'tata');
                
                Tools::prePrint($collection);
                $collection->set('toto', 'tutu');
                Tools::prePrint($collection);
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/includes/footer.php';
    ?>
</body>
</html>