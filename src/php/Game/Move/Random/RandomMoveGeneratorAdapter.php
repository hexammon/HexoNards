<?php

namespace Hexammon\HexoNards\Game\Move\Random;

use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;

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