<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Game\PlayerInterface;

interface MovableArmiesCollectorInterface
{
    public function getMovableArmies(Board $board, PlayerInterface $player): array;
}
