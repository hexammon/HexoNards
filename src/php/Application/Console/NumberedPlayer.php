<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Application\Console;

use Hexammon\HexoNards\Game\PlayerInterface;

class NumberedPlayer implements PlayerInterface
{

    private int $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getId()
    {
        return $this->number;
    }
}
