<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\AbstractTile;
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
     * @var AbstractTile
     */
    private $tile;

    public function __construct(Player $owner, AbstractTile $tile)
    {
        $this->owner = $owner;
        if($tile->hasCastle()) {
            throw new ConstructOnOccupiedTileException();
        }
        $this->tile = $tile;
    }

    public function getOwner(): Player
    {
        return $this->owner;
    }

    public function getTile(): AbstractTile
    {
        return $this->tile;
    }

    public function isUnderSiege(): bool
    {
        foreach ($this->getTile()->getNearestTiles() as $tile) {
            if($tile->hasArmy()) {
                $garrison = $this->getTile()->getArmy();
                if($tile->getArmy()->isSameOwner($garrison)) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }
}