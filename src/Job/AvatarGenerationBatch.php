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
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar;
use Illuminate\Contracts\Bus\Dispatcher;

class AvatarGenerationBatch extends AbstractJob
{
    public function __construct(
        protected Collection $users,
        protected bool $force = false
    ) {
    }

    public function handle(Dispatcher $bus): void
    {
        $this->users->each(function ($user) use ($bus) {
            if ($this->force || $user->user_svg === null) {
                if ($user->user_svg !== null) {
                    $user->user_svg = null;
                    $user->save();
                }
                $bus->dispatch(new GenerateAvatar($user, BoringAvatar::$defaultGenerationSize, BoringAvatar::$defaultSquareAvatar));
            }
        });
    }
}
