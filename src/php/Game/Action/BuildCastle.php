<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BuildCastle implements PlayerActionInterface
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