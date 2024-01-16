<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Command;

use Flarum\User\User;

class GenerateAvatar
{
    public function __construct(public User $user, public int $renderSize = 100, public bool $square = false, public array $colors = [])
    {
    }
}
