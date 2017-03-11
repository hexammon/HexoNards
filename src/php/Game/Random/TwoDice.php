<?php

namespace FreeElephants\HexoNards\Game\Random;

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