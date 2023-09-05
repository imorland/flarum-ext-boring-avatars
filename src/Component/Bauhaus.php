<?php

namespace IanM\BoringAvatars\Component;

use IanM\BoringAvatars\BoringAvatar;
use Illuminate\Contracts\View\View;

class Bauhaus extends BoringAvatar
{
    const ELEMENTS = 4;
    const SIZE = 80;

    static string $name = 'bauhaus';

    protected function generateData(string $name, array $colors, int $renderSize): array
    {
        $numFromName = $this->hashCode($name);
        $range = count($colors);
    
        $elementsProperties = [];
        for ($i = 0; $i < self::ELEMENTS; $i++) {
            $elementsProperties[] = [
                'color' => $this->getRandomColor($numFromName + $i, $colors, $range),
                'translateX' => $this->getUnit($numFromName * ($i + 1), self::SIZE / 2 - ($i + 17), 1),
                'translateY' => $this->getUnit($numFromName * ($i + 1), self::SIZE / 2 - ($i + 17), 2),
                'rotate' => $this->getUnit($numFromName * ($i + 1), 360),
                'isSquare' => $this->getBoolean($numFromName, 2),
            ];
        }
    
        return $elementsProperties;
    }

    public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View
    {
        if (empty($colors)) {
            $colors = $this->getDefaultColors();
        }

        return $this->view->make('ianm-boring-avatars::bauhaus', [
            'properties' => $this->generateData($name, $colors, $renderSize),
            'maskID' => $this->getMaskId($name),
            'square' => $square,
            'size' => self::SIZE,
            'renderSize' => $renderSize,
            'fill' => 'none'
        ]);
    }
}
