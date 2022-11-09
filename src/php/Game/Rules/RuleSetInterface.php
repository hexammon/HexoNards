<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\PlayerInterface;

interface RuleSetInterface
{

    public function getInitialSetting(): InitialSettingInterface;

    public function getMoveGenerator(): MoveGeneratorInterface;

    public function isGameOver(Game $game): bool;

    public function getWinner(Game $game): PlayerInterface;

    public function getActionVariantsCollector(): ActionVariantsCollectorInterface;
}
