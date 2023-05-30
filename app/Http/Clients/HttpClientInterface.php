<?php

namespace App\Http\Clients;

interface HttpClientInterface
{
    public function get(string $url, array $params = [], array $headers = []): mixed;
    public function post(string $url, array $data = [], array $headers = []): mixed;
}
