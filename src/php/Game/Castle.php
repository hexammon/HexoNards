<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Tile;
use FreeElephants\HexoNards\Game\Exception\ConstructOnOccupiedTileException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Castle
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
        if($tile->hasCastle()) {
            throw new ConstructOnOccupiedTileException();
        }
        $this->tile = $tile;
    }

    /**
     * @return Player
     */
    public function getOwner(): Player
    {
        return $this->owner;
    }

    /**
     * @return Tile
     */
    public function getTile(): Tile
    {
        return $this->tile;
    }
}