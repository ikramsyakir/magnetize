<?php

namespace App\Utilities;

use Illuminate\Support\Collection;

class Theme
{
    const string LIGHT = "light";
    const string DARK = "dark";

    public static function themeType(): Collection
    {
        return collect([
            self::LIGHT => self::LIGHT,
            self::DARK => self::DARK,
        ]);
    }
}
