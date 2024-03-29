<?php

namespace Hexammon\HexoNards\Game;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Exception\InvalidArgumentException;
use Hexammon\HexoNards\Game\Exception\MoveToOccupiedTileException;
use Hexammon\HexoNards\Game\Exception\TooMuchDistanceException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class Army implements \Countable
{

    /**
     * @var PlayerInterface
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

    public function __construct(PlayerInterface $owner, AbstractTile $tile, int $numberOfUnits)
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

    public static function merge(Army &$target, Army &$anotherArmy): Army
    {
        if (false === $target->isSameOwner($anotherArmy)) {
            throw new DomainException('Can not merge with enemy. ');
        }
        $newArmy = new self($target->getOwner(), $target->getTile(), $target->numberOfUnits + $anotherArmy->numberOfUnits);
        $target = null;
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

    public function getOwner(): PlayerInterface
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
        $tile = $this->getTile();
        if ($tile->hasCastle() && $tile->getCastle()->isUnderSiege()) {
            throw new DomainException('Can not replenish garrison under siege. ');
        }
        $this->numberOfUnits += $value;
    }

    public function isDestroyed()
    {
        return $this->destroyed;
    }

    public function divide(int $units)
    {
        $this->numberOfUnits -= $units;
        return new Army($this->owner, $this->tile, $units);
    }
}
