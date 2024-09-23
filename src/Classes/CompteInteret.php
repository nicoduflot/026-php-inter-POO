<?php

namespace App;
use Utils\Tools;

class CompteInteret extends Compte{

    /* Attributs */
    private $taux;

    /**
     * Compte constructor
     * @param string    nom
     * @param string    prenom
     * @param string    numcompte
     * @param string    numagence
     * @param string    rib
     * @param string    iban
     * @param float     taux
     * @param float     solde
     * @param string    devise
     */
    public function __construct(
        $nom, $prenom, $numcompte, $numagence, $rib, $iban, $solde = 0, $taux = 0.03, $decouvert = 0, $devise = '€',$uniqueid = null)
    {
        parent::__construct($nom, $prenom, $numcompte, $numagence, $rib, $iban, $solde, $decouvert, $devise, $uniqueid);
        $this->decouvert = 0;
        $this->setTaux($taux);
    }

    /**
     * Get the value of taux
     */ 
    public function getTaux()
    {
        return $this->taux;
    }
    
    /**
     * Set the value of taux
     *
     * @return  self
     */ 
    public function setTaux($taux)
    {
        if (!is_float($taux) || $taux <= 0) {
            echo '
            <div class="alert alert-warning alert-dismissible fade show">
                Le taux d\'intérêt ne peut être une chaîne de caractère ou inférieur ou égal à 0.<br />
                Le taux par défaut de 3% sera appliqué au compte
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
            $taux = 0.03;
        }
        $this->taux = $taux;
        return true;
    }

    /* Méthode(s) de CompteInteret */
    /* surcharge de la méthode virement : il est impossible d'être débiteur sur un compte à intérêts */

    public function crediterinterets(){
        $message = '';
        $interets = 0;
        if($this->getSolde() > 0){
            $interets = $this->getSolde()*$this->getTaux();
            $this->modifierSolde($interets);
            $message .= 'Le compte inétrêt à taux '. $this->getTaux() . ' a été crédité de '. $interets .' ' . $this->getDevise();
        }

        return $message;
    }

    public function ficheCompte(): string
    {
        $ficheCompte = parent::ficheCompte();
        $ficheCompte .= '<div class="my-2">Taux d\'intérêt : <b>'.$this->getTaux().'</b></div>';
        return $ficheCompte;
    }

    public function insertCompte(){
        $params = [
            'uniqueid' => 'CPT-'.time(),
            'typecompte' => $this->typeCompte(),
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'numcompte' => $this->numcompte,
            'numagence' => $this->numagence,
            'rib' => $this->rib,
            'iban' => $this->iban,
            'solde' => $this->solde,
            'devise' => $this->devise,
            'taux' => $this->taux,
            'decouvert' => $this->decouvert
        ];

        $sql = '
        INSERT INTO `compte` (
            `uniqueid`, `typecompte`, `nom`,
            `prenom`, `numcompte`, `numagence`,
            `rib`, `iban`, `solde`,
            `devise`, `taux`, `decouvert`
        ) VALUES  (
            :uniqueid, :typecompte, :nom, 
            :prenom, :numcompte, :numagence,
            :rib, :iban, :solde,
            :devise, :taux, :decouvert
        );';
        Tools::modBdd($sql, $params);
    }

    public function enregCompte()
    {
        $params = [
            'uniqueid' => 'CIT-'. time(),
            'typecompte' => $this->typeCompte(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'numcompte' => $this->getNumcompte(),
            'numagence' => $this->getNumagence(),
            'rib' => $this->getRib(),
            'iban' => $this->getIban(),
            'solde' => $this->getSolde(),
            'devise' => $this->getDevise(),
            'taux' => $this->getTaux()
            ];
    
            $sql = 'INSERT INTO compte (
                `uniqueid` , `typecompte` , `nom` , `prenom` , `numcompte` ,
                `numagence` , `rib` , `iban` , `solde` , `devise`, `taux`
            ) VALUES (
                :uniqueid, :typecompte, :nom, :prenom, :numcompte,
                :numagence, :rib, :iban, :solde, :devise, :taux);';
            
            Tools::modBdd($sql, $params);

    }

    public function modCompte(){
        $params = [
        'uniqueid' => $this->getUniqueid(),
        'nom' => $this->getNom(),
        'prenom' => $this->getPrenom(),
        'numcompte' => $this->getNumcompte(),
        'numagence' => $this->getNumagence(),
        'rib' => $this->getRib(),
        'iban' => $this->getIban(),
        'solde' => $this->getSolde(),
        'devise' => $this->getDevise(),
        'taux' => $this->getTaux()
        ];

        $sql = '
        UPDATE `compte` SET 
        `uniqueid` = :uniqueid,
        `nom` = :nom,
        `prenom` = :prenom,
        `numcompte` = :numcompte,
        `numagence` = :numagence,
        `rib` = :rib,
        `iban` = :iban,
        `solde` = :solde,
        `devise` = :devise,
        `taux` = :taux
        WHERE `uniqueid` = :uniqueid;
        ';

        Tools::modBdd($sql, $params);
    }


}