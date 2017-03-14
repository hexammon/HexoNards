<?php

namespace FreeElephants\HexoNardsTests\Board\Hex;

use FreeElephants\HexoNards\Board\Column;
use FreeElephants\HexoNards\Board\Hex\Tile;
use FreeElephants\HexoNards\Board\Row;
use FreeElephants\HexoNardsTests\AbstractTestCase;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TileTest extends AbstractTestCase
{

    /*
     * test for tile 1.1
     *
     *     1.1   1.2
     * 2.1   2.2   2.3
     */
    public function testGetNearestTilesInLeftTopCorner()
    {
        $row1 = new Row(1);
        $row2 = new Row(2);
        $row1->setNext($row2);
        $column1 = new Column(1);
        $column2 = new Column(2);
        $column1->setNext($column2);

        $tile1_2 = new Tile($row1, $column2);
        $tile2_1 = new Tile($row2, $column1);
        $tile2_2 = new Tile($row2, $column2);
        // let's go from 1.1 tile
        $cornerTile = new Tile($row1, $column1);

        $nearestTiles = $cornerTile->getNearestTiles();
        $this->assertCount(3, $nearestTiles);
        $this->assertContains($tile1_2, $nearestTiles);
        $this->assertContains($tile2_2, $nearestTiles);
        $this->assertContains($tile2_1, $nearestTiles);
        $this->assertNotContains($cornerTile, $nearestTiles);
    }

    /*
     * test for tile 2.2
     *
     *       1.1   1.2    1.3
     *    2.1   2.2   2.3
     * 3.1   3.2   3.3
     */
    public function testGetNearestTilesForSurrounded()
    {
        $row1 = new Row(1);
        $row2 = new Row(2);
        $row3 = new Row(3);
        $row1->setNext($row2);
        $row2->setNext($row3);

        $col1 = new Column(1);
        $col2 = new Column(2);
        $col3 = new Column(3);
        $col1->setNext($col2);
        $col2->setNext($col3);

        $tile1_1 = new Tile($row1, $col1);
        $tile1_2 = new Tile($row1, $col2);
        $tile1_3 = new Tile($row1, $col3);

        $tile2_1 = new Tile($row2, $col1);
        $tile2_2 = new Tile($row2, $col2);
        $tile2_3 = new Tile($row2, $col3);

        $tile3_1 = new Tile($row3, $col1);
        $tile3_2 = new Tile($row3, $col2);
        $tile3_3 = new Tile($row3, $col3);

        $nearestTiles = $tile2_2->getNearestTiles();
        $this->assertCount(6, $nearestTiles);
        $this->assertArraySubset([
            $tile1_1,
            $tile1_2,
            $tile2_1,
            // exclude self
            $tile2_3,
            $tile3_2,
            $tile3_3,
        ], $nearestTiles);
        $this->assertNotContains($tile2_2, $nearestTiles);
    }

    /*
     * test for tile 1.2
     *
     *       1.1   1.2    1.3
     *    2.1   2.2   2.3
     * 3.1   3.2   3.3
     */
    public function testGetNearestTilesTopEdgeCase()
    {
        $row1 = new Row(1);
        $row2 = new Row(2);
        $row3 = new Row(3);
        $row1->setNext($row2);
        $row2->setNext($row3);

        $col1 = new Column(1);
        $col2 = new Column(2);
        $col3 = new Column(3);
        $col1->setNext($col2);
        $col2->setNext($col3);

        $tile1_1 = new Tile($row1, $col1);
        $tile1_2 = new Tile($row1, $col2);
        $tile1_3 = new Tile($row1, $col3);

        $tile2_1 = new Tile($row2, $col1);
        $tile2_2 = new Tile($row2, $col2);
        $tile2_3 = new Tile($row2, $col3);

        $tile3_1 = new Tile($row3, $col1);
        $tile3_2 = new Tile($row3, $col2);
        $tile3_3 = new Tile($row3, $col3);

        $nearestTiles = $tile1_2->getNearestTiles();
        $this->assertCount(4, $nearestTiles);
        $this->assertContains($tile1_1, $nearestTiles);
        $this->assertContains($tile2_2, $nearestTiles);
        $this->assertContains($tile2_3, $nearestTiles);
        $this->assertContains($tile1_3, $nearestTiles);
        $this->assertNotContains($tile1_2, $nearestTiles);
    }
}