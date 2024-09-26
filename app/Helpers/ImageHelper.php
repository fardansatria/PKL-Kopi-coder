<?php

namespace App\Helpers;

class ImageHelper
{
    public static function resizeImage($sourcePath, $destinationPath, $width, $height)
    {
        // Load the image
        $image = imagecreatefromjpeg($sourcePath);
        
        if (!$image) {
            return false;
        }

        // Get original dimensions
        list($originalWidth, $originalHeight) = getimagesize($sourcePath);

        // Create a square canvas
        $canvas = imagecreatetruecolor($width, $height);

        // Resize image to fit the canvas
        $srcX = ($originalWidth > $originalHeight) ? ($originalWidth - $originalHeight) / 2 : 0;
        $srcY = ($originalHeight > $originalWidth) ? ($originalHeight - $originalWidth) / 2 : 0;
        $srcWidth = min($originalWidth, $originalHeight);
        $srcHeight = $srcWidth;

        imagecopyresampled($canvas, $image, 0, 0, $srcX, $srcY, $width, $height, $srcWidth, $srcHeight);

        // Save the image
        imagejpeg($canvas, $destinationPath, 90);

        // Free up memory
        imagedestroy($image);
        imagedestroy($canvas);

        return true;
    }
}
