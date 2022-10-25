<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\AssaultCastle;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Castle;

class Assault implements ActionVariantInterface
{

    private Castle $castle;
    private Army $army;

    public function __construct(Castle $castle, Army $army)
    {
        $this->castle = $castle;
        $this->army = $army;
    }

    public function makeAction(): PlayerActionInterface
    {
        return new AssaultCastle($this->castle, $this->army);
    }

    public function getTargetTile(): AbstractTile
    {
        return $this->castle->getTile();
    }

    public function getSourceTile(): AbstractTile
    {
        return $this->army->getTile();
    }
}
