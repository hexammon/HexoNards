<?php
declare(strict_types=1);


namespace Hexammon\HexoNards\Application\I18n;

class TranslationService implements Translation
{

    public function translate(string $key, ...$params): string
    {
        return sprintf($key, ...$params);
    }
}
