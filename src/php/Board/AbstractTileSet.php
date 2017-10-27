<?php

namespace FreeElephants\HexoNards\Board;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
abstract class AbstractTileSet
{

    /**
     * @var AbstractTile[]
     */
    protected $tiles;
    /**
     * @var static
     */
    protected $next;
    /**
     * @var static
     */
    protected $previous;
    /**
     * @var int
     */
    protected $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTiles()
    {
        return $this->tiles;
    }

    public function hasNext(): bool
    {
        return null !== $this->next;
    }

    public function hasPrevious(): bool
    {
        return null !== $this->previous;
    }


    public function getLastTile(): AbstractTile
    {
        return $this->tiles[count($this->tiles)];
    }
}