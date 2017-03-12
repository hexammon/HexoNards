<?php

namespace FreeElephants\HexoNards\Board;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractTile
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
    /**
     * @var Army
     */
    private $army;

    public function __construct(Row $row, Column $column)
    {
        $this->row = $row;
        $this->column = $column;
        $row->addTile($this);
        $column->addTile($this);
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

    public function hasArmy(): bool
    {
        return null !== $this->army;
    }

    public function getArmy(): Army
    {
        return $this->army;
    }

    public function setArmy(Army $army)
    {
        $this->army = $army;
    }

    public function resetArmy()
    {
        $this->army = null;
    }

    /**
     * @return array|static[]
     */
    abstract public function getNearestTiles(): array;
}