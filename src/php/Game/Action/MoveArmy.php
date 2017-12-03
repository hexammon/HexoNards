<?php

namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\Exception\InapplicableActionException;
use Hexammon\HexoNards\Game\Action\Exception\TouchForeignOwnException;
use Hexammon\HexoNards\Game\PlayerInterface;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class MoveArmy implements PlayerActionInterface
{
    /**
     * @var AbstractTile
     */
    private $source;
    /**
     * @var AbstractTile
     */
    private $target;
    /**
     * @var int
     */
    private $units;

    public function __construct(AbstractTile $source, AbstractTile $target, int $units = null)
    {
        $this->source = $source;
        $this->target = $target;
        $this->units = $units;
    }

    public function execute(PlayerInterface $player)
    {
        $army = $this->source->getArmy();
        if ($player !== $army->getOwner()) {
            throw new TouchForeignOwnException();
        }
        if ($this->source->hasCastle() && $this->units === $army->count()) {
            throw new InapplicableActionException('Can not leave castle without garrison. ');
        }

        if (isset($this->units) && $this->units !== $army->count()) {
            $army->divide($army->count() - $this->units);
        }

        if ($this->target->hasArmy()) {
            throw new InapplicableActionException('Can not move army to not empty tile. ');
        }

        $army->move($this->target);
    }
}