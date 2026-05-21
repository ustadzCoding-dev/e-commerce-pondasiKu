<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WebpImageUploader
{
    public static function store(UploadedFile $file, string $directory): string
    {
        $publicDirectory = public_path(trim($directory, '/'));
        File::ensureDirectoryExists($publicDirectory);

        $baseName = time() . '-' . Str::random(10);
        $webpPath = $publicDirectory . DIRECTORY_SEPARATOR . $baseName . '.webp';

        if (! self::isSupportedImage($file)) {
            throw ValidationException::withMessages([
                'image' => 'File harus berupa gambar JPG, PNG, atau WebP yang valid.',
            ]);
        }

        if (self::saveAsWebp($file, $webpPath)) {
            return '/' . trim($directory, '/') . '/' . $baseName . '.webp';
        }

        throw ValidationException::withMessages([
            'image' => 'Gambar gagal diproses ke format WebP. Silakan unggah ulang gambar JPG, PNG, atau WebP yang valid.',
        ]);
    }

    private static function isSupportedImage(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), ['image/png', 'image/jpeg', 'image/webp'], true);
    }

    private static function saveAsWebp(UploadedFile $file, string $targetPath): bool
    {
        $contents = @file_get_contents($file->getRealPath());

        if ($contents === false) {
            return false;
        }

        $image = @imagecreatefromstring($contents);

        if (! $image) {
            return false;
        }

        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $saved = imagewebp($image, $targetPath, 82);
        imagedestroy($image);

        return $saved;
    }
}
