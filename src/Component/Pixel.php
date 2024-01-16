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

class Pixel extends BoringAvatar
{
    const ELEMENTS = 64;
    const SIZE = 80;

    public static string $name = 'pixel';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);

        $colorList = [];
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $colorList[] = $this->getRandomColor($numFromName % ($i + 1), $colors, $range);
        }

        return $colorList;
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        // Positions for each rect
        $positions = [
            [20, 0], [40, 0], [60, 0], [10, 0], [30, 0], [50, 0], [70, 0],
            [0, 10], [0, 20], [0, 30], [0, 40], [0, 50], [0, 60], [0, 70], [20, 10],
            [20, 20], [20, 30], [20, 40], [20, 50], [20, 60], [20, 70], [40, 10], [40, 20],
            [40, 30], [40, 40], [40, 50], [40, 60], [40, 70], [60, 10], [60, 20], [60, 30],
            [60, 40], [60, 50], [60, 60], [60, 70], [10, 10], [10, 20], [10, 30], [10, 40],
            [10, 50], [10, 60], [10, 70], [30, 10], [30, 20], [30, 30], [30, 40], [30, 50],
            [30, 60], [30, 70], [50, 10], [50, 20], [50, 30], [50, 40], [50, 50], [50, 60],
            [50, 70], [70, 10], [70, 20], [70, 30], [70, 40], [70, 50], [70, 60], [70, 70],
        ];

        return $this->view->make('ianm-boring-avatars::pixel', [
            'pixelColors' => $this->generateData($name, $colors, $renderSize),
            'positions'   => $positions,
            'maskID'      => $this->getMaskId($name),
            'square'      => $square,
            'size'        => self::SIZE,
            'renderSize'  => $renderSize,
            'fill'        => 'none',
            'elements'    => self::ELEMENTS,
        ]);
    }
}
