<?php

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
