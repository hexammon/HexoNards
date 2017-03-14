<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MergeArmy implements PlayerActionInterface
{

    /**
     * @var Army
     */
    private $sourceArmy;
    /**
     * @var Army
     */
    private $targetArmy;

    public function __construct(Army &$sourceArmy, Army &$targetArmy)
    {
        $this->sourceArmy = &$sourceArmy;
        $this->targetArmy = &$targetArmy;
    }

    public function execute(Player $player)
    {
        $targetTile = $this->targetArmy->getTile();
        $unionArmy = Army::merge($this->sourceArmy, $this->targetArmy);
        $targetTile->setArmy($unionArmy);
    }
}