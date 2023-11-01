<?php

namespace IanM\BoringAvatars;

use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

abstract class BoringAvatar
{
    public function __construct(protected Factory $view, protected SettingsRepositoryInterface $settings)
    {
    }

    static string $name;

    static int $defaultGenerationSize = 100;

    static bool $defaultSquareAvatar = false;

    public function getMaskId(string $name): string
    {
        return 'mask__' . static::$name . '__' . md5($name);
    }

    protected function getDefaultColors(): array
    {
        $boringDefaults = ['#92A1C6', '#146A7C', '#F0AB3D', '#C271B4', '#C20D90'];

        if ($this->settings->get('ianm-boring-avatars.include_forum_colors')) {
            $boringDefaults = array_merge_recursive($boringDefaults, [$this->settings->get('theme_primary_color'), $this->settings->get('theme_secondary_color')]);
        }
        
        return $boringDefaults;
    }

    /**
     * Convert a string to a 32-bit hash number.
     * Update: Restricted the hash value to 32 bits to mimic JavaScript behavior.
     */
    protected function hashCode(string $str): int
    {
        $str = md5($str);

        $hash = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $char = ord($str[$i]);
            $hash = (($hash << 5) - $hash) + $char;

            // Convert to 32bit integer
            $hash = (int)($hash & 0xFFFFFFFF);

            if ($hash & 0x80000000) {
                $hash = - (~$hash + 1);
            }
        }

        if ($hash > pow(2, 31) - 1) {
            $hash -= pow(2, 32);
        }

        return abs($hash);
    }

    /**
     * Return modulus of a number.
     */
    protected function getModulus(int $num, int $max): float
    {
        $result = $num % $max;
        return $result < 0 ? $result + $max : $result;
    }

    /**
     * Get the nth digit of a number.
     * Used absolute value of the number to mimic JavaScript's non-negative numbers.
     */
    protected function getDigit(int $number, int $ntn): int
    {
        $m = (int) floor(($number / (pow(10, $ntn))));
        return (int) $this->getModulus($m, 10);
    }

    /**
     * Convert a number to boolean based on its nth digit.
     */
    protected function getBoolean(int $number, int $ntn): bool
    {
        return !($this->getModulus($this->getDigit($number, $ntn), 2));
    }

    /**
     * Get a unit value from a number.
     */
    protected function getUnit(int $number, float $range, ?int $index = null): float
    {
        $value = $this->getModulus($number, (int) $range);

        if ($index !== null && ($this->getDigit($number, $index) % 2) === 0) {
            return -$value;
        }
        return $value;
    }


    /**
     * Get a random color from a set based on a number.
     * Update: Used absolute value of the number for the index to ensure a non-negative index.
     */
    protected function getRandomColor(int $number, array $colors, int $range): string
    {
        $index = ($this->getModulus($number, $range));
        return $colors[$index];
    }

    /**
     * Calculate contrast color for a given hex color.
     */
    protected function getContrast(string $hexcolor): string
    {
        $hexcolor = ltrim($hexcolor, '#');
        if (strlen($hexcolor) !== 6) {
            throw new \InvalidArgumentException("Invalid hex color provided.");
        }

        $r = hexdec(substr($hexcolor, 0, 2));
        $g = hexdec(substr($hexcolor, 2, 2));
        $b = hexdec(substr($hexcolor, 4, 2));

        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 128) ? '#000000' : '#FFFFFF';
    }

    /**
     * Generate data based on the name, colors, and size.
     */
    abstract protected function generateData(string $name, array $colors, int $renderSize): array;

    /**
     * Generate the SVG for the Avatar.
     */
    abstract public function generateSvg(string $name, int $renderSize = 80, bool $square = false, array $colors = []): View;
}
