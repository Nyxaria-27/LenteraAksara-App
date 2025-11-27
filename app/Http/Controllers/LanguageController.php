<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (!in_array($locale, ['id', 'en'])) {
            return redirect()->back();
        }

        // Store in session
        session(['locale' => $locale]);
        
        // Set app locale
        app()->setLocale($locale);

        return redirect()->back();
    }
}
