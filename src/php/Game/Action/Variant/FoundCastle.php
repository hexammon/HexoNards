<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\BuildCastle;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;

class FoundCastle implements ActionVariantInterface
{

    private AbstractTile $tile;

    public function __construct(AbstractTile $tile)
    {
        $this->tile = $tile;
    }

    public function makeAction(): PlayerActionInterface
    {
        return new BuildCastle($this->tile);
    }

    public function getTargetTile(): AbstractTile
    {
        return $this->tile;
    }
}
