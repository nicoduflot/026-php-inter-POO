<?php
namespace Media;

class Radio{
    private $marque;
    private $modele;
    private $volume;
    private $frequenceFm;
    private $frequenceActuelle;
    private $limiteDb;

    public function __construct($marque, $modele)
    {
        $this->marque = $marque;
        $this->modele = $modele;
        $this->volume = 0;
        $this->frequenceFm = [87.5, 108];
        $this->frequenceActuelle = $this->frequenceFm[0];
        $this->limiteDb = 65;
    }

    /**
     * Get the value of marque
     */ 
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set the value of marque
     *
     * @return  self
     */ 
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get the value of modele
     */ 
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set the value of modele
     *
     * @return  self
     */ 
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get the value of volume
     */ 
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set the value of volume
     *
     * @return  self
     */ 
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get the value of frequenceFm
     */ 
    public function getFrequenceFm()
    {
        return $this->frequenceFm;
    }

    /**
     * Set the value of frequenceFm
     *
     * @return  self
     */ 
    public function setFrequenceFm($frequenceFm)
    {
        $this->frequenceFm = $frequenceFm;

        return $this;
    }

    /**
     * Get the value of frequenceActuelle
     */ 
    public function getFrequenceActuelle()
    {
        return $this->frequenceActuelle;
    }

    /**
     * Set the value of frequenceActuelle
     *
     * @return  self
     */ 
    public function setFrequenceActuelle($frequenceActuelle)
    {
        $this->frequenceActuelle = $frequenceActuelle;

        return $this;
    }

    /**
     * Get the value of limiteDb
     */ 
    public function getLimiteDb()
    {
        return $this->limiteDb;
    }

    /**
     * Set the value of limiteDb
     *
     * @return  self
     */ 
    public function setLimiteDb($limiteDb)
    {
        $this->limiteDb = $limiteDb;

        return $this;
    }

    public function modifierVolume($volume){
        switch(true){
            case ($this->getVolume() + $volume < 0):
                $this->setVolume(0);
            break;
            case ($this->getVolume() + $volume > $this->getLimiteDb()):
                $this->setVolume(65);
            break;
            default:
            $this->setVolume($this->getVolume() + $volume);
        }
    }

    public function modifierFrequence($frequence){
        $frequenceMin = $this->getFrequenceFm()[0];
        $frequenceMax = $this->getFrequenceFm()[1];
        switch(true){
            case ($this->getFrequenceActuelle() + $frequence < $frequenceMin):
                $this->setFrequenceActuelle($frequenceMin);
            break;
            case ($this->getFrequenceActuelle() + $frequence > $frequenceMax):
                $this->setFrequenceActuelle($frequenceMax);
            break;
            default:
                $this->setFrequenceActuelle($this->getFrequenceActuelle() + $frequence);
        }
    }
}