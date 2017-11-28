<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;

class ClassicGameOverDetector implements GameOverDetectorInterface
{

    /**
     * Check that board have more than one army
     */
    public function isOver(Game $game): bool
    {
        /**@var Army $lastArmy */
        $lastArmy = null;
        /**@var AbstractTile $tile */
        foreach ($game->getBoard()->getTiles() as $tile) {
            if ($tile->hasArmy()) {
                if (empty($lastArmy)) {
                    $lastArmy = $tile->getArmy();
                    continue;
                }

                if ($lastArmy->isSameOwner($tile->getArmy())) {
                    continue;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    public function getWinner(Game $game): PlayerInterface
    {
        // TODO: Implement getWinner() method.
    }

    public function getLoser(Game $game): PlayerInterface
    {
        // TODO: Implement getLoser() method.
    }
}