<?php

namespace Hexammon\HexoNards\Game\Move\Random;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TwoDice implements RandomInterface
{

    public function random(): int
    {
        return rand(2, 12);
    }
}