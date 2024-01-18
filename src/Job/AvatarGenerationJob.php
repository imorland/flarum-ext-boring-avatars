<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Job;

use Flarum\Database\Eloquent\Collection;
use Flarum\Queue\AbstractJob;
use Flarum\User\User;
use Illuminate\Contracts\Queue\Queue;

class AvatarGenerationJob extends AbstractJob
{
    const BATCH_SIZE = 1000;

    public function __construct(
        protected bool $force = false
    ) {
    }

    public function handle(Queue $queue): void
    {
        $force = $this->force;

        User::query()->chunkById(self::BATCH_SIZE, function (Collection $users) use ($queue, $force) {
            $queue->push(new AvatarGenerationBatch($users, $force));
        });
    }
}
