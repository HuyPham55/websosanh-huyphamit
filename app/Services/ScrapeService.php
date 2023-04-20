<?php

namespace App\Services;

use Goutte\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ScrapeService
{
    public function scrape($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $html = $crawler->html();
        return compact('html');
    }

    public function saveImage($url, $subFolderName)
    {
        $fallback = '/images/no-image.png';

        if ($this->relativeExists($url)) {
            $fallback = $url;
        }

        if (!isValidUrl($url)) {
            return $fallback;
        }

        //Validate MIME
        if (!isImage($url)) {
            return $url;
        }

        try {
            $request = Http::get($url);
            if ($request->status() !== 200) {
                return $fallback;
            }
            $fileName = substr($url, strrpos($url, '/') + 1);
            $fileName = $this->sanitizeFileName($fileName);

            $file = $request->body();
            $disk = 'public_relative';
            $diskPrefix = config("filesystems.disks.$disk.url");
            $savingDirectory = "/photos/shares/scrapes/$subFolderName/";

            Storage::disk($disk)->put($savingDirectory . $fileName, $file);
            return $diskPrefix . $savingDirectory . $fileName;
        } catch (\Exception $exception) {
            return $fallback;
        }
    }

    /**
     * @param $url
     * @return bool
     */
    public function relativeExists($url): bool
    {
        return File::exists(public_path($url));
    }

    /**
     * @param string $fileName
     * @return array|string|string[]|null
     */
    public function sanitizeFileName(string $fileName): string|array|null
    {
        return preg_replace('/[^a-z0-9.]+/', '-', strtolower($fileName));
    }
}
