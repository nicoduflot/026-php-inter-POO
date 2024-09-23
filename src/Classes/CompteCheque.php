<?php

namespace App;
use Utils\Tools;

class CompteCheque extends Compte{

    /* Attributs */
    private $carte;

    /**
     * Compte constructor
     * @param string $nom - le nom du détenteur du compte
     * @param string $prenom - le prénom du détenteur du compte
     * @param string $numcompte - le numéro
     * @param string $numagence - 
     * @param string $rib - 
     * @param string $iban - 
     * @param string $numcarte
     * @param string $codepin
     * @param float  $solde - 
     * @param float  $decouvert - 
     * @param string $devise - 
     */
    public function __construct(
        $nom,
        $prenom,
        $numcompte,
        $numagence,
        $rib,
        $iban,
        $numcarte,
        $codepin,
        $solde = 0,
        $decouvert = 0,
        $devise = '€',
        $uniqueid = null
        )
    {
        parent::__construct($nom, $prenom, $numcompte, $numagence, $rib, $iban, $solde, $decouvert, $devise, $uniqueid);
        $this->carte = new Carte($numcarte, $codepin);
    }

    /**
     * Get the value of carte
     */ 
    public function getCarte()
    {
        return $this->carte;
    }

    /* Méthode(s) de CompteCheque */
    public function payerparcarte($numcarte, $codepin, $montant, $destinataire){
        $message = '';
        if($this->getCarte()->getNumcarte() === $numcarte && $this->getCarte()->getCodepin() === $codepin){
            if($this->virement($montant, $destinataire)){
                $etatSolde = ($this->getSolde() <= 0)? 'débiteur' : 'créditeur';
                $message .= 'Un paiement de '. $montant . $this->getDevise() .' a été effectué vers le receveur '. $destinataire->getNom() . '<br />'.
                'Compte '. $etatSolde . ' : <b>'.$this->getSolde(). ' ' .$this->getDevise() . '</b>';
            }else{
                $message .= 'Une erreur est survenue lors de la tentative de paiement de '.$montant. ' vers le destinataire '. $destinataire->getNom(). '.';
            }
        }else{
            $message .= 'Une erreur est survenue lors de la tentative de paiement de '.$montant. ' vers le destinataire '. $destinataire->getNom(). '.';
        }
        return $message;
    }

    public function ficheCompte(): string
    {
        $ficheCompte = parent::ficheCompte();
        $ficheCompte .= '<div class="my-2">Numéro de carte : <b>'.$this->getCarte()->getNumcarte().'</b></div>';
        return $ficheCompte;
    }

    public static function generatePin(){
        $pin = ''. rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        return $pin;
    }

    public static function generateCardNumber(){
        $numcarte = ''. CompteCheque::generatePin() . ' ' . CompteCheque::generatePin() . ' ' . CompteCheque::generatePin() . ' ' . CompteCheque::generatePin();

        return $numcarte;
    }

    public function insertCompte(){
        /* avant d'enregistrer le compte en bdd, on enregistre sa carte qui se trouve dans $carte */
        $cardid = $this->getCarte()->insertcard();
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
            'cardid' => $cardid,
            'decouvert' => $this->decouvert
        ];

        $sql = '
        INSERT INTO `compte` (
            `uniqueid`, `typecompte`, `nom`,
            `prenom`, `numcompte`, `numagence`,
            `rib`, `iban`, `solde`,
            `devise`, `cardid`, `decouvert`
        ) VALUES  (
            :uniqueid, :typecompte, :nom, 
            :prenom, :numcompte, :numagence,
            :rib, :iban, :solde,
            :devise, :cardid, :decouvert
        );';
        Tools::modBdd($sql, $params);
    }
}