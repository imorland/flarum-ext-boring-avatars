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
use IanM\BoringAvatars\Job\AvatarGenerationJob;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Str;

class SettingsChanged
{
    public function __construct(
        protected Queue $queue
    ) {
    }

    public function __invoke(Saved $event)
    {
        $settings = $event->settings;

        // Check if any keys in the settings array start with 'ianm-boring-avatars.'
        $prefix = 'ianm-boring-avatars.';
        $keysWithPrefix = array_filter($settings, function (string $key) use ($prefix) {
            return Str::startsWith($key, $prefix);
        }, ARRAY_FILTER_USE_KEY);

        if (!empty($keysWithPrefix)) {
            $this->queue->push(new AvatarGenerationJob(true));
        }
    }
}
