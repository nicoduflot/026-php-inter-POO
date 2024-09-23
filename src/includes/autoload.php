<?php
/* la fonction de chargement des classes */
function loadClass($class){
    require './src/Classes/'.$class.'.php';
}

/* 
spl_autoload_register reconnaît l'utilisation d'une classe.
on lui indique d'utiliser la fonction loadClass
*/

spl_autoload_register('loadClass');