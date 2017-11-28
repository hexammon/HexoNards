<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Exception\DomainException;
use Hexammon\HexoNards\Game\Action\Exception\InapplicableActionException;
use Hexammon\HexoNards\Game\Castle;
use Hexammon\HexoNards\Game\Exception\AttackItSelfException;
use Hexammon\HexoNards\Game\PlayerInterface;

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