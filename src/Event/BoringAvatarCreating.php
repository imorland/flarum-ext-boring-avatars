<?php

namespace IanM\BoringAvatars\Event;

use Flarum\User\User;

class BoringAvatarCreating
{
    public function __construct(public User $user, public ?string $svg)
    {
        
    }
}
