<?php

namespace IanM\BoringAvatars\Component;

use IanM\BoringAvatars\BoringAvatar;
use Illuminate\Contracts\View\View;

class Sunset extends BoringAvatar
{
    const ELEMENTS = 4;
    const SIZE = 80;

    static string $name = 'sunset';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);

        $colorsList = [];
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $colorsList[] = $this->getRandomColor($numFromName + $i, $colors, $range);
        }

        return $colorsList;
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = null): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        $nameForId = preg_replace('/\s+/', '', $name);

        return $this->view->make('ianm-boring-avatars::sunset', [
            'sunsetColors' => $this->generateData($name, $colors, $renderSize),
            'maskID' => $this->getMaskId($name),
            'nameForId' => $nameForId,
            'square' => $square,
            'size' => self::SIZE,
            'renderSize' => $renderSize,
            'fill' => 'none'
        ]);
    }
}
