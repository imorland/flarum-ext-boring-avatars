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

class Beam extends BoringAvatar
{
    const SIZE = 36;

    public static string $name = 'beam';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);
        $wrapperColor = $this->getRandomColor($numFromName, $colors, $range);
        $preTranslateX = $this->getUnit($numFromName, 10, 1);
        $wrapperTranslateX = $preTranslateX < 5 ? $preTranslateX + self::SIZE / 9 : $preTranslateX;
        $preTranslateY = $this->getUnit($numFromName, 10, 2);
        $wrapperTranslateY = $preTranslateY < 5 ? $preTranslateY + self::SIZE / 9 : $preTranslateY;

        return [
            'wrapperColor'      => $wrapperColor,
            'faceColor'         => $this->getContrast($wrapperColor),
            'backgroundColor'   => $this->getRandomColor($numFromName + 13, $colors, $range),
            'wrapperTranslateX' => $wrapperTranslateX,
            'wrapperTranslateY' => $wrapperTranslateY,
            'wrapperRotate'     => $this->getUnit($numFromName, 360),
            'wrapperScale'      => (int) floor(1 + $this->getUnit($numFromName, self::SIZE / 12) / 10),
            'isMouthOpen'       => $this->getBoolean($numFromName, 2),
            'isCircle'          => $this->getBoolean($numFromName, 1),
            'eyeSpread'         => $this->getUnit($numFromName, 5),
            'mouthSpread'       => $this->getUnit($numFromName, 3),
            'faceRotate'        => $this->getUnit($numFromName, 10, 3),
            'faceTranslateX'    => $wrapperTranslateX > self::SIZE / 6 ? $wrapperTranslateX / 2 : $this->getUnit($numFromName, 8, 1),
            'faceTranslateY'    => $wrapperTranslateY > self::SIZE / 6 ? $wrapperTranslateY / 2 : $this->getUnit($numFromName, 7, 2),
        ];
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        // Adjust the scaling factor for the eyes and mouth based on the size parameter
        $scaleFactor = self::SIZE / 36;  // 36 is the original JS size

        return $this->view->make('ianm-boring-avatars::beam', [
            'data'        => $this->generateData($name, $colors, $renderSize),
            'maskID'      => $this->getMaskId($name),
            'square'      => $square,
            'size'        => self::SIZE,
            'renderSize'  => $renderSize,
            'scaleFactor' => $scaleFactor,
            'fill'        => 'none',
        ]);
    }
}
