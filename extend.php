<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars;

use Blomstra\Gdpr\Extend\UserData;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Settings\Event\Saved;
use Flarum\User\User;
use IanM\BoringAvatars\Api\Serializer\AddBoringAvatarAttributes;
use IanM\BoringAvatars\Api\Serializer\AddForumAttributes;
use IanM\BoringAvatars\Extend\Lifecycle;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less')
        ->content(function (Document $document) {
            $document->payload['boringAvatarThemes'] = resolve('boring.avatar.themes');
        }),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Model(User::class))
        ->cast('user_svg', 'string'),

    new Lifecycle(),

    (new Extend\Routes('api'))
        ->get('/users/{id}/boring-avatar', 'users.boring-avatar', Api\Controller\ShowBoringAvatarController::class),

    (new Extend\ApiSerializer(BasicUserSerializer::class))
        ->attributes(AddBoringAvatarAttributes::class),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(AddForumAttributes::class),

    (new Extend\ServiceProvider())
        ->register(Provider\BoringAvatarProvider::class),

    (new Extend\View())
        ->namespace('ianm-boring-avatars', __DIR__.'/views/boring'),

    (new Extend\Settings())
        ->default('ianm-boring-avatars.color1', '#92A1C6')
        ->default('ianm-boring-avatars.color2', '#146A7C')
        ->default('ianm-boring-avatars.color3', '#F0AB3D')
        ->default('ianm-boring-avatars.color4', '#C271B4')
        ->default('ianm-boring-avatars.color5', '#C20D90')
        ->default('ianm-boring-avatars.theme', Component\Beam::$name),

    (new Extend\Event())
        ->subscribe(Listener\GenerateAvatar::class)
        ->listen(Saved::class, Listener\SettingsChanged::class),

    (new Extend\Console())
        ->command(Console\GenerateBoringAvatars::class),

    (new Extend\Conditional())
        ->whenExtensionEnabled('blomstra-gdpr', fn () => [
            (new UserData())
                ->addType(Data\BoringAvatar::class),
        ]),
];
