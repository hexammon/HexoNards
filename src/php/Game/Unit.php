<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Tile;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Unit
{
    /**
     * @var Player
     */
    private $owner;
    /**
     * @var Tile
     */
    private $tile;

    public function __construct(Player $owner, Tile $tile)
    {
        $this->owner = $owner;
        $this->tile = $tile;
    }

    /**
     * @return Player
     */
    public function getOwner(): Player
    {
        return $this->owner;
    }

    public function move(Tile $tile)
    {
        $this->tile  = $tile;
    }

    public function getTile(): Tile
    {
        return $this->tile;
    }
}