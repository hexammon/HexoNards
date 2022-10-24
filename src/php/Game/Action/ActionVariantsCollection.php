<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Action;

use Hexammon\HexoNards\Game\Action\Variant\Assault;
use Hexammon\HexoNards\Game\Action\Variant\Attack;
use Hexammon\HexoNards\Game\Action\Variant\DeductEnemyGarrison;
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
    private array $foundCastleVariants = [];
    private array $deductEnemyGarrison = [];

    public function addSpawn(Spawn $spawn)
    {
        $this->spawnVariants[] = $spawn;
    }

    public function hasSpawn(): bool
    {
        return count($this->spawnVariants) > 0;
    }

    public function getSpawnVariants(): array
    {
        return $this->spawnVariants;
    }

    public function addMovement(Movement $move)
    {
        $this->moveVariants[] = $move;
    }

    public function hasMovement(): bool
    {
        return count($this->moveVariants) > 0;
    }

    public function getMovementVariants(): array
    {
        return $this->moveVariants;
    }

    public function addFoundCastle(FoundCastle $buildCastle): void
    {
        $this->foundCastleVariants[] = $buildCastle;
    }

    public function hasFoundCastle(): bool
    {
        return count($this->foundCastleVariants) > 0;
    }

    public function getFoundCastleVariants(): array
    {
        return $this->foundCastleVariants;
    }

    public function addAssault(Assault $assault): void
    {
        $this->assaultVariants[] = $assault;
    }

    public function hasAssaultCastle(): bool
    {
        return count($this->assaultVariants) > 0;
    }

    public function addDeductEnemyGarrison(DeductEnemyGarrison $deductEnemyGarrison): void
    {
        $this->deductEnemyGarrison[] = $deductEnemyGarrison;
    }

    public function hasDeductEnemyGarrison(): bool
    {
        return count($this->deductEnemyGarrison) > 0;
    }

    public function getDeductEnemyGarrisonVariants(): array
    {
        return $this->deductEnemyGarrison;
    }

    public function addAttackVariant(Attack $attack): void
    {
        $this->attackVariants[] = $attack;
    }

    public function hasAttack(): bool
    {
        return count($this->attackVariants) > 0;
    }
}
