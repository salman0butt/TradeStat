<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class HttpClient implements HttpClientInterface
{
    public function get(string $url, array $params = [], array $headers = []): mixed
    {
        return Http::withHeaders($headers)->get($url, $params);
    }

    public function post(string $url, array $data = [], array $headers = []): mixed
    {
        return Http::withHeaders($headers)->post($url, $data);
    }
}
