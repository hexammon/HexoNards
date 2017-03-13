<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BaseCastle implements PlayerActionInterface
{

    /**
     * @var AbstractTile
     */
    private $tile;

    public function __construct(AbstractTile $tile)
    {
        $this->tile = $tile;
    }

    public function execute(Player $player)
    {
        new Castle($player, $this->tile);
    }
}