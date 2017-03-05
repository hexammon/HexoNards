<?php

namespace FreeElephants\HexoNards\Board;

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

    public function __construct(Row $row, Column $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    /**
     * @return Row
     */
    public function getRow(): Row
    {
        return $this->row;
    }

    /**
     * @return Column
     */
    public function getColumn(): Column
    {
        return $this->column;
    }
}