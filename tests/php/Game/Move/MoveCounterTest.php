<?php

namespace FreeElephants\HexoNardsTests\Game\Move;

use FreeElephants\HexoNards\Game\Move\MoveGeneratorInterface;
use FreeElephants\HexoNards\Game\Move\MovesCounter;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveCounterTest extends AbstractTestCase
{

    public function testTick()
    {
        $generator = new class implements MoveGeneratorInterface{

            public function generate(): int
            {
                return 1;
            }
        };
        $counter = new MovesCounter($generator, new \ArrayIterator(['A', 'B', 'C']));
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(1, $counter);
        $counter->tick();
        $this->assertSame('B', $counter->getCurrent());
        $this->assertCount(1, $counter);
        $counter->tick();
        $this->assertSame('C', $counter->getCurrent());
        $this->assertCount(1, $counter);
        $counter->tick();
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(1, $counter);
    }
}