# TradeStat

The TradeStat project is a Laravel application that fetches trading data from a third-party data source and displays the data based on validated company data obtained from another API. This project includes PHPUnit tests and Laravel Dusk tests for ensuring the functionality and integrity of the application.

## Features and Highlights

- Utilizes services/Clients classes for dependency injection and modular separation.
- Custom exceptions are implemented to provide meaningful and informative error messages.
- Contracts/interfaces are used to ensure flexibility and future extensibility.
- Includes PHPUnit tests and browser tests using Laravel Dusk for comprehensive testing coverage.

## Requirements

To run the TradeStat project locally, you need to have the following requirements installed:

- PHP 8.1 or higher
- Composer (Dependency Manager for PHP)
- Laravel 10.x

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/salman0butt/TradeStat.git
   ```

### Installation Using Docker

1. Configure the environment variables:

- Copy the .env.example file and rename it to .env.
- Update the TradState credentials and other configuration variables in the .env file.

1. Install the Docker and inside Project root directory run:

   ```bash
   cd TradeStat
   ```
   ```bash
   docker-compose up --build
   ```

The docker setup will Create, Configure and Run the Container

1. when Everything install and ready it will run. Access the TradeStat application in your browser:
   
    ```bash
    http://127.0.0.1:8000
    ```
### Installation without Docker

1. Install the project dependencies using Composer:

    ```bash
    cd TradeStat
    ```
    ```bash
    composer install
    ```

1. Configure the environment variables:

- Copy the .env.example file and rename it to .env.
- Update the TradState credentials and other configuration variables in the .env file.

1. Generate a new application key:

    ```bash
    php artisan key:generate
    ```

1. Start the development server:
    ```bash
    php artisan serve
    ```

1. Access the TradeStat application in your browser:
    ```bash
    http://127.0.0.1:8000
    ```
## Testing

1. The TradeStat project includes both PHPUnit tests and Laravel Dusk tests for automated testing.

1. To run the PHPUnit tests:

    ```php
    php artisan test
    ```

1. To run the Laravel Dusk tests, make sure you have a compatible browser driver installed (e.g., ChromeDriver) and update the DuskTestCase class in tests/DuskTestCase.php with the appropriate configuration. Then, run the following command:

    ```php
    php artisan dusk
    ```

Make sure to set up the necessary environment variables and configurations for running the tests.

## License

This project is licensed under the MIT License.
