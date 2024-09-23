<?php

namespace Utrain;

class PublicUser implements Utrain{
    protected $nomUtilisateur;
    protected $statut;
    protected $prixAbo;

    public function __construct($nom, $statut = ''){
        $this->nomUtilisateur = $nom;
        $this->statut = $statut;
    }
    public function getNomUtilisateur(){
        echo $this->nomUtilisateur;
    }
    public function getPrixAbo(){
        echo $this->prixAbo;
    }
    public function setPrixAbo(){
        if($this->statut === 'Police'){
            return $this->prixAbo = Utrain::PRIXABO / 2;
        }else{
            return $this->prixAbo = Utrain::PRIXABO;
        }
    }
}