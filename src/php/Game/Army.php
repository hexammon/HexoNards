<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Board\Tile;

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
     * @var Tile
     */
    private $tile;

    public function __construct(Player $owner, Tile $tile, int $numberOfUnits)
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

    public function getTile(): Tile
    {
        return $this->tile;
    }

    public function setTile(Tile $newTile)
    {
        $this->tile = $newTile;
    }

    public function move(Tile $newTile)
    {
        $this->tile->resetArmy();
        $this->tile = $newTile;
    }
}