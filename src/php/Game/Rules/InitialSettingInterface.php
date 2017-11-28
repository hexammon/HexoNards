<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Game;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface InitialSettingInterface
{

    /**
     * @return array|int[]
     */
    public function getSupportedNumberOfPlayers(): array;

    public function isSupportedNumberOfPlayers(int $numberOfPlayers): bool;

    public function arrangePieces(Game $game);
}