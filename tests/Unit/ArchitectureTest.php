<?php

arch('does not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'ds'])
    ->not->toBeUsed();

// arch()->preset()->laravel();
