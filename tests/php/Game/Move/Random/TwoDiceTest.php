<?php

namespace Hexammon\HexoNardsTests\Game\Move\Random;

use Hexammon\HexoNards\Game\Move\Random\TwoDice;
use Hexammon\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TwoDiceTest extends AbstractTestCase
{

    public function testRandom()
    {
        $twoDice = new TwoDice();
        $random = $twoDice->random();

        $variants = range(2, 12);

        $this->assertContains($random, $variants);
    }
}