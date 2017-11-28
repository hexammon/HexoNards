<?php

namespace Hexammon\HexoNardsTests\Game\Action;

use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Game\Action\Exception\InapplicableActionException;
use Hexammon\HexoNards\Game\Action\TakeOffEnemyGarrison;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Exception\AttackItSelfException;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TakeOffEnemyGarrisonTest extends AbstractTestCase
{

    public function testExecuteSuccess()
    {
        $player = $this->createMock(PlayerInterface::class);
        $otherPlayer = $this->createMock(PlayerInterface::class);
        $tile = $this->createTileWithMocks();
        $garrison = new Army($otherPlayer, $tile, 10);
        $castle = $this->createMock(Castle::class);
        $castle->method('getArmy')->willReturn($garrison);
        $castle->method('isUnderSiege')->willReturn(true);

        $command = new TakeOffEnemyGarrison($castle);
        $command->execute($player);

        $this->assertCount(9, $garrison);
    }

    public function testExecuteOnLastGarrisonUnitShouldBeAssaulted()
    {
        $player = $this->createMock(PlayerInterface::class);
        $otherPlayer = $this->createMock(PlayerInterface::class);
        $tile = $this->createTileWithMocks();
        $garrison = new Army($otherPlayer, $tile, 1);
        $castle = $this->createMock(Castle::class);
        $castle->method('getArmy')->willReturn($garrison);
        $castle->method('isUnderSiege')->willReturn(true);

        $command = new TakeOffEnemyGarrison($castle);
        $this->expectException(InapplicableActionException::class);
        $command->execute($player);
    }

    public function testExecuteOnNotBesieged()
    {
        $player = $this->createMock(PlayerInterface::class);
        $otherPlayer = $this->createMock(PlayerInterface::class);
        $tile = $this->createTileWithMocks();
        $garrison = new Army($otherPlayer, $tile, 10);
        $castle = $this->createMock(Castle::class);
        $castle->method('getArmy')->willReturn($garrison);
        $castle->method('isUnderSiege')->willReturn(false);

        $command = new TakeOffEnemyGarrison($castle);
        $this->expectException(DomainException::class);
        $command->execute($player);
    }

    public function testExecuteOnSelfOwnCastleException()
    {
        $player = $this->createMock(PlayerInterface::class);
        $tile = $this->createTileWithMocks();
        $garrison = new Army($player, $tile, 10);
        $castle = $this->createMock(Castle::class);
        $castle->method('getArmy')->willReturn($garrison);
        $castle->method('getOwner')->willReturn($player);
        $castle->method('isUnderSiege')->willReturn(true);

        $command = new TakeOffEnemyGarrison($castle);
        $this->expectException(AttackItSelfException::class);
        $command->execute($player);
    }
}