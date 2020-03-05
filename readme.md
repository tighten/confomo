![ConFOMO logo](https://raw.githubusercontent.com/tightenco/confomo/master/confomo-logo.png)

[![Codeship Status for mattstauffer/confomo](https://codeship.com/projects/5f3d86b0-1335-0134-c5b2-1e1a7920036c/status?branch=master)](https://codeship.com/projects/157478)

### Connecting your online community with the real world, one conference at a time.

Built in 4 hours to help me track who I wanted to meet at Laracon 2014, and who I met there who I didn't know yet.

Updated for Laravel 5.1 and Vue in 2015/2016. @michaeldyrynda did most of the hard work there, and we documented it [on a podcast](http://rebuilding.confomo.com/).

### Requirements

- PHP >= 7.1.3
- Composer
- Node and npm

### Installation

1. [Fork this repository](https://help.github.com/articles/fork-a-repo/) (optional).
1. Clone the repository locally.
1. Install dependencies with `composer install`.
1. Copy [`.env.example`](https://github.com/tightenco/confomo/blob/master/.env.example) to `.env` and modify its contents to reflect your local environment.
1. Generate an application key with `php artisan key:generate`.
1. Migrate the database with `php artisan migrate`.
1. Install frontend dependencies with `npm install`.
1. Build and watch frontend assets with `npm run dev`.
1. Configure a web server, such as the built-in PHP web server, to serve the site using the `public` directory as the document root: `php -S localhost:8080 -t public`.
1. Run tests with `vendor/bin/phpunit`.

### Contributing

Submit an issue for bugs or feature requests, or submit a PR against the `master` branch.

![ConFOMO screenshot](public/assets/img/confomo-screenshot.png)

### License

Not sure. Don't steal it? Let's call it MIT for today.
