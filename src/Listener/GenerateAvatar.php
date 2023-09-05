<?php

namespace IanM\BoringAvatars\Listener;

use Flarum\Bus\Dispatcher as BusDispatcher;
use Flarum\User\Event\LoggedIn;
use Flarum\User\Event\Registered;
use Flarum\User\Event\RegisteringFromProvider;
use FoF\Extend\Events\OAuthLoginSuccessful;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar as GenerateAvatarCommand;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;

class GenerateAvatar
{
    public function __construct(public BusDispatcher $bus)
    {
        
    }
    
    public function subscribe(EventsDispatcher $events): void
    {
        $events->listen([Registered::class, LoggedIn::class], [$this, 'generate']);
    }

    public function generate($event): void
    {
        if ($event->user && empty($event->user->user_svg)) {
            $event->user = $this->bus->dispatch(new GenerateAvatarCommand(
                $event->user,
                BoringAvatar::$defaultGenerationSize,
                BoringAvatar::$defaultSquareAvatar
            ));
        }
    }
}
