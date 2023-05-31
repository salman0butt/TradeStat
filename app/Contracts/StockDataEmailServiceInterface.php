<?php

namespace App\Contracts;

/**
 * Interface StockDataEmailServiceInterface
 *
 * This interface defines the contract for a Stock data Email service,
 * Which is Responsible to send email
 *
 */

interface StockDataEmailServiceInterface
{
    /**
     * Send the stock data email.
     *
     * @param string $email The recipient's email address.
     * @param array $data The data to be included in the email.
     * @return void
     */
    public function sendEmail($email, $data): void;
}
