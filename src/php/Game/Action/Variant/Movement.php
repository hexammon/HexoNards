<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action\Variant;

use Hexammon\HexoNards\Board\AbstractTile;
use Hexammon\HexoNards\Game\Action\MergeArmy;
use Hexammon\HexoNards\Game\Action\MoveArmy;
use Hexammon\HexoNards\Game\Action\PlayerActionInterface;
use Hexammon\HexoNards\Game\Army;

class Movement implements UnitVolumeAwareActionVariantInterface
{
    private AbstractTile $source;
    private AbstractTile $target;
    private int $units;

    public function __construct(AbstractTile $source, AbstractTile $target)
    {
        $this->source = $source;
        $this->target = $target;
    }

    public function getSource(): AbstractTile
    {
        return $this->source;
    }

    public function getTarget(): AbstractTile
    {
        return $this->target;
    }

    public function makeAction(): PlayerActionInterface
    {
        if (empty($this->units)) {
            throw new \LogicException('Units volume required for this action');
        }
        if ($this->target->hasArmy()) {
            $sourceArmy = $this->source->getArmy();
            $targetArmy = $this->target->getArmy();
            if($sourceArmy->count() === $this->units) {
                $this->source->resetArmy();
                return new MergeArmy($sourceArmy, $targetArmy);
            } else {
                $sourceArmy->deduct($this->units);
                $division = new Army($sourceArmy->getOwner(), $this->target, $this->units);
                return new MergeArmy($division, $targetArmy);
            }
        }

        return new MoveArmy($this->source, $this->target, $this->units);
    }

    public function setUnitsVolume(int $units): void
    {
        $this->units = $units;
    }
}
