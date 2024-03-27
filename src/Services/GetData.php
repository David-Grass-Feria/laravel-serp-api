<?php

namespace GrassFeria\LaravelSerpApi\Services;

use Illuminate\Support\Facades\Http;

class GetData

{
    public function getDataFromSerpApi(string $engine, array $parameters = [])
    {
        $parameters = array_merge([
            'engine' => $engine,
            'api_key' => config('laravel-serp-api.serp_api_key'),
        ], $parameters);

        $response = Http::get('https://serpapi.com/search.json', $parameters);

        $data = $response->json();
        return $data;
    }
}
