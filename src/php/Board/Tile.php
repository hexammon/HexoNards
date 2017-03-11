<?php

namespace FreeElephants\HexoNards\Board;

use FreeElephants\HexoNards\Game\Castle;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Tile
{
    /**
     * @var Row
     */
    private $row;
    /**
     * @var Column
     */
    private $column;
    /**
     * @var Castle
     */
    private $castle;

    public function __construct(Row $row, Column $column)
    {
        $row->addTile($this);
        $this->row = $row;
        $column->addTile($this);
        $this->column = $column;
    }

    public function getRow(): Row
    {
        return $this->row;
    }

    public function getColumn(): Column
    {
        return $this->column;
    }

    public function getCoordinates(): string
    {
        return $this->row->getNumber() . '.' . $this->column->getNumber();
    }

    public function hasCastle(): bool
    {
        return null !== $this->castle;
    }

    public function setCastle(Castle $castle)
    {
        $this->castle = $castle;
    }

    public function getCastle(): Castle
    {
        return $this->castle;
    }
}