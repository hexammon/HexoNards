<?php

namespace FreeElephants\HexoNardsTests\Game\Action;

use FreeElephants\HexoNards\Board\Square\Tile;
use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Action\MoveArmy;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveArmyTest extends AbstractTestCase
{

    public function testExecute()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createMock(Tile::class);
        $targetTile = $this->createTile();
        $sourceTile->method('getNearestTiles')->willReturn([$targetTile]);
        $army = new Army($player, $sourceTile, 20);
        $sourceTile->method('getArmy')->willReturn($army);

        $command = new MoveArmy($player, $sourceTile, $targetTile, 10);

        $command->execute();

        $this->assertSame($targetTile, $army->getTile());
    }

    public function testMoveForeignArmyException()
    {
        $player = $this->createMock(Player::class);
        $sourceTile = $this->createTile();
        $otherPlayer = $this->createMock(Player::class);
        $army = new Army($otherPlayer, $sourceTile, 20);
        $sourceTile->setArmy($army);
        $targetTile = $this->createTile();
        $command = new MoveArmy($player, $sourceTile, $targetTile, 10);
        $this->expectException(TouchForeignOwnException::class);
        $command->execute();
    }

}