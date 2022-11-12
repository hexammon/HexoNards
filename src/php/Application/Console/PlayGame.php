<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Application\Console;

use Hexammon\HexoNards\Application\I18n\HelpMessages;
use Hexammon\HexoNards\Application\I18n\Questions;
use Hexammon\HexoNards\Application\I18n\Translation;
use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\Rules\Classic\RuleSet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class PlayGame extends Command
{

    private const NUMBER_OF_PLAYERS = 'players';
    private const NUMBER_OF_ROWS    = 'rows';
    private const NUMBER_OF_COLS    = 'cols';

    private const DEFAULT_PLAYERS = 2;
    private const DEFAULT_ROWS    = 4;
    private const DEFAULT_COLS    = 4;
    private Translation $translation;

    private const DICE_SYMBOLS = [
        1 => '⚀',
        2 => '⚁',
        3 => '⚂',
        4 => '⚃',
        5 => '⚄',
        6 => '⚅',
    ];

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
        parent::__construct('game:play');
    }

    protected function configure()
    {
        $this->addOption(self::NUMBER_OF_PLAYERS, 'p', InputOption::VALUE_OPTIONAL, 'number of players', self::DEFAULT_PLAYERS);
        $this->addOption(self::NUMBER_OF_ROWS, 'r', InputOption::VALUE_OPTIONAL, 'number of rows', self::DEFAULT_ROWS);
        $this->addOption(self::NUMBER_OF_COLS, 'c', InputOption::VALUE_OPTIONAL, 'number of columns', self::DEFAULT_COLS);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /**@var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $numberOfPlayers = (int)$input->getOption(self::NUMBER_OF_PLAYERS) ?: self::DEFAULT_PLAYERS;
        $rows = (int)$input->getOption(self::NUMBER_OF_ROWS) ?: self::DEFAULT_ROWS;
        $cols = (int)$input->getOption(self::NUMBER_OF_COLS) ?: self::DEFAULT_COLS;

        $players = [];
        for ($number = 1; $number <= $numberOfPlayers; $number++) {
            $players[] = new NumberedPlayer($number);
        }

        $boardBuilder = new BoardBuilder();
        $board = $boardBuilder->build(Board::TYPE_SQUARE, $rows, $cols);

        $game = new Game($players, $board);

        $ruleSet = new RuleSet();
        $ruleSet->getInitialSetting()->arrangePieces($game);

        $this->outputBoard($board, $output);


        while (!$ruleSet->isGameOver($game)) {
            $activePlayer = $game->getActivePlayer();
            $questionHelper->ask($input, $output, new ConfirmationQuestion($this->translation->translate(Questions::THROW_DICES_PLAYER, $activePlayer->getId())));
            $moves = $game->getMoveCounter()->count();
            $output->writeln($this->translation->translate(HelpMessages::PLAYER_HAVE_MOVES, self::DICE_SYMBOLS[$moves], $moves));
            for ($move = 1; $move <= $moves; $move++) {
                $output->writeln($this->translation->translate(HelpMessages::PLAYER_DO_MOVE, $activePlayer->getId(), $move, $moves));
                $this->doNextAction($game, $output, $input);
                $this->outputBoard($board, $output);
                if ($ruleSet->isGameOver($game)) {
                    $winner = $ruleSet->getWinner($game);
                    $winnerMessageStyle = new OutputFormatterStyle('green', 'red', ['bold', 'blink']);
                    $output->getFormatter()->setStyle('win', $winnerMessageStyle);
                    $winnerMessage = sprintf('<win>Player %s won!</win>', $winner->getId());
                    $output->writeln($winnerMessage);
                    break;
                }
            }
        }

        return 0;
    }

    private function outputBoard(Board $board, OutputInterface $output)
    {
        $cols = $board->getColumns();
        $rowBorder = str_pad('_____', count($cols) * 7, '_');

        $output->write('     |');
        foreach ($cols as $column) {
            $columnsHeader = sprintf('%s|', str_pad((string)$column->getNumber(), 5, ' ', STR_PAD_BOTH));
            $output->write($columnsHeader);
        }

        $output->writeln('');
        $output->writeln($rowBorder);

        $blankRow = str_repeat('     |', count($cols) + 1);
        foreach ($board->getRows() as $row) {
            $output->write(' pl. |');
            foreach ($row->getTiles() as $tile) {
                if ($tile->hasArmy()) {
                    $playerId = substr((string)$tile->getArmy()->getOwner()->getId(), 0, 1);
                    $output->write(sprintf('  %s. |', $playerId));
                } else {
                    $output->write('     |');
                }
            }
            $output->writeln('');
            $rowHeader = sprintf('%s|', str_pad((string)$row->getNumber(), 5, ' ', STR_PAD_BOTH));
            $output->write($rowHeader);
            foreach ($row->getTiles() as $tile) {
                $coords = $tile->getCoordinates();
                if ($tile->hasCastle()) {
                    $castleArmyValue = str_pad((string)$tile->getArmy()->count(), 3, ' ', STR_PAD_BOTH);
                    $output->write(sprintf('[%s]|', $castleArmyValue));
                } elseif ($tile->hasArmy()) {
                    $fieldArmyValue = str_pad((string)$tile->getArmy()->count(), 5, ' ', STR_PAD_BOTH);
                    $output->write(sprintf('%s|', $fieldArmyValue));
                } else {
                    $output->write('     |');
                }
            }
            $output->writeln('');
            $output->writeln($blankRow);
            $output->writeln($rowBorder);
        }
    }

    private function doNextAction(Game $game, OutputInterface $output, InputInterface $input)
    {
        /**@var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $actionVariants = $game->getRuleSet()->getActionVariantsCollector()->getActionVariants($game);
        $availableActions = [];
        $variantsMap = [];

        foreach ($actionVariants->getSpawnVariants() as $spawnVariant) {
            $optionDescription = 'Пополнить гарнизон на ' . $spawnVariant->getTargetTile()->getCoordinates();
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $spawnVariant;
        }

        foreach ($actionVariants->getFoundCastleVariants() as $foundCastleVariant) {
            $optionDescription = sprintf('Основать замок на %s', $foundCastleVariant->getTargetTile()->getCoordinates());
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $foundCastleVariant;
        }

        foreach ($actionVariants->getMovementVariants() as $movementVariant) {
            $optionDescription = 'Передвинуть армию с ' . $movementVariant->getSource()->getCoordinates() . ' на ' . $movementVariant->getTarget()->getCoordinates();
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $movementVariant;
        }

        foreach ($actionVariants->getAttackVariants() as $attackVariant) {
            $optionDescription = sprintf('Атаковать врага с %s на %s', $attackVariant->getSourceTile()->getCoordinates(), $attackVariant->getTargetTile()->getCoordinates());
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $attackVariant;
        }

        foreach ($actionVariants->getDeductEnemyGarrisonVariants() as $deductEnemyGarrisonVariant) {
            $optionDescription = sprintf('Уменьшить вражеский осаждённый гарнизон на %s', $deductEnemyGarrisonVariant->getTargetTile()->getCoordinates());
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $deductEnemyGarrisonVariant;
        }

        foreach ($actionVariants->getAssaultVariants() as $assaultVariant) {
            $optionDescription = sprintf('Захватить вражеский осаждённый замок на %s армией %s', $assaultVariant->getTargetTile()->getCoordinates(), $assaultVariant->getSourceTile()->getCoordinates());
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $assaultVariant;
        }

        $choice = $questionHelper->ask($input, $output, new ChoiceQuestion($this->translation->translate(Questions::WHAT_DO_YOUR_DO), $availableActions));
        $selectedVariant = $variantsMap[$choice];
        if ($selectedVariant instanceof Movement) {
            $limitUnitsToMove = $selectedVariant->getSource()->getArmy()->count();
            if ($selectedVariant->getSource()->hasCastle()) {
                $limitUnitsToMove = $limitUnitsToMove - 1;
            }
            if ($limitUnitsToMove > 1) {
                $units = (int)$questionHelper->ask($input, $output, new Question($this->translation->translate(Questions::CHOISE_HOW_MATCH, $limitUnitsToMove)));
            } else {
                $units = $limitUnitsToMove;
            }

            $selectedVariant->setUnitsVolume($units);
        }


        $action = $selectedVariant->makeAction();

        $game->invoke($action);
    }
}

