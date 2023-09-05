<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2023 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars;

use Flarum\Api\Controller\ListUsersController;
use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Controller\ShowUserController;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\User\User;
use IanM\BoringAvatars\Api\Serializer\AddBoringAvatarAttributes;
use IanM\BoringAvatars\Api\Serializer\AddForumAttributes;

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
        ->default('ianm-boring-avatars.include_forum_colors', false)
        ->default('ianm-boring-avatars.theme', Component\Beam::$name),

    (new Extend\Event())
        ->subscribe(Listener\GenerateAvatar::class),

    (new Extend\Console())
        ->command(Console\GenerateBoringAvatars::class)
];
