<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Game\Game;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GameTest extends AbstractTestCase
{

    public function testGetActivePlayer()
    {
        $player1 = $this->createMock(Player::class);
        $player2 = $this->createMock(Player::class);
        $board = $this->createMock(Board::class);
        $game = new Game([
            $player1,
            $player2
        ], $board);

        $this->assertSame($player1, $game->getActivePlayer());
    }
}