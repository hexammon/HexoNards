<?php

namespace Hexammon\HexoNardsTests\Game;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\BattleService;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleServiceTest extends AbstractTestCase
{

    public function testAttack()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $assaulterTile = $this->createTileWithMocks();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);

        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $this->createTileWithMocks();
        $defenderArmy = new Army($defender, $defenderTile, 4);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check losses
        $this->assertCount(4, $assaulterArmy);
        $this->assertCount(2, $defenderArmy);
        // check positions after draw
        $this->assertSame($assaulterTile, $assaulterArmy->getTile());
        $this->assertSame($defenderTile, $defenderArmy->getTile());
    }

    public function testAttackWithAssaulterCompleteVictory()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $assaulterTile = $this->createMock(AbstractTile::class);
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);

        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $this->createTileWithMocks();
        $assaulterTile->method('getNearestTiles')->willReturn([$defenderTile]);
        $defenderArmy = new Army($defender, $defenderTile, 1);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check losses
        $this->assertCount(5, $assaulterArmy);
        $this->assertNull($defenderArmy);
        // check positions after victory
        $this->assertSame($defenderTile, $assaulterArmy->getTile());
        $this->assertFalse($assaulterTile->hasArmy());
    }

    public function testAttackWithDefenderCompleteVictory()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $assaulterTile = $this->createTileWithMocks();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 1);

        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $this->createTileWithMocks();
        $defenderArmy = new Army($defender, $defenderTile, 2);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check losses
        $this->assertCount(1, $defenderArmy);
        $this->assertNull($assaulterArmy);
        // check positions after battle
        $this->assertSame($defenderTile, $defenderArmy->getTile());
        $this->assertFalse($assaulterTile->hasArmy());
    }

    public function testAttackBothAnnihilation()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $assaulterTile = $this->createTileWithMocks();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 1);

        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $this->createTileWithMocks();
        $defenderArmy = new Army($defender, $defenderTile, 1);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check that armies are empties
        $this->assertNull($defenderArmy);
        $this->assertNull($assaulterArmy);
        // check that positions after battle is clear
        $this->assertFalse($defenderTile->hasArmy());
        $this->assertFalse($assaulterTile->hasArmy());
    }

    public function testAtackFromCastleWithAssaulterCompleteVictoryAndStayOn()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $board = (new BoardBuilder())->build('hex', 2, 2);
        $assaulterTile = $board->getTileByCoordinates('1.1');
        $assaulterArmy = new Army($assaulter, $assaulterTile, 2);
        $castle = new Castle($assaulterTile);
        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $board->getTileByCoordinates('1.2');
        $defenderArmy = new Army($defender, $defenderTile, 1);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check losses
        $this->assertCount(1, $assaulterArmy);
        $this->assertNull($defenderArmy);
        $this->assertFalse($defenderTile->hasArmy());
        // check positions after victory
        $this->assertSame($assaulterArmy, $castle->getArmy());
    }

    public function testAtackFromCastleWithAssaulterVictoryAndStayOn()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $board = (new BoardBuilder())->build('hex', 2, 2);
        $assaulterTile = $board->getTileByCoordinates('1.1');
        $assaulterArmy = new Army($assaulter, $assaulterTile, 1);
        $castle = new Castle($assaulterTile);
        $defender = $this->createMock(PlayerInterface::class);
        $defenderTile = $board->getTileByCoordinates('1.2');
        $defenderArmy = new Army($defender, $defenderTile, 1);

        $battleService = new BattleService();
        $battleService->attack($assaulterArmy, $defenderArmy);

        // check losses
        $this->assertCount(1, $assaulterArmy);
        $this->assertNull($defenderArmy);
        $this->assertFalse($defenderTile->hasArmy());
        // check positions after victory
        $this->assertSame($assaulterArmy, $castle->getArmy());
    }


    public function testAttackSelfOwnedException()
    {
        $assaulter = $this->createMock(PlayerInterface::class);
        $assaulterTile = $this->createTileWithMocks();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);
        $assaulterTile->setArmy($assaulterArmy);

        $defender = $assaulter;
        $defenderTile = $this->createTileWithMocks();
        $defenderArmy = new Army($defender, $defenderTile, 4);
        $defenderTile->setArmy($defenderArmy);

        $battleService = new BattleService();
        $this->expectException(DomainException::class);
        $battleService->attack($assaulterArmy, $defenderArmy);
    }
}