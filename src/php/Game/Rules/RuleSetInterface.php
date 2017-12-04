<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;

interface RuleSetInterface
{

    public function getInitialSetting(): InitialSettingInterface;

    public function getMoveGenerator(): MoveGeneratorInterface;
}