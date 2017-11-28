<?php

namespace Hexammon\HexoNards\Game\Move;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MovesCounter implements \Countable
{

    /**
     * @var MoveGeneratorInterface
     */
    private $generator;
    /**
     * @var \Iterator
     */
    private $sequenceToSwitch;

    private $moves = 0;

    public function __construct(MoveGeneratorInterface $generator, \Iterator $sequenceToSwitch)
    {
        $this->generator = $generator;
        $this->sequenceToSwitch = $sequenceToSwitch;
        $this->moves = $generator->generate();
    }

    public function tick()
    {
        $this->moves--;
        if (0 === $this->moves) {
            $this->moves = $this->generator->generate();
            $this->sequenceToSwitch->next();
            if (false === $this->sequenceToSwitch->valid()) {
                $this->sequenceToSwitch->rewind();
            }
        }
    }

    public function getCurrent()
    {
        return $this->sequenceToSwitch->current();
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->moves;
    }
}