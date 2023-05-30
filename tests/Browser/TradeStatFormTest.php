<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TradeStatFormTest extends DuskTestCase
{
    /**
     * A basic test to validate TradeStat form submission and validation.
     *
     * @return void
     */
    public function testTradeStatForm()
    {
        $this->browse(function (Browser $browser) {
            // Visit the TradeStat form page
            $browser->visit('/')
                ->assertSee('TradeStat')
                ->assertSee('Get Historical Data');

            // Submit the form with empty fields
            $browser->press('Get Historical Data')
                ->assertSee('Company Symbol is required')
                ->assertSee('Start Date is required')
                ->assertSee('End Date is required')
                ->assertSee('Email is required');

            // Submit the form with invalid email
            $browser->type('company_symbol', 'AAPL')
                ->click('#start_date')
                ->press('.ui-datepicker-today')
                ->click('#end_date')
                ->press('.ui-datepicker-today')
                ->type('email', 'invalid_email')
                ->press('Get Historical Data')
                ->assertSee('The email must be a valid email address.');

            $todayDate = date("Y-m-d");
            // Submit the form with valid inputs
            $browser->type('company_symbol', 'AAPL')
                ->click('#start_date')
                ->press('.ui-datepicker-today')
                ->click('#end_date')
                ->press('.ui-datepicker-today')
                ->type('email', 'test@example.com')
                ->press('Get Historical Data')
                ->assertPathIs('/get-historical-data')
                ->assertSee('AAPL')
                ->assertSee($todayDate);
        });
    }
}
