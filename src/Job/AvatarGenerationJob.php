<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Job;

use Flarum\Queue\AbstractJob;
use IanM\BoringAvatars\Console\GenerateBoringAvatars;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class AvatarGenerationJob extends AbstractJob
{
    public function __construct(
        protected bool $force = false
    ) {
    }
    
    public function handle(GenerateBoringAvatars $command, Container $container): void
    {
        $command->setLaravel($container);

        $command->run(new ArrayInput($this->force ? ['--force' => true] : []), new NullOutput());
    }
}
