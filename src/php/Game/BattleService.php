<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Exception\DomainException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleService
{

    public function attack(Army $assaulter, Army &$defender)
    {
        $this->assertArmyOwnersNotSame($assaulter, $defender);
        $assaulterTile = $assaulter->getTile();
        $defenderTile = $defender->getTile();
        $assaulterSize = count($assaulter);
        $defenderSize = count($defender);
        $losses = ceil(min($assaulterSize, $defenderSize) / 2);
        if ($losses >= $defenderSize) {
            $defender = null;
            $defenderTile->setArmy($assaulter);
            $assaulter->setTile($defenderTile);
            $assaulterTile->resetArmy();
        } else {
            $defender->deduct($losses);
        }
        $assaulter->deduct($losses);
    }

    private function assertArmyOwnersNotSame(Army $assaulter, Army $defender)
    {
        if ($assaulter->getOwner() === $defender->getOwner()) {
            throw new DomainException('Self attack detected. ');
        }
    }
}