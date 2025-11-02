<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extend\LifecycleInterface;
use Flarum\Extension\Extension;
use IanM\BoringAvatars\Job\AvatarGenerationJob;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\SyncQueue;

class Lifecycle implements ExtenderInterface, LifecycleInterface
{
    public function onEnable(Container $container, Extension $extension): void
    {
        /** @var Queue $queue */
        $queue = $container->make(Queue::class);

        if ($queue instanceof SyncQueue) {
            // If using the sync queue, we can't run the job as at the point of this Lifecycle event
            // the provider has not yet been registered, therefore we'd get an error trying to resolve BoringAvatar.
            // Workaround: Set a flag that will trigger job on next request
            $container->make('flarum.settings')->set('ianm-boring-avatars.generate_on_next_request', true);
        } else {
            $queue->push(new AvatarGenerationJob());
        }
    }

    public function onDisable(Container $container, Extension $extension): void
    {
        // Do nothing
    }

    public function extend(Container $container, ?Extension $extension = null): void
    {
        // Do nothing
    }
}
