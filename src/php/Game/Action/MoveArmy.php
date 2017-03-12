<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveArmy
{

    /**
     * @var Player
     */
    private $player;
    /**
     * @var AbstractTile
     */
    private $source;
    /**
     * @var AbstractTile
     */
    private $target;
    /**
     * @var int
     */
    private $units;

    public function __construct(Player $player, AbstractTile $source, AbstractTile $target, int $units = null)
    {
        $this->player = $player;
        $this->source = $source;
        $this->target = $target;
        $this->units = $units;
    }

    public function execute()
    {
        $army = $this->source->getArmy();
        if($this->player !== $army->getOwner()) {
            throw new TouchForeignOwnException();
        }

        $army->move($this->target);
    }
}