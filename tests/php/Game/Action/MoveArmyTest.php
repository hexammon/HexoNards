<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Board\Square\Tile;
use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Action\MoveArmy;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;
use FreeElephants\HexoNardsTests\Game\Action\Exception\InapplicableActionException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveArmyTest extends AbstractTestCase
{

    public function testExecute()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createMock(Tile::class);
        $targetTile = $this->createTileWithMocks();
        $sourceTile->method('getNearestTiles')->willReturn([$targetTile]);
        $army = new Army($player, $sourceTile, 20);
        $sourceTile->method('getArmy')->willReturn($army);

        $command = new MoveArmy($sourceTile, $targetTile, 20);

        $command->execute($player);

        $this->assertSame($targetTile, $army->getTile());
    }

    public function testExecuteWithDivision()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createMock(Tile::class);
        $targetTile = $this->createTileWithMocks();
        $sourceTile->method('getNearestTiles')->willReturn([$targetTile]);
        $sourceTile->expects($sourceTileSpy = $this->any())->method('setArmy');
        $army = new Army($player, $sourceTile, 20);
        $sourceTile->method('getArmy')->willReturn($army);

        $command = new MoveArmy($sourceTile, $targetTile, 15);

        $command->execute($player);

        $this->assertCount(15, $army);
        $this->assertSame($targetTile, $army->getTile());
        $this->assertSame($army, $targetTile->getArmy());

        $remainingArmyTileSpy = $sourceTileSpy->getInvocations()[1];
        $remainingArmy = $remainingArmyTileSpy->parameters[0];
        $this->assertCount(5, $remainingArmy);
        $this->assertSame($sourceTile, $remainingArmy->getTile());
    }

    public function testMoveForeignArmyException()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createTileWithMocks();
        $otherPlayer = $this->createMock(Player::class);
        $army = new Army($otherPlayer, $sourceTile, 20);
        $sourceTile->setArmy($army);
        $targetTile = $this->createTileWithMocks();
        $command = new MoveArmy($sourceTile, $targetTile, 10);
        $this->expectException(TouchForeignOwnException::class);
        $command->execute($player);
    }

    public function testMoveLastUnitFromCastleException()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createMock(Tile::class);
        $targetTile = $this->createTileWithMocks();
        $sourceTile->method('getNearestTiles')->willReturn([$targetTile]);
        $army = new Army($player, $sourceTile, 20);
        $sourceTile->method('getArmy')->willReturn($army);
        $sourceTile->method('hasCastle')->willReturn(true);
        $command = new MoveArmy($sourceTile, $targetTile, 20);
        $this->expectException(InapplicableActionException::class);
        $command->execute($player);
    }

}