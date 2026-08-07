<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Clean and sanitize HTML string from XSS vectors.
     */
    public static function clean(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        // Hapus script tag beserta isinya
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Hapus event handler inline seperti onload, onerror, onclick, dll.
        $html = preg_replace('/on[a-z]+\s*=\s*(["\']).*?\1/i', '', $html);
        $html = preg_replace('/on[a-z]+\s*=\s*[^"\'\s>]+/i', '', $html);

        // Hapus skema pseudo-protocol javascript:
        $html = preg_replace('/href\s*=\s*["\']?\s*javascript:[^"\'\s>]+/i', 'href="#"', $html);
        $html = preg_replace('/src\s*=\s*["\']?\s*javascript:[^"\'\s>]+/i', '', $html);

        return $html;
    }
}
