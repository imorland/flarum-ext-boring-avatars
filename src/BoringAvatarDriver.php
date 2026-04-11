<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars;

use Flarum\Bus\Dispatcher;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Avatar\DriverInterface;
use Flarum\User\User;
use IanM\BoringAvatars\Command\GenerateAvatar;

class BoringAvatarDriver implements DriverInterface
{
    public function __construct(
        protected Dispatcher $bus,
        protected SettingsRepositoryInterface $settings
    ) {
    }

    public function avatarUrl(User $user): ?string
    {
        if (empty($user->user_svg)) {
            $user = $this->bus->dispatch(new GenerateAvatar(
                $user,
                BoringAvatar::$defaultGenerationSize,
                BoringAvatar::$defaultSquareAvatar
            ));
        }

        return 'data:image/svg+xml;base64,'.$user->user_svg;
    }

    public function avatarSrcset(User $user): ?string
    {
        // SVGs are resolution-independent; no srcset needed.
        return null;
    }
}
