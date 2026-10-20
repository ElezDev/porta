<?php

namespace App\Support;

class Theme
{
    public const KEYS = [
        'header_color',
        'sidebar_color',
        'primary_color',
        'success_color',
        'warning_color',
        'danger_color',
        'info_color',
    ];

    public const DEFAULTS = [
        'header_color' => '#162A56',
        'sidebar_color' => '#0C1A38',
        'primary_color' => '#1E3F8F',
        'success_color' => '#2F855A',
        'warning_color' => '#B7791F',
        'danger_color' => '#C53030',
        'info_color' => '#3B6EA5',
    ];

    public static function sanitize($input)
    {
        $clean = [];
        foreach (self::KEYS as $key) {
            $hex = self::hex($input[$key] ?? null);
            if ($hex) {
                $clean[$key] = $hex;
            }
        }

        return $clean;
    }

    public static function hex($value, $fallback = null)
    {
        if (!is_string($value)) {
            return $fallback;
        }

        $value = trim($value);
        if (!preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $value)) {
            return $fallback;
        }

        $hex = ltrim($value, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        return '#' . strtoupper($hex);
    }

    public static function rgb($hex)
    {
        $hex = ltrim(self::hex($hex, '#000000'), '#');

        return hexdec(substr($hex, 0, 2)) . ', ' . hexdec(substr($hex, 2, 2)) . ', ' . hexdec(substr($hex, 4, 2));
    }

    public static function shade($hex, $percent)
    {
        $hex = ltrim(self::hex($hex, '#000000'), '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $amt = $percent / 100;

        if ($amt < 0) {
            $r = (int) round($r * (1 + $amt));
            $g = (int) round($g * (1 + $amt));
            $b = (int) round($b * (1 + $amt));
        } else {
            $r = (int) round($r + (255 - $r) * $amt);
            $g = (int) round($g + (255 - $g) * $amt);
            $b = (int) round($b + (255 - $b) * $amt);
        }

        return sprintf('#%02X%02X%02X', max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
    }

    public static function on($hex)
    {
        $hex = ltrim(self::hex($hex, '#000000'), '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $l = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

        return $l > 0.62 ? '#111827' : '#FFFFFF';
    }
}
