<?php

namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Game\Action\PlayerActionInterface;

interface ActionVariantInterface
{
    public function makeAction(): PlayerActionInterface;
}
