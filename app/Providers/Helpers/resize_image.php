<?php
use Intervention\Image\ImageManagerStatic as Image;

if (!function_exists('resize_image')) {
    /**
     * Greeting a person
     *
     * @param  string $person Name
     * @return string
     */
    function resize_image($image, $size = 300)
    {
        return Image::make($image)->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90);
    }
}