<?php
/*
<li>Un titre</li>
<li>Un ou des créateurs</li>
<li>Une description ou un résumé</li>
*/

namespace Oeuvres;
use Oeuvres\Createur;
use Utils\Tools;

class Oeuvre{
    /* Attribut */
    private $uniqueid;
    private $titre;
    private $createurs;
    private $description;

    public function __construct($titre, $description = '')
    {
        $this->titre = $titre;
        $this->description = $description;
        $this->createurs = [];
        $this->uniqueid = time().'-'.Tools::slugTitle($titre);
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of createurs
     */ 
    public function getCreateurs()
    {
        return $this->createurs;
    }

    /**
     * Set the value of createurs
     *
     * @return  self
     */ 
    public function setCreateurs(Createur $createur)
    {
        array_push($this->createurs, $createur);

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function ajoutcreateur($nom, $prenom = '', $bio = ''){
        $this->setCreateurs(new Createur($nom, $prenom, $bio));
    }

}
