<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslatorHelper
{
    /**
     * Translate text from Indonesian to target language
     *
     * @param string $text Indonesian text
     * @param string $targetLang 'id' or 'en'
     * @return string
     */
    public static function translate(string $text, string $targetLang = 'en'): string
    {
        // If target is Indonesian (no translation needed) or text is empty, return original
        if ($targetLang === 'id' || empty(trim($text))) {
            return $text;
        }

        // Strip HTML tags for cache key (but translate with HTML)
        $textForKey = strip_tags($text);
        
        // Create cache key
        $cacheKey = 'translation_' . md5($textForKey . '_' . $targetLang);

        // Try to get from cache first (cache for 7 days)
        return Cache::remember($cacheKey, 60 * 24 * 7, function () use ($text, $targetLang) {
            try {
                $translator = new GoogleTranslate($targetLang);
                $translator->setSource('id'); // Source is always Indonesian
                $translated = $translator->translate($text);
                return $translated;
            } catch (\Exception $e) {
                // If translation fails, return original text
                Log::error('Translation failed: ' . $e->getMessage(), [
                    'text' => substr($text, 0, 100),
                    'target' => $targetLang
                ]);
                return $text;
            }
        });
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public static function getCurrentLocale(): string
    {
        return session('locale', 'id');
    }
}
