<?php

namespace FreeElephants\HexoNardsTests;

use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNards\Board\Square\Tile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected function createTile(int $rowNumber = 1, int $colNumber = 1): Tile
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