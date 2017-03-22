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
     * @var array|Column
     */
    private $cols;
    /**
     * @var array|AbstractTile[]
     */
    private $tiles;

    /**
     * Board constructor.
     * @param string $type
     * @param array|AbstractTile[] $tiles
     */
    public function __construct(string $type, array $tiles)
    {
        $this->type = $type;
        $this->tiles = $tiles;
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
}