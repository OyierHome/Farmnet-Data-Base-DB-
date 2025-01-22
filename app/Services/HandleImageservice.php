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

        return $path . '/' . $newName;
    }
    public function deleteImage($image)
    {
        if (!$image) {
            throw new \InvalidArgumentException('Image is required.');
        }

        // Delete Image
        if (file_exists(public_path($image))) {
            unlink(public_path($image));
        }
    }


}
