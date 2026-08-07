<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Upload and compress image to WebP format.
     */
    public static function uploadWebp(UploadedFile $file, string $folder, int $quality = 80): string
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = time() . '_' . \Illuminate\Support\Str::slug($filename) . '.webp';
        $path = trim($folder, '/') . '/' . $name;

        $encoded = Image::read($file->getRealPath())->encodeByExtension('webp', quality: $quality);

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}