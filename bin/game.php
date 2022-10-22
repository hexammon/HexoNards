<?php

use Hexammon\HexoNards\Application\Console\PlayGame;
use Hexammon\HexoNards\Application\I18n\TranslationService;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';


$app = new Application();

$app->add(new PlayGame(new TranslationService()));

$app->run();
