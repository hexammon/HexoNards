<?php

namespace FreeElephants\HexoNards\Board;

use FreeElephants\HexoNards\Board\Exception\TileOutOfBoundsException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Board
{

    const TYPE_HEX = 'hex';
    const TYPE_SQUARE = 'square';

    private $type;
    /**
     * @var array|Row[]
     */
    private $rows;
    /**
     * @var array|AbstractTile[]
     */
    private $tiles;
    /**
     * @var array
     */
    private $columns;

    /**
     * Board constructor.
     * @param string $type
     * @param array|AbstractTile[] $tiles
     * @param array|Row[] $rows
     * @param array|Column[] $columns
     */
    public function __construct(string $type, array $tiles, array $rows, array $columns)
    {
        $this->type = $type;
        $this->tiles = $tiles;
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array|AbstractTile
     */
    public function getTiles(): array
    {
        return $this->tiles;
    }

    public function getTileByCoordinates(string $coordinates)
    {
        if (array_key_exists($coordinates, $this->tiles)) {
            return $this->tiles[$coordinates];
        }

        throw new TileOutOfBoundsException(sprintf('Tile with coordinates %s does not exists on this board. ',
            $coordinates));
    }

    public function getFirstRow(): Row
    {
        return $this->rows[1];
    }

    public function getLastRow(): Row
    {
        return $this->rows[count($this->rows)];
    }

    /**
     * @return array|Row[]
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return array|Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}