<?php

namespace Hexammon\HexoNards\Game;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Game\Exception\ConstructOnOccupiedTileException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Castle
{

    /**
     * @var AbstractTile
     */
    private $tile;

    public function __construct(AbstractTile $tile)
    {
        if($tile->hasCastle()) {
            throw new ConstructOnOccupiedTileException('Castle already exists on this tile. ');
        }
        if(false === $tile->hasArmy()) {
            throw new DomainException('Constructing castle without garrison. ');
        }
        $this->tile = $tile;
        $this->tile->setCastle($this);
    }

    public function getOwner(): PlayerInterface
    {
        return $this->getArmy()->getOwner();
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