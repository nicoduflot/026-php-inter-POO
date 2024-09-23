<?php

namespace Oeuvres;

class Film extends Oeuvre{
    /* 
    <li>Casting (tableau de Personne)</li>
                    <li>synopsis</li>
                    <li>support</li>
                    <li>genre</li>
    */

    /* attributs */
    private $casting;
    private $synopsis;
    private $support;
    private $genre;

    /* constructeur */
    public function __construct($titre, $description, $synopsis, $support, $genre){
        parent::__construct($titre, $description);
        $this->casting = [];
        $this->synopsis = $synopsis;
        $this->support = $support;
        $this->genre = $genre;
    }

    /* assesseurs mutateurs */

    /**
     * Get the value of casting
     */ 
    public function getCasting()
    {
        return $this->casting;
    }

    /**
     * Set the value of casting
     *
     * @return  self
     */ 
    public function setCasting(Role $role)
    {
        array_push($this->casting, $role);

        return $this;
    }

    /**
     * Get the value of synopsis
     */ 
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set the value of synopsis
     *
     * @return  self
     */ 
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get the value of support
     */ 
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * Set the value of support
     *
     * @return  self
     */ 
    public function setSupport($support)
    {
        $this->support = $support;

        return $this;
    }

    /**
     * Get the value of genre
     */ 
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /* méthode de films */
    public function ajouterActeur(Role $acteur){
        $this->setCasting($acteur);
    }

    public function retirerActeur(Role $acteur){

    }
}