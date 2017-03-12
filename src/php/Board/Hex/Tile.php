<?php

namespace FreeElephants\HexoNards\Board\Hex;

use FreeElephants\HexoNards\Board\AbstractTile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Tile extends AbstractTile
{

    /**
     * @return array|static[]
     */
    public function getNearestTiles(): array
    {
        $tiles = [];
        /*
         * let this tile in the middle: e.g.: 2.2
         *       1.1   1.2   1.3
         *    2.1   2.2   2.3
         * 3.1   3.2   3.3
         */
        // go to row 1
        if ($this->getRow()->hasPrevious()) {
            $prevRow = $this->getRow()->getPrevious();
            if ($this->getColumn()->hasPrevious()) {
                $prevCol = $this->getColumn()->getPrevious();
                // 1.1
                $tiles[] = $prevRow->getTile($prevCol);
            }
            // 1.2
            $tiles[] = $prevRow->getTile($this->getColumn());

//            if ($this->getColumn()->hasNext()) {
//                // 1.3
//                $tiles[] = $prevRow->getTile($this->getColumn()->getNext());
//            }
        }
        // this row - 2
        if ($this->getColumn()->hasPrevious()) {
            // 2.1
            $tiles[] = $this->getRow()->getTile($this->getColumn()->getPrevious());
        }
        if ($this->getColumn()->hasNext()) {
            // 2.3
            $tiles[] = $this->getRow()->getTile($this->getColumn()->getNext());
        }

        // go to row 3
        if ($this->getRow()->hasNext()) {
            $nextRow = $this->getRow()->getNext();
//            if ($this->getColumn()->hasPrevious()) {
//                $prevCol = $this->getColumn()->getPrevious();
//                // 3.1
//                $tiles[] = $nextRow->getTile($prevCol);
//            }
            // 3.2
            $tiles[] = $nextRow->getTile($this->getColumn());

            if ($this->getColumn()->hasNext()) {
                // 3.3
                $tiles[] = $nextRow->getTile($this->getColumn()->getNext());
            }
        }

        return $tiles;
    }
}