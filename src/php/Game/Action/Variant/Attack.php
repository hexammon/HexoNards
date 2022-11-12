<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\AttackEnemy;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\BattleService;

class Attack implements ActionVariantInterface
{

    private Army $assaulterArmy;
    private Army $attackedArmy;
    private BattleService $battleService;

    public function __construct(
        Army          $assaulterArmy,
        Army          $attackedArmy,
        BattleService $battleService
    )
    {
        $this->assaulterArmy = $assaulterArmy;
        $this->attackedArmy = $attackedArmy;
        $this->battleService = $battleService;
    }

    public function makeAction(): PlayerActionInterface
    {
        return new AttackEnemy($this->assaulterArmy, $this->attackedArmy, $this->battleService);
    }

    public function getSourceTile(): AbstractTile
    {
        return $this->assaulterArmy->getTile();
    }

    public function getTargetTile(): AbstractTile
    {
        return $this->attackedArmy->getTile();
    }
}
