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

class Ring extends BoringAvatar
{
    const SIZE = 90;
    const COLORS = 5;

    public static string $name = 'ring';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);

        $colorsShuffle = [];
        for ($i = 0; $i < self::COLORS; $i++) {
            $colorsShuffle[] = $this->getRandomColor($numFromName + $i, $colors, $range);
        }

        $colorsList = [
            $colorsShuffle[0],
            $colorsShuffle[1],
            $colorsShuffle[1],
            $colorsShuffle[2],
            $colorsShuffle[2],
            $colorsShuffle[3],
            $colorsShuffle[3],
            $colorsShuffle[0],
            $colorsShuffle[4],
        ];

        return $colorsList;
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        return $this->view->make('ianm-boring-avatars::ring', [
            'ringColors' => $this->generateData($name, $colors, $renderSize),
            'maskID'     => $this->getMaskId($name),
            'square'     => $square,
            'size'       => self::SIZE,
            'renderSize' => $renderSize,
            'fill'       => 'none',
        ]);
    }
}
