<?php

namespace Hexammon\HexoNards\Game\Rules\Classic;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Exception\GameNotOverException;
use Hexammon\HexoNards\Game\Rules\GameOverDetectorInterface;

class GameOverDetector implements GameOverDetectorInterface
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
        if ($this->isOver($game)) {
            /**@var AbstractTile $tile */
            foreach ($game->getBoard()->getTiles() as $tile) {
                if ($tile->hasArmy()) {
                    return $tile->getArmy()->getOwner();
                }
            }
        }

        throw new GameNotOverException();
    }

}
