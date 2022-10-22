<?php

use Hexammon\HexoNards\Application\Console\PlayGame;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';


$app = new Application();

$app->add(new PlayGame('game:play'));

$app->run();
