<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Data;

use Blomstra\Gdpr\Data\Type;

class BoringAvatar extends Type
{
    public function export(): ?array
    {
        $svg = $this->user->user_svg;

        if (!$svg) {
            return [];
        }

        return ["avatars/boringavatar-{$this->user->id}.svg" => base64_decode($svg)];
    }

    public function anonymize(): void
    {
        // Handled in `\IanM\BoringAvatars\Listener\GenerateAvatar` listener
    }

    public function delete(): void
    {
        // Handled by the User record being deleted
    }
}
