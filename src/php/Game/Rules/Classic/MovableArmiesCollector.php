<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Rules\Classic;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\MovableArmiesCollectorInterface;

class MovableArmiesCollector implements MovableArmiesCollectorInterface
{

    public function getMovableArmies(Board $board, PlayerInterface $player): array
    {
        $armies = [];
        foreach ($board->getTiles() as $tile) {
            if ($tile->hasArmy() && $tile->getArmy()->getOwner() === $player) {
                if ($tile->hasCastle() && $tile->getArmy()->count() === 1) {
                    continue;
                }
                $tilesForMove = array_filter($tile->getNearestTiles(), function (AbstractTile $nearestTile) use ($player) {
                    return !$nearestTile->hasArmy() || $nearestTile->getArmy()->getOwner() === $player;
                });
                if (count($tilesForMove)) {
                    $armies[] = $tile->getArmy();
                }
            }
        }

        return $armies;
    }
}
