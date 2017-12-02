<?php

namespace Hexammon\HexoNards\Game\Rules;

class ClassicRuleSet implements RuleSetInterface
{

    private $initialSetting;

    public function __construct()
    {
        $this->initialSetting = new ClassicInitialSetting();
    }

    public function getInitialSetting(): InitialSettingInterface
    {
        return $this->initialSetting;
    }
}