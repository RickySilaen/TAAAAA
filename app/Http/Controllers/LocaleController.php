<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Supported locales.
     */
    protected array $supportedLocales = ['id', 'en'];

    /**
     * Switch application locale.
     *
     * @return RedirectResponse|JsonResponse
     */
    public function switch(Request $request, string $locale)
    {
        // Validate locale
        if (! in_array($locale, $this->supportedLocales)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unsupported locale',
                ], 400);
            }

            return redirect()->back()->with('error', 'Bahasa tidak didukung');
        }

        // Set locale in session
        Session::put('locale', $locale);

        // Set locale for current request
        App::setLocale($locale);

        // Return response
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'locale' => $locale,
                'message' => __('messages.success'),
            ]);
        }

        return redirect()->back()
            ->cookie('locale', $locale, 60 * 24 * 365) // 1 year
            ->with('success', __('messages.messages.updated', ['item' => 'Bahasa']));
    }

    /**
     * Get current locale.
     */
    public function current(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'locale' => App::getLocale(),
            'supported' => $this->supportedLocales,
        ]);
    }

    /**
     * Get all supported locales.
     */
    public function supported(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'locales' => [
                [
                    'code' => 'id',
                    'name' => 'Bahasa Indonesia',
                    'flag' => '🇮🇩',
                ],
                [
                    'code' => 'en',
                    'name' => 'English',
                    'flag' => '🇬🇧',
                ],
            ],
        ]);
    }
}
