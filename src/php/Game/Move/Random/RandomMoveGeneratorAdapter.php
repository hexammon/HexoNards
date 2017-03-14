<?php

namespace FreeElephants\HexoNards\Game\Move\Random;

use FreeElephants\HexoNards\Game\Move\MoveGeneratorInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RandomMoveGeneratorAdapter implements MoveGeneratorInterface
{
    /**
     * @var RandomInterface
     */
    private $random;

    public function __construct(RandomInterface $random)
    {
        $this->random = $random;
    }

    public function generate(): int
    {
        return $this->random->random();
    }
}