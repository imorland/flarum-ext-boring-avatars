<?php

namespace IanM\BoringAvatars\Api\Serializer;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Bus\Dispatcher;
use Flarum\Http\UrlGenerator;
use Flarum\User\User;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar;

class AddBoringAvatarAttributes
{
    protected $url;
    protected $bus;
    
    public function __construct(UrlGenerator $url, Dispatcher $bus)
    {
        $this->url = $url;
    }
    
    public function __invoke(BasicUserSerializer $serializer, User $user, array $attributes): array
    {
        // $attributes['avatarUrl'] = $this->url->to('api')->route('users.boring-avatar', [
        //     'id' => $user->id,
        // ]);

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
