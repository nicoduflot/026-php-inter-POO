<?php

namespace Wargame;

use Wargame\TroopsFactory;

class Commandant
{
    /**
     * @var int[] $composition
     */
    private array $composition = [];

    public function __construct(
        private int $army
    ) {}

    /**
     * @param string[] $troops
     */
    public function determineTroops(array $troops): void
    {
        foreach ($troops as $troopClass) {
            $troop = TroopsFactory::recruit($troopClass, $this->army);

            $troop->calculNumberOfTroops();

            $this->composition[$troopClass] = $troop->getNbTroops();
            $this->army -= $troop->getRealNumberOfTroops();
        }
    }

    public function getComposition(): array
    {
        return $this->composition;
    }
}