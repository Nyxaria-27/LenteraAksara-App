<?php

if (!function_exists('feature_enabled')) {
    /**
     * Check if a feature is enabled
     *
     * @param string $feature Feature key from config/features.php
     * @return bool
     */
    function feature_enabled(string $feature): bool
    {
        return (bool) config("features.{$feature}", false);
    }
}

if (!function_exists('feature_disabled')) {
    /**
     * Check if a feature is disabled
     *
     * @param string $feature Feature key from config/features.php
     * @return bool
     */
    function feature_disabled(string $feature): bool
    {
        return !feature_enabled($feature);
    }
}

if (!function_exists('aos')) {
    /**
     * Return AOS animation attribute only if feature is enabled
     *
     * @param string $animation Animation type (fade-up, fade-down, fade-left, fade-right, zoom-in, etc)
     * @param int|null $delay Optional delay in milliseconds
     * @return string AOS data attributes or empty string
     */
    function aos(string $animation, ?int $delay = null): string
    {
        if (!config('features.aos_animations', true)) {
            return '';
        }

        $attrs = "data-aos=\"{$animation}\"";
        
        if ($delay !== null) {
            $attrs .= " data-aos-delay=\"{$delay}\"";
        }

        return $attrs;
    }
}
