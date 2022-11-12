<?php

namespace Hexammon\HexoNards\Application\I18n;

interface Translation
{
    public function translate(string $key, ...$params): string;
}
