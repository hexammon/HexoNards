<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Game\Action\Variant\Assault;
use Hexammon\HexoNards\Game\Action\Variant\Attack;
use Hexammon\HexoNards\Game\Action\Variant\FoundCastle;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Action\Variant\Spawn;
use Hexammon\HexoNards\Game\Rules\ActionVariantsCollectionInterface;

class ActionVariantsCollection implements ActionVariantsCollectionInterface
{
    private array $spawnVariants = [];
    private array $moveVariants = [];
    private array $attackVariants = [];
    private array $assaultVariants = [];
    private array $buildCastle = [];
    private array $takeOffEnemyGarrison = [];

    public function addSpawn(Spawn $spawn)
    {
        $this->spawnVariants[] = $spawn;
    }

    public function addMovement(Movement $move)
    {
        $this->moveVariants[] = $move;
    }

    public function hasSpawn(): bool
    {
        return count($this->spawnVariants) > 0;
    }

    public function hasMovement(): bool
    {
        return count($this->moveVariants) > 0;
    }

    public function addBuildCastle(FoundCastle $buildCastle): void
    {
        $this->buildCastle[] = $buildCastle;
    }

    public function hasBuildCastle(): bool
    {
        return count($this->buildCastle) > 0;
    }

    public function addAssault(Assault $assault): void
    {
        $this->assaultVariants[] = $assault;
    }

    public function hasAssaultCastle(): bool
    {
        return count($this->assaultVariants) > 0;
    }

    public function hasTakeOffEnemyGarrison(): bool
    {
        return count($this->takeOffEnemyGarrison) > 0;
    }

    public function hasAttack(): bool
    {
        return count($this->attackVariants) > 0;
    }

    public function getSpawnVariants(): array
    {
        return $this->spawnVariants;
    }

    public function getMovementVariants(): array
    {
        return $this->moveVariants;
    }

    public function addAttackVariant(Attack $attack): void
    {
        $this->attackVariants[] = $attack;
    }
}
