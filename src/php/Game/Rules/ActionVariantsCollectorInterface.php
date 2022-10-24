<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Game;

interface ActionVariantsCollectorInterface
{
    public function getActionVariants(Game $game): ActionVariantsCollectionInterface;
}
