<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Game\Player;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface PlayerActionInterface
{

    public function execute(Player $player);
}