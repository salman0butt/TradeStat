<?php

namespace App\Contracts;

interface StockDataEmailServiceInterface
{
    public function sendEmail($email, $data): void;
}
