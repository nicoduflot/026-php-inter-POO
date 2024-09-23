<?php

namespace App;

use Utils\Tools;

class Carte{
    private $numcarte;
    private $codepin;

    /**
     * Carte constructor
     * @param string numcarte
     * @param string codepin
     */
    public function __construct($numcarte, $codepin)
    {
        $this->numcarte = $numcarte;
        $this->codepin = $codepin;
    }
 
    /**
     * Get the value of numcarte
     */ 
    public function getNumcarte()
    {
        return $this->numcarte;
    }

    /**
     * Get the value of codepin
     */ 
    public function getCodepin()
    {
        return $this->codepin;
    }
    
    public function enreg(){
        $bdd = Tools::setBdd('localhost', '2024-05-27-php-avance');
        $sql = 'INSERT INTO `carte` (`cardnumber`, `codepin`) VALUES ( :cardnumber, :codepin) ;';
        $params = ['cardnumber' => $this->getNumcarte(), 'codepin' => $this->getCodepin()];
        $request = $bdd->prepare($sql);
        $request->execute($params);
        $idcard = $bdd->lastInsertId();
        $request->closeCursor();
        return $idcard;
    }

    /**
     * Set the value of numcarte
     *
     * @return  self
     */ 
    public function setNumcarte($numcarte)
    {
        $this->numcarte = $numcarte;

        return $this;
    }

    /**
     * Set the value of codepin
     *
     * @return  self
     */ 
    public function setCodepin($codepin)
    {
        $this->codepin = $codepin;

        return $this;
    }

    public function insertcard(){
        $sql = 'INSERT INTO `carte` (`cardnumber`, `codepin`) VALUES ( :cardnumber, :codepin); ';
        $params = [
            'cardnumber' => $this->numcarte,
            'codepin' => $this->codepin
        ];
        $id = Tools::insertBdd($sql, $params);
        return $id;
    }

    public function removeSelf(){
        $bdd = Tools::setBdd('localhost', '2024-05-27-php-avance');
        $sql = 'DELETE FROM `carte` WHERE `cardnumber` = :cardnumber AND `codepin` = :codepin;';
        $params = ['cardnumber' => $this->getNumcarte(), 'codepin' => $this->getCodepin()];
        $request = $bdd->prepare($sql);
        $request->execute($params);
        $request->closeCursor();
        return true;
    }
}