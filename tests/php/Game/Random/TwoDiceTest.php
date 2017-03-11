<?php

namespace FreeElephants\HexoNardsTests\Game\Random;

use FreeElephants\HexoNards\Game\Random\TwoDice;
use FreeElephants\HexoNardsTests\AbstractTestCase;

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