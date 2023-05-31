<?php

declare (strict_types = 1);

namespace App\Services;

use App\Mail\StockDataEmail;
use Illuminate\Support\Facades\Mail;
use App\Contracts\StockDataEmailServiceInterface;

class StockDataEmailService implements StockDataEmailServiceInterface
{
    /**
     * Send the stock data email.
     *
     * @param string $email The recipient's email address.
     * @param array $data The data to be included in the email.
     * @return void
     */
    public function sendEmail($email, $data): void
    {
        Mail::to($email)->send(new StockDataEmail($data));
    }
}

