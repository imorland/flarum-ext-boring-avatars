<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Middleware;

use Flarum\Settings\SettingsRepositoryInterface;
use IanM\BoringAvatars\Job\AvatarGenerationJob;
use Illuminate\Contracts\Queue\Queue;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class QueuePendingJobs implements MiddlewareInterface
{
    public function __construct(
        protected SettingsRepositoryInterface $settings,
        protected Queue $queue
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        // Check if we need to queue avatar generation
        if ($this->settings->get('ianm-boring-avatars.generate_on_next_request')) {
            // Clear the flag first to avoid repeated execution
            $this->settings->set('ianm-boring-avatars.generate_on_next_request', false);

            // Now queue the job - service providers are fully loaded at this point
            $this->queue->push(new AvatarGenerationJob());
        }

        return $response;
    }
}
