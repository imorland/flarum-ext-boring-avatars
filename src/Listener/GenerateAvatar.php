<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Listener;

use Blomstra\Gdpr\Events\Erased;
use Blomstra\Gdpr\Models\ErasureRequest;
use Flarum\Bus\Dispatcher as BusDispatcher;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\EmailChanged;
use Flarum\User\Event\LoggedIn;
use Flarum\User\Event\Registered;
use Flarum\User\Event\Renamed;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Command\GenerateAvatar as GenerateAvatarCommand;
use Illuminate\Contracts\Events\Dispatcher as EventsDispatcher;

class GenerateAvatar
{
    public function __construct(
        public BusDispatcher $bus,
        protected SettingsRepositoryInterface $settings
    ) {
    }

    public function subscribe(EventsDispatcher $events): void
    {
        $events->listen([Registered::class, LoggedIn::class, Renamed::class, EmailChanged::class], [$this, 'generate']);
        $events->listen(Erased::class, [$this, 'handleErased']);
    }

    public function generate($event): void
    {
        if (
            (!$event->user->isGuest() && empty($event->user->user_svg)) ||
            ($event instanceof Renamed && $this->getIdentifier() === 'display_name') ||
            ($event instanceof EmailChanged && $this->getIdentifier() === 'email')
        ) {
            $event->user = $this->bus->dispatch(new GenerateAvatarCommand(
                $event->user,
                BoringAvatar::$defaultGenerationSize,
                BoringAvatar::$defaultSquareAvatar
            ));
        }
    }

    public function handleErased(Erased $event): void
    {
        if ($event->mode === ErasureRequest::MODE_ANONYMIZATION) {
            $user = $event->user;

            if ($user->exists) {
                $this->bus->dispatch(new GenerateAvatarCommand(
                    $user,
                    BoringAvatar::$defaultGenerationSize,
                    BoringAvatar::$defaultSquareAvatar
                ));
            }
        }
    }

    protected function getIdentifier(): string
    {
        return $this->settings->get('ianm-boring-avatars.identifier');
    }
}
