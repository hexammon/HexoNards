<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Application\Console;

use Hexammon\HexoNards\Application\I18n\HelpMessages;
use Hexammon\HexoNards\Application\I18n\Questions;
use Hexammon\HexoNards\Application\I18n\Translation;
use Hexammon\HexoNards\Board\Board;
use Hexammon\HexoNards\Board\BoardBuilder;
use Hexammon\HexoNards\Game\Action\MoveArmy;
use Hexammon\HexoNards\Game\Action\ReplenishGarrison;
use Hexammon\HexoNards\Game\Action\Variant\Movement;
use Hexammon\HexoNards\Game\Army;
use Hexammon\HexoNards\Game\Game;
use Hexammon\HexoNards\Game\PlayerInterface;
use Hexammon\HexoNards\Game\Rules\Classic\RuleSet;
use Symfony\Component\Console\Command\Command;
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
        parent::configure(); // TODO: Change the autogenerated stub
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /**@var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $numberOfPlayers = (int)$input->getOption(self::NUMBER_OF_PLAYERS) ?: self::DEFAULT_PLAYERS;
//        $playersQuestion = new Question('How many players will play the game? [' . $numberOfPlayers . ']' . PHP_EOL, $numberOfPlayers);
//        $numberOfPlayers = (int)$questionHelper->ask($input, $output, $playersQuestion);

        $rows = (int)$input->getOption(self::NUMBER_OF_ROWS) ?: self::DEFAULT_ROWS;
//        $rowsQuestion = new Question('Enter rows size of board for the game [' . $rows . ']' . PHP_EOL, $rows);
//        $rows = (int)$questionHelper->ask($input, $output, $rowsQuestion);

        $cols = (int)$input->getOption(self::NUMBER_OF_COLS) ?: self::DEFAULT_COLS;
//        $colsQuestion = new Question('Enter columns size of board for the game [' . $cols . ']' . PHP_EOL, $cols);
//        $cols = (int)$questionHelper->ask($input, $output, $colsQuestion);

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
                $this->doNextAction($game, $moves, $output, $input);
                $this->outputBoard($board, $output);
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
            $output->writeln($blankRow);
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

    private function doNextAction(Game $game, int $moves, OutputInterface $output, InputInterface $input)
    {
        /**@var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $activePlayer = $game->getActivePlayer();

        $actionVariants = $game->getRuleSet()->getActionVariantsCollector()->getActionVariants($game);
        $availableActions = [];
        $variantsMap = [];

        foreach ($actionVariants->getSpawnVariants() as $spawnVariant) {
            $optionDescription = 'spawn at ' . $spawnVariant->getTargetTile()->getCoordinates();
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $spawnVariant;
        }
        foreach ($actionVariants->getMovementVariants() as $movementVariant) {
            $optionDescription = 'move from ' . $movementVariant->getSource()->getCoordinates() . ' to ' . $movementVariant->getTarget()->getCoordinates();
            $availableActions[] = $optionDescription;
            $variantsMap[$optionDescription] = $movementVariant;
        }

        $choice = $questionHelper->ask($input, $output, new ChoiceQuestion($this->translation->translate(Questions::WHAT_DO_YOUR_DO), $availableActions));
        $selectedVariant = $variantsMap[$choice];
        if ($selectedVariant instanceof Movement) {
            if ($selectedVariant->getSource()->hasCastle()) {
                $units = (int)$questionHelper->ask($input, $output, new Question($this->translation->translate(Questions::CHOISE_HOW_MATCH, $selectedVariant->getSource()->getArmy()->count() - 1)));
            } else {
                $units = (int)$questionHelper->ask($input, $output, new Question($this->translation->translate(Questions::CHOISE_HOW_MATCH, $selectedVariant->getSource()->getArmy()->count())));
            }

            $selectedVariant->setUnitsVolume($units);
        }

        $action = $selectedVariant->makeAction();

        $game->invoke($action);
    }
}

