<?php

namespace App\Http\Clients;
/**
 * Interface HttpClientInterface
 *
 * Represents an HTTP client interface for making HTTP requests.
 */
interface HttpClientInterface
{
     /**
     * Perform an HTTP GET request.
     *
     * @param string $url The URL to send the GET request to.
     * @param array $params The query parameters to include in the request.
     * @param array $headers The headers to include in the request.
     * @return mixed The response from the HTTP GET request.
     */
    public function get(string $url, array $params = [], array $headers = []): mixed;

     /**
     * Perform an HTTP POST request.
     *
     * @param string $url The URL to send the POST request to.
     * @param array $data The data to include in the request body.
     * @param array $headers The headers to include in the request.
     * @return mixed The response from the HTTP POST request.
     */
    public function post(string $url, array $data = [], array $headers = []): mixed;
}
