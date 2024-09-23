<?php

namespace Wargame;

class Cavaliers extends Troops
{
    public function calculNumberOfTroops(): void
    {
        $troops = floor($this->army / 200);

        $troops = floor($troops / 10);

        $this->nbTroops = (int) min([$troops, 200]);
    }

    public function getRealNumberOfTroops(): int
    {
        return $this->nbTroops * 1000;
    }
}