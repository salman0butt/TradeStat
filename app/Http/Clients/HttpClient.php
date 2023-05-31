<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class HttpClient implements HttpClientInterface
{
    /**
     * Send a GET request to the specified URL.
     *
     * @param string $url The URL to send the request to.
     * @param array $params The query parameters to include in the request.
     * @param array $headers The headers to include in the request.
     * @return mixed The response from the GET request.
     */
    public function get(string $url, array $params = [], array $headers = []): mixed
    {
        return Http::withHeaders($headers)->get($url, $params);
    }

    /**
     * Send a POST request to the specified URL.
     *
     * @param string $url The URL to send the request to.
     * @param array $data The data to include in the request body.
     * @param array $headers The headers to include in the request.
     * @return mixed The response from the POST request.
     */
    public function post(string $url, array $data = [], array $headers = []): mixed
    {
        return Http::withHeaders($headers)->post($url, $data);
    }
}
