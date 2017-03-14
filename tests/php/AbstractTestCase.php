<?php

namespace FreeElephants\HexoNardsTests;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNards\Board\Hex\Tile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected function createTileWithMocks($tileClassName = Tile::class): AbstractTile
    {
        $rowMock = $this->createMock(Row::class);
        $columnMock = $this->createMock(Column::class);
        /**
         * @var $rowMock Row
         * @var $columnMock Column
         */
        return new $tileClassName($rowMock, $columnMock);
    }

    /**
     * build list of tiles indexed by coordinates strings, e.g.
     * 1.1 => Tile,
     * 1.2 => Tile
     * 2.1 => Tile
     * @return AbstractTile[]
     */
    protected function createGrid(int $height, int $width, $tileClassName = Tile::class): array
    {
        $tiles = [];
        $rows = $this->createTileSetList($height, Row::class);
        $columns = $this->createTileSetList($width, Column::class);
        foreach ($rows as $rowNumber => $row) {
            foreach ($columns as $columnNumber => $column) {
                /** @var AbstractTile $newTile */
                $newTile = new $tileClassName($row, $column);
                $tiles[$newTile->getCoordinates()] = $newTile;
            }
        }

        return $tiles;
    }

    private function createTileSetList(int $numberOfSets, $tileSetClass)
    {
        $sets = [];
        for ($number = 1; $number <= $numberOfSets; $number++) {
            $newSet = new $tileSetClass($number);
            $sets[$number] = $newSet;
            $previousSetNumber = $number - 1;
            if(array_key_exists($previousSetNumber, $sets)) {
                $sets[$previousSetNumber]->setNext($newSet);
            }
        }

        return $sets;
    }
}