<?php

namespace FreeElephants\HexoNardsTests\Game;

use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Exception\DomainException;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\BattleService;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testAttack()
    {
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, 6);
        $assaulterTile->setArmy($assaulterArmy);

        $defender = $this->createMock(Player::class);
        $defenderTile = $this->createTile();
        $defenderArmy = new Army($defender, 4);
        $defenderTile->setArmy($defenderArmy);

        $battleService = new BattleService();
        $battleService->attack($assaulterTile, $defenderTile);

        // check losses
        $this->assertCount(4, $assaulterArmy);
        $this->assertCount(2, $defenderArmy);
        // check positions after draw
        $this->assertSame($assaulterArmy, $assaulterTile->getArmy());
        $this->assertSame($defenderArmy, $defenderTile->getArmy());
    }

    public function testAttackSelfOwnedException()
    {
        $assaulter = $this->createMock(Player::class);
        $assaulterTile = $this->createTile();
        $assaulterArmy = new Army($assaulter, 6);
        $assaulterTile->setArmy($assaulterArmy);

        $defender = $assaulter;
        $defenderTile = $this->createTile();
        $defenderArmy = new Army($defender, 4);
        $defenderTile->setArmy($defenderArmy);

        $battleService = new BattleService();
        $this->expectException(DomainException::class);
        $battleService->attack($assaulterTile, $defenderTile);

    }


    private function createTile(): Tile
    {
        $rowMock = $this->createMock(Row::class);
        $columnMock = $this->createMock(Column::class);
        /**
         * @var $rowMock Row
         * @var $columnMock Column
         */
        return new Tile($rowMock, $columnMock);
    }
}