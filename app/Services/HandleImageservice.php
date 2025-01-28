<?php

namespace App\Services;

class HandleImageService
{

    public function imageHandle($image , $path)
    {
        if (!$image || !$path) {
            throw new \InvalidArgumentException('Image and path are required.');
        }

        // handle Image
        $extension = $image->getClientOriginalExtension();
        $newName = uniqid() . '.' . $extension;
        $image->move($path, $newName);

    $profileUrl = url("{$path}/{$newName}");
    return $profileUrl;
    }
    public function deleteImage($image)
    {
        if (!$image) {
            throw new \InvalidArgumentException('Image URL is required.');
        }

        // Delete Image
        $imagePath = parse_url($image, PHP_URL_PATH);
        $fullImagePath = public_path($imagePath);

        if (file_exists($fullImagePath)) {
            unlink($fullImagePath);
        }
    }


}
