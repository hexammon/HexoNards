<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\BattleService;
use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class AttackEnemy implements PlayerActionInterface
{

    /**
     * @var Army
     */
    private $assaulterArmy;
    /**
     * @var Army
     */
    private $attackedArmy;
    /**
     * @var BattleService
     */
    private $battleService;

    public function __construct(
        Army $assaulterArmy,
        Army $attackedArmy,
        BattleService $battleService = null
    ) {
        $this->assaulterArmy = $assaulterArmy;
        $this->attackedArmy = $attackedArmy;
        $this->battleService = $battleService ?: new BattleService();
    }

    public function execute(PlayerInterface $player)
    {
        $this->battleService->attack($this->assaulterArmy, $this->attackedArmy);
    }
}