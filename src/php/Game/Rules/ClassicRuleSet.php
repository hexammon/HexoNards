<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\Move\Random\RandomMoveGeneratorAdapter;
use Hexammon\HexoNards\Game\Move\Random\TwoDice;

class ClassicRuleSet implements RuleSetInterface
{

    private $initialSetting;
    private $moveGenerator;

    public function __construct()
    {
        $this->initialSetting = new ClassicInitialSetting();
        $this->moveGenerator = new RandomMoveGeneratorAdapter(new TwoDice());
    }

    public function getInitialSetting(): InitialSettingInterface
    {
        return $this->initialSetting;
    }

    public function getMoveGenerator(): MoveGeneratorInterface
    {
        return $this->moveGenerator;
    }
}