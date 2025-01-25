<?php


if (!function_exists('convertCmToMeters')) {
    /**
     * Convert centimeters to meters.
     *
     * @param float|int $centimeters
     * @return float
     */
    function convertCmToMeters(float|int $centimeters): float
    {
        return $centimeters / 100;
    }
}

if (!function_exists('convertGramsToKilograms')) {
    /**
     * Convert grams to kilograms.
     *
     * @param float|int $grams
     * @return float
     */
    function convertGramsToKilograms(float|int $grams): float
    {
        return $grams / 1000;
    }
}
