<?php

namespace IanM\BoringAvatars\Command;

use enshrined\svgSanitize\Sanitizer;
use Flarum\User\User;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Event\BoringAvatarCreating;
use Illuminate\Contracts\Events\Dispatcher;

class GenerateAvatarHandler
{
    public function __construct(protected BoringAvatar $avatar, protected Sanitizer $sanitizer, protected Dispatcher $events)
    {
    }
    
    public function handle(GenerateAvatar $command): User
    {
        $view = $this->avatar->generateSvg(
            $command->user->display_name,
            $command->renderSize,
            $command->square,
            $command->colors,
        );

        $svg = $view->render();

        $this->events->dispatch(new BoringAvatarCreating($command->user, $svg));

        //$svg = $this->sanitizer->sanitize($svg);

        if ($svg === false) {
            $svg = null;
        }

        $command->user->user_svg = $this->encodeSvgUrl($svg);

        $command->user->save();

        return $command->user;
    }

    protected function encodeSvgUrl(string $svg): string
    {
        return base64_encode($svg);
    }
}
