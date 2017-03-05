<?php

namespace FreeElephants\HexoNards\Board;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Row
{

    /**
     * @var Tile[]
     */
    private $tiles = [];

    /**
     * @var int
     */
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function addTile(Tile $tile)
    {
        $this->tiles[] = $tile;
    }

    public function getTiles()
    {
        return $this->tiles;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

}