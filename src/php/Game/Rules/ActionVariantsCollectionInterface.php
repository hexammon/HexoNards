<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Action\TakeOffEnemyGarrison;
use Hexammon\HexoNards\Game\Action\Variant\DeductEnemyGarrison;
use Hexammon\HexoNards\Game\Action\Variant\FoundCastle;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Action\Variant\Spawn;

interface ActionVariantsCollectionInterface /*extends \IteratorAggregate*/
{
    public function hasSpawn(): bool;

    /**
     * @return array|Spawn[]
     */
    public function getSpawnVariants(): array;

    public function hasMovement(): bool;

    /**
     * @return array|Movement[]
     */
    public function getMovementVariants(): array;

    public function hasFoundCastle(): bool;

    /**
     * @return array|FoundCastle[]
     */
    public function getFoundCastleVariants(): array;

    public function hasAssaultCastle(): bool;

    public function hasDeductEnemyGarrison(): bool;

    /**
     * @return array|DeductEnemyGarrison[]
     */
    public function getDeductEnemyGarrisonVariants(): array;

    public function hasAttack(): bool;
}
