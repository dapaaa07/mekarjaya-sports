<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressionService
{
    /**
     * Max file size in bytes before automatic compression (2 MB).
     */
    protected int $maxSizeBytes = 2097152; // 2 * 1024 * 1024

    /**
     * Allowed safe mime types for document image uploads.
     */
    protected array $allowedMimes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    /**
     * Process, compress (if > 2MB or oversized), and store the uploaded image.
     *
     * @param UploadedFile $file
     * @param string $subfolder
     * @return string Relative storage path (e.g. 'documents/kk/filename.jpg')
     * @throws \InvalidArgumentException
     */
    public function processAndStore(UploadedFile $file, string $subfolder = 'documents/kk'): string
    {
        // 1. Strict Security Validation
        $mime = $file->getMimeType();
        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($mime, $this->allowedMimes) || !in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            throw new \InvalidArgumentException('Format file dokumen tidak diizinkan. Hanya format JPG, JPEG, PNG, dan WEBP yang diperbolehkan.');
        }

        // 2. Prepare destination path on public disk
        $disk = Storage::disk('public');
        $directory = trim($subfolder, '/');
        if (!$disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $filename = 'kk_' . date('Ymd_His') . '_' . Str::random(8) . '.jpg';
        $relativeDestination = $directory . '/' . $filename;
        $absoluteDestination = $disk->path($relativeDestination);
        $sourcePath = $file->getRealPath();
        $originalSize = $file->getSize();

        // 3. Compression Trigger (If > 2MB or large dimensions)
        $needsCompression = ($originalSize > $this->maxSizeBytes);

        if ($needsCompression) {
            $compressed = $this->compressWithGd($sourcePath, $absoluteDestination);

            if (!$compressed) {
                $compressed = $this->compressWithPythonPillow($sourcePath, $absoluteDestination);
            }

            if ($compressed && file_exists($absoluteDestination)) {
                return $relativeDestination;
            }
        }

        // If not compressed or < 2MB, store directly
        $storedPath = $file->storeAs($directory, $filename, 'public');
        return $storedPath;
    }

    /**
     * Compress using PHP GD if available.
     */
    protected function compressWithGd(string $sourcePath, string $destinationPath): bool
    {
        if (!extension_loaded('gd')) {
            return false;
        }

        try {
            $imageInfo = @getimagesize($sourcePath);
            if (!$imageInfo) {
                return false;
            }

            $sourceImage = null;
            switch ($imageInfo[2]) {
                case IMAGETYPE_JPEG:
                    $sourceImage = @imagecreatefromjpeg($sourcePath);
                    break;
                case IMAGETYPE_PNG:
                    $sourceImage = @imagecreatefrompng($sourcePath);
                    break;
                case IMAGETYPE_WEBP:
                    if (function_exists('imagecreatefromwebp')) {
                        $sourceImage = @imagecreatefromwebp($sourcePath);
                    }
                    break;
            }

            if (!$sourceImage) {
                return false;
            }

            $width = imagesx($sourceImage);
            $height = imagesy($sourceImage);
            $maxDimension = 1600;

            if ($width > $maxDimension || $height > $maxDimension) {
                if ($width > $height) {
                    $newWidth = $maxDimension;
                    $newHeight = (int) round(($height / $width) * $maxDimension);
                } else {
                    $newHeight = $maxDimension;
                    $newWidth = (int) round(($width / $height) * $maxDimension);
                }

                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                // Fill with white background in case of PNG transparency
                $white = imagecolorallocate($resizedImage, 255, 255, 255);
                imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $white);
                imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($sourceImage);
                $sourceImage = $resizedImage;
            }

            // Save as JPEG with 75% quality (excellent readability & tiny file size)
            $success = imagejpeg($sourceImage, $destinationPath, 75);
            imagedestroy($sourceImage);

            return $success;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Compress using Python Pillow CLI fallback if GD is not present.
     */
    protected function compressWithPythonPillow(string $sourcePath, string $destinationPath): bool
    {
        try {
            $escapedSource = escapeshellarg($sourcePath);
            $escapedDest = escapeshellarg($destinationPath);

            $pyCode = "
import sys
from PIL import Image

try:
    src = sys.argv[1]
    dst = sys.argv[2]
    im = Image.open(src)
    if im.mode in ('RGBA', 'P'):
        im = im.convert('RGB')
    if max(im.size) > 1600:
        im.thumbnail((1600, 1600), Image.Resampling.LANCZOS)
    im.save(dst, format='JPEG', quality=75, optimize=True)
    print('OK')
except Exception as e:
    sys.exit(1)
";
            $command = "python3 -c " . escapeshellarg($pyCode) . " " . $escapedSource . " " . $escapedDest;
            exec($command, $output, $returnCode);

            return ($returnCode === 0 && file_exists($destinationPath));
        } catch (\Throwable $e) {
            return false;
        }
    }
}
