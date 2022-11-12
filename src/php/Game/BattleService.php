<?php

namespace Hexammon\HexoNards\Game;

use Hexammon\HexoNards\Exception\DomainException;

/**
 * @author samizdam <samizdam@inbox.ru>
 * TODO extract interface and move this implementation to Classic Ruleset
 */
class BattleService
{

    const BOTH_ANNIHILATION = 0;
    const DRAW = 1;
    const ASSAULTER_WIN = 2;
    const DEFENDER_WIN = 3;

    public function attack(Army &$assaulter, Army &$defender)
    {
        if ($assaulter->isSameOwner($defender)) {
            throw new DomainException('Self attack detected. ');
        }

        $assaulterSize = count($assaulter);
        $defenderSize = count($defender);
        $losses = ceil(min($assaulterSize, $defenderSize) / 2);

        $battleResult = $this->calculateResult($losses, $assaulterSize, $defenderSize);
        switch ($battleResult) {
            case self::BOTH_ANNIHILATION:
                if (!$assaulter->getTile()->hasCastle()) {
                    Army::destroy($defender);
                    Army::destroy($assaulter);
                } else {
                    if ($assaulter->count() > $losses) {
                        $assaulter->deduct($losses);
                    }
                    Army::destroy($defender);
                }
                break;

            case self::DRAW:
                $assaulter->deduct($losses);
                $defender->deduct($losses);
                break;

            case self::ASSAULTER_WIN:
                $newTile = $defender->getTile();
                Army::destroy($defender);
                if (!$assaulter->getTile()->hasCastle()) {
                    $assaulter->move($newTile);
                }
                $assaulter->deduct($losses);
                break;

            case self::DEFENDER_WIN:
                Army::destroy($assaulter);
                $defender->deduct($losses);
                break;

            default:
                throw new DomainException('Unexpected battler result. '); // @codeCoverageIgnore
        }
    }

    private function calculateResult(int $losses, int $assaulterSize, int $defenderSize): int
    {
        if ($losses === $assaulterSize && $losses === $defenderSize) {
            return self::BOTH_ANNIHILATION;
        } elseif ($losses >= $defenderSize) {
            return self::ASSAULTER_WIN;
        } elseif ($losses >= $assaulterSize) {
            return self::DEFENDER_WIN;
        }

        return self::DRAW;
    }
}
