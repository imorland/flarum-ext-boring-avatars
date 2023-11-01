<?php

namespace IanM\BoringAvatars\Api\Serializer;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\User\User;

class AddBoringAvatarAttributes
{
    public function __invoke(BasicUserSerializer $serializer, User $user, array $attributes): array
    {
        if ($user->avatar_url === null) {
            $attributes['avatarUrl'] = $this->assignSvgData($user);
            $attributes['avatarIsGenerated'] = true;
        } else {
            $attributes['avatarIsGenerated'] = false;
        }
        
        

        return $attributes;
    }

    protected function assignSvgData(User $user): string
    {
        return 'data:image/svg+xml;base64,' . $user->user_svg;
    }
}
