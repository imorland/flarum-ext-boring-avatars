<?php

namespace IanM\BoringAvatars\Component;

use Illuminate\Contracts\View\View;

class SpinningRing extends Ring
{
    static string $name = 'spinningring';

    const ANIMATED_RINGS = 6;
    const COLORS = 9;
    const BASE_DURATION = 10;  // 10 seconds as a base duration
    const DURATION_DECREMENT = 1;  // decrement by 0.5 seconds for each ring
    const START_TIME_INCREMENT = 1;  // increment start time by 0.5 seconds for each ring

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        $animationDetails = [
            'keyTimes' => "0; 0.33; 1",
            'values' => [
                'clockwise' => "0 45 45; 360 45 45; 360 45 45",
                'anticlockwise' => "360 45 45; 0 45 45; 0 45 45",
            ]
        ];

        return $this->view->make('ianm-boring-avatars::spinningring', [
            'ringColors' => $this->generateColors($name, $colors),
            'maskID' => $this->getMaskId($name),
            'square' => $square,
            'size' => self::SIZE,
            'renderSize' => $renderSize,
            'fill' => 'none',
            'animationStartTimes' => $this->calculateStartTimes(),
            'animationDurations' => $this->calculateDurations(),
            'animationDetails' => $animationDetails,
            'rings' => self::ANIMATED_RINGS
        ]);
    }

    protected function generateColors(string $name, array $colors): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);

        $colorsShuffle = [];
        for ($i = 0; $i < self::COLORS; $i++) {
            $colorsShuffle[] = $this->getRandomColor($numFromName + $i, $colors, $range);
        }

        return $colorsShuffle;
    }

    protected function calculateStartTimes(): array
    {
        $startTimes = [];
        for ($i = 0; $i < self::ANIMATED_RINGS; $i++) {
            $startTimes[] = ($i * self::START_TIME_INCREMENT) . "s";
        }
        return $startTimes;
    }

    protected function calculateDurations(): array
    {
        $durations = [];
        for ($i = 0; $i < self::ANIMATED_RINGS; $i++) {
            $durations[] = (self::BASE_DURATION - $i * self::DURATION_DECREMENT) . "s";
        }
        return $durations;
    }
}
