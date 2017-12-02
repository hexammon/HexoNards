<?php

namespace Hexammon\HexoNards\Game\Rules;

interface RuleSetInterface
{

    public function getInitialSetting(): InitialSettingInterface;

}