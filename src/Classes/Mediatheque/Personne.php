<?php

namespace Oeuvres;

class Personne{
    /* Attributs */
    private $uniqueid;
    private $nom;
    private $prenom;
    private $pseudonyme;
    private $bio;

    public function __construct($nom, $prenom = '', $pseudonyme = '', $bio = ''){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->bio = $bio;
        $this->pseudonyme = $pseudonyme;
        $this->uniqueid = time().'-'.$nom.'-'.$prenom;
    }

    /**
     * Get the value of uniqueid
     */ 
    public function getUniqueid()
    {
        return $this->uniqueid;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of pseudonyme
     */ 
    public function getPseudonyme()
    {
        return $this->pseudonyme;
    }

    /**
     * Set the value of pseudonyme
     *
     * @return  self
     */ 
    public function setPseudonyme($pseudonyme)
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * Get the value of bio
     */ 
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */ 
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }
}