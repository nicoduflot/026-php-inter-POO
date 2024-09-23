<?php
namespace Oeuvres;

class Periodique extends Oeuvre{
    /* attributs */
    private $intervenants;
    private $periodicite;
    private $theme;

    /* contructeur */
    public function __construct($titre, $description = '', $intervenants = [], $periodicite = '', $theme = '')
    {
        parent::__construct($titre, $description);
        $this->intervenants = $intervenants;
        $this->periodicite = $periodicite;
        $this->theme = $theme;
    }
    /* assesseurs / mutateurs */
    
    /**
     * Get the value of intervenants
     */ 
    public function getIntervenants()
    {
        return $this->intervenants;
    }

    /**
     * Set the value of intervenants
     *
     * @return  self
     */ 
    public function setIntervenants(Role $intervenants)
    {
        array_push($this->intervenants, $intervenants);

        return $this;
    }

    /**
     * Get the value of periodicite
     */ 
    public function getPeriodicite()
    {
        return $this->periodicite;
    }

    /**
     * Set the value of periodicite
     *
     * @return  self
     */ 
    public function setPeriodicite($periodicite)
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    /**
     * Get the value of theme
     */ 
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set the value of theme
     *
     * @return  self
     */ 
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function ajouterIntervenant(Role $intervenant){
        $this->setIntervenants($intervenant);
    }
}