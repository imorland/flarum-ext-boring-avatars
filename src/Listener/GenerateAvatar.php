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

use Flarum\Bus\Dispatcher as BusDispatcher;
use Flarum\Gdpr\Events\Erased;
use Flarum\Gdpr\Models\ErasureRequest;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\EmailChanged;
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
        $events->listen([Renamed::class, EmailChanged::class], [$this, 'regenerateOnIdentifierChange']);
        $events->listen(Erased::class, [$this, 'handleErased']);
    }

    public function regenerateOnIdentifierChange($event): void
    {
        if (
            ($event instanceof Renamed && $this->getIdentifier() === 'display_name') ||
            ($event instanceof EmailChanged && $this->getIdentifier() === 'email')
        ) {
            // Null out the cached SVG so the driver regenerates it on next view.
            $event->user->user_svg = null;
            $event->user->save();
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
