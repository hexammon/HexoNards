<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Game\Action\PlayerActionInterface;
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

    public function testInvoke()
    {
        $player1 = $this->createMock(Player::class);
        $player2 = $this->createMock(Player::class);
        $board = $this->createMock(Board::class);
        $game = new Game([
            $player1,
            $player2
        ], $board);

        $command = $this->createMock(PlayerActionInterface::class);
        $command->expects($commandSpy = $this->any())->method('execute');
        $game->invoke($command);
        $this->assertSame(1, $commandSpy->getInvocationCount());
        $this->assertSame($player1, $commandSpy->getInvocations()[0]->parameters[0]);
    }


}