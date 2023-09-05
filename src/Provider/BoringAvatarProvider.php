<?php

namespace IanM\BoringAvatars\Provider;

use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use IanM\BoringAvatars\BoringAvatar;
use IanM\BoringAvatars\Component;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;

class BoringAvatarProvider extends AbstractServiceProvider
{
    // Define a theme for fallback
    const FALLBACK_THEME = Component\Beam::class;

    public function register()
    {
        // List of available themes mapped to their respective class names
        $themes = [
            Component\Bauhaus::$name => Component\Bauhaus::class,
            Component\Beam::$name => Component\Beam::class,
            Component\Marble::$name => Component\Marble::class,
            Component\Pixel::$name => Component\Pixel::class,
            Component\Ring::$name => Component\Ring::class,
            Component\SpinningRing::$name => Component\SpinningRing::class,
            Component\Sunset::$name => Component\Sunset::class,
        ];
        
        // Register available theme names
        $this->container->singleton('boring.avatar.themes', function () use ($themes): array {
            return array_keys($themes);
        });

        // Bind the appropriate theme based on settings or fallback
        $this->container->bind(BoringAvatar::class, function (Container $container) use ($themes): BoringAvatar {
            $settings = $container->make(SettingsRepositoryInterface::class);
            $theme = $settings->get('ianm-boring-avatars.theme');
            
            // Fetch the appropriate theme class or fallback
            $themeClass = Arr::get($themes, $theme, self::FALLBACK_THEME);

            return $container->make($themeClass);
        });
    }
}
