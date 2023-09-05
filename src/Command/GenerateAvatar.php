<?php

namespace IanM\BoringAvatars\Command;

use Flarum\User\User;

class GenerateAvatar
{
    public function __construct(public User $user, public int $renderSize = 100, public bool $square = false, public array $colors = [])
    {
        
    }
}
