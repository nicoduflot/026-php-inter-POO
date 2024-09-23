<?php

namespace Oeuvres;

class Createur extends Personne{
    public function __construct($nom, $prenom = '', $pseudonyme = '', $bio = '')
    {
        parent::__construct($nom, $prenom, $pseudonyme, $bio);
    }
}