<?php

use Illuminate\Support\Facades\Cache;

function isImage($path = ''): bool
{
    $imageExtensions = ['gif', 'jpg', 'jpeg', 'png', 'webp', 'svg'];
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive

    return in_array($ext, $imageExtensions);
}

/**
 * check if email is valid
 * @param string $email
 * @return bool
 */
function isValidEmail($email = ''): bool
{
    $pattern = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

    return preg_match($pattern, $email) ? true : false;
}

function isVideo($path = ''): bool
{
    $imageExtensions = ['mp4', 'avi', 'mkv', 'webm'];
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive

    return in_array($ext, $imageExtensions);
}

function simple_slug($string): array|string
{
    $search = ['/', ';', '\'', '(', ')', ' ', '!', '*', ',', '&', '.','?','#','%'];

    $text = str_replace($search, '-', $string);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);


    return !empty($text) ? $text : 'n-a';
}

function either($first = null, $second = null, $third = null) {return !empty($first)?$first:(!empty($second)?$second:$third);}

function LFMThumb($url): string
{
    $url2 = str_replace(basename($url), '', $url);
    $url2 = $url2 . 'thumbs/' . basename($url);
    return $url2;
}

function cachedOption($key)
{
    return Cache::remember($key, rand(0, env('SESSION_LIFETIME')), function () use ($key) {
        return option($key);
    });
}

