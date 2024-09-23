<?php

namespace App;
use Utils\Tools;

class Compte{
    /* Attributs */
    protected $nom;
    protected $prenom;
    protected $numcompte;
    protected $numagence;
    protected $rib;
    protected $iban;
    protected $solde;
    protected $decouvert;
    protected $devise;
    protected $uniqueid;

    /**
     * Compte constructor
     * @param string $nom
     * @param string $prenom
     * @param string $numcompte
     * @param string $numagence
     * @param string $rib
     * @param string $iban
     * @param float  $solde
     * @param float  $decouvert
     * @param string $devise
     */
    public function __construct(
        $nom,
        $prenom,
        $numcompte,
        $numagence,
        $rib,
        $iban,
        $solde = 0,
        $decouvert = 0,
        $devise = '€',
        $uniqueid = null
    )
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->numcompte = $numcompte;
        $this->numagence = $numagence;
        $this->rib = $rib;
        $this->iban = $iban;
        $this->solde = $solde;
        $this->decouvert = $decouvert;
        $this->devise = $devise;
        $this->uniqueid = $uniqueid;
    }

    /* getters et setters */
    

    /**
     * Get the value of nom
     */ 
    public function getNom() : string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  bool
     */ 
    public function setNom($nom) : bool
    {
        if( !is_string($nom) ){
            trigger_error('Le nom doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->nom = $nom;

        return true;
    }
    
    /**
     * Get the value of prenom
     */ 
    public function getPrenom() : string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  bool
     */ 
    public function setPrenom($prenom) : bool
    {
        if( !is_string($prenom) ){
            trigger_error('Le prénom doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->prenom = $prenom;

        return true;
    }

    /**
     * Get the value of numcompte
     */ 
    public function getNumcompte() : string
    {
        return $this->numcompte;
    }

    /**
     * Set the value of numcompte
     *
     * @return  bool
     */ 
    public function setNumcompte($numcompte) : bool
    {
        if( !is_string($numcompte) ){
            trigger_error('Le numéro de compte doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->numcompte = $numcompte;

        return true;
    }
    
    /**
     * Get the value of numagence
     */ 
    public function getNumagence() : string
    {
        return $this->numagence;
    }

    /**
     * Set the value of numagence
     *
     * @return  bool
     */ 
    public function setNumagence($numagence) : bool
    {
        if( !is_string($numagence) ){
            trigger_error('Le numéro d\'agence doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->numagence = $numagence;

        return true;
    }

    
    /**
     * Get the value of rib
     */ 
    public function getRib() : string
    {
        return $this->rib;
    }

    /**
     * Set the value of rib
     *
     * @return  bool
     */ 
    public function setRib($rib) : bool
    {
        if( !is_string($rib) ){
            trigger_error('Le numéro de rib doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->rib = $rib;

        return true;
    }

    
    /**
     * Get the value of iban
     */ 
    public function getIban() : string
    {
        return $this->iban;
    }

    /**
     * Set the value of iban
     *
     * @return  bool
     */ 
    public function setIban($iban) : bool
    {
        if( !is_string($iban) ){
            trigger_error('Le numéro d\'iban doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->iban = $iban;

        return true;
    }

    /**
     * Get the value of solde
     * @return float
     */ 
    public function getSolde() : float
    {
            return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  bool
     */ 
    public function setSolde($solde) : bool
    {
        if( !is_float($solde) ){
            trigger_error('Le solde doit être un nombre', E_USER_WARNING);
        }
            $this->solde = $solde;

            return true;
    }

    /**
     * Get the value of decouvert
     */ 
    public function getDecouvert()
    {
        return $this->decouvert;
    }

    /**
     * Set the value of decouvert
     *
     * @return  self
     */ 
    public function setDecouvert($decouvert)
    {
        $this->decouvert = $decouvert;

        return $this;
    }

    /**
     * Get the value of devise
     */ 
    public function getDevise() : string
    {
        return $this->devise;
    }

    /**
     * Set the value of devise
     *
     * @return  bool
     */ 
    public function setDevise($devise) : bool
    {
        if( !is_string($devise) ){
            trigger_error('La devise doit être une chaîne de caractère', E_USER_WARNING);
        }
        $this->devise = $devise;

        return true;
    }

    /**
     * Get the value of uniqueid
     */ 
    public function getUniqueid()
    {
        return $this->uniqueid;
    }

    /**
     * @return string
     */
    public function typeCompte() : string {
        $namespace = __NAMESPACE__.'\\';
        $className = str_replace($namespace, '', get_class($this));
        return $className;
    }

    /**
     * @param float montant
     */
    public function modifierSolde($montant) : bool
    {
        $this->setSolde( $this->getSolde() + $montant);
        if($this->getUniqueid() !== null){
            $sql = 'UPDATE `compte` SET `solde` = '.$this->getSolde().' WHERE `uniqueid` == :uniqueid';
            $params = ['uniqueid' => $this->getUniqueid()];
            Tools::modBdd($sql, $params);
        }
        return true;
    }

    /**
     * @param float $montant - montant positif et entier ou flottant de la transaction
     * @param object $destinataire - objet instance de la classe Compte
     */
    public function virement($montant, Compte $destinataire){
        if( (!is_float($montant) && !is_int($montant) ) && $montant <= 0 ){
            echo '<p>Le montant doit être un chiffre supérieur à 0</p>
            <br />Virement impossible vers le compte n°'.$destinataire->getNumcompte(). '.<br />';
            return false;
        }
        
        if( ($this->getSolde() - $montant) < (-$this->getDecouvert()) ){
            echo '<p>Votre virement dépasse votre découvert autorisé de '. $this->getDecouvert(). ' '.$this->getDevise().'.
            <br />Virement impossible vers le compte n°'.$destinataire->getNumcompte(). '.</p>';
            return false;
        }
        $this->modifierSolde(-$montant);
        $destinataire->modifierSolde($montant);
        echo 'Le compte n°'.$destinataire->getNumcompte(). ' a été crédité de '.$montant. ' ' .$this->getDevise() .'.<br />';
        /* Mise à jour du solde du compte dans la BDD */
        return true;
    }

    /**
     * @return string
     */
    public function infoCompte() : string {
        $ficheCompte = '';
        /*
        ternaire : if raccourci
        $variable = (condition)? résultat si condition vraie (vérifiée) : résultat si condition fausse (non vérifiée);
        */
        $etatSolde = ($this->getSolde() <= 0)? 'débiteur' : 'créditeur';
        $ficheCompte = ''.
        '<div>'.
            '<div class="my-2"><b>'.$this->typeCompte().'</b></div>'.
            '<div class="my-2"><b>'.$this->getNom().' '.$this->getPrenom().'</b></div>'.
            '<div class="my-2">Agence n°<b>'.$this->getNumagence().'</b></div>'.
            '<div class="my-2">RIB : <b>'.$this->getRib().'</b></div>'.
            '<div class="my-2">IBAN : <b>'.$this->getIban().'</b></div>'.
            '<div class="my-2">Compte : '.$etatSolde.' <b>'.$this->getSolde().' '.$this->getDevise().'</b></div>'.
        '</div>';
        return $ficheCompte;
    }

    /**
     * @return string
     */
    public function ficheCompte() : string {
        $ficheCompte = '';
        /* on utilise un ternaire pour définir l'état du solde créditeur ou débiteur */
        $etatSolde = ( $this->getSolde() < 0 )? 'débiteur':'créditeur';
        $ficheCompte = '
        <div class="my-2"><b>'.$this->typeCompte().'</b></div>
        <div class="my-2"><b>'.$this->getNom(). ' '. $this->getPrenom() .'</b></div>
        <div class="my-2">Agence n°<b>'.$this->getNumagence().'</b></div>
        <div class="my-2">RIB : <b>'.$this->getRib().'</b></div>
        <div class="my-2">IBAN : <b>'.$this->getIban().'</b></div>
        <div class="my-2">Compte : '. $etatSolde .' <b>' .$this->getSolde(). ' ' . $this->getDevise() . '</b></div>';
        return $ficheCompte;
    }

    /**
     * @return array
     */
    public function showAttr(): array{
        $tabAttr = get_object_vars($this);
        return $tabAttr;
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
            'decouvert' => $this->decouvert
        ];

        $sql = '
        INSERT INTO `compte` (
            `uniqueid`, `typecompte`, `nom`,
            `prenom`, `numcompte`, `numagence`,
            `rib`, `iban`, `solde`,
            `devise`, `decouvert`
        ) VALUES  (
            :uniqueid, :typecompte, :nom, 
            :prenom, :numcompte, :numagence,
            :rib, :iban, :solde,
            :devise, :decouvert
        );';
        Tools::modBdd($sql, $params);
    }

    public function modCompte(){
        $params = [
        'uniqueid' => $this->uniqueid,
        'nom' => $this->nom,
        'prenom' => $this->prenom,
        'numcompte' => $this->numcompte,
        'numagence' => $this->numagence,
        'rib' => $this->rib,
        'iban' => $this->iban,
        'solde' => $this->solde,
        'devise' => $this->devise,
        'decouvert' => $this->decouvert
        ];

        $sql = '
        UPDATE `compte` SET 
        `nom` = :nom,
        `prenom` = :prenom,
        `numcompte` = :numcompte,
        `numagence` = :numagence,
        `rib` = :rib,
        `iban` = :iban,
        `solde` = :solde,
        `devise` = :devise,
        `decouvert` = :decouvert
        WHERE `uniqueid` = :uniqueid;
        ';

        Tools::modBdd($sql, $params);
    }


    /**
     * Set the value of uniqueid
     *
     * @return  self
     */ 
    public function setUniqueid($uniqueid)
    {
        $this->uniqueid = $uniqueid;

        return $this;
    }
}