<?php

namespace FreeElephants\HexoNards\Board;

use FreeElephants\HexoNards\Board\Exception\UnknownBoardTypeException;
use FreeElephants\HexoNards\Board\Hex\Tile as HexTile;
use FreeElephants\HexoNards\Board\Square\Tile as SquareTile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BoardBuilder
{

    public function build(string $type, int $numberOfRows, int $numberOfCols): Board
    {
        switch ($type) {
            case Board::TYPE_HEX:
                $tileClassName = HexTile::class;
                break;
            case Board::TYPE_SQUARE:
                $tileClassName = SquareTile::class;
                break;
            default:
                throw new UnknownBoardTypeException();
        }
        list($tiles, $rows, $columns) = $this->createGrid($numberOfRows, $numberOfCols, $tileClassName);
        return new Board($type, $tiles, $rows, $columns);
    }

    private function createGrid(int $numberOfRows, int $numberOfCols, string $tileClassName): array
    {
        $tiles = [];
        $rows = $this->createTileSetList($numberOfRows, Row::class);
        $columns = $this->createTileSetList($numberOfCols, Column::class);
        foreach ($rows as $rowNumber => $row) {
            foreach ($columns as $columnNumber => $column) {
                /** @var AbstractTile $newTile */
                $newTile = new $tileClassName($row, $column);
                $tiles[$newTile->getCoordinates()] = $newTile;
            }
        }

        return [$tiles, $rows, $columns];
    }

    private function createTileSetList(int $numberOfSets, string $tileSetClass)
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