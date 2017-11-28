<?php

namespace Hexammon\HexoNards\Game\Move;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
interface MoveGeneratorInterface
{

    public function generate(): int;
}