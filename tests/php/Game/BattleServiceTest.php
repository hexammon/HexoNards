<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Exception\DomainException;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\BattleService;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleServiceTest extends AbstractTestCase
{

    public function testAttack()
    {
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);

        $defender = $this->createMock(Player::class);
        $defenderTile = $this->createTile();
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
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createMock(AbstractTile::class);
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);

        $defender = $this->createMock(Player::class);
        $defenderTile = $this->createTile();
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
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 1);

        $defender = $this->createMock(Player::class);
        $defenderTile = $this->createTile();
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
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 1);

        $defender = $this->createMock(Player::class);
        $defenderTile = $this->createTile();
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


    public function testAttackSelfOwnedException()
    {
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, $assaulterTile, 6);
        $assaulterTile->setArmy($assaulterArmy);

        $defender = $assaulter;
        $defenderTile = $this->createTile();
        $defenderArmy = new Army($defender, $defenderTile, 4);
        $defenderTile->setArmy($defenderArmy);

        $battleService = new BattleService();
        $this->expectException(DomainException::class);
        $battleService->attack($assaulterArmy, $defenderArmy);
    }
}