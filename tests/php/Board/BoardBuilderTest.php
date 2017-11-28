<?php

namespace Hexammon\HexoNardsTests\Board;

use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Board\Exception\UnknownBoardTypeException;
use Hexammon\HexoNards\Board\Hex\Tile as HexTile;
use Hexammon\HexoNards\Board\Square\Tile as SquareTile;
use Hexammon\HexoNardsTests\AbstractTestCase;

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