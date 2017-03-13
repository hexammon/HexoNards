<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Exception\DomainException;
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
            throw new ConstructOnOccupiedTileException('Castle already exists on this tile. ');
        }
        if(false === $tile->hasArmy()) {
            throw new DomainException('Constructing castle without garrison. ');
        } elseif($owner !== $tile->getArmy()->getOwner()) {
            throw new ConstructOnOccupiedTileException('Tile is occupied by enemy');
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

    public function getArmy(): Army
    {
        return $this->tile->getArmy();
    }
}