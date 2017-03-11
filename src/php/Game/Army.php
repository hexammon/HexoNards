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

    public function __construct(Player $owner, int $numberOfUnits)
    {
        $this->owner = $owner;
        $this->numberOfUnits = $numberOfUnits;
    }

    public function count()
    {
        return $this->numberOfUnits;
    }

    public function join(Army $anotherArmy): Army
    {
        return new self($this->owner, $this->numberOfUnits + $anotherArmy->numberOfUnits);
    }

    public function deduct(int $losses)
    {
        $this->numberOfUnits -= $losses;
    }

    public function getOwner(): Player
    {
        return $this->owner;
    }
}