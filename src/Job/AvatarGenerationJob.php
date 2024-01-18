<?php

namespace IanM\BoringAvatars\Job;

use Flarum\Queue\AbstractJob;
use IanM\BoringAvatars\Console\GenerateBoringAvatars;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class AvatarGenerationJob extends AbstractJob
{
    public function handle(GenerateBoringAvatars $command, Container $container): void
    {
        $command->setLaravel($container);

        $command->run(new ArrayInput(['--force' => true]), new NullOutput());
    }
}
