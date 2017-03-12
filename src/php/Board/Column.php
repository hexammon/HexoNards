<?php

namespace FreeElephants\HexoNards\Board;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Column extends AbstractTileSet
{

    public function addTile(AbstractTile $tile)
    {
        $this->tiles[$tile->getRow()->getNumber()] = $tile;
    }

    public function setNext(Column $column)
    {
        $this->next = $column;
        $column->previous = $this;
    }

    public function getPrevious(): Column
    {
        return $this->previous;
    }

    public function getNext(): Column
    {
        return $this->next;
    }
}