<?php

namespace Mariale098\Quotes;

use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Quotes
{
    protected $cache;
    protected $config;
    protected $client;

    public function __construct($cache, array $config)
    {
        $this->cache = $cache;
        $this->config = $config;
        $this->client = new Client([
            'base_uri' => 'https://dummyjson.com/',
            'timeout' => 5.0,
        ]);
    }

    public function getRandomQuote()
    {
        return $this->cache->remember('random_quote', $this->config['cache_ttl'], function () {
            try {
                $response = $this->client->get('quotes/random');
                return json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $e) {
                return null;
            }
        });
    }

    public function getQuotes($limit = 10, $skip = 0)
    {
        $cacheKey = "quotes_{$limit}_{$skip}";
        
        return $this->cache->remember($cacheKey, $this->config['cache_ttl'], function () use ($limit, $skip) {
            try {
                $response = $this->client->get("quotes?limit={$limit}&skip={$skip}");
                return json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $e) {
                return null;
            }
        });
    }

    public function getQuote($id)
    {
        return $this->cache->remember("quote_{$id}", $this->config['cache_ttl'], function () use ($id) {
            try {
                $response = $this->client->get("quotes/{$id}");
                return json_decode($response->getBody()->getContents(), true);
            } catch (GuzzleException $e) {
                return null;
            }
        });
    }
} 