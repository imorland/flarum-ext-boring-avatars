<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema;
use Flarum\User\User;

class AddBoringAvatarAttributes
{
    public function __invoke(): array
    {
        return [
            Schema\Str::make('avatarUrl')
                ->get(fn (User $user, Context $context) => $user->avatar_url === null ? $this->assignSvgData($user) : $user->avatar_url),
            Schema\Boolean::make('avatarIsGenerated')
                ->get(fn (User $user, Context $context) => $user->avatar_url === null),
        ];
    }

    protected function assignSvgData(User $user): string
    {
        return 'data:image/svg+xml;base64,'.$user->user_svg;
    }
}
