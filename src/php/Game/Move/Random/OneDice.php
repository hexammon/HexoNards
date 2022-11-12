<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Move\Random;

class OneDice implements RandomInterface
{
    public function random(): int
    {
        return rand(1, 6);
    }
}
