<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Exception\InvalidArgumentException;
use FreeElephants\HexoNards\Game\Exception\MoveToOccupiedTileException;
use FreeElephants\HexoNardsTests\Game\Exception\TooMuchDistanceException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Army implements \Countable
{

    /**
     * @var Player
     */
    private $owner;
    /**
     * @var int
     */
    private $numberOfUnits;
    /**
     * @var AbstractTile
     */
    private $tile;
    /**
     * @var bool
     */
    private $destroyed = false;

    public function __construct(Player $owner, AbstractTile $tile, int $numberOfUnits)
    {
        $this->owner = $owner;
        $this->tile = $tile;
        $this->tile->setArmy($this);
        $this->numberOfUnits = $numberOfUnits;
    }

    public function count()
    {
        return $this->numberOfUnits;
    }

    public static function merge(Army &$army, Army &$anotherArmy): Army
    {
        $newArmy = new self($army->getOwner(), $army->getTile(), $army->numberOfUnits + $anotherArmy->numberOfUnits);
        $army = null;
        $anotherArmy = null;
        return $newArmy;
    }

    public static function destroy(self &$army)
    {
        $army->destroyed = true;
        $army->getTile()->resetArmy();
        $army = null;
    }

    public function deduct(int $losses)
    {
        $this->numberOfUnits -= $losses;
    }

    public function getOwner(): Player
    {
        return $this->owner;
    }

    public function getTile(): AbstractTile
    {
        return $this->tile;
    }

    public function isSameOwner(Army $anotherArmy): bool
    {
        return $this->owner === $anotherArmy->getOwner();
    }

    public function move(AbstractTile $newTile)
    {
        if ($newTile->hasArmy()) {
            throw new MoveToOccupiedTileException();
        }

        if (false === in_array($newTile, $this->tile->getNearestTiles(), true)) {
            throw new TooMuchDistanceException();
        }

        $this->tile->resetArmy();
        $this->tile = $newTile;
        $newTile->setArmy($this);
    }

    public function replenish(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Value for replenish must be greater than 0. ');
        }
        $this->numberOfUnits += $value;
    }

    public function isDestroyed()
    {
        return $this->destroyed;
    }
}