<?php

namespace FreeElephants\HexoNards\Game\Rules;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Game;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ClassicInitialSetting implements InitialSettingInterface
{

    public function arrangePieces(Game $game)
    {
        $players = $game->getPlayers();
        $player1 = $players[0];
        $player2 = $players[1];


        $topTile = $game->getBoard()->getFirstRow()->getLastTile();
        new Army($player1, $topTile, 1);
        new Castle($topTile);
        $bottomTile = $game->getBoard()->getLastRow()->getFirstTile();
        new Army($player2, $bottomTile, 1);
        new Castle($bottomTile);
    }
}