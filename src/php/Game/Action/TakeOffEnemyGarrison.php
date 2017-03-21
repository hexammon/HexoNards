<?php

namespace FreeElephants\HexoNards\Game\Action;

use FreeElephants\HexoNards\Exception\DomainException;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\PlayerInterface;
use FreeElephants\HexoNardsTests\Game\Action\Exception\InapplicableActionException;
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

    public function execute(PlayerInterface $player)
    {
        if(false === $this->castle->isUnderSiege()) {
            throw new DomainException('Castle not under siege. ');
        }

        if($player === $this->castle->getOwner()) {
            throw new AttackItSelfException();
        }

        $garrison = $this->castle->getArmy();
        if(1 === count($garrison)) {
            throw new InapplicableActionException('Cannot deducy last unit in garrison, castle should be assaulted. ');
        }
        $garrison->deduct(1);
    }
}