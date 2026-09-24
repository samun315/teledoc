<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use RuntimeException;

class ImageOptimizer
{
    public const QUALITY = 80;

    public const MAX_EDGE = 1920;

    private const CONVERTIBLE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    private const CONVERTIBLE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp',
        'image/x-ms-bmp',
    ];

    /**
     * Convert an uploaded image to WebP, compress it, and store it on a disk.
     */
    public function storeOnDisk(
        UploadedFile $file,
        string $directory,
        string $prefix = '',
        string $disk = 'public',
        ?int $maxEdge = null
    ): string {
        $directory = trim($directory, '/');
        $relativePath = $directory.'/'.$this->filename($prefix);
        $saved = false;

        foreach ($this->storagePaths($relativePath) as $absolutePath) {
            $folder = dirname($absolutePath);

            if (! is_dir($folder) && ! mkdir($folder, 0755, true) && ! is_dir($folder)) {
                continue;
            }

            $this->writeWebp($file, $absolutePath, $maxEdge);
            $saved = is_file($absolutePath) || $saved;
        }

        if (! $saved) {
            throw new RuntimeException('Failed to save image file. Please check directory permissions.');
        }

        return $relativePath;
    }

    /**
     * Remove a stored image from the public storage directory.
     */
    public function delete(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }

        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');

        foreach ($this->storagePaths($relativePath) as $absolutePath) {
            if (is_file($absolutePath)) {
                unlink($absolutePath);
            }
        }
    }

    /**
     * Web-visible path and Laravel's public disk path.
     * On the live server these are not always the same directory.
     *
     * @return list<string>
     */
    private function storagePaths(string $relativePath): array
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');

        return array_values(array_unique([
            public_path('storage/'.$relativePath),
            storage_path('app/public/'.$relativePath),
        ]));
    }

    /**
     * Convert an uploaded image to WebP and save it under public/{directory}.
     * Returns the filename only.
     */
    public function storeInPublic(UploadedFile $file, string $directory, string $prefix = '', ?int $maxEdge = null): string
    {
        $directory = trim($directory, '/');
        $path = public_path($directory);

        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException('Failed to create image directory.');
        }

        $filename = $this->filename($prefix);
        $this->writeWebp($file, $path.DIRECTORY_SEPARATOR.$filename, $maxEdge);

        return $filename;
    }

    public function canConvert(UploadedFile $file): bool
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: '');

        if (in_array($extension, self::CONVERTIBLE_EXTENSIONS, true)) {
            return true;
        }

        return in_array(strtolower((string) $file->getMimeType()), self::CONVERTIBLE_MIMES, true);
    }

    private function filename(string $prefix = ''): string
    {
        $prefix = $prefix !== '' ? $prefix.'_' : '';

        return time().'_'.$prefix.Str::random(10).'.webp';
    }

    private function writeWebp(UploadedFile $file, string $absolutePath, ?int $maxEdge): void
    {
        $image = (new ImageManager(new Driver()))->read($file->getRealPath());
        $edge = $maxEdge ?? self::MAX_EDGE;
        $image->scaleDown(width: $edge, height: $edge);
        $image->encode(new WebpEncoder(quality: self::QUALITY, strip: true))->save($absolutePath);
    }
}
