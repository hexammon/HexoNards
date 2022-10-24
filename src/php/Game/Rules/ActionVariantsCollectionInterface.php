<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Rules;

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

    public function hasBuildCastle(): bool;

    public function hasAssaultCastle(): bool;

    public function hasTakeOffEnemyGarrison(): bool;

    public function hasAttack(): bool;

    /**
     * @return array|Movement[]
     */
    public function getMovementVariants(): array;
}
