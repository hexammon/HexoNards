<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Game\Rules\Classic;

use Hexammon\HexoNards\Game\Action\ActionVariantsCollection;
use Hexammon\HexoNards\Game\Action\Variant\Assault;
use Hexammon\HexoNards\Game\Action\Variant\Attack;
use Hexammon\HexoNards\Game\Action\Variant\DeductEnemyGarrison;
use Hexammon\HexoNards\Game\Action\Variant\FoundCastle;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Action\Variant\Spawn;
use Hexammon\HexoNards\Game\BattleService;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Rules\ActionVariantsCollectionInterface;
use Hexammon\HexoNards\Game\Rules\ActionVariantsCollectorInterface;

class ActionVariantsCollector implements ActionVariantsCollectorInterface
{

    private BattleService $battleService;

    public function __construct(BattleService $battleService)
    {
        $this->battleService = $battleService;
    }

    public function getActionVariants(Game $game): ActionVariantsCollectionInterface
    {
        $player = $game->getActivePlayer();
        $board = $game->getBoard();

        $actionVariantsCollection = new ActionVariantsCollection();

        foreach ($board->getTiles() as $tile) {
            $hasCastle = $tile->hasCastle();
            if ($hasCastle) {
                $castle = $tile->getCastle();
                if ($castle->getOwner() === $player && !$castle->isUnderSiege()) {
                    $actionVariantsCollection->addSpawn(new Spawn($castle));
                } elseif ($castle->getOwner() !== $player && $castle->isUnderSiege()) {
                    if ($castle->getArmy()->count() === 1) {
                        foreach ($castle->getTile()->getNearestTiles() as $nearestTile) {
                            $actionVariantsCollection->addAssault(new Assault($castle, $nearestTile->getArmy()));
                        }
                    } else {
                        $actionVariantsCollection->addDeductEnemyGarrison(new DeductEnemyGarrison($castle));
                    }
                }
            }
        }

        $playerArmies = $board->getPlayerArmies($player);
        foreach ($playerArmies as $army) {
            $source = $army->getTile();
            foreach ($source->getNearestTiles() as $target) {
                if ($tile->hasCastle() && $tile->getArmy()->count() === 1) {
                    continue;
                }
                $enemyOnNearestTile = $target->hasArmy() && $target->getArmy()->getOwner() !== $player;
                if ($enemyOnNearestTile) {
                    $actionVariantsCollection->addAttackVariant(new Attack($army, $target->getArmy(), $this->battleService));
                } else {
                    $actionVariantsCollection->addMovement(new Movement($source, $target));
                }
            }
        }

        foreach ($playerArmies as $army) {
            $tile = $army->getTile();
            if ($tile->hasCastle()) {
                continue;
            }
            $canFound = true;
            foreach ($tile->getNearestTiles() as $nearestTile) {
                if ($nearestTile->hasCastle() || $nearestTile->hasArmy() && $nearestTile->getArmy()->getOwner() !== $player) {
                    $canFound = false;
                    break;
                }
                foreach ($nearestTile->getNearestTiles() as $secondDistanceTile) {
                    if ($secondDistanceTile->hasCastle() || $secondDistanceTile->hasCastle() && $secondDistanceTile->getArmy()->getOwner() !== $player) {
                        $canFound = false;
                        break 2;
                    }
                }
            }
            if ($canFound) {
                $actionVariantsCollection->addFoundCastle(new FoundCastle($tile));
            }
        }

        return $actionVariantsCollection;
    }

}
