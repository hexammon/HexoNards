<?php

namespace Hexammon\HexoNards\Board;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Row extends AbstractTileSet
{

    public function addTile(AbstractTile $tile)
    {
        $this->tiles[$tile->getColumn()->getNumber()] = $tile;
    }

    public function setNext(Row $row)
    {
        $this->next = $row;
        $row->previous = $this;
    }

    public function getNext(): Row
    {
        return $this->next;
    }

    public function getPrevious(): Row
    {
        return $this->previous;
    }

    public function getTile(Column $column): AbstractTile
    {
        return $this->tiles[$column->getNumber()];
    }

    public function getFirstTile()
    {
        return $this->tiles[1];
    }

}