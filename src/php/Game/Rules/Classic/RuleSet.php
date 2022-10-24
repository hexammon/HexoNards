<?php

namespace Hexammon\HexoNards\Game\Rules\Classic;

use Hexammon\HexoNards\Game\BattleService;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Move\MoveGeneratorInterface;
use Hexammon\HexoNards\Game\Move\Random\OneDice;
use Hexammon\HexoNards\Game\Move\Random\RandomMoveGeneratorAdapter;
use Hexammon\HexoNards\Game\Rules\ActionVariantsCollectorInterface;
use Hexammon\HexoNards\Game\Rules\InitialSettingInterface;
use Hexammon\HexoNards\Game\Rules\RuleSetInterface;

class RuleSet implements RuleSetInterface
{

    private $initialSetting;
    private $moveGenerator;
    private $gameOverDetector;
    private ActionVariantsCollector $actionVariantsCollector;

    public function __construct()
    {
        $this->initialSetting = new InitialSetting();
        $this->moveGenerator = new RandomMoveGeneratorAdapter(new OneDice());
        $this->gameOverDetector = new GameOverDetector();
        $this->actionVariantsCollector = new ActionVariantsCollector(new BattleService());
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

    public function getActionVariantsCollector(): ActionVariantsCollectorInterface
    {
        return $this->actionVariantsCollector;
    }
}
