<?php

namespace Hexammon\HexoNardsTests\Game\Move\Random;

use Hexammon\HexoNards\Game\Move\Random\RandomInterface;
use Hexammon\HexoNards\Game\Move\Random\RandomMoveGeneratorAdapter;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class RandomMoveGeneratorAdapterTest extends AbstractTestCase
{

    public function testGenerate()
    {
        $random = $this->createMock(RandomInterface::class);
        $random->expects($randomSpy = $this->any())->method('random');
        $adapter = new RandomMoveGeneratorAdapter($random);
        $adapter->generate();
        $adapter->generate();
        $this->assertSame(2, $randomSpy->getInvocationCount());
    }
}