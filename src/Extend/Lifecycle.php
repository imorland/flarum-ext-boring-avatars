<?php

namespace IanM\BoringAvatars\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extend\LifecycleInterface;
use Flarum\Extension\Extension;
use IanM\BoringAvatars\Job\AvatarGenerationJob;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Queue\Queue;

class Lifecycle implements ExtenderInterface, LifecycleInterface
{
    public function onEnable(Container $container, Extension $extension): void
    {
        $container->make(Queue::class)
            ->push(new AvatarGenerationJob());
    }

    public function onDisable(Container $container, Extension $extension)
    {
        // Do nothing
    }

    public function extend(Container $container, Extension $extension = null)
    {
        // Do nothing
    }
}
