<?php

namespace FreeElephants\HexoNardsTests\Board;

use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Board\BoardBuilder;
use FreeElephants\HexoNards\Board\Exception\UnknownBoardTypeException;
use FreeElephants\HexoNards\Board\Hex\Tile as HexTile;
use FreeElephants\HexoNards\Board\Square\Tile as SquareTile;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BoardBuilderTest extends AbstractTestCase
{

    public function testBuildHex()
    {
        $builder = new BoardBuilder();

        $board = $builder->build(Board::TYPE_HEX, 8, 8);

        $this->assertSame('hex', $board->getType());
        $this->assertCount(64, $board->getTiles());
        $this->assertContainsOnlyInstancesOf(HexTile::class, $board->getTiles());
    }

    public function testBuildSquare()
    {
        $builder = new BoardBuilder();

        $board = $builder->build(Board::TYPE_SQUARE, 8, 8);

        $this->assertSame('square', $board->getType());
        $this->assertCount(64, $board->getTiles());
        $this->assertContainsOnlyInstancesOf(SquareTile::class, $board->getTiles());
    }

    public function testBuildUnknownBoardTypeException()
    {
        $builder = new BoardBuilder();

        $this->expectException(UnknownBoardTypeException::class);

        $builder->build('foo', 8, 8);
    }

}