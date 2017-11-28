<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface PlayerActionInterface
{

    public function execute(PlayerInterface $player);
}