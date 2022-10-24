<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Action\ReplenishGarrison;
use Hexammon\HexoNards\Game\Castle;

class Spawn implements ActionVariantInterface
{

    private Castle $castle;

    public function __construct(Castle $castle)
    {
        $this->castle = $castle;
    }

    public function getTargetTile(): AbstractTile
    {
        return $this->castle->getTile();
    }

    public function makeAction(): PlayerActionInterface
    {
        return new ReplenishGarrison($this->castle->getArmy(), 1);
    }
}
