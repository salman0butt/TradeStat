<?php

declare (strict_types = 1);

namespace App\Services;

use App\Mail\StockDataEmail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\StockDataEmailServiceInterface;

class StockDataEmailService implements StockDataEmailServiceInterface
{
    public function sendEmail($email, $data): void
    {
        Mail::to($email)->send(new StockDataEmail($data));
    }
}

