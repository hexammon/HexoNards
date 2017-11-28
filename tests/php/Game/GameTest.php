<?php

namespace Hexammon\HexoNardsTests\Game;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class GameTest extends AbstractTestCase
{

    public function testGetActivePlayer()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $movesGenerator->method('generate')->willReturn(1);

        $game = new Game([
            $player1,
            $player2
        ], $board, $movesGenerator);

        $this->assertSame($player1, $game->getActivePlayer());
    }

    public function testInvoke()
    {
        $player1 = $this->createMock(PlayerInterface::class);
        $player2 = $this->createMock(PlayerInterface::class);
        $board = $this->createMock(Board::class);
        $movesGenerator = $this->createMock(MoveGeneratorInterface::class);
        $movesGenerator->method('generate')->willReturn(1);
        $game = new Game([
            $player1,
            $player2
        ], $board, $movesGenerator);

        $command = $this->createMock(PlayerActionInterface::class);
        $command->expects($commandSpy = $this->any())->method('execute');
        $game->invoke($command);

        $this->assertSame(1, $commandSpy->getInvocationCount());
        $this->assertSame($player1, $commandSpy->getInvocations()[0]->parameters[0]);
        $this->assertSame($player2, $game->getActivePlayer());
    }


}