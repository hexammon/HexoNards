<?php

namespace Hexammon\HexoNardsTests\Game\Move;

use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\Move\MovesCounter;
use Hexammon\HexoNardsTests\AbstractTestCase;

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
                return 2;
            }
        };
        $counter = new MovesCounter($generator, new \ArrayIterator(['A', 'B', 'C']));
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(2, $counter);

        $counter->tick();
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(1, $counter);

        $counter->tick();
        $this->assertSame('B', $counter->getCurrent());
        $this->assertCount(2, $counter);

        $counter->tick();
        $this->assertSame('B', $counter->getCurrent());
        $this->assertCount(1, $counter);

        $counter->tick();
        $this->assertSame('C', $counter->getCurrent());
        $this->assertCount(2, $counter);

        $counter->tick();
        $this->assertSame('C', $counter->getCurrent());
        $this->assertCount(1, $counter);

        $counter->tick();
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(2, $counter);

        $counter->tick();
        $this->assertSame('A', $counter->getCurrent());
        $this->assertCount(1, $counter);
    }
}