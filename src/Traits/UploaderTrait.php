<?php

namespace Stew\ImageUploader\Traits;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait UploaderTrait
{
    /**
     * @param $table
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    public function getImageDisk($table = 'settings')
    {
        if (Schema::hasTable($table))
        {
            $disk = DB::table($table)
                ->where('key', 'filesystem_disk')
                ->first();
            if (!empty($disk)) {
                $setting = DB::table($table)
                    ->where('key', $disk->value)
                    ->first();

                config([
                    'filesystems.default' => $disk->value,
                ]);
                config([
                    'filesystems.disks.' . $setting->key  => json_decode($setting->value, true),
                ]);
            }
        }

        return config('filesystems.default');
    }

    /**
     * @param $path
     * @return mixed|string
     */
    public function getDirectory($path)
    {
        $disk = $this->getImageDisk();
        if ($disk === 'local') {
            return 'public' . $path;
        }
        return $path;
    }

    /**
     * @param $fileName
     * @param $path
     * @return string
     */
    public function saveFileToStorage($fileName, $path): string
    {
        if (!empty($fileName)) {
            $disk = $this->getImageDisk();
            $directory = $this->getDirectory($path);
            // Create a folder if it doesn't exist
            if (!Storage::disk($disk)->exists($directory)) {
                Storage::disk($disk)->makeDirectory($directory);
            }
            // Check if the file is in base64 format
            if ($this->isBase64($fileName)) {
                if (strpos($fileName, ';') !== false) {
                    list($type, $fileName) = explode(';', $fileName);
                    list(, $imageBase64) = explode(',', $fileName);
                    $extension = explode('/', $type)[1];
                } else {
                    $extension = 'webp';
                    $imageBase64 = $fileName;
                }
                $contents = base64_decode($imageBase64);
                $size = $this->getSizeImage($contents);
                // Check if the image is not in webp format
                if ($extension !== 'webp') {
                    $imageName = $this->convertImageToWebp($contents, $directory);
                } else {
                    $imageName = time() . '-' . $size . '.' . $extension;
                }
            } else {
                // The file is not in base64 format, so read its contents
                $contents = file_get_contents($fileName->getRealPath());
                $imageName = $this->convertImageToWebp($contents, $directory);
            }
            // Save the image to the specified directory on the selected disk
            Storage::disk($disk)->put($directory . $imageName, $contents);

            return $path . $imageName;
        }

        return '';
    }

    /**
     * @param $strEndcode
     * @return bool
     */
    public function isBase64($strEndcode): bool
    {
        $base64 = explode(',', $strEndcode);
        if (!empty($base64[1])) {
            $strEndcode = $base64[1];
        }

        return base64_encode(base64_decode($strEndcode)) === $strEndcode ?? false;
    }

    /**
     * @param $imageString
     * @param $directory
     * @return string
     */
    public function convertImageToWebp ($imageString, $directory): string
    {
        // Create a new image from the image stream in the string
        $originalImage = imagecreatefromstring($imageString);
        // Converts a palette based image to true color
        imagepalettetotruecolor($originalImage);
        $size = $this->getSizeImage($imageString);
        $imageName = time() . '-' . $size . '.' . '.webp';
        // Convert file to webp
        imagewebp($originalImage, Storage::path($directory . $imageName));
        // Frees image object memory
        imagedestroy($originalImage);

        return $imageName;
    }

    /**
     * @param $filePath
     * @return bool
     */
    public function deleteImage($filePath): bool
    {
        if (!empty($filePath)) {
            $disk = $this->getImageDisk();
            $directory = $this->getDirectory($filePath);
            Storage::disk($disk)->delete($directory);

            return true;
        }

        return false;
    }

    /**
     * @param $strDecodeBase64
     * @return string
     */
    private function getSizeImage($strDecodeBase64): string
    {
        $image = imagecreatefromstring($strDecodeBase64);
        $width = imagesx($image);
        $height = imagesy($image);

        return $width . 'x' . $height;
    }
}
