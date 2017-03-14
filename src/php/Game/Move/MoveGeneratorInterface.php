<?php

namespace FreeElephants\HexoNards\Game\Move;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MoveGeneratorInterface
{

    public function generate(): int;
}