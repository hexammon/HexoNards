<?php

namespace FreeElephants\HexoNards\Game\Rules;

use FreeElephants\HexoNards\Board\AbstractTile;
use FreeElephants\HexoNards\Board\Board;
use FreeElephants\HexoNards\Game\Army;
use FreeElephants\HexoNards\Game\Castle;
use FreeElephants\HexoNards\Game\Game;
use FreeElephants\HexoNardsTests\Game\Exception\UnsupportedConfigurationException;

/**
 * @author samizdam <samizdam@inbox.ru>
 */
class ClassicInitialSetting implements InitialSettingInterface
{

    private $tileDetectionCallbacks;

    public function __construct()
    {
        $this->tileDetectionCallbacks = [
            function (Board $board): AbstractTile {
                return $board->getFirstRow()->getLastTile();
            },
            function (Board $board): AbstractTile {
                return $board->getLastRow()->getFirstTile();
            },
            function (Board $board): AbstractTile {
                return $board->getFirstRow()->getFirstTile();
            },
            function (Board $board): AbstractTile {
                return $board->getLastRow()->getLastTile();
            },
        ];
    }

    public function arrangePieces(Game $game)
    {
        $players = $game->getPlayers();

        $numberOfPlayers = count($players);
        if (!$this->isSupportedNumberOfPlayers($numberOfPlayers)) {
            $msg = sprintf('This game has %d players, but Classic Setting support only %s', $numberOfPlayers,
                join(', ', $this->getSupportedNumberOfPlayers()));
            throw new UnsupportedConfigurationException($msg);
        }

        foreach ($players as $playerNumber => $player) {
            $tile = $this->tileDetectionCallbacks[$playerNumber]($game->getBoard());
            new Army($player, $tile, 1);
            new Castle($tile);
        }
    }

    public function isSupportedNumberOfPlayers(int $numberOfPlayers): bool
    {
        return in_array($numberOfPlayers, $this->getSupportedNumberOfPlayers());
    }

    /**
     * @return array|int[]
     */
    public function getSupportedNumberOfPlayers(): array
    {
        return [2, 4];
    }
}