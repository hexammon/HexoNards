<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveArmy implements PlayerActionInterface
{
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

    public function __construct(AbstractTile $source, AbstractTile $target, int $units = null)
    {
        $this->source = $source;
        $this->target = $target;
        $this->units = $units;
    }

    public function execute(Player $player)
    {
        $army = $this->source->getArmy();
        if($player !== $army->getOwner()) {
            throw new TouchForeignOwnException();
        }

        $army->move($this->target);
    }
}