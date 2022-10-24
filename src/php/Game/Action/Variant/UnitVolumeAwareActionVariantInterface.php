<?php

namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Game\Action\PlayerActionInterface;

interface UnitVolumeAwareActionVariantInterface extends ActionVariantInterface
{
    public function setUnitsVolume(int $units): void;
}
