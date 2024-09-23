<?php

namespace Wargame;

use Wargame\Troops;

class TroopsFactory
{
    public static function recruit(string $className, int $army): Troops
    {
        if (! class_exists('Wargame\\' . $className)) {
            throw new \Exception('La classe ' . $className . ' n\'existe pas');
        }

        $class = 'Wargame\\' . $className;
        $instance = new $class($army);
    
        return $instance;
    }
}