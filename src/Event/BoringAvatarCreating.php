<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Event;

use Flarum\User\User;

class BoringAvatarCreating
{
    public function __construct(public User $user, public ?string $svg)
    {
    }
}
