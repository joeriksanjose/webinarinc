<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class ChuckNorrisService
{
    private $base_url;
    private $client;
    private $api_categories = '/categories';
    private $api_random = '/random';
    private $api_search = '/search';

    const CATEGORIES_CACHE_KEY = 'categories';

    public function __construct()
    {
        $this->base_url = env('CHUCK_NORRIS_BASE_URL');
        $this->client = new Client();
    }

    public function categories()
    {
        $cacheData = Cache::get(self::CATEGORIES_CACHE_KEY);
        if ($cacheData) {
            return $cacheData;
        }

        $categories = $this->request('GET', $this->api_categories);

        Cache::add(self::CATEGORIES_CACHE_KEY, $categories);

        return $categories;
    }

    public function randomChuck($category = '')
    {
        return $this->request('GET', $this->api_random, ['query' => ['category' => $category]]);
    }

    public function search($query)
    {
        return $this->request('GET', $this->api_search, ['query' => ['query' => $query]]);
    }

    private function request($method, $uri, $options = [])
    {
        try {
            $uri = env('CHUCK_NORRIS_BASE_URL') . $uri;
            $res = $this->client->request($method, $uri, $options);

            return json_decode($res->getBody());
        } catch (\Exception $e) {
            \Log::error($e->getMessage() . ', '. __NAMESPACE__ . ':' . __CLASS__ . ':' . __FUNCTION__);
            throw $e;
        }
    }
}
