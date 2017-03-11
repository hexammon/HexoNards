<?php

namespace FreeElephants\HexoNards\Game;

use FreeElephants\HexoNards\Exception\DomainException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class BattleService
{

    const BOTH_ANNIHILATION = 0;
    const DRAW = 1;
    const ASSAULTER_WIN = 2;
    const DEFENDER_WIN = 3;

    public function attack(Army &$assaulter, Army &$defender)
    {
        $this->assertArmyOwnersNotSame($assaulter, $defender);

        $assaulterSize = count($assaulter);
        $defenderSize = count($defender);
        $losses = ceil(min($assaulterSize, $defenderSize) / 2);

        $battleResult = $this->calculateResult($losses, $assaulterSize, $defenderSize);
        switch ($battleResult) {
            case self::BOTH_ANNIHILATION:
                Army::destroy($defender);
                Army::destroy($assaulter);
                break;

            case self::DRAW:
                $assaulter->deduct($losses);
                $defender->deduct($losses);
                break;

            case self::ASSAULTER_WIN:
                $assaulter->deduct($losses);
                $assaulter->move($defender->getTile());
                Army::destroy($defender);
                break;

            case self::DEFENDER_WIN:
                Army::destroy($assaulter);
                $defender->deduct($losses);
                break;

            default:
                throw new DomainException('Unexpected battler result. ');
        }
    }

    private function assertArmyOwnersNotSame(Army $assaulter, Army $defender)
    {
        if ($assaulter->getOwner() === $defender->getOwner()) {
            throw new DomainException('Self attack detected. ');
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