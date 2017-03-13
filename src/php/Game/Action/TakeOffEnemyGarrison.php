<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Exception\DomainException;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Player;
use FreeElephants\HexoNardsTests\Game\Exception\AttackItSelfException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class TakeOffEnemyGarrison implements PlayerActionInterface
{

    /**
     * @var Castle
     */
    private $castle;

    public function __construct(Castle $castle)
    {
        $this->castle = $castle;
    }

    public function execute(Player $player)
    {
        if(false === $this->castle->isUnderSiege()) {
            throw new DomainException('Castle not under siege. ');
        }

        if($player === $this->castle->getOwner()) {
            throw new AttackItSelfException();
        }
        $this->castle->getArmy()->deduct(1);
    }
}