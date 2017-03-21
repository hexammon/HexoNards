<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\PlayerInterface;

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

    public function execute(PlayerInterface $player)
    {
        new Castle($this->tile);
    }
}