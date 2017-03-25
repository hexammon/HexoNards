<?php

namespace FreeElephants\HexoNards\Game\Rules;

use FreeElephants\HexoNards\Game\Game;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface InitialSettingInterface
{
    public function arrangePieces(Game $game);
}