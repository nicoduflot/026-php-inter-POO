<?php

namespace Wargame;

abstract class Troops
{
    /* 
    nbTroupes est utilisables par les classe enfants 
    mais ne sera pas accessible depuis l'extérieur de ces classes 
    protected au lieu de private 
    */
    protected int $nbTroops;

    public function __construct(
        protected int $army
    ) {}

    /* 
    on déclare la signature des classes abstraites : 
    elles ne sont pas implémentée dans la classe mère 
    mais DOIVENT l'être dans toutes les classes qui étendront Troupes 
    abstract
    */

    abstract public function calculNumberOfTroops(): void;
    abstract public function getRealNumberOfTroops(): int;

    public function getNbTroops(): int
    {
        return $this->nbTroops;
    }

}