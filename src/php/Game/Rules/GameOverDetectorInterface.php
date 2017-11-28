<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;

interface GameOverDetectorInterface
{

    public function isOver(Game $game): bool;

    public function getWinner(Game $game): PlayerInterface;

}