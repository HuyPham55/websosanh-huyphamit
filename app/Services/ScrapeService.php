<?php

namespace App\Services;

use Goutte\Client;

class ScrapeService
{
    public function scrape($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $html = $crawler->html();
        return compact('html');
    }
}
