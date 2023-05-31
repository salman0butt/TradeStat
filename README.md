# TradeStat

The TradeStat project is a Laravel application that fetches trading data from a third-party data source and displays the data based on validated company data obtained from another API. This project includes PHPUnit tests and Laravel Dusk tests for ensuring the functionality and integrity of the application.

## Features

- Fetches trading data from a third-party data source.
- Validates and fetches company data from another API.
- Displays and Graphical trading data based on validated company data.
- Includes PHPUnit tests for unit testing.
- Includes Laravel Dusk tests for browser automation testing.

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
- Update the database credentials and other configuration variables in the .env file.

1. Install the Docker and inside Project root directory run:

  ```bash
    docker-compose up --build
   ```



### Installation without Docker

1. Install the project dependencies using Composer:

  ```bash
    cd TradeStat
    composer install
   ```
The docker setup will Create, Configure and Run the Container

1. when Everything install and ready it will run. Access the TradeStat application in your browser:
    ```bash
    http://127.0.01:8000
   ```

1. Configure the environment variables:

- Copy the .env.example file and rename it to .env.
- Update the database credentials and other configuration variables in the .env file.

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
    http://127.0.01:8000
   ```
## Testing
The TradeStat project includes both PHPUnit tests and Laravel Dusk tests for automated testing.

To run the PHPUnit tests:
    ```bash
    php artisan test
   ```

To run the Laravel Dusk tests, make sure you have a compatible browser driver installed (e.g., ChromeDriver) and update the DuskTestCase class in tests/DuskTestCase.php with the appropriate configuration. Then, run the following command:

    ```bash
    php artisan dusk
   ```

Make sure to set up the necessary environment variables and configurations for running the tests

## License

This project is licensed under the MIT License.



