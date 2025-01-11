<?php

namespace App\Utilities;

use Illuminate\Support\Collection;

class Localization
{
    public static function get(): Collection
    {
        return collect([
            'oops' => __('messages.oops'),
            'page_expired_try_again' => __('messages.page_expired_try_again'),
        ]);
    }
}
