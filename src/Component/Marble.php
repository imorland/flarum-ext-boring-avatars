<?php

/*
 * This file is part of ianm/boring-avatars.
 *
 * Copyright (c) 2024 IanM.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace IanM\BoringAvatars\Component;

use IanM\BoringAvatars\BoringAvatar;
use Illuminate\Contracts\View\View;

class Marble extends BoringAvatar
{
    const ELEMENTS = 3;
    const SIZE = 80;

    public static string $name = 'marble';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        return $this->generateColors($name, $colors);
    }

    protected function generateColors(string $name, array $colors): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);

        $elementsProperties = [];
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $elementsProperties[] = [
                'color'      => $this->getRandomColor($numFromName + $i, $colors, $range),
                'translateX' => $this->getUnit($numFromName * ($i + 1), self::SIZE / 10, 1),
                'translateY' => $this->getUnit($numFromName * ($i + 1), self::SIZE / 10, 2),
                'scale'      => 1.2 + $this->getUnit($numFromName * ($i + 1), self::SIZE / 20.0) / 10.0,
                'rotate'     => $this->getUnit($numFromName * ($i + 1), 360, 1),
            ];
        }

        return $elementsProperties;
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        return $this->view->make('ianm-boring-avatars::marble', [
            'properties' => $this->generateData($name, $colors, $renderSize),
            'maskID'     => $this->getMaskId($name),
            'square'     => $square,
            'size'       => self::SIZE,
            'renderSize' => $renderSize,
            'fill'       => 'none',
        ]);
    }
}
