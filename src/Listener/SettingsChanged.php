<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Listener;

use Flarum\Settings\Event\Saved;
use Flarum\User\User;
use Illuminate\Support\Str;

class SettingsChanged
{
    public function __invoke(Saved $event)
    {
        $prefix = 'ianm-boring-avatars.';
        $changed = array_filter($event->settings, function (string $key) use ($prefix) {
            return Str::startsWith($key, $prefix);
        }, ARRAY_FILTER_USE_KEY);

        if (!empty($changed)) {
            // Null out all cached SVGs so they are regenerated lazily on next view.
            User::query()->update(['user_svg' => null]);
        }
    }
}
