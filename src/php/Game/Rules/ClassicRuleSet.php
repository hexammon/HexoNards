<?php

namespace Hexammon\HexoNards\Game\Rules;

use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\Move\Random\RandomMoveGeneratorAdapter;
use Hexammon\HexoNards\Game\Move\Random\TwoDice;

class ClassicRuleSet implements RuleSetInterface
{

    private $initialSetting;
    private $moveGenerator;
    private $gameOverDetector;

    public function __construct()
    {
        $this->initialSetting = new ClassicInitialSetting();
        $this->moveGenerator = new RandomMoveGeneratorAdapter(new TwoDice());
        $this->gameOverDetector = new ClassicGameOverDetector();
    }

    public function getInitialSetting(): InitialSettingInterface
    {
        return $this->initialSetting;
    }

    public function getMoveGenerator(): MoveGeneratorInterface
    {
        return $this->moveGenerator;
    }

    public function isGameOver(Game $game): bool
    {
        return $this->gameOverDetector->isOver($game);
    }
}